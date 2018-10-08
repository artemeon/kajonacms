<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                         *
********************************************************************************************************/

namespace Kajona\Search\Installer;

use Kajona\Search\System\SearchIndexwriter;
use Kajona\Search\System\SearchSearch;
use Kajona\System\System\Carrier;
use Kajona\System\System\DbDatatypes;
use Kajona\System\System\InstallerBase;
use Kajona\System\System\InstallerRemovableInterface;
use Kajona\System\System\OrmSchemamanager;
use Kajona\System\System\SystemModule;
use Kajona\System\System\SystemSetting;

/**
 * Class providing the installer of the search-module
 *
 * @package module_search
 * @moduleId _search_module_id_
 */
class InstallerSearch extends InstallerBase implements InstallerRemovableInterface {

    private $bitIndexTablesUpToDate = false;

    public function install() {

        $objManager = new OrmSchemamanager();
        //Install Index Tables
        $strReturn = $this->installIndexTables();

        //Table for search
        $strReturn .= "Installing table search_search...\n";
        $objManager->createTable(SearchSearch::class
        );

        //Table for search log entry
        $strReturn .= "Installing search-log table...\n";

        $arrFields = array();
		$arrFields["search_log_id"] 	  = array("char20", false);
		$arrFields["search_log_date"] 	  = array("int", true);
		$arrFields["search_log_query"] 	  = array("char254", true);
		$arrFields["search_log_language"] = array("char10", true);

		if(!$this->objDB->createTable("agp_search_log", $arrFields, array("search_log_id")))
			$strReturn .= "An error occurred! ...\n";

        //Table for the index queue
        $strReturn .= "Installing search-queue table...\n";

        $arrFields = array();
		$arrFields["search_queue_id"] 	    = array("char20", false);
		$arrFields["search_queue_systemid"] = array("char20", true);
		$arrFields["search_queue_action"] 	= array("char20", true);

		if(!$this->objDB->createTable("agp_search_queue", $arrFields, array("search_queue_id")))
			$strReturn .= "An error occurred! ...\n";


		$strReturn .= "Registering module...\n";
		//register the module
		$this->registerModule("search", _search_module_id_, "", "SearchAdmin.php", $this->objMetadata->getStrVersion());

        $strReturn .= "Registering config-values...\n";
        $this->registerConstant("_search_deferred_indexer_", "false", SystemSetting::$int_TYPE_BOOL, _search_module_id_);

        $strReturn .= "Rebuilding search index...\n";
        $this->updateIndex();


        return $strReturn;

	}

    /**
     * Validates whether the current module/element is removable or not.
     * This is the place to trigger special validations and consistency checks going
     * beyond the common metadata-dependencies.
     *
     * @return bool
     */
    public function isRemovable() {
        return true;
    }

    /**
     * Removes the elements / modules handled by the current installer.
     * Use the reference param to add a human readable logging.
     *
     * @param string &$strReturn
     *
     * @return bool
     */
    public function remove(&$strReturn) {

        /** @var SearchSearch $objOneObject */
        foreach(SearchSearch::getObjectListFiltered() as $objOneObject) {
            $strReturn .= "Deleting object '".$objOneObject->getStrDisplayName()."' ...\n";
            if(!$objOneObject->deleteObjectFromDatabase()) {
                $strReturn .= "Error deleting object, aborting.\n";
                return false;
            }
        }

        //delete the module-node
        $strReturn .= "Deleting the module-registration...\n";
        $objModule = SystemModule::getModuleByName($this->objMetadata->getStrTitle(), true);
        if(!$objModule->deleteObjectFromDatabase()) {
            $strReturn .= "Error deleting module, aborting.\n";
            return false;
        }

        //delete the tables
        foreach(array("search_search", "search_log", "search_ix_document", "search_ix_content") as $strOneTable) {
            $strReturn .= "Dropping table ".$strOneTable."...\n";
            if(!$this->objDB->_pQuery("DROP TABLE ".$this->objDB->encloseTableName($strOneTable), array())) {
                $strReturn .= "Error deleting table, aborting.\n";
                return false;
            }

        }

        return true;
    }


