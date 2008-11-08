<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2008 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                           *
********************************************************************************************************/

include_once(_systempath_."/class_model.php");
include_once(_systempath_."/interface_model.php");

/**
 * Model for a language
 *
 * @package modul_languages
 */
class class_modul_languages_language extends class_model implements interface_model  {

    private $strName = "";
    private $bitDefault = false;

    private $strLanguagesAvailable = "de,en,fr,ru";

    /**
     * Constructor to create a valid object
     *
     * @param string $strSystemid (use "" on new objets)
     */
    public function __construct($strSystemid = "") {
        $arrModul["name"] 				= "modul_languages";
		$arrModul["author"] 			= "sidler@mulchprod.de";
		$arrModul["moduleId"] 			= _languages_modul_id_;
		$arrModul["table"]       		= _dbprefix_."languages";
		$arrModul["modul"]				= "languages";

		//base class
		parent::__construct($arrModul, $strSystemid);

		//init current object
		if($strSystemid != "")
		    $this->initObject();
    }

    /**
     * Initalises the current object, if a systemid was given
     *
     */
    public function initObject() {
        $strQuery = "SELECT * FROM "._dbprefix_."system, ".$this->arrModule["table"]."
                     WHERE system_id = language_id
                     AND system_id = '".dbsafeString($this->getSystemid())."'";
        $arrRow = $this->objDB->getRow($strQuery);

        if(count($arrRow) > 1) {
            $this->setBitDefault($arrRow["language_default"]);
            $this->setStrName($arrRow["language_name"]);
        }
    }

    /**
     * saves the current object with all its params back to the database
     *
     * @return bool
     */
    public function updateObjectToDb() {
        class_logger::getInstance()->addLogRow("updated language ".$this->getSystemid(), class_logger::$levelInfo);
        $this->setEditDate();
        $strQuery = "UPDATE ".$this->arrModule["table"]."
                     SET language_name = '".dbsafeString($this->getStrName())."',
                         language_default = '".dbsafeString($this->getBitDefault())."'
                     WHERE language_id = '".dbsafeString($this->getSystemid())."'";
        return $this->objDB->_query($strQuery);
    }

    /**
     * saves the current object as a new object to the database
     *
     * @return bool
     */
    public function saveObjectToDb() {
		//Start tx
		$this->objDB->transactionBegin();
		$bitCommit = true;
        //Create System-Records
        $strLanguageSystemId = $this->createSystemRecord(0, "Language: ".$this->getStrName());
        $this->setSystemid($strLanguageSystemId);
        class_logger::getInstance()->addLogRow("new language ".$this->getSystemid(), class_logger::$levelInfo);

        //if no other language exists, we have a new default language
        $arrObjLanguages = class_modul_languages_language::getAllLanguages();
        if(count($arrObjLanguages) == 0 ) {
        	$this->setBitDefault(1);
        }

        //insert in languages table
        $strQuery = "INSERT INTO ".$this->arrModule["table"]."
                     (language_id, language_name, language_default) VALUES
                     ('".dbsafeString($strLanguageSystemId)."', '".dbsafeString($this->getStrName())."', '".dbsafeString($this->getBitDefault())."')";
		if(!$this->objDB->_query($strQuery))
		    $bitCommit = false;


		//End tx
		if($bitCommit) {
			$this->objDB->transactionCommit();
			return true;
		}
		else {
			$this->objDB->transactionRollback();
			return false;
		}
    }



    /**
     * Returns an array of all languages available
     *
     * @param bool $bitJustActive
     * @return mixed
     * @static
     */
    public static function getAllLanguages($bitJustActive = false) {
        $strQuery = "SELECT system_id
                     FROM "._dbprefix_."languages, "._dbprefix_."system
		             WHERE system_id = language_id
		             ".($bitJustActive ? "AND system_status != 0 ": "")."
		             ORDER BY system_sort ASC, system_comment ASC";
        $arrIds = class_carrier::getInstance()->getObjDB()->getArray($strQuery);
        $arrReturn = array();
        foreach($arrIds as $arrOneId)
            $arrReturn[] = new class_modul_languages_language($arrOneId["system_id"]);

        return $arrReturn;
    }
    
    /**
     * Returns the number of languages installed in the system 
     *
     * @param bool $bitJustActive
     * @return int
     */
    public static function getNumberOfLanguagesAvailable($bitJustActive = false) {
    	$strQuery = "SELECT COUNT(*)
                     FROM "._dbprefix_."languages, "._dbprefix_."system
                     WHERE system_id = language_id
                     ".($bitJustActive ? "AND system_status != 0 ": "")."
                     ORDER BY system_sort ASC, system_comment ASC";
        $arrRow = class_carrier::getInstance()->getObjDB()->getRow($strQuery);

        return (int)$arrRow["COUNT(*)"];
    	
    }

