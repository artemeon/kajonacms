<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2009 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                 *
********************************************************************************************************/

require_once(_systempath_."/class_installer_base.php");
require_once(_systempath_."/interface_installer.php");
include_once(_systempath_."/class_modul_pages_element.php");

/**
 * Installer to install a tagto-element to use in the portal
 *
 * @package modul_pages
 */
class class_installer_element_tagto extends class_installer_base implements interface_installer {

    /**
     * Constructor
     *
     */
	public function __construct() {
        $arrModule = array();
		$arrModule["version"] 		= "3.2.0";
		$arrModule["name"] 			= "element_tagto";
		$arrModule["name_lang"] 	= "Element tagto";
		$arrModule["nummer2"] 		= _pages_inhalte_modul_id_;
		parent::__construct($arrModule);
	}

	public function getNeededModules() {
	    return array("system", "pages");
	}
	
    public function getMinSystemVersion() {
	    return "3.0.9";
	}

	public function hasPostInstalls() {
	    //needed: pages
	    try {
		    $objModule = class_modul_system_module::getModuleByName("pages");
		}
		catch (class_exception $objE) {
		    return false;
		}

	    //check, if not already existing
	    $objElement = null;
		try {
		    $objElement = class_modul_pages_element::getElement("tagto");
		}
		catch (class_exception $objEx)  {
		}
        if($objElement == null)
            return true;

        return false;
	}

	public function install() {
    }

    public function postInstall() {
		$strReturn = "";

		//Register the element
		$strReturn .= "Registering tagto-element...\n";
		//check, if not already existing
        $objElement = null;
		try {
		    $objElement = class_modul_pages_element::getElement("tagto");
		}
		catch (class_exception $objEx)  {
		}
        
		if($objElement == null) {
		    $objElement = new class_modul_pages_element();
		    $objElement->setStrName("tagto");
		    $objElement->setStrClassAdmin("class_element_tagto.php");
		    $objElement->setStrClassPortal("class_element_tagto.php");
		    $objElement->setIntCachetime(-1);
		    $objElement->setIntRepeat(0);
			$objElement->saveObjectToDb();
			$strReturn .= "Element registered...\n";
		}
		else {
			$strReturn .= "Element already installed!...\n";
		}
		return $strReturn;
	}


	public function update()
	{

	}
}
?>