    public function update() {
	    $strReturn = "";
        //check installed version and to which version we can update
        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        $strReturn .= "Version found:\n\t Module: ".$arrModule["module_name"].", Version: ".$arrModule["module_version"]."\n\n";

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if($arrModule["module_version"] == "6.2") {
            $strReturn .= "Updating to 6.5...\n";
            $this->updateModuleVersion("search", "6.5");
        }

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if($arrModule["module_version"] == "6.5") {
            $strReturn .= "Updating to 6.6...\n";
            $this->updateModuleVersion($this->objMetadata->getStrTitle(), "6.6");
        }

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if($arrModule["module_version"] == "6.6") {
            $strReturn .= $this->update_66_70();
        }

        $arrModule = SystemModule::getPlainModuleData($this->objMetadata->getStrTitle(), false);
        if($arrModule["module_version"] == "7.0") {
            $strReturn .= $this->update_70_71();
        }


        return $strReturn."\n\n";
	}


    private function update_66_70()
    {
        $strReturn = "Update to 7.0".PHP_EOL;

        $strReturn .= "Updating schema".PHP_EOL;
        $this->objDB->removeColumn("agp_search_ix_document", "search_ix_content_lang");
        $this->objDB->removeColumn("agp_search_ix_document", "search_ix_portal_object");

        $this->updateModuleVersion($this->objMetadata->getStrTitle(), "7.0");

        return $strReturn;
	}

    private function update_70_71()
    {
        $strReturn = "Updating to 7.1...\n";

        $strReturn .= "Migrating date col\n";
        $this->objDB->addColumn("agp_search_search", "search_change_start",DbDatatypes::STR_TYPE_LONG);
        $this->objDB->addColumn("agp_search_search", "search_change_end",DbDatatypes::STR_TYPE_LONG);

        foreach ($this->objDB->getGenerator("SELECT system_date_start, system_date_end, search_search_id FROM agp_system_date, agp_search_search WHERE system_date_id = search_search_id ORDER BY system_date_id DESC", []) as $sets) {
            foreach ($sets as $row) {
                $this->objDB->_pQuery("UPDATE agp_search_search SET search_change_start = ?, search_change_end = ? WHERE search_search_id = ?", [$row["system_date_start"], $row["system_date_end"], $row["search_search_id"]]);
                $this->objDB->_pQuery("DELETE FROM agp_system_date WHERE system_date_id = ?", [$row["search_search_id"]]);
            }
        }

        $this->updateModuleVersion($this->objMetadata->getStrTitle(), "7.1");
        return $strReturn;
    }


    private function updateIndex() {
        Carrier::getInstance()->flushCache(Carrier::INT_CACHE_TYPE_DBQUERIES | Carrier::INT_CACHE_TYPE_MODULES);

        SearchIndexwriter::resetIndexAvailableCheck();
        $objWorker = new SearchIndexwriter();
        $objWorker->indexRebuild();
    }

    private function installIndexTables() {
        $this->bitIndexTablesUpToDate = true;
        //Tables for search documents
        $strReturn = "Installing table search_ix_document...\n";

        $arrFields = array();
        $arrFields["search_ix_document_id"] 		= array("char20", false);
        $arrFields["search_ix_system_id"] 	        = array("char20", true);

        if(!$this->objDB->createTable("agp_search_ix_document", $arrFields, array("search_ix_document_id"), array("search_ix_system_id")))
            $strReturn .= "An error occurred! ...\n";

        $strReturn .= "Installing table search_ix_content...\n";

        $arrFields = array();
        $arrFields["search_ix_content_id"] 		    = array("char20", false);
        $arrFields["search_ix_content_field_name"] 	= array("char254", false);
        $arrFields["search_ix_content_content"] 	= array("char254", true);
        $arrFields["search_ix_content_score"] 	    = array("int", true);
        $arrFields["search_ix_content_document_id"] = array("char20", true);

        if(!$this->objDB->createTable("agp_search_ix_content", $arrFields, array("search_ix_content_id"), array("search_ix_content_field_name", "search_ix_content_content", "search_ix_content_document_id")))
           $strReturn .= "An error occurred! ...\n";

        return $strReturn;
    }

}