    /**
     * Returns the language requested.
     * If the language doesn't exist, false is returned
     *
     * @param string $strName
     * @static
     * @return  class_modul_languages_language or false
     */
    public static function getLanguageByName($strName) {
        $strQuery = "SELECT system_id
                     FROM "._dbprefix_."languages, "._dbprefix_."system
		             WHERE system_id = language_id
		             AND language_name = '".dbsafeString($strName)."'
		             ORDER BY system_sort ASC, system_comment ASC";
        $arrRow = class_carrier::getInstance()->getObjDB()->getRow($strQuery);
        if(count($arrRow)>0)
            return new class_modul_languages_language($arrRow["system_id"]);
        else
            return false;
    }


    /**
     * Resets all default languages.
     * Afterwards, no default language is available!
     *
     * @return bool
     */
    public static function resetAllDefaultLanguages() {
        $strQuery = "UPDATE "._dbprefix_."languages
                     SET language_default = 0";
        return class_carrier::getInstance()->getObjDB()->_query($strQuery);
    }


    /**
     * Deletes the current object from the database
     *
     * @return bool
     */
    public function deleteObject() {
        //Start tx
		$this->objDB->transactionBegin();
		$bitCommit = true;
        class_logger::getInstance()->addLogRow("deleted language ".$this->getSystemid(), class_logger::$levelInfo);
        //start with the modul-table
        $strQuery = "DELETE FROM ".$this->arrModule["table"]." WHERE language_id = '".dbsafeString($this->getSystemid())."'";
		if(!$this->objDB->_query($strQuery))
		    $bitCommit = false;

		//rights an systemrecords
		if(!$this->deleteSystemRecord($this->getSystemid()))
		    $bitCommit = false;

		 //if we have just one language remaining, set this one as default
        $arrObjLanguages = class_modul_languages_language::getAllLanguages();
        if(count($arrObjLanguages) == 1) {
        	$objOneLanguage = $arrObjLanguages[0];
        	$objOneLanguage->setBitDefault(1);
        	$objOneLanguage->updateObjectToDb();
        }

		//End tx
		if($bitCommit) {
			$this->objDB->transactionCommit();
			return true;
		}
		else {
			$this->objDB->transactionRollback();
			return false;
		}
    }
    
    
    /**
     * Moves all contents created in a given language to the current langugage
     *
     * @param string $strSourceLanguage
     * @return bool
     */
    public function moveContentsToCurrentLanguage($strSourceLanguage) {
        $bitCommit = true;
        $this->objDB->transactionBegin();
        
        $strQuery1 = "UPDATE "._dbprefix_."page_properties 
                        SET pageproperties_language = '".dbsafeString($this->getStrName())."'
                        WHERE pageproperties_language = '".dbsafeString($strSourceLanguage)."'";
        
        $strQuery2 = "UPDATE "._dbprefix_."page_element
                        SET page_element_placeholder_language = '".dbsafeString($this->getStrName())."'
                        WHERE page_element_placeholder_language = '".dbsafeString($strSourceLanguage)."'";
        
        $bitCommit = ($this->objDB->_query($strQuery1) && $this->objDB->_query($strQuery2));
        
        if($bitCommit) {
            $this->objDB->transactionCommit();
            class_logger::getInstance()->addLogRow("moved contents from ".$strSourceLanguage." to ".$this->getStrName()." successfully", class_logger::$levelInfo);
        }
        else {
            $this->objDB->transactionRollback();
            class_logger::getInstance()->addLogRow("moved contents from ".$strSourceLanguage." to ".$this->getStrName()." failed", class_logger::$levelError);
        }
        
        return $bitCommit;
    }

