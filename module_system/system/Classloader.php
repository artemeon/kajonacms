<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
********************************************************************************************************/

namespace Kajona\System\System;


require_once __DIR__."/PharModule.php";
require_once __DIR__."/BootstrapCache.php";

use Kajona\Packagemanager\System\PackagemanagerMetadata;
use ReflectionClass;

/**
 * Class-loader for all Kajona classes.
 * Implemented as a singleton.
 *
 * @package module_system
 * @author sidler@mulchprod.de
 */
class Classloader
{

    const PREFER_PHAR = false;


    private $intNumberOfClassesLoaded = 0;

    /**
     * @var Classloader
     */
    private static $objInstance = null;

    /**
     * Cached array of the core dirs
     *
     * @var array
     */
    private $arrCoreDirs = array();

    /**
     * List of folder names which are not scanned for classes inside a module folder
     *
     * @var array
     */
    private static $arrCodeFoldersBlacklist = array(
        "docs/",
        "lang/",
        "less/", // installer
        "pics/",
        "scripts/",
        "vendor/",
        "node_modules/",
    );

    /**
     * Factory method returning an instance of Classloader.
     * The class-loader implements the singleton pattern.
     *
     * @static
     * @return Classloader
     */
    public static function getInstance()
    {
        if (self::$objInstance == null) {
            self::$objInstance = new Classloader();
        }

        return self::$objInstance;
    }

    /**
     * Constructor, initializes the internal fields
     */
    private function __construct()
    {
        $this->scanModules();
        $this->indexAvailableCodefiles();
//        $this->bootstrapIncludeModuleIds();
    }


