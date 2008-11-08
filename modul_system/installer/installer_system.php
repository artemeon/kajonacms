<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2008 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                        *
********************************************************************************************************/

require_once(_systempath_."/class_installer_base.php");
require_once(_systempath_."/interface_installer.php");

/**
 * Installer for the system-module
 *
 * @package modul_system
 */
class class_installer_system extends class_installer_base implements interface_installer {

    private $strContentLanguage;

	public function __construct() {

		$arrModul["version"] 			= "3.1.9";
		$arrModul["name"] 				= "system";
		$arrModul["class_admin"] 		= "class_system_admin";
		$arrModul["file_admin"] 		= "class_system_admin.php";
		$arrModul["class_portal"]		= "";
		$arrModul["file_portal"] 		= "";
		$arrModul["name_lang"] 			= "System kernel";
		$arrModul["moduleId"] 			= _system_modul_id_;

		$arrModul["tabellen"][] 		= _dbprefix_."system";
		$arrModul["tabellen"][] 		= _dbprefix_."system_right";
		$arrModul["tabellen"][] 		= _dbprefix_."system_module";
		$arrModul["tabellen"][] 		= _dbprefix_."system_date";
		$arrModul["tabellen"][] 		= _dbprefix_."user";
		$arrModul["tabellen"][] 		= _dbprefix_."user_group";
		$arrModul["tabellen"][] 		= _dbprefix_."user_group_members";
		$arrModul["tabellen"][] 		= _dbprefix_."user_log";
		$arrModul["tabellen"][] 		= _dbprefix_."filemanager";

		parent::__construct($arrModul);
		
		//set the correct language
		if($this->objSession->getAdminLanguage() == "en")
		    $this->strContentLanguage = "en";
		else
		    $this->strContentLanguage = "de";
	}


	public function getMinSystemVersion() {
	    return "";
	}

	public function getNeededModules() {
	    return array();
	}

	public function hasPostInstalls() {
        //check, if not already existing
	    $objElement = null;
		try {
		    $objElement = class_modul_pages_element::getElement("languageswitch");
		}
		catch (class_exception $objEx)  {
		}
        if($objElement == null)
            return true;

        return false;
	}

	public function postInstall() {
	    //Register the element
		$strReturn = "Registering languageswitch-element...\n";
		//check, if not already existing
		$strQuery = "SELECT COUNT(*) FROM "._dbprefix_."element WHERE element_name='languageswitch'";
		$arrRow = $this->objDB->getRow($strQuery);
		if($arrRow["COUNT(*)"] == 0) {
			$strQuery = "INSERT INTO "._dbprefix_."element
							(element_id, element_name, element_class_portal, element_class_admin, element_repeat) VALUES
							('".$this->generateSystemid()."', 'languageswitch', 'class_element_languageswitch.php', 'class_element_languageswitch.php', 0)";
			$this->objDB->_query($strQuery);
			$strReturn .= "Element registered...\n";
		}
		else {
				$strReturn .= "Element already installed!...\n";
		}
		
		return $strReturn;
	}


