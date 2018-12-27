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
        $arrFields["downloads_log_ip"] = array("char254", true);

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
        $this->registerConstant("_mediamanager_default_temprepoid_", "", SystemSetting::$int_TYPE_STRING, _mediamanager_module_id_);

        $strReturn .= "Trying to copy the *.root files to top-level...\n";
        if (!file_exists(_realpath_."download.php")) {
            if (!copy(Resourceloader::getInstance()->getAbsolutePathForModule("module_mediamanager")."/download.php.root", _realpath_."download.php")) {
                $strReturn .= "<b>Copying the download.php.root to top level failed!!!</b>";
            }
        }



        $strReturn .= "Creating upload folders\n";
        if (!is_dir(_realpath_._filespath_."/images/upload")) {
            mkdir(_realpath_._filespath_."/images/upload", 0777, true);
        }

        if (!is_dir(_realpath_._filespath_."/downloads/default")) {
            mkdir(_realpath_._filespath_."/downloads/default", 0777, true);
        }

        if (!is_dir(_realpath_._filespath_."/temp")) {
            mkdir(_realpath_._filespath_."/temp", 0777, true);
        }

        $strReturn .= "Creating new picture repository\n";
        $objRepo = new MediamanagerRepo();
        $objRepo->setStrTitle("Picture uploads");
        $objRepo->setStrPath(_filespath_."/images/upload");
        $objRepo->setStrUploadFilter(".jpg,.png,.gif,.jpeg");
        $objRepo->setStrViewFilter(".jpg,.png,.gif,.jpeg");
        $objRepo->updateObjectToDb();
        $objRepo->syncRepo();
        $strReturn .= "ID of new repo: ".$objRepo->getSystemid()."\n";

        $strReturn .= "Setting the repository as the default images repository\n";
        $objSetting = SystemSetting::getConfigByName("_mediamanager_default_imagesrepoid_");
        $objSetting->setStrValue($objRepo->getSystemid());
        $objSetting->updateObjectToDb();

        $strReturn .= "Creating new file repository\n";
        $objRepo = new MediamanagerRepo();
        $objRepo->setStrTitle("File uploads");
        $objRepo->setStrPath(_filespath_."/downloads/default");
        $objRepo->setStrUploadFilter(".zip,.pdf,.txt");
        $objRepo->setStrViewFilter(".zip,.pdf,.txt");
        $objRepo->updateObjectToDb();
        $objRepo->syncRepo();
        $strReturn .= "ID of new repo: ".$objRepo->getSystemid()."\n";

        $strReturn .= "Setting the repository as the default files repository\n";
        $objSetting = SystemSetting::getConfigByName("_mediamanager_default_filesrepoid_");
        $objSetting->setStrValue($objRepo->getSystemid());
        $objSetting->updateObjectToDb();



        $strReturn .= "Creating new temp repository\n";
        $objRepo = new MediamanagerRepo();
        $objRepo->setStrTitle("Temp uploads");
        $objRepo->setStrPath(_filespath_."/temp");
        $objRepo->updateObjectToDb();
        $objRepo->syncRepo();
        $strReturn .= "ID of new repo: ".$objRepo->getSystemid()."\n";

        $strReturn .= "Setting the repository as the default files repository\n";
        $objSetting = SystemSetting::getConfigByName("_mediamanager_default_temprepoid_");
        $objSetting->setStrValue($objRepo->getSystemid());
        $objSetting->updateObjectToDb();




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

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if($arrModule["module_version"] == "6.6") {
            $strReturn .= "Updating to 7.0...\n";
            $this->updateModuleVersion($this->objMetadata->getStrTitle(), "7.0");
        }

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if($arrModule["module_version"] == "7.0") {
            $strReturn .= $this->update70_701();
        }

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if($arrModule["module_version"] == "7.0.1") {
            $strReturn .= $this->update701_702();
        }

        return $strReturn."\n\n";
    }

    private function update70_701()
    {
        $strReturn = "Update to 7.0.1".PHP_EOL;

        if (!is_dir(_realpath_._filespath_."/temp")) {
            mkdir(_realpath_._filespath_."/temp", 0777, true);
        }

        $this->registerConstant("_mediamanager_default_temprepoid_", "", SystemSetting::$int_TYPE_STRING, _mediamanager_module_id_);

        $strReturn .= "Creating new temp repository\n";
        $objRepo = new MediamanagerRepo();
        $objRepo->setStrTitle("Temp uploads");
        $objRepo->setStrPath(_filespath_."/temp");
        $objRepo->updateObjectToDb();
        $objRepo->syncRepo();
        $strReturn .= "ID of new repo: ".$objRepo->getSystemid()."\n";

        $strReturn .= "Setting the repository as the default files repository\n";
        $objSetting = SystemSetting::getConfigByName("_mediamanager_default_temprepoid_");
        $objSetting->setStrValue($objRepo->getSystemid());
        $objSetting->updateObjectToDb();

        $this->updateModuleVersion($this->objMetadata->getStrTitle(), "7.0.1");
        return $strReturn;
    }

    private function update701_702()
    {
        $strReturn = "Update to 7.0.2".PHP_EOL;
        $strReturn .= "Changing log table".PHP_EOL;
        $this->objDB->changeColumn("mediamanager_dllog", "downloads_log_ip", "downloads_log_ip", DbDatatypes::STR_TYPE_CHAR254);

        $this->updateModuleVersion($this->objMetadata->getStrTitle(), "7.0.2");
        return $strReturn;
    }


}
