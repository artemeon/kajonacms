<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
********************************************************************************************************/

namespace Kajona\System\Tests;


use Kajona\System\System\Carrier;
use Kajona\System\System\Classloader;
use Kajona\System\System\Config;
use Kajona\System\System\Database;
use Kajona\System\System\Date;
use Kajona\System\System\Lifecycle\ServiceLifeCycleFactory;
use Kajona\System\System\Model;
use Kajona\System\System\OrmBase;
use Kajona\System\System\Reflection;
use Kajona\System\System\StringUtil;
use PHPUnit\Framework\TestCase;


/**
 * The Testbase is the common baseclass for all testcases.
 * Triggers the methods required to run proper PHPUnit tests such as starting the system-kernel
 *
 * @package module_system
 * @since 3.4
 * @author sidler@mulchprod.de
 */
abstract class Testbase extends TestCase
{

    private $arrTestStartDate = null;

    protected function printDebugValues()
    {
        $strDebug = "";
        $arrTimestampEnde = gettimeofday();
        $intTimeUsed = (($arrTimestampEnde['sec'] * 1000000 + $arrTimestampEnde['usec'])
                - ($this->arrTestStartDate['sec'] * 1000000 + $this->arrTestStartDate['usec'])) / 1000000;

        $strDebug .= "PHP-Time:                            ".number_format($intTimeUsed, 6)." sec \n";

        //Hows about the queries?
        $strDebug .= "Queries db/cachesize/cached/fired:   ".Carrier::getInstance()->getObjDB()->getNumber()."/".
            Carrier::getInstance()->getObjDB()->getCacheSize()."/".
            Carrier::getInstance()->getObjDB()->getNumberCache()."/".
            (Carrier::getInstance()->getObjDB()->getNumber() - Carrier::getInstance()->getObjDB()->getNumberCache())." \n";

        //memory
        $strDebug .= "Memory/Max Memory:                   ".bytesToString(memory_get_usage())."/".bytesToString(memory_get_peak_usage())." \n";
        $strDebug .= "Classes Loaded:                      ".Classloader::getInstance()->getIntNumberOfClassesLoaded()." \n";

        //echo get_called_class()."\n".$strDebug."\n";
    }

    protected function setUp()
    {

        $this->arrTestStartDate = gettimeofday();


        if (!defined("_autotesting_")) {
            define("_autotesting_", true);
        }

        Carrier::getInstance()->flushCache(Carrier::INT_CACHE_TYPE_APC | Carrier::INT_CACHE_TYPE_DBQUERIES);
        parent::setUp();
    }


    protected function tearDown()
    {
        Carrier::getInstance()->flushCache(Carrier::INT_CACHE_TYPE_CHANGELOG);

        $this->printDebugValues();

        parent::tearDown();
    }

    protected function flushDBCache()
    {
        Carrier::getInstance()->flushCache(Carrier::INT_CACHE_TYPE_DBQUERIES | Carrier::INT_CACHE_TYPE_DBTABLES);
    }


    /**
     * Crreates an object of type '$strClassType'.
     * Only properties which are annotated with @var will be considered
     *
     * @param string $strClassType - the name of the class as a string
     * @param string $strParentId - the parent id of the object to be created
     * @param array $arrExcludeFillProperty - array of poperty names which will not be set
     * @param array $arrPropertyValues - assoziative array which has as key the property name and as value the to be set for the property
     * @param boolean $bitAutofillProperties - if true all properties which have annotation @tableColumn agp_will be filled with random values
     *
     * @return Model
     */
    protected function createObject($strClassType, $strParentId, array $arrExcludeFillProperty = array(), array $arrPropertyValues = array(), $bitAutofillProperties = true)
    {
        //get properties with an tablecolumn annotation
        /** @var Model $objObject */
        $objObject = new $strClassType();
        $objReflection = new Reflection($strClassType);
        $arrProperties = $objReflection->getPropertiesWithAnnotation(OrmBase::STR_ANNOTATION_TABLECOLUMN);
        $arrProperties = array_merge($objReflection->getPropertiesWithAnnotation(OrmBase::STR_ANNOTATION_OBJECTLIST), $arrProperties);

        //exclude Root properties
        $objRootReflection = new Reflection("Kajona\\System\\System\\Root");
        $arrExcludeFillProperty = array_merge($arrExcludeFillProperty, array_keys($objRootReflection->getPropertiesWithAnnotation(OrmBase::STR_ANNOTATION_TABLECOLUMN)));

        foreach ($arrProperties as $strPropName => $strValue) {

            //Exclude properties to be set
            if (in_array($strPropName, $arrExcludeFillProperty)) {
                continue;
            }

            //Set properties from array $arrPropertyValues
            if (array_key_exists($strPropName, $arrPropertyValues)) {
                $strSetterMethod = $objReflection->getSetter($strPropName);
                if ($strSetterMethod !== null) {
                    $objValue = $arrPropertyValues[$strPropName];
                    $objObject->$strSetterMethod($objValue);
                    continue;
                }
            }

            //check if the property is annotated with @tablecolumn
            if ($bitAutofillProperties) {
                if ($objReflection->hasPropertyAnnotation($strPropName, OrmBase::STR_ANNOTATION_TABLECOLUMN)) {
                    $strSetterMethod = $objReflection->getSetter($strPropName);
                    if ($strSetterMethod !== null) {
                        //determine the field type
                        $strDataType = $objReflection->getAnnotationValueForProperty($strPropName, "@var");
                        $strFieldType = $objReflection->getAnnotationValueForProperty($strPropName, "@fieldType");
                        $objMethodValue = null;

                        if ($strDataType == "string") {
                            if ($strFieldType == "text" || $strFieldType == "textarea") {
                                $objMethodValue = $strPropName."_".$objObject->getStrSystemid();

                                if (StringUtil::length($objMethodValue) > 10) {
                                    $objMethodValue = StringUtil::truncate($objMethodValue, 10, "");
                                }
                            }
                        }
                        elseif ($strDataType == "int" || $strDataType == "numeric") {
                            if ($strFieldType != "dropdown") {
                                $objMethodValue = 1;
                            }
                        }
                        elseif ($strDataType == "\Kajona\System\System\Date") {
                            $objMethodValue = new Date();
                        }
                        elseif ($strDataType == "bool") {
                            $objMethodValue = false;
                        }
                        else {
                            continue;//continue with foreach
                        }

                        $objObject->$strSetterMethod($objMethodValue);
                    }
                }
            }
        }

        //save it
        ServiceLifeCycleFactory::getLifeCycle(get_class($objObject))->update($objObject, $strParentId);
        return $objObject;
    }


    /**
     * Resets all relevant caches
     */
    protected function resetCaches()
    {
        Carrier::getInstance()->flushCache(Carrier::INT_CACHE_TYPE_DBQUERIES | Carrier::INT_CACHE_TYPE_ORMCACHE | Carrier::INT_CACHE_TYPE_OBJECTFACTORY | Carrier::INT_CACHE_TYPE_APC);
    }

}