	public function install() {
	    $strReturn = "";

		// System table ---------------------------------------------------------------------------------
		$strReturn .= "Installing table system...\n";

		$arrFields = array();
		$arrFields["system_id"] 		= array("char20", false);
		$arrFields["system_prev_id"] 	= array("char20", false);
		$arrFields["system_module_nr"] 	= array("int", false);
		$arrFields["system_sort"] 		= array("int", true);
		$arrFields["system_lm_user"] 	= array("char20", true);
		$arrFields["system_lm_time"] 	= array("int", true);
		$arrFields["system_lock_id"] 	= array("char20", true);
		$arrFields["system_lock_time"] 	= array("int", true);
		$arrFields["system_status"] 	= array("int", true);
		$arrFields["system_comment"]	= array("char254", true);
		
		if(!$this->objDB->createTable("system", $arrFields, array("system_id"), array("system_prev_id", "system_module_nr")))
			$strReturn .= "An error occured! ...\n";

		//Rights table ----------------------------------------------------------------------------------
		$strReturn .= "Installing table system_right...\n";
		
		$arrFields = array();
		$arrFields["right_id"] 		= array("char20", false);
		$arrFields["right_comment"] = array("char254", true);
		$arrFields["right_inherit"] = array("int", true);
		$arrFields["right_view"] 	= array("char254", true);
		$arrFields["right_edit"] 	= array("char254", true);
		$arrFields["right_delete"] 	= array("char254", true);
		$arrFields["right_right"] 	= array("char254", true);
		$arrFields["right_right1"] 	= array("char254", true);
		$arrFields["right_right2"] 	= array("char254", true);
		$arrFields["right_right3"] 	= array("char254", true);
		$arrFields["right_right4"] 	= array("char254", true);
		$arrFields["right_right5"] 	= array("char254", true);

		if(!$this->objDB->createTable("system_right", $arrFields, array("right_id")))
			$strReturn .= "An error occured! ...\n";

		// Modul table ----------------------------------------------------------------------------------
		$strReturn .= "Installing table system_module...\n";
		
		$arrFields = array();
		$arrFields["module_id"] 			    = array("char20", false);
		$arrFields["module_nr"]					= array("int", false);
		$arrFields["module_name"] 				= array("char254", false);
		$arrFields["module_filenameportal"] 	= array("char254", true);
		$arrFields["module_xmlfilenameportal"] 	= array("char254", true);
		$arrFields["module_filenameadmin"] 		= array("char254", true);
		$arrFields["module_xmlfilenameadmin"] 	= array("char254", true);
		$arrFields["module_version"] 			= array("char254", true);
		$arrFields["module_date"] 				= array("int", true);
		$arrFields["module_navigation"] 		= array("int", true);

		if(!$this->objDB->createTable("system_module", $arrFields, array("module_id")))
			$strReturn .= "An error occured! ...\n";

		// Date table -----------------------------------------------------------------------------------
		$strReturn .= "Installing table system_date...\n";
		
		$arrFields = array();
		$arrFields["system_date_id"] 		= array("char20", false);
		$arrFields["system_date_start"]		= array("int", true);
		$arrFields["system_date_end"] 		= array("int", true);
		$arrFields["system_date_special"] 	= array("int", true);
		
		if(!$this->objDB->createTable("system_date", $arrFields, array("system_date_id")))
			$strReturn .= "An error occured! ...\n";

		// Config table ---------------------------------------------------------------------------------
		$strReturn .= "Installing table system_config...\n";

		$arrFields = array();
		$arrFields["system_config_id"] 		= array("char20", false);
		$arrFields["system_config_name"]	= array("char254", true);
		$arrFields["system_config_value"] 	= array("char254", true);
		$arrFields["system_config_type"] 	= array("int", true);
		$arrFields["system_config_module"] 	= array("int", true);
		
		if(!$this->objDB->createTable("system_config", $arrFields, array("system_config_id")))
			$strReturn .= "An error occured! ...\n";


		// User table -----------------------------------------------------------------------------------
		$strReturn .= "Installing table user...\n";
		
		$arrFields = array();
		$arrFields["user_id"] 			= array("char20", false);
		$arrFields["user_username"]		= array("char254", true);
		$arrFields["user_pass"] 		= array("char254", true);
		$arrFields["user_email"] 		= array("char254", true);
		$arrFields["user_forename"] 	= array("char254", true);
		$arrFields["user_name"] 		= array("char254", true);
		$arrFields["user_street"] 		= array("char254", true);
		$arrFields["user_postal"] 		= array("char254", true);
		$arrFields["user_city"] 		= array("char254", true);
		$arrFields["user_tel"] 			= array("char254", true);
		$arrFields["user_mobile"] 		= array("char254", true);
		$arrFields["user_date"] 		= array("char254", true);
		$arrFields["user_logins"] 		= array("int", true);
		$arrFields["user_lastlogin"] 	= array("int", true);
		$arrFields["user_active"] 		= array("int", true);
		$arrFields["user_admin"] 		= array("int", true);
		$arrFields["user_portal"] 		= array("int", true);
		$arrFields["user_admin_skin"] 	= array("char254", true);
		$arrFields["user_admin_language"]=array("char254", true);

		if(!$this->objDB->createTable("user", $arrFields, array("user_id")))
			$strReturn .= "An error occured! ...\n";


		// User group table -----------------------------------------------------------------------------
		$strReturn .= "Installing table user_group...\n";
		
		$arrFields = array();
		$arrFields["group_id"] 			= array("char20", false);
		$arrFields["group_name"]		= array("char254", true);

		if(!$this->objDB->createTable("user_group", $arrFields, array("group_id")))
			$strReturn .= "An error occured! ...\n";


		// User group_members table ---------------------------------------------------------------------
		$strReturn .= "Installing table user_group_members...\n";
		
		$arrFields = array();
		$arrFields["group_member_group_id"] 	= array("char20", false);
		$arrFields["group_member_user_id"]		= array("char20", false);

		if(!$this->objDB->createTable("user_group_members", $arrFields, array("group_member_group_id", "group_member_user_id")))
			$strReturn .= "An error occured! ...\n";


		// User log table -------------------------------------------------------------------------------
		$strReturn .= "Installing table user_log...\n";
		
		$arrFields = array();
		$arrFields["user_log_id"] 		= array("char20", false);
		$arrFields["user_log_userid"]	= array("char254", true);
		$arrFields["user_log_date"] 	= array("int", true);
		$arrFields["user_log_status"] 	= array("int", true);
		$arrFields["user_log_ip"] 		= array("char20", true);

		if(!$this->objDB->createTable("user_log", $arrFields, array("user_log_id")))
			$strReturn .= "An error occured! ...\n";
			
		// Sessionmgtm ----------------------------------------------------------------------------------
		$strReturn .= "Installing table session...\n";
		
		$arrFields = array();
		$arrFields["session_id"] 		      = array("char20", false);
		$arrFields["session_phpid"]	          = array("char254", true);
		$arrFields["session_userid"] 	      = array("char20", true);
		$arrFields["session_groupids"] 	      = array("text", true);
		$arrFields["session_releasetime"]     = array("int", true);
		$arrFields["session_loginstatus"]     = array("char254", true);
		$arrFields["session_loginprovider"]   = array("char20", true);
		$arrFields["session_lasturl"] 		  = array("char254", true);

		if(!$this->objDB->createTable("session", $arrFields, array("session_id"), array("session_phpid")))
			$strReturn .= "An error occured! ...\n";	

		//Filemanager -----------------------------------------------------------------------------------
		$strReturn .= "Installing table filemanager...\n";
		
		$arrFields = array();
		$arrFields["filemanager_id"] 			= array("char20", false);
		$arrFields["filemanager_path"]			= array("char254", true);
		$arrFields["filemanager_name"] 			= array("char254", true);
		$arrFields["filemanager_upload_filter"] = array("char254", true);
		$arrFields["filemanager_view_filter"] 	= array("char254", true);

		if(!$this->objDB->createTable("filemanager", $arrFields, array("filemanager_id")))
			$strReturn .= "An error occured! ...\n";

        //dashboard & widgets ---------------------------------------------------------------------------			
		$strReturn .= "Installing table dashboard...\n";
		
		$arrFields = array();
		$arrFields["dashboard_id"] 			= array("char20", false);
		$arrFields["dashboard_column"]		= array("char254", true);
		$arrFields["dashboard_user"] 		= array("char20", true);
		$arrFields["dashboard_widgetid"] 	= array("char20", true);
		
		if(!$this->objDB->createTable("dashboard", $arrFields, array("dashboard_id")))
			$strReturn .= "An error occured! ...\n";

		$strReturn .= "Installing table adminwidget...\n";
		
		$arrFields = array();
		$arrFields["adminwidget_id"] 		= array("char20", false);
		$arrFields["adminwidget_class"]		= array("char254", true);
		$arrFields["adminwidget_content"] 	= array("text", true);
		
		if(!$this->objDB->createTable("adminwidget", $arrFields, array("adminwidget_id")))
			$strReturn .= "An error occured! ...\n";
			
		//remoteloader-cache ----------------------------------------------------------------------------
		$strReturn .= "Installing table remoteloader_cache...\n";
			
		$arrFields = array();
		$arrFields["remoteloader_cache_checksum"]     = array("char40", false);
		$arrFields["remoteloader_cache_releasetime"]  = array("int", false);
		$arrFields["remoteloader_cache_response"]     = array("text", false);
		
		if(!$this->objDB->createTable("remoteloader_cache", $arrFields, array("remoteloader_cache_checksum")))
            $strReturn .= "An error occured! ...\n";
            
        //languages -------------------------------------------------------------------------------------
        $strReturn .= "Installing table languages...\n";
		
		$arrFields = array();
		$arrFields["language_id"] 		= array("char20", false);
		$arrFields["language_name"] 	= array("char254", true);
		$arrFields["language_default"]  = array("int", true);

		if(!$this->objDB->createTable("languages", $arrFields, array("language_id")))
			$strReturn .= "An error occured! ...\n";            
			
			

		//Now we have to register module by module

		//The Systemkernel
		$strSystemID = $this->registerModule("system", _system_modul_id_, "", "class_system_admin.php", $this->arrModule["version"], true, "", "class_modul_system_admin_xml.php" );
		//The Rightsmodule
		$strRightID = $this->registerModule("right", _system_modul_id_, "", "class_right_admin.php", $this->arrModule["version"], false );
		//The Usermodule
		$strUserID = $this->registerModule("user", _user_modul_id_, "", "class_user_admin.php", $this->arrModule["version"], true );
        //The filemanagermodule
		$strFilemanagerID = $this->registerModule("filemanager", _filemanager_modul_id_, "", "class_modul_filemanager_admin.php", $this->arrModule["version"], true, "", "class_modul_filemanager_admin_xml.php");
        //the dashboard
        $strDashboardID = $this->registerModule("dashboard", _dashboard_modul_id_, "", "class_modul_dashboard_admin.php", $this->arrModule["version"], false, "", "class_modul_dashboard_admin_xml.php");
        //languages
        $strLanguagesID = $this->registerModule("languages", _languages_modul_id_, "class_modul_languages_portal.php", "class_modul_languages_admin.php", $this->arrModule["version"] , true);
        
        
        
		//Registering a few constants
		$strReturn .= "Registering system-constants...\n";
		//Number of rows in the login-log
		$this->registerConstant("_user_log_anzahl_", "50", 1, _user_modul_id_);
        //Systemid of guest-user & admin group
        $strGuestID = $this->generateSystemid();
        $strAdminID = $this->generateSystemid();
        $this->registerConstant("_gaeste_gruppe_id_", $strGuestID, class_modul_system_setting::$int_TYPE_STRING, _user_modul_id_);
        $this->registerConstant("_admin_gruppe_id_", $strAdminID, class_modul_system_setting::$int_TYPE_STRING, _user_modul_id_);
        //And the default skin
        $this->registerConstant("_admin_skin_default_", "kajona_v3", class_modul_system_setting::$int_TYPE_STRING, _user_modul_id_);

        //and a few system-settings
        $this->registerConstant("_system_portal_disable_", "false", class_modul_system_setting::$int_TYPE_BOOL, _system_modul_id_);
        $this->registerConstant("_system_portal_disablepage_", "", class_modul_system_setting::$int_TYPE_PAGE, _system_modul_id_);

        //new in 2.1.1.0: cachepath now in the system-settings
        $this->registerConstant("_bildergalerie_cachepfad_", "/portal/pics/cache/", class_modul_system_setting::$int_TYPE_STRING, _system_modul_id_);

        //New in 3.0: Number of db-dumps to hold
	    $this->registerConstant("_system_dbdump_amount_", 5, class_modul_system_setting::$int_TYPE_INT, _system_modul_id_);
	    //new in 3.0: mod-rewrite on / off
        $this->registerConstant("_system_mod_rewrite_", "false", class_modul_system_setting::$int_TYPE_BOOL, _system_modul_id_);
        //New Constant: Max time to lock records
	    $this->registerConstant("_system_lock_maxtime_", 7200, class_modul_system_setting::$int_TYPE_INT, _system_modul_id_);
        //Filemanger settings
        $this->registerConstant("_filemanager_ordner_groesse_", "true", class_modul_system_setting::$int_TYPE_BOOL, _filemanager_modul_id_);
        //Email to send error-reports
	    $this->registerConstant("_system_admin_email_", "", class_modul_system_setting::$int_TYPE_STRING, _system_modul_id_);
	    //3.0.1: gzip-compression
	    $this->registerConstant("_system_output_gzip_", "false", class_modul_system_setting::$int_TYPE_BOOL, _system_modul_id_);

	    //3.0.2: user are allowed to change their settings?
	    $this->registerConstant("_user_selfedit_", "true", class_modul_system_setting::$int_TYPE_BOOL, _user_modul_id_);

	    //3.1: nr of rows in admin
	    $this->registerConstant("_admin_nr_of_rows_", 15, class_modul_system_setting::$int_TYPE_INT, _system_modul_id_);
	    $this->registerConstant("_admin_only_https_", "false", class_modul_system_setting::$int_TYPE_BOOL, _system_modul_id_);
        $this->registerConstant("_system_use_dbcache_", "true", class_modul_system_setting::$int_TYPE_BOOL, _system_modul_id_);
        
        //3.1: remoteloader max cachtime --> default 30 min
        $this->registerConstant("_remoteloader_max_cachetime_", 30*60, class_modul_system_setting::$int_TYPE_INT, _system_modul_id_);
        
        //3.2: max session duration
        $this->registerConstant("_system_release_time_", 3600, class_modul_system_setting::$int_TYPE_INT, _system_modul_id_);

        //Create an root-record for the tree
        $this->createSystemRecord(0, "System Rights Root", true, _system_modul_id_, "0");
		//BUT: We have to modify the right-record of the system
		$strGroupsAll = "'".$strGuestID.",".$strAdminID."'";
		$strGroupsAdmin = "'".$strAdminID."'";

		$strQuery = "UPDATE "._dbprefix_."system_right SET
						right_inherit	= 0,
					   	right_view	 	= ".$strGroupsAll.",
					   	right_edit 		= ".$strGroupsAdmin.",
					   	right_delete	= ".$strGroupsAdmin.",
					   	right_right		= ".$strGroupsAdmin.",
					   	right_right1 	= ".$strGroupsAdmin.",
					   	right_right2 	= ".$strGroupsAdmin.",
					   	right_right3  	= ".$strGroupsAdmin.",
					   	right_right4    = ".$strGroupsAdmin.",
					   	right_right5  	= ".$strGroupsAdmin."
					   	WHERE right_id='0'";

		$this->objDB->_query($strQuery);
		$strReturn .= "Modified root-rights....\n";

		//Creating the admin & guest groups
		$strQuery = "INSERT INTO "._dbprefix_."user_group
						(group_id, group_name) VALUES
						('".$strAdminID."', 'Admins')";
		$this->objDB->_query($strQuery);
		$strReturn .= "Registered Group Admins...\n";
		$strQuery = "INSERT INTO "._dbprefix_."user_group
						(group_id, group_name) VALUES
						('".$strGuestID."', 'Guests')";
		$this->objDB->_query($strQuery);
		$strReturn .= "Registered Group Guests...\n";

		//Creating an admin-user
		//Login-Data given from installer?
		if($this->objSession->getSession("install_username") !== false && $this->objSession->getSession("install_username") != "" &&
		   $this->objSession->getSession("install_password") !== false && $this->objSession->getSession("install_password") != "")
		   {
            $strUsername = dbsafeString($this->objSession->getSession("install_username"));
            $strPassword = dbsafeString($this->objSession->getSession("install_password"));
		}
		else {
            $strUsername = "admin";
            $strPassword = "kajona";
		}

		//the admin-language
		$strAdminLanguage = $this->objSession->getAdminLanguage();

		$strUserID = generateSystemid();
		$strQuery = "INSERT INTO "._dbprefix_."user
						(user_id, user_username, user_pass, user_admin, user_active, user_admin_language) VALUES
						('".$strUserID."', '".$strUsername."', '".$this->objSession->encryptPassword($strPassword)."', 1, 1, '".dbsafeString($strAdminLanguage)."')";
		$this->objDB->_query($strQuery);
		$strReturn .= "Created User Admin: <strong>Username: ".$strUsername.", Password: ***********</strong> ...\n";
		//The Admin should belong to the admin-Group
		$strQuery = "INSERT INTO "._dbprefix_."user_group_members
					(group_member_group_id, group_member_user_id) VALUES
					('".$strAdminID."','".$strUserID."')";
		$this->objDB->_query($strQuery);
		$strReturn .= "Registered Admin in Admin-Group...\n";
		
		//try to create a default-dashboard for the admin
		include_once(_systempath_."/class_modul_dashboard_widget.php");
        $objDashboard = new class_modul_dashboard_widget();
        $objDashboard->createInitialWidgetsForUser($strUserID);
        
        //create a default language
		$strReturn .= "Creating new default-language\n";
        include_once(_systempath_."/class_modul_languages_language.php");
        $objLanguage = new class_modul_languages_language();

        if($this->strContentLanguage == "de")
            $objLanguage->setStrName("de");
        else
           $objLanguage->setStrName("en");
           
        $objLanguage->setBitDefault(true);
        $objLanguage->saveObjectToDb();
        $strReturn .= "ID of new language: ".$objLanguage->getSystemid()."\n";

		return $strReturn;
	}