    /**
     * We autoload all classes which are in the event folder of each module. Theses classes can register events etc.
     *
     * @throws Exception
     */
    public function includeClasses()
    {
        foreach (BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_CLASSES) as $strClass => $strOneFile) {
            if (strpos($strOneFile, "/event/") !== false) {
                // include all classes which are in the event folder
                $this->loadClass($strClass);
            }
        }
    }

    /**
     * Registers all service providers to the DI container
     *
     * @param \Pimple\Container $objContainer
     */
    public function registerModuleServices(\Pimple\Container $objContainer)
    {
        foreach (BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_SERVICES) as $strClass => $strOneFile) {
            $objServiceProvider = new $strClass();
            if ($objServiceProvider instanceof \Pimple\ServiceProviderInterface) {
                $objServiceProvider->register($objContainer);
            }
        }

        // check the project config and maybe override a service definition
        $arrServiceProvider = Config::getInstance()->getConfig("service_provider");
        if (!empty($arrServiceProvider) && is_array($arrServiceProvider)) {
            foreach ($arrServiceProvider as $strName => $objCallback) {
                $objContainer->offsetSet($strName, $objCallback);
            }
        }
    }

    /**
     * Scans all core directories for matching modules
     *
     * @param bool $bitForce
     */
    private function scanModules($bitForce = false)
    {

        if (!$bitForce && (BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_MODULES) !== false && BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_PHARMODULES) !== false)) {
            return;
        }


        $arrIncludedModules = null;
        if (is_file(_realpath_."project/packageconfig.json")) {
            $arrIncludedModules = json_decode(file_get_contents(_realpath_."project/packageconfig.json"), true);
        }

        //Module-Constants
        $this->arrCoreDirs = self::getCoreDirectories();

        $arrModules = array();
        $arrPharModules = array();
        foreach ($this->arrCoreDirs as $strRootFolder) {
            if (strpos($strRootFolder, "core") === false) {
                continue;
            }

            foreach (scandir(_realpath_.$strRootFolder) as $strOneModule) {
                $strModuleName = null;
                $boolIsPhar = PharModule::isPhar($strOneModule);

                if ($boolIsPhar) {
                    $strModuleName = PharModule::getPharBasename($strOneModule);
                } elseif (preg_match("/^(module|_)+.*/i", $strOneModule)) {
                    $strModuleName = $strOneModule;
                }

                if ($strModuleName != null) {
                    //skip module if not marked as to be included
                    if ($arrIncludedModules !== null && !isset($arrIncludedModules[$strRootFolder])) {
                        continue;
                    }
                    if ($arrIncludedModules !== null && isset($arrIncludedModules[$strRootFolder]) && !in_array($strModuleName, $arrIncludedModules[$strRootFolder])) {
                        continue;
                    }

                    if ($boolIsPhar) {
                        $arrPharModules[$strRootFolder."/".$strOneModule] = $strModuleName;
                    } else {
                        $arrModules[$strRootFolder."/".$strOneModule] = $strModuleName;
                    }
                }
            }
        }

        if (self::PREFER_PHAR) {
            $arrDiffedPhars = $arrPharModules;
            $arrModules = array_diff($arrModules, $arrPharModules);
        } else {
            $arrDiffedPhars = array_diff($arrPharModules, $arrModules);
        }

        BootstrapCache::getInstance()->updateCache(BootstrapCache::CACHE_MODULES, $arrModules);
        BootstrapCache::getInstance()->updateCache(BootstrapCache::CACHE_PHARMODULES, $arrDiffedPhars);
    }

    /**
     * Returns a list of all core directories available
     *
     * @return array
     */
    public static function getCoreDirectories()
    {
        $arrCores = array();
        foreach (scandir(_realpath_) as $strRootFolder) {
            if (strpos($strRootFolder, "core") === false) {
                continue;
            }

            $arrCores[] = $strRootFolder;
        }

        return $arrCores;
    }


    /**
     * Flushes the cache-files.
     * Use this method if you added new modules / classes.
     * The classes are reinitialized automatically.
     *
     * @return void
     */
    public function flushCache()
    {
        BootstrapCache::getInstance()->flushCache();
        $this->scanModules(true);
        $this->indexAvailableCodefiles(true);
    }

    /**
     * Indexes all available code-files, so classes.
     * Therefore, all relevant folders are traversed.
     *
     * @return void
     */
    private function indexAvailableCodefiles($bitForce = false)
    {
        if (!$bitForce && !empty(BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_CLASSES))) {
            return;
        }

        $arrMergedFiles = $this->getClassesInFolder();

        foreach (BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_PHARMODULES) as $strPath => $strSingleModule) {
            $objPhar = new PharModule($strPath);
            $arrFiles = $objPhar->load(self::$arrCodeFoldersBlacklist);

            $arrResolved = array();
            foreach ($arrFiles as $strName => $strPath) {
                $arrResolved[$this->getClassnameFromFilename($strPath)] = $strPath;
            }

            // PHAR archive files must never override existing file system files
            if (self::PREFER_PHAR) {
                $arrMergedFiles = array_merge($arrMergedFiles, $arrResolved);
            } else {
                $arrMergedFiles += array_diff_key($arrResolved, $arrMergedFiles);
            }
        }

        $arrServiceProvider = array();
        foreach ($arrMergedFiles as $strClassName => $strFile) {
            if (strpos($strClassName, "\\ServiceProvider") !== false) {
                $arrServiceProvider[$strClassName] = $strFile;
            }
        }

        BootstrapCache::getInstance()->updateCache(BootstrapCache::CACHE_CLASSES, $arrMergedFiles);
        BootstrapCache::getInstance()->updateCache(BootstrapCache::CACHE_SERVICES, $arrServiceProvider);
    }

    /**
     * Loads all classes in a single folder, but traversing each module available.
     * Internal helper.
     *
     * @param string $strFolder
     *
     * @return string[]
     */
    private function getClassesInFolder()
    {
        $arrFiles = array();

        $arrModules = BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_MODULES);

        // add module redefinitions from /project for both, phars and non phars
        foreach ($this->getArrModules() as $strModulePath => $strSingleModule) {
            $strPath = "project/".$strSingleModule;
            if (is_dir(_realpath_.$strPath)) {
                $arrModules[$strPath] = $strSingleModule;
            }
        }

        foreach ($arrModules as $strPath => $strSingleModule) {
            if (strpos($strSingleModule, "module_") === 0) {
                if (is_dir(_realpath_.$strPath)) {
                    $arrFiles = array_merge($arrFiles, $this->getRecursiveFiles(_realpath_.$strPath));
                }
            }
        }

        return $arrFiles;
    }

    /**
     * @param string $strPath
     * @return array
     */
    private function getRecursiveFiles($strPath)
    {
        $arrFiles = array();
        $arrTempFiles = scandir($strPath);
        foreach ($arrTempFiles as $strFile) {
            if ($strFile != "." && $strFile != ".." && !in_array($strFile."/", self::$arrCodeFoldersBlacklist)) {
                if (strpos($strFile, ".php") !== false) {
                    $strClassName = $this->getClassnameFromFilename($strPath."/".$strFile);
                    if (!empty($strClassName)) {
                        $arrFiles[$strClassName] = $strPath."/".$strFile;
                    }
                } elseif (is_dir($strPath."/".$strFile)) {
                    $arrFiles = array_merge($arrFiles, $this->getRecursiveFiles($strPath."/".$strFile));
                }
            }
        }
        return $arrFiles;
    }

    /**
     * The class-loader itself. Loads the class, if existing. Otherwise the chain of class-loaders is triggered.
     *
     * @param string $strClassName
     *
     * @return bool
     */
    public function loadClass($strClassName)
    {
        $cacheRow = BootstrapCache::getInstance()->getCacheRow(BootstrapCache::CACHE_CLASSES, $strClassName);
        if ($cacheRow) {
            $this->intNumberOfClassesLoaded++;
            include_once $cacheRow;
            return true;
        }

        return false;
    }

    /**
     * Extracts the class-name out of a filename.
     * Normally this method is only used by getInstanceFromFilename, so no use to call it directly.
     * The method does not include the file so it does not trigger any other autoload calls
     *
     * @param $strFilename
     *
     * @param bool $bitAddToClassmap Disables the writing to the classmap
     *
     * @return null|string
     */
    public function getClassnameFromFilename($strFilename, $bitAddToClassmap = true)
    {
        // if empty we cant resolve a class name
        if (empty($strFilename) || StringUtil::substring($strFilename, -4) != '.php') {
            return null;
        }

        //perform a reverse lookup using the cache, maybe the file was indexed before
        $arrMap = BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_CLASSES);
        if ($arrMap !== false) {
            $strHit = array_search($strFilename, $arrMap);
            if ($strHit !== false && $strHit !== null) {
                return $strHit;
            }
        }

        $strFile = StringUtil::substring(basename($strFilename), 0, -4);
        $strClassname = null;

        // if the filename contains an underscore we have an old class else a camelcase one
        if (strpos($strFile, "_") !== false) {
            $strClassname = $strFile;
        } else {
            $strSource = file_get_contents($strFilename);
            preg_match('/namespace ([a-zA-Z0-9_\x7f-\xff\\\\]+);/', $strSource, $arrMatches);

            $strNamespace = isset($arrMatches[1]) ? $arrMatches[1] : null;
            if (!empty($strNamespace)) {
                $strClassname = $strNamespace."\\".$strFile;
            } else {
                //ugly fallback for ioncube encoded files, could be upgrade to an improved regex
                //TODO: move this name-based detection to the general approach, replacing the content parsing
                if (strpos($strSource, "sg_load") !== false) {
                    if ($strFile === "functions") {
                        return null;
                    }

                    $strParsedFilename = str_replace(array("\\", ".phar"), array("/", ""), StringUtil::substring($strFilename, 0, -4));


                    $strClassname = "Kajona\\";
                    if (strpos($strParsedFilename, "core_") !== false) {
                        $strClassname = "AGP\\";
                    }

                    $arrPath = array();
                    $arrSections = array_reverse(explode("/", $strParsedFilename));
                    foreach ($arrSections as $strOnePart) {
                        if ($strOnePart !== "core"
                            && $strOnePart !== "project"
                            && strpos($strOnePart, "core_") === false) {
                            if (strpos($strOnePart, "module_") !== false) {
                                $strOnePart = substr($strOnePart, 7);
                            }

                            //e.g. agp_commons will become Agp_Commons
                            //e.g. commons will become Commons
                            $arrExp = explode("_", $strOnePart);
                            $arrNew = array();
                            foreach ($arrExp as $str) {
                                $arrNew[] = ucfirst($str);
                            }
                            $arrPath[] = implode("_", $arrNew);
                        } else {
                            break;
                        }
                    }

                    //file is in project path?
                    if (strpos($strParsedFilename, "/project/") !== false) {
                        $strTargetPath = _realpath_."core/module_".strtolower(array_reverse($arrPath)[0]);
                        if (is_dir($strTargetPath) || is_file($strTargetPath.".phar")) {
                            $strClassname = "Kajona\\";
                        } else {
                            $strClassname = "AGP\\";
                        }
                    }

                    $strClassname .= implode("\\", array_reverse($arrPath));
                }
            }
        }
        if ($arrMap !== false && $bitAddToClassmap) {
            BootstrapCache::getInstance()->addCacheRow(BootstrapCache::CACHE_CLASSES, $strClassname, $strFilename);
        }
        return $strClassname;
    }


    /**
     * Creates a new instance of an object based on the filename
     *
     * @param $strFilename
     * @param string $strBaseclass an optional filter-restriction based on a base class
     * @param string $strImplementsInterface
     * @param array $arrConstructorParams
     *
     * @return null|object
     */
    public function getInstanceFromFilename($strFilename, $strBaseclass = null, $strImplementsInterface = null, $arrConstructorParams = null, $bitInject = false)
    {
        $strResolvedClassname = $this->getClassnameFromFilename($strFilename, false);

        if ($strResolvedClassname != null) {

            //see if the class was overwritten/index at a different location - then replace the passed filename
            $strPathFromCache = BootstrapCache::getInstance()->getCacheRow(BootstrapCache::CACHE_CLASSES, $strResolvedClassname);
            if ($strPathFromCache !== false && $strPathFromCache != $strFilename) {
                $strFilename = $strPathFromCache;
            }

            // if the class does not exist we simply include the filename and hope that the class is defined there. This
            // is the case where the filename is not equal to the class name i.e. installer_sc_zzlanguages.php
            if (!class_exists($strResolvedClassname, false)) {
                include_once $strFilename;
            }

            $objReflection = new ReflectionClass($strResolvedClassname);
            if ($objReflection->isInstantiable() && ($strBaseclass == null || $objReflection->isSubclassOf($strBaseclass)) && ($strImplementsInterface == null || $objReflection->implementsInterface($strImplementsInterface))) {
                if ($bitInject) {
                    $objFactory = Carrier::getInstance()->getContainer()->offsetGet(ServiceProvider::STR_OBJECT_BUILDER);
                    if (!empty($arrConstructorParams)) {
                        return $objFactory->factory($objReflection->getName(), $arrConstructorParams);
                    } else {
                        return $objFactory->factory($objReflection->getName());
                    }
                } else {
                    if (!empty($arrConstructorParams)) {
                        return $objReflection->newInstanceArgs($arrConstructorParams);
                    } else {
                        return $objReflection->newInstance();
                    }
                }
            }
        }

        return null;
    }

    /**
     * Includes the module-ids available and registers them as defined constants
     */
    public function bootstrapIncludeModuleIds()
    {

        $ids = BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_MODULEIDS);

        if (!empty($ids)) {
            foreach ($ids as $name => $val) {
                define($name, $val);
            }
            return;
        } else {

            $ids = [];
            foreach ($this->getArrModules() as $modulePath => $moduleName) {
                $metadata = new PackagemanagerMetadata();
                $metadata->autoInit($modulePath);

                foreach ($metadata->getConstants() as $name => $val) {
                    define($name, (int)$val);
                    $ids[$name] = (int)$val;
                }
            }

            BootstrapCache::getInstance()->updateCache(BootstrapCache::CACHE_MODULEIDS, $ids);
        }
    }


    /**
     * Returns the list of modules indexed by the classloader, so residing under /core
     *
     * @return string[]
     */
    public function getArrModules()
    {
        return BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_MODULES) + BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_PHARMODULES);
    }

    /**
     * Returns the list of phar-based modules
     *
     * @return array
     */
    public function getArrPharModules()
    {
        return BootstrapCache::getInstance()->getCacheContent(BootstrapCache::CACHE_PHARMODULES);
    }

    /**
     * Returns the number of classes loaded internally
     *
     * @return int
     */
    public function getIntNumberOfClassesLoaded()
    {
        return $this->intNumberOfClassesLoaded;
    }


}
