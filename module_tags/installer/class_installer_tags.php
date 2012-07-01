<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2012 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                *
********************************************************************************************************/

/**
 * Class providing an install for the tags module
 *
 * @package module_tags
 */
class class_installer_tags extends class_installer_base implements interface_installer {

	public function __construct() {
        $this->objMetadata = new class_module_packagemanager_metadata();
        $this->objMetadata->autoInit(uniStrReplace(array(DIRECTORY_SEPARATOR."installer", _realpath_), array("", ""), __DIR__));

        $this->setArrModuleEntry("moduleId", _tags_modul_id_);

        parent::__construct();
	}

    public function install() {
		$strReturn = "";

		//tags_tag --------------------------------------------------------------------------------------
		$strReturn .= "Installing table tags_tag...\n";

		$arrFields = array();
		$arrFields["tags_tag_id"] 		= array("char20", false);
		$arrFields["tags_tag_name"] 	= array("char254", true);

		if(!$this->objDB->createTable("tags_tag", $arrFields, array("tags_tag_id")))
			$strReturn .= "An error occured! ...\n";

        //tags_member --------------------------------------------------------------------------------------
		$strReturn .= "Installing table tags_member...\n";

        $arrFields = array();
		$arrFields["tags_systemid"] 	= array("char20", false);
		$arrFields["tags_tagid"]        = array("char20", false);
		$arrFields["tags_attribute"]    = array("char254", true);

		if(!$this->objDB->createTable("tags_member", $arrFields, array("tags_systemid", "tags_tagid", "tags_attribute")))
			$strReturn .= "An error occured! ...\n";



        //tags_favorite ---------------------------------------------------------------------------------
        $strReturn .= "Installing table tags_favorite...\n";

        $arrFields = array();
        $arrFields["tags_fav_id"] 	        = array("char20", false);
        $arrFields["tags_fav_tagid"]        = array("char20", true);
        $arrFields["tags_fav_userid"]       = array("char20", true);

        if(!$this->objDB->createTable("tags_favorite", $arrFields, array("tags_fav_id")))
            $strReturn .= "An error occured! ...\n";

		//register the module
		$this->registerModule(
            "tags",
            _tags_modul_id_,
            "",
            "class_module_tags_admin.php",
            $this->objMetadata->getStrVersion(),
            true,
            "",
            "class_module_tags_admin_xml.php"
        );

		$strReturn .= "Registering system-constants...\n";

        //Register the element
        $strReturn .= "Registering tags-element...\n";

        //check, if not already existing
        $objElement = class_module_pages_element::getElement("tags");
        if($objElement == null) {
            $objElement = new class_module_pages_element();
            $objElement->setStrName("tags");
            $objElement->setStrClassAdmin("class_element_tags_admin.php");
            $objElement->setStrClassPortal("class_element_tags_portal.php");
            $objElement->setIntCachetime(3600*24*30);
            $objElement->setIntRepeat(0);
            $objElement->setStrVersion($this->objMetadata->getStrVersion());
            $objElement->updateObjectToDb();
            $strReturn .= "Element registered...\n";
        }
        else {
            $strReturn .= "Element already installed!...\n";
        }

		return $strReturn;

	}


	public function update() {
	    $strReturn = "";
        //check installed version and to which version we can update
        $arrModul = $this->getModuleData($this->objMetadata->getStrTitle(), false);

        $strReturn .= "Version found:\n\t Module: ".$arrModul["module_name"].", Version: ".$arrModul["module_version"]."\n\n";

        $arrModul = $this->getModuleData($this->objMetadata->getStrTitle(), false);
        if($arrModul["module_version"] == "3.4.1") {
            $strReturn .= $this->update_342_349();
            $this->objDB->flushQueryCache();
        }

        return $strReturn."\n\n";
	}



    private function update_342_349() {
        $strReturn = "Updating 3.4.2 to 3.4.9...\n";

        $strReturn .= "Adding classes for existing records...\n";


        $strReturn .= "Tags\n";
        $arrRows = $this->objDB->getPArray("SELECT system_id FROM "._dbprefix_."tags_tag, "._dbprefix_."system WHERE system_id = tags_tag_id AND (system_class IS NULL OR system_class = '')", array());
        foreach($arrRows as $arrOneRow) {
            $strQuery = "UPDATE "._dbprefix_."system SET system_class = ? where system_id = ?";
            $this->objDB->_pQuery($strQuery, array( 'class_module_tags_tag', $arrOneRow["system_id"] ) );
        }

        $strReturn .= "Installing table tags_favorite...\n";

        $arrFields = array();
        $arrFields["tags_fav_id"] 	        = array("char20", false);
        $arrFields["tags_fav_tagid"]        = array("char20", true);
        $arrFields["tags_fav_userid"]       = array("char20", true);

        if(!$this->objDB->createTable("tags_favorite", $arrFields, array("tags_fav_id")))
            $strReturn .= "An error occured! ...\n";

        $strReturn .= "Updating module-versions...\n";
        $this->updateModuleVersion($this->objMetadata->getStrTitle(), "3.4.9");
        $strReturn .= "Updating element-versions...\n";
        $this->updateElementVersion("tags", "3.4.9");

        return $strReturn;
    }


}