	protected function updateModuleVersion($strNewVersion) {
		parent::updateModuleVersion("system", $strNewVersion);
        parent::updateModuleVersion("right", $strNewVersion);
        parent::updateModuleVersion("user", $strNewVersion);
        parent::updateModuleVersion("filemanager", $strNewVersion);
        parent::updateModuleVersion("dashboard", $strNewVersion);
        parent::updateModuleVersion("languages", $strNewVersion);
	}

	public function update() {
	    $strReturn = "";
        //check the version we have and to what version to update
        $arrModul = $this->getModuleData($this->arrModule["name"], false);

        $strReturn .= "Version found:\n\t Module: ".$arrModul["module_name"].", Version: ".$arrModul["module_version"]."\n\n";

        $arrModul = $this->getModuleData($this->arrModule["name"], false);
        if($arrModul["module_version"] == "3.0.0") {
            $strReturn .= $this->update_300_301();
        }

        $arrModul = $this->getModuleData($this->arrModule["name"], false);
        if($arrModul["module_version"] == "3.0.1") {
            $strReturn .= $this->update_301_302();
        }

        $arrModul = $this->getModuleData($this->arrModule["name"], false);
        if($arrModul["module_version"] == "3.0.2") {
            $strReturn .= $this->update_302_309();
        }
        
		$arrModul = $this->getModuleData($this->arrModule["name"], false);
        if($arrModul["module_version"] == "3.0.9") {
            $strReturn .= $this->update_309_3095();
        }
        
	    $arrModul = $this->getModuleData($this->arrModule["name"], false);
        if($arrModul["module_version"] == "3.0.95") {
            $strReturn .= $this->update_3095_310();
        }
        
	    $arrModul = $this->getModuleData($this->arrModule["name"], false);
        if($arrModul["module_version"] == "3.1.0") {
            $strReturn .= $this->update_310_311();
        }
        
	    $arrModul = $this->getModuleData($this->arrModule["name"], false);
        if($arrModul["module_version"] == "3.1.1") {
            $strReturn .= $this->update_311_319();
        }
        
        return $strReturn."\n\n";
	}

	
	private function update_300_301() {
	    $strReturn = "";
	    $strReturn .= "Updating 3.0.0 to 3.0.1...\n";

	    //new constant for gzip
	    $strReturn .= "Registering gzip-compression constant...\n";
	    $this->registerConstant("_system_output_gzip_", "false", class_modul_system_setting::$int_TYPE_BOOL, _system_modul_id_);

        $strReturn .= "Updating module-versions...\n";
	    $this->updateModuleVersion("system", "3.0.1");
        $this->updateModuleVersion("right", "3.0.1");
        $this->updateModuleVersion("user", "3.0.1");
        $this->updateModuleVersion("filemanager", "3.0.1");

	    return $strReturn;
	}