    /**
     * Tries to determin the language currently active
     * Looks up the session for previous languages,
     * if no entry was found, the default language is being returned
     * part for the portal
     * tries to load the language, the browser sends as accept-language
     *
     * @return string
     */
    public function getPortalLanguage() {
        if($this->objSession->getSession("portalLanguage") !== false && $this->objSession->getSession("portalLanguage") != "") {
            //Return language saved before in the session
            return $this->objSession->getSession("portalLanguage");
        }
        else {
            //try to load the default language
            //maybe the user sent a wanted language
            $strUserLanguages = str_replace(";", ",", getServer("HTTP_ACCEPT_LANGUAGE"));
            if(uniStrlen($strUserLanguages) > 0) {
                $arrLanguages = explode(",", $strUserLanguages);
                //check, if one of the requested languages is available on our system
                foreach ($arrLanguages as $strOneLanguage) {
                    if(!preg_match("#q\=[0-9]\.[0-9]#i", $strOneLanguage)) {
                        //search language
                        $strQuery = "SELECT language_name
                                 FROM "._dbprefix_."languages, "._dbprefix_."system
            		             WHERE system_id = language_id
            		             AND system_status = 1
            		             AND language_name='".dbsafeString($strOneLanguage)."'
            		             ORDER BY system_sort ASC, system_comment ASC";
                        $arrRow = $this->objDB->getRow($strQuery);
                        if(count($arrRow) > 0) {
                            //save to session
                            $this->objSession->setSession("portalLanguage", $arrRow["language_name"]);
                            return $arrRow["language_name"];
                        }
                    }
                }
            }

            $strQuery = "SELECT language_name
                     FROM "._dbprefix_."languages, "._dbprefix_."system
		             WHERE system_id = language_id
		             AND language_default = 1
		             AND system_status = 1
		             ORDER BY system_sort ASC, system_comment ASC";
            $arrRow = $this->objDB->getRow($strQuery);
            if(count($arrRow) > 0) {
                //save to session
                $this->objSession->setSession("portalLanguage", $arrRow["language_name"]);
                return $arrRow["language_name"];
            }
            else {
                //No default language set? Uh oh...
                $strQuery = "SELECT language_name
                     FROM "._dbprefix_."languages, "._dbprefix_."system
		             WHERE system_id = language_id
		             AND system_status = 1
		             ORDER BY system_sort ASC, system_comment ASC";
                $arrRow = $this->objDB->getRow($strQuery);
                if(count($arrRow) > 0) {
                    //save to session
                    $this->objSession->setSession("portalLanguage", $arrRow["language_name"]);
                    return $arrRow["language_name"];
                }
                else {
                    return "";
                }
            }
        }
    }

    /**
     * Tries to determin the language currently active
     * Looks up the session for previous languages,
     * if no entry was found, the default language is being returned
     * part for the admin
     *
     * @return string
     */
    public function getAdminLanguage() {
        if($this->objSession->getSession("adminLanguage") !== false && $this->objSession->getSession("adminLanguage") != "") {
            //Return language saved before in the session
            return $this->objSession->getSession("adminLanguage");
        }
        else {

            $strQuery = "SELECT language_name
                     FROM "._dbprefix_."languages, "._dbprefix_."system
		             WHERE system_id = language_id
		             AND language_default = 1
		             ORDER BY system_sort ASC, system_comment ASC";
            $arrRow = $this->objDB->getRow($strQuery);
            if(count($arrRow) > 0) {
                //save to session
                $this->objSession->setSession("adminLanguage", $arrRow["language_name"]);
                return $arrRow["language_name"];
            }
            else {
                //No default language set? Uh oh...
                $strQuery = "SELECT language_name
                     FROM "._dbprefix_."languages, "._dbprefix_."system
		             WHERE system_id = language_id
		             ORDER BY system_sort ASC, system_comment ASC";
                $arrRow = $this->objDB->getRow($strQuery);
                if(count($arrRow) > 0) {
                    //save to session
                    $this->objSession->setSession("adminLanguage", $arrRow["language_name"]);
                    return $arrRow["language_name"];
                }
                else {
                    return "";
                }
            }
        }
    }

    /**
     * Returns the default language, defined in the admin.
     *
     * @return class_modul_languages_language
     */
    public static function getDefaultLanguage() {
        //try to load the default language
        $strQuery = "SELECT system_id
                 FROM "._dbprefix_."languages, "._dbprefix_."system
	             WHERE system_id = language_id
	             AND language_default = 1
	             AND system_status = 1
	             ORDER BY system_sort ASC, system_comment ASC";
        $arrRow = class_carrier::getInstance()->getObjDB()->getRow($strQuery);
        if(count($arrRow) > 0) {
            return new class_modul_languages_language($arrRow["system_id"]);
        }
        else
            return null;
    }

    /**
     * Writes the passed language to the session, if the language exists
     *
     * @param string $strLanguage
     */
    public function setStrPortalLanguage($strLanguage) {
        $objLanguage = class_modul_languages_language::getLanguageByName($strLanguage);
        if($objLanguage !== false) {
            if($objLanguage->getStatus() != 0) {
                $this->objSession->setSession("portalLanguage", $objLanguage->getStrName());
            }
        }
    }

    /**
     * Writes the passed language to the session, if the language exists
     *
     * @param string $strLanguage
     */
    public function setStrAdminLanguageToWorkOn($strLanguage) {
        $objLanguage = class_modul_languages_language::getLanguageByName($strLanguage);
        if($objLanguage !== false) {
            if($objLanguage->getStatus() != 0) {
                $this->objSession->setSession("adminLanguage", $objLanguage->getStrName());
            }
        }
    }

// --- GETTERS / SETTERS --------------------------------------------------------------------------------

    public function setStrName($strName) {
        $this->strName = $strName;
    }
    public function setBitDefault($bitDefault) {
        $this->bitDefault = $bitDefault;
    }

    public function getStrName() {
        return $this->strName;
    }
    public function getBitDefault() {
        return $this->bitDefault;
    }
    /**
     * Returns a list of all languages available
     *
     * @return array
     */
    public function getAllLanguagesAvailable() {
        return explode(",", $this->strLanguagesAvailable);
    }
}
?>