<?php
/*"******************************************************************************************************
*   (c) 2007-2012 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                              *
********************************************************************************************************/

/**
 * Installer of the packageserver module
 *
 * @package module_packageserver
 */
class class_installer_packageserver extends class_installer_base {

    public function __construct() {

        $this->objMetadata = new class_module_packagemanager_metadata();
        $this->objMetadata->autoInit(uniStrReplace(array(DIRECTORY_SEPARATOR."installer", _realpath_), array("", ""), __DIR__));

        $this->setArrModuleEntry("moduleId", _packageserver_module_id_);
        parent::__construct();
    }


    public function install() {

        $strReturn = "";

        $strReturn .= "Installing table packageserver_log...\n";

        $arrFields = array();
        $arrFields["log_id"] = array("char20", false);
        $arrFields["log_query"] = array("char254", true);
        $arrFields["log_ip"] = array("char254", true);
        $arrFields["log_hostname"] = array("char254", true);
        $arrFields["log_date"] = array("long", true);

        if(!$this->objDB->createTable("packageserver_log", $arrFields, array("log_id"), array("log_date"), false))
            $strReturn .= "An error occured! ...\n";


        //register the module
        $this->registerModule("packageserver", _packageserver_module_id_, "class_module_packageserver_portal.php", "class_module_packageserver_admin.php", $this->objMetadata->getStrVersion(), true);


        $strReturn .= "creating package-upload-repository...\n";
        $objFilesytem = new class_filesystem();
        $objFilesytem->folderCreate("/files/packages");
        $objRepo = new class_module_mediamanager_repo();
        $objRepo->setStrPath("/files/packages");
        $objRepo->setStrViewFilter(".zip");
        $objRepo->setStrUploadFilter(".zip");
        $objRepo->setStrTitle("Packageserver packages");
        $objRepo->updateObjectToDb();

        class_carrier::getInstance()->getObjRights()->addGroupToRight(_guests_group_id_, $objRepo->getSystemid(), class_rights::$STR_RIGHT_RIGHT2);


        $strReturn .= "Registering system-constants...\n";
        $this->registerConstant("_packageserver_repo_id_", $objRepo->getSystemid(), class_module_system_setting::$int_TYPE_STRING, _packageserver_module_id_);


        return $strReturn;

    }


    public function update() {
        $strReturn = "";
        //check installed version and to which version we can update
        $arrModul = $this->getModuleData($this->objMetadata->getStrTitle(), false);

        $strReturn .= "Version found:\n\t Module: ".$arrModul["module_name"].", Version: ".$arrModul["module_version"]."\n\n";


        return $strReturn."\n\n";
    }

}