	private function update_301_302() {
	    $strReturn = "";
	    $strReturn .= "Updating 3.0.1 to 3.0.2...\n";

	    //new constant for gzip
	    $strReturn .= "Registering user-selfedit constant...\n";
	    $this->registerConstant("_user_selfedit_", "true", class_modul_system_setting::$int_TYPE_BOOL, _user_modul_id_);

	    //try to delete the old fckeditor folders
	    include_once(_systempath_."/class_filesystem.php");
	    $objFilesystem = new class_filesystem();
	    $strReturn .= "Deleting old fck-editor folder...\n";
	    if(!$objFilesystem->folderDeleteRecursive("/admin/elemente/fckeditor"))
	       $strReturn .= "<b>Error deleting the folder \n /admin/elemente/fckeditor,\nplease delete manually</b>\n";

        $strReturn .= "Updating module-versions...\n";
	    $this->updateModuleVersion("system", "3.0.2");
        $this->updateModuleVersion("right", "3.0.2");
        $this->updateModuleVersion("user", "3.0.2");
        $this->updateModuleVersion("filemanager", "3.0.2");

	    return $strReturn;
	}

	private function update_302_309() {
	    $strReturn = "";
	    $strReturn .= "Updating 3.0.2 to 3.0.9...\n";

	    //new constant for nr of rows in admin
	    $strReturn .= "Registering nr of rows constant...\n";
	    $this->registerConstant("_admin_nr_of_rows_", 15, class_modul_system_setting::$int_TYPE_INT, _system_modul_id_);
        $strReturn .= "Registering admin https flag...\n";
	    $this->registerConstant("_admin_only_https_", "false", class_modul_system_setting::$int_TYPE_BOOL, _system_modul_id_);
	    
	    //add systems' xml-handler
	    $strReturn .= "Registering system xml handler...\n";
	    $objSystemModule = class_modul_system_module::getModuleByName("system");
	    $objSystemModule->setStrXmlNameAdmin("class_modul_system_admin_xml.php");
	    if(!$objSystemModule->updateObjectToDb())
	        $strReturn .= "An error occured!\n";
	        
	        
	    //dashboard & widgets ---------------------------------------------------------------------------			
		$strReturn .= "Installing table dashboard...\n";
		
		$arrFields = array();
		$arrFields["dashboard_id"] 			= array("char20", false);
		$arrFields["dashboard_column"]		= array("char254", true);
		$arrFields["dashboard_user"] 		= array("char20", true);
		$arrFields["dashboard_widgetid"] 	= array("char20", true);
		
		if(!$this->objDB->createTable("dashboard", $arrFields, array("dashboard_id")))
			$strReturn .= "An error occured! ...\n";

		$strReturn .= "Installing table adminwidget...\n";
		
		$arrFields = array();
		$arrFields["adminwidget_id"] 		= array("char20", false);
		$arrFields["adminwidget_class"]		= array("char254", true);
		$arrFields["adminwidget_content"] 	= array("text", true);
		
		if(!$this->objDB->createTable("adminwidget", $arrFields, array("adminwidget_id")))
			$strReturn .= "An error occured! ...\n";    
	        

        $strReturn .= "Registering new module dashboard...\n";
        $strDashboardID = $this->registerModule("dashboard", _dashboard_modul_id_, "", "class_modul_dashboard_admin.php", $this->arrModule["version"], false, "", "class_modul_dashboard_admin_xml.php");
        
        $strReturn .= "Removing classnames from module-table...\n";
        $strQuery = "ALTER TABLE `"._dbprefix_."system_module`
                        DROP `module_classnameportal`,
                        DROP `module_classnameadmin`;";
        if(!$this->objDB->_query($strQuery))
            $strReturn .= "An error occured!!!\n";
            
        $strReturn .= "Register db-cache constant...\n";    
        $this->registerConstant("_system_use_dbcache_", "true", class_modul_system_setting::$int_TYPE_BOOL, _system_modul_id_);    

	    $strReturn .= "Creating default dashboard for existing users...\n";
        include_once(_systempath_."/class_modul_dashboard_widget.php");
        include_once(_systempath_."/class_modul_user_user.php");
        $objDashboard = new class_modul_dashboard_widget();
        
        $arrUsers = class_modul_user_user::getAllUsers();
        foreach($arrUsers as $objOneUser) {
            $strReturn .= " found ".$objOneUser->getStrUsername()."\n";
            $objDashboard->createInitialWidgetsForUser($objOneUser->getSystemid());
        }

        $strReturn .= "Updating module-versions...\n";
	    $this->updateModuleVersion("3.0.9");

	    return $strReturn;
	}
	
