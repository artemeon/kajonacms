<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                            *
********************************************************************************************************/

namespace Kajona\Mediamanager\Installer;

use Kajona\Mediamanager\System\MediamanagerFile;
use Kajona\Mediamanager\System\MediamanagerRepo;
use Kajona\System\System\DbDatatypes;
use Kajona\System\System\InstallerBase;
use Kajona\System\System\InstallerInterface;
use Kajona\System\System\OrmSchemamanager;
use Kajona\System\System\Resourceloader;
use Kajona\System\System\SystemModule;
use Kajona\System\System\SystemSetting;


/**
 * Installer to install the mediamanager-module
 *
 * @package module_mediamanager
 * @moduleId _mediamanager_module_id_
 */
class InstallerMediamanager extends InstallerBase implements InstallerInterface
{

    public function install()
    {

        $strReturn = "Installing ".$this->objMetadata->getStrTitle()."...\n";
        $objManager = new OrmSchemamanager();

        $strReturn .= "Installing table mediamanager_repo...\n";
        $objManager->createTable(MediamanagerRepo::class);

        $strReturn .= "Installing table mediamanager_file...\n";
        $objManager->createTable(MediamanagerFile::class);


        $strReturn .= "Installing table mediamanager_dllog...\n";

        $arrFields = array();
        $arrFields["downloads_log_id"] = array("char20", false);
        $arrFields["downloads_log_date"] = array("int", true);
        $arrFields["downloads_log_file"] = array("char254", true);
        $arrFields["downloads_log_user"] = array("char20", true);
        $arrFields["downloads_log_ip"] = array("char20", true);

        if (!$this->objDB->createTable("mediamanager_dllog", $arrFields, array("downloads_log_id"))) {
            $strReturn .= "An error occurred! ...\n";
        }


        //register the module
        $this->registerModule(
            "mediamanager",
            _mediamanager_module_id_,
            "",
            "MediamanagerAdmin.php",
            $this->objMetadata->getStrVersion()
        );

        //The folderview
        $this->registerModule("folderview", _mediamanager_folderview_modul_id_, "", "FolderviewAdmin.php", $this->objMetadata->getStrVersion(), false);

        $this->registerConstant("_mediamanager_default_imagesrepoid_", "", SystemSetting::$int_TYPE_STRING, _mediamanager_module_id_);
        $this->registerConstant("_mediamanager_default_filesrepoid_", "", SystemSetting::$int_TYPE_STRING, _mediamanager_module_id_);

        $strReturn .= "Trying to copy the *.root files to top-level...\n";
        if (!file_exists(_realpath_."download.php")) {
            if (!copy(Resourceloader::getInstance()->getAbsolutePathForModule("module_mediamanager")."/download.php.root", _realpath_."download.php")) {
                $strReturn .= "<b>Copying the download.php.root to top level failed!!!</b>";
            }
        }


        return $strReturn;

    }


    public function update()
    {
        $strReturn = "";
        //check installed version and to which version we can update
        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        $strReturn .= "Version found:\n\t Module: ".$arrModule["module_name"].", Version: ".$arrModule["module_version"]."\n\n";

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if ($arrModule["module_version"] == "6.2") {
            $strReturn = "Updating to 6.5...\n";
            $this->updateModuleVersion($this->objMetadata->getStrTitle(), "6.5");
            $this->updateModuleVersion("folderview", "6.5");
        }

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if ($arrModule["module_version"] == "6.5") {
            $strReturn = "Updating to 6.5.1...\n";

            $this->objDB->addColumn("mediamanager_file", "file_search_content", DbDatatypes::STR_TYPE_TEXT);
            $this->objDB->addColumn("mediamanager_repo", "repo_search_index", DbDatatypes::STR_TYPE_INT);

            $this->updateModuleVersion($this->objMetadata->getStrTitle(), "6.5.1");
            $this->updateModuleVersion("folderview", "6.5.1");
        }

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if($arrModule["module_version"] == "6.5.1") {
            $strReturn .= "Updating to 6.6...\n";
            $this->updateModuleVersion($this->objMetadata->getStrTitle(), "6.6");
        }

        return $strReturn."\n\n";
    }


}
