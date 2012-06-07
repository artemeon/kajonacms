<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2012 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id: class_element_directorybrowser.php 4041 2011-07-25 17:34:43Z sidler $                                   *
********************************************************************************************************/

/**
 * Loads the last-modified date of the current page and prepares it for output
 *
 * @package element_directorybrowser
 * @author sidler@mulchprod.de
 */
class class_element_directorybrowser_portal extends class_element_portal implements interface_portal_element {

    /**
     * Constructor
     *
     * @param class_module_pages_pageelement $objElementData
     */
	public function __construct($objElementData) {
		parent::__construct($objElementData);
        $this->setArrModuleEntry("table", _dbprefix_."element_universal");
	}

    /**
     * Loads the feed and displays it
     *
     * @return string the prepared html-output
     */
	public function loadData() {
        $strReturn = "";

        //Load all files in the folder
        $objFilesystem = new class_filesystem();
        $arrFiles = $objFilesystem->getFilelist($this->arrElementData["char2"]);
        
        
		$strWrapperTemplateID = $this->objTemplate->readTemplate("/element_directorybrowser/".$this->arrElementData["char1"], "directorybrowser_wrapper");
        $strEntryTemplateID = $this->objTemplate->readTemplate("/element_directorybrowser/".$this->arrElementData["char1"], "directorybrowser_entry");
        
		$strContent = "";
        foreach($arrFiles as $strOneFile) {
            $arrDetails = $objFilesystem->getFileDetails($this->arrElementData["char2"]."/".$strOneFile);
            
            $arrTemplate = array();
            $arrTemplate["file_name"] = $arrDetails["filename"];
            $arrTemplate["file_href"] = _webpath_.$this->arrElementData["char2"]."/".$strOneFile;
            $arrTemplate["file_date"] = timeToString($arrDetails["filechange"]);
            $arrTemplate["file_size"] = bytesToString($arrDetails["filesize"]);
            
            $strContent .= $this->fillTemplate($arrTemplate, $strEntryTemplateID);
        }


		$strReturn .= $this->fillTemplate(array("files" => $strContent), $strWrapperTemplateID);

		return $strReturn;
	}

}