	private function update_309_3095() {
	    $strReturn = "";
	    $strReturn .= "Updating 3.0.9 to 3.0.95...\n";

        $strReturn .= "Updating module-versions...\n";
	    $this->updateModuleVersion("3.0.95");

	    return $strReturn;
	}
	
    private function update_3095_310() {
        $strReturn = "";
        $strReturn .= "Updating 3.0.95 to 3.1.0...\n";
        
        $strReturn .= "Installing table remoteloader_cache...\n";
            
        $arrFields = array();
        $arrFields["remoteloader_cache_checksum"]     = array("char40", false);
        $arrFields["remoteloader_cache_releasetime"]  = array("int", false);
        $arrFields["remoteloader_cache_response"]     = array("text", false);
        
        if(!$this->objDB->createTable("remoteloader_cache", $arrFields, array("remoteloader_cache_checksum")))
            $strReturn .= "An error occured! ...\n";
            
        //3.1: remoteloader max cachtime --> default 30 min
        $strReturn .= "Registering remoteloader max cachteime constant...\n";
        $this->registerConstant("_remoteloader_max_cachetime_", 30*60, class_modul_system_setting::$int_TYPE_INT, _system_modul_id_);    

        $strReturn .= "Updating module-versions...\n";
        $this->updateModuleVersion("3.1.0");

        return $strReturn;
    }
    
    private function update_310_311() {
        $strReturn = "";
        $strReturn .= "Updating 3.1.0 to 3.1.1...\n";
        
        $strReturn .= "Deleting old js-calendar...\n";
        include_once(_systempath_."/class_filesystem.php");
        $objFilesystem = new class_filesystem();
        $strReturn .= "Deleting old calendar-editor folder...\n";
        if(!$objFilesystem->folderDeleteRecursive("/admin/scripts/jscalendar"))
           $strReturn .= "<b>Error deleting the folder \n /admin/scripts/jscalendar,\nplease delete manually</b>\n";
        

        
        $strReturn .= "Updating module-versions...\n";
        $this->updateModuleVersion("3.1.1");

        return $strReturn;
    }
    
    private function update_311_319() {
        $strReturn = "";
        $strReturn .= "Updating 3.1.1 to 3.1.9...\n";
        
        
        $strReturn .= "Registering filemanager xml handlers...\n";
        $objFilemanagerModule = class_modul_system_module::getModuleByName("filemanager", true);
        $objFilemanagerModule->setStrXmlNameAdmin("class_modul_filemanager_admin_xml.php");
        if(!$objFilemanagerModule->updateObjectToDb())
            $strReturn .= "An error occured!\n";
        
            
        //need to install languages?            
        $strReturn .= "Validating if languages are installed...\n";
        $objLanguagesModule = class_modul_system_module::getModuleByName("languages", true);
        if($objLanguagesModule == null)
            $strReturn .= $this->update_319_addLanguages();

        $strReturn .= "Deleting languages module-id file...\n";
        include_once(_systempath_."/class_filesystem.php");
        $objFilesystem = new class_filesystem();
        if(!$objFilesystem->fileDelete("/system/config/modul_languages_id.php"))
           $strReturn .= "<b>Error deleting the file \n /system/config/modul_languages_id.php,\nplease delete manually</b>\n";    
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskconsistency_de.php"))
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskconsistency_de.php,\nplease delete manually</b>\n";   
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskconsistency_en.php"))
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskconsistency_en.php,\nplease delete manually</b>\n";   
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskdbexport_de.php"))
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskdbexport_de.php,\nplease delete manually</b>\n";   
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskdbexport_en.php"))
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskdbexport_en.php,\nplease delete manually</b>\n";   
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskdbimport_de.php"))
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskdbimport_de.php,\nplease delete manually</b>\n";   
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskdbimport_en.php"))
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskdbimport_en.php,\nplease delete manually</b>\n";   
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskflushpiccache_de.php"))   
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskflushpiccache_de.php,\nplease delete manually</b>\n";   
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskflushpiccache_en.php"))
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskflushpiccache_en.php,\nplease delete manually</b>\n";   
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskflushremoteloadercache_de.php"))
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskflushremoteloadercache_de.php,\nplease delete manually</b>\n";         
        if(!$objFilesystem->fileDelete("/texte/admin/modul_system/texte_systaskflushremoteloadercache_en.php"))
           $strReturn .= "<b>Error deleting the file \n /texte/admin/modul_system/texte_systaskflushremoteloadercache_en.php,\nplease delete manually</b>\n";      
            
        $strReturn .= "Installing table session...\n";
		$arrFields = array();
		$arrFields["session_id"] 		      = array("char20", false);
		$arrFields["session_phpid"]	          = array("char254", true);
		$arrFields["session_userid"] 	      = array("char20", true);
		$arrFields["session_groupids"] 	      = array("text", true);
		$arrFields["session_releasetime"]     = array("int", true);
		$arrFields["session_loginstatus"]     = array("char254", true);
		$arrFields["session_loginprovider"]   = array("char20", true);
		$arrFields["session_lasturl"] 		  = array("char254", true);

		if(!$this->objDB->createTable("session", $arrFields, array("session_id"), array("session_phpid")))
			$strReturn .= "An error occured! ...\n";	     
			
		$strReturn .= "Registering session relasetime setting...\n";
		$this->registerConstant("_system_release_time_", 3600, class_modul_system_setting::$int_TYPE_INT, _system_modul_id_);	 
        
        $strReturn .= "Updating module-versions...\n";
        $this->updateModuleVersion("3.1.9");

        return $strReturn;
    }
    
    private function update_319_addLanguages() {
        $strReturn = "";
        $strReturn .= "Installing table languages...\n";
		
		$arrFields = array();
		$arrFields["language_id"] 		= array("char20", false);
		$arrFields["language_name"] 	= array("char254", true);
		$arrFields["language_default"]  = array("int", true);

		if(!$this->objDB->createTable("languages", $arrFields, array("language_id")))
			$strReturn .= "An error occured! ...\n";


		//register the module
		$strSystemID = $this->registerModule("languages", _languages_modul_id_, "class_modul_languages_portal.php",
		                                      "class_modul_languages_admin.php", $this->arrModule["version"] , true);

		$strReturn .= "Systemid of module languages: ".$strSystemID."";

		//Register the element
		$strReturn .= "Registering languageswitch-element...\n";
		//check, if not already existing
		$strQuery = "SELECT COUNT(*) FROM "._dbprefix_."element WHERE element_name='languageswitch'";
		$arrRow = $this->objDB->getRow($strQuery);
		if($arrRow["COUNT(*)"] == 0) {
			$strQuery = "INSERT INTO "._dbprefix_."element
							(element_id, element_name, element_class_portal, element_class_admin, element_repeat) VALUES
							('".$this->generateSystemid()."', 'languageswitch', 'class_element_languageswitch.php', 'class_element_languageswitch.php', 0)";
			$this->objDB->_query($strQuery);
			$strReturn .= "Element registered...\n";
		}
		else {
				$strReturn .= "Element already installed!...\n";
		}
		
		//create default language & assign existing contents
		$strReturn .= "Creating new default-language\n";
        include_once(_systempath_."/class_modul_languages_language.php");
        $objLanguage = new class_modul_languages_language();

        if($this->strContentLanguage == "de")
            $objLanguage->setStrName("de");
        else
           $objLanguage->setStrName("en");
           
        $objLanguage->setBitDefault(true);
        $objLanguage->saveObjectToDb();
        $strReturn .= "ID of new language: ".$objLanguage->getSystemid()."\n";
        $strReturn .= "Assigning null-properties and elements to the default language.\n";
        if($this->strContentLanguage == "de") {
        
            if(include_once(_systempath_."/class_modul_pages_page.php"))
                class_modul_pages_page::assignNullProperties("de");
            if(include_once(_systempath_."/class_modul_pages_pageelement.php"))
                class_modul_pages_pageelement::assignNullElements("de");
        }
        else {
        	
            if(include_once(_systempath_."/class_modul_pages_page.php"))
                class_modul_pages_page::assignNullProperties("en");
            if(include_once(_systempath_."/class_modul_pages_pageelement.php"))
                class_modul_pages_pageelement::assignNullElements("en");
                
        }
		 
		return $strReturn;                                          
    }
	
	
}
?>