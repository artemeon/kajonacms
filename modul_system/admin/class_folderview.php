<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007 by Kajona, www.kajona.de                                                                   *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
* 																										*
* 	class_folderview.php																				*
* 	Returns a small List-Viewer of Folder created in the database										*
*																										*
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                         *
********************************************************************************************************/

//Base class
include_once(_adminpath_."/class_admin.php");

//Interface
include_once(_adminpath_."/interface_admin.php");

/**
 * This class provides a list-view of the folders created in the database / filesystem
 *
 * @package modul_system
 */
class class_folderview extends class_admin  implements interface_admin {
	//Which paths are allowed to browse?
	private $strStart = "portal/pics,portal/pics/,/portal/pics,/portal/pics/,/portal/downloads,portal/downloads/,portal/downloads,/portal/downloads";

	/**
	 * Constructor, doin nothing but a few inits
	 *
	 */
	public function __construct() {
		$arrModule["name"] 					= "class_folderview";
		$arrModule["author"] 				= "sidler@mulchprod.de";
		$arrModule["moduleId"]				= _filesystem_modul_id_;
		$arrModule["modul"]					= "folderview";
		$arrModule["template"] 				= "/folderview.tpl";

		parent::__construct($arrModule);
	}

	/**
	 * Action block
	 *
	 * @param string $strAction
	 */
	public function action($strAction = "") {
		$strReturn = "";

		//The common list. Used to select files or folders.
		if($strAction == "list") {
			if($this->getParam("form_element") != "")
				$strElement = $this->getParam("form_element");
			else
				$strElement = "bild";

			$strReturn = $this->getListFilemanager($strElement);
		}

		if($strAction == "folderList") 	{
			if($this->getParam("folder") != "")
				$strFolder = $this->getParam("folder");
			else
				$strFolder = "/portal/pics";
			if($this->getParam("suffix") != "")
				$arrSuffix = explode("|", $this->getParam("suffix"));
			else
				$arrSuffix = array();
			if($this->getParam("exclude") != "")
				$arrExclude = explode("|", $this->getParam("exclude"));
			else
				$arrExclude = array();
			if($this->getParam("bit_folder") != "")
				$bitFolder = $this->getParam("bit_folder");
			else
				$bitFolder = true;
			if($this->getParam("bit_file") != "")
				$bitFile = $this->getParam("bit_dateien");
			else
				$bitFile = true;
			if($this->getParam("exclude_folder") != "")
				$arrExcludeFolder = explode("|", $this->getParam("exclude_folder"));
			else
				$arrExcludeFolder = array(0 => ".", 1 => "..");
			if($this->getParam("form_element") != "")
				$strElement = $this->getParam("form_element");
			else
				$strElement = "bild";
			if($this->getParam("detail") != "")
				$strDetail = $this->getParam("detail");
			else
				$strDetail = "";

			$strReturn = $this->getFolderlist($strFolder, $arrSuffix, $arrExclude, $arrExcludeFolder, $bitFolder, $bitFile, $strElement, $strDetail);
		}

		if($strAction == "pagesFolderBrowser") {
			$bitPages = ($this->getParam("pages") != "" ? true : false);
			$strFolderid = ($this->getParam("folderid") != "" ? $this->getParam("folderid") : 0 );
			$strElement = ($this->getParam("form_element") != "" ? $this->getParam("form_element") : "ordner_name");
            $strPageid = ($this->getParam("pageid") != "" ? $this->getParam("pageid") : "0" );
			$strReturn = $this->pagesFolderBrowser($strFolderid, $bitPages, $strElement, $strPageid);
		}

		if($strAction == "navigationBrowser")
			$strReturn = $this->navigationBrowser();

		$this->strOutput = $strReturn;
	}

	public function getOutputContent() {
		return $this->strOutput;
	}



	/**
	 * Opens the filemanager to browse files
	 *
	 * @param string $strTargetfield
	 * @return string
	 */
	public function getListFilemanager($strTargetfield) {
        include_once(_adminpath_."/class_modul_filemanager_admin.php");
        $objFilemanager = new class_modul_filemanager_admin();
        return $objFilemanager->actionFolderContentFolderviewMode($strTargetfield);
	}


	/**
	* @return void
	* @param string $verzeichnis
	* @param mixed $arr_endung
	* @param mixed $arr_ausschluss
	* @param mixed $arr_ausschluss_ordner
	* @param bool $bit_ordner
	* @param bool $bit_dateien
	* @desc Laedt eine Liste der Ordner im Dateisystem
	*/
	public function getFolderlist($strFolder, $arrSuffix = array(), $arrExclude = array(), $arrExcludeFolder = array(), $bitFolder = true, $bitFiles = false, $strFormElement = "bild", $strDetail = "") {
	    $strReturn = "";
		include_once(_systempath_."/class_filesystem.php");
		$objFilesystem = new class_filesystem();
		$arrContent = $objFilesystem->getCompleteList($strFolder, $arrSuffix, $arrExclude, $arrExcludeFolder, $bitFolder, false);

		$strReturn .= $this->objToolkit->listHeader();
		$strReturn .= $this->objToolkit->listRow2($this->getText("pfad"), $strFolder, 1);
		$strReturn .= $this->objToolkit->listRow2($this->getText("ordner_anz"), $arrContent["nrFolders"], 1);
		$strReturn .= $this->objToolkit->listFooter();
		$strReturn .= $this->objToolkit->divider();

        $intCounter = 0;
		//Show Folders
		//Folder to jump one back up
		$arrFolderStart = array("/portal");
		$bitHit = false;
		if(!in_array($strFolder, $arrFolderStart) && $bitHit == false) {
			$strReturn .= $this->objToolkit->listHeader();
			$strAction = $this->objToolkit->listButton(getLinkAdmin("folderview", "folderList", "&folder=".uniSubstr($strFolder, 0, uniStrrpos($strFolder, "/"))."&suffix=".implode("|", $arrSuffix)."&exclude=".implode("|", $arrExclude)."&bit_folder=".$bitFolder."&bit_file=".$bitFiles."&form_element=".$strFormElement, $this->getText("ordner_hoch"), $this->getText("ordner_hoch"), "icon_folderActionLevelup.gif"));
			$strReturn .= $this->objToolkit->listRow2Image(getImageAdmin("icon_folderOpen.gif"), "..", $strAction, $intCounter++);
			$bitHit = true;
		}
		if($arrContent["nrFolders"] != 0) {
			if(!$bitHit)
				$strReturn .= $this->objToolkit->listHeader();
			$bitHit = true;
			foreach($arrContent["folders"] as $strFolderCur) {
				$strAction = $this->objToolkit->listButton(getLinkAdmin("folderview", "folderList", "&folder=".$strFolder."/".$strFolderCur."&suffix=".implode("|", $arrSuffix)."&exclude=".implode("|", $arrExclude)."&bit_folder=".$bitFolder."&bit_file=".$bitFiles."&form_element=".$strFormElement, $this->getText("ordner_oeffnen"), $this->getText("ordner_oeffnen"), "icon_folderActionOpen.gif"));
				$strAction .= $this->objToolkit->listButton("<a href=\"#\" title=\"".$this->getText("ordner_uebernehmen")."\" class=\"showTooltip\" onClick=\"window.opener.document.getElementById('".$strFormElement."').value='".$strFolder."/".$strFolderCur."'; self.close(); \">".getImageAdmin("icon_accept.gif"));
				$strReturn .= $this->objToolkit->listRow2Image(getImageAdmin("icon_folderOpen.gif", "Ordner"), $strFolderCur, $strAction, $intCounter++);
			}
		}
		if($bitHit)
		  $strReturn .= $this->objToolkit->listFooter();
        return $strReturn;
	}


	/**
	 * Returns details about the given file
	 *
	 * @param string $strFile
	 * @return string
	 */
	public function fileDetailview($strFile) {
		$strReturn = "";
		if(is_file($strFile)) {
			//Details der Datei sammeln
			include_once(_systempath_."/class_filesystem.php");
			$objFilesystem = new class_filesystem();
			$arrDetails = $objFilesystem->getFileDetails($strFile);
			$arrTemplate = array();
			$arrTemplate[$this->getText("datei_name")] = $arrDetails["filename"];
			$arrTemplate[$this->getText("datei_pfad")] = $arrDetails["filepath"];
			$arrTemplate[$this->getText("datei_typ")] = $arrDetails["filetype"];

			//If we have an image, return more detailed infos
			if($arrDetails["filetype"] == ".jpg" || $arrDetails["filetype"] == ".gif" || $arrDetails["filetype"] == ".png") {
				$arrSize = getimagesize($strFile);
				$arrTemplate[$this->getText("bild_groesse")] = $arrSize[0]." x ".$arrSize[1];
				$arrTemplate[$this->getText("bild_vorschau")] = "";

				//Generate Dimensions
				$intHeight = $arrSize[1];
				$intWidth = $arrSize[0];
				$strPath = $strFile;
				if(uniStrpos($strPath, _realpath_) !== false)
					$strPath = str_replace(_realpath_, _webpath_, $strPath);

				while($intWidth > 300 || $intHeight > 300) {
					$intWidth *= 0.8;
					$intHeight *= 0.8;
				}
				//Round
				$intWidth = number_format($intWidth, 0);
				$intHeight = number_format($intHeight, 0);
				$arrTemplate["  "] = "<img src=\"".$strPath."\" width=\"".$intWidth."\" height=\"".$intHeight."\" />";
			}
			//Filesize
			$arrTemplate[$this->getText("datei_groesse")] = bytesToString($arrDetails["filesize"]);
			//Creation
			$arrTemplate[$this->getText("datei_erstell")] = timeToString($arrDetails["filecreation"]);
			//Edit
			$arrTemplate[$this->getText("datei_bearbeit")] = timeToString($arrDetails["filechange"]);
			//Access
			$arrTemplate[$this->getText("datei_zugriff")] = timeToString($arrDetails["fileaccess"]);
		}
		$strReturn .= $this->objToolkit->getFileDetails($arrTemplate);
		return $strReturn;
	}


	/**
	 * Looks up the icon for the passed file
	 *
	 * @param string $strType
	 * @return string
	 */
	private function getFileicon($strType) {
		$arrType = $this->objToolkit->mimeType($strType);
		return getImageAdmin($arrType[2]);
	}


	/**
	 * Returns a list of folders in the pages-database
	 *
	 * @param string $strFolder
	 * @param bool $bitPages
	 * @param bool $strElement
	 * @param string $strPageid
	 * @return String
	 */
	private function pagesFolderBrowser($strFolder, $bitPages, $strElement, $strPageid = "0" ) {
		$strReturn = "";
		$intCounter = 1;

		include_once(_systempath_."/class_modul_pages_folder.php");

		$arrFolder = class_modul_pages_folder::getFolderList($strFolder);
        $objFolder = new class_modul_pages_folder($strFolder);
		$strLevelUp = "";

		if($strFolder != "0")
			$strLevelUp = $objFolder->getPrevId();
		//but: when browsing pages the current level should be kept
		iF($strPageid != "0")
		   $strLevelUp = $strFolder;

		$strReturn .= $this->objToolkit->listHeader();
		//Folder to jump one level up
		if(!$bitPages || $strLevelUp != "") {
			$strAction = $this->objToolkit->listButton(($strFolder != "0" && $strLevelUp!= "") || $strPageid != "0" ? getLinkAdmin("folderview", "pagesFolderBrowser", "&folderid=".$strLevelUp.($bitPages ? "&pages=1" : "")."&form_element=".$strElement.($this->getParam("bit_link")  != "" ? "&bit_link=1" : ""), $this->getText("ordner_hoch"), $this->getText("ordner_hoch"), "icon_folderActionLevelup.gif") :  "" );
			if($strFolder == 0 && !$bitPages)
				$strAction .= $this->objToolkit->listButton("<a href=\"#\" title=\"".$this->getText("ordner_uebernehmen")."\" class=\"showTooltip\" onClick=\"window.opener.document.getElementById('ordnerid').value='0'; window.opener.document.getElementById('".$strElement."').value=''; self.close(); \">".getImageAdmin("icon_accept.gif"));

			$strReturn .= $this->objToolkit->listRow2("..", $strAction, $intCounter++);
		}

		if(count($arrFolder) > 0 && $strPageid == "0") {
			foreach($arrFolder as $objSingleFolder) {
				if($bitPages) {
					$strAction = $this->objToolkit->listButton(getLinkAdmin("folderview", "pagesFolderBrowser", "&folderid=".$objSingleFolder->getSystemid()."&pages=1&form_element=".$strElement.($this->getParam("bit_link")  != "" ? "&bit_link=1" : "")."", $this->getText("ordner_oeffnen"), $this->getText("ordner_oeffnen"), "icon_folderActionOpen.gif"));
					$strReturn .= $this->objToolkit->listRow2($objSingleFolder->getStrName(), $strAction, $intCounter++);
				}
				else {
				    $strAction = $this->objToolkit->listButton(getLinkAdmin("folderview", "pagesFolderBrowser", "&folderid=".$objSingleFolder->getSystemid()."&form_element=".$strElement, $this->getText("ordner_oeffnen"), $this->getText("ordner_oeffnen"), "icon_folderActionOpen.gif"));
					$strAction .= $this->objToolkit->listButton("<a href=\"#\" title=\"".$this->getText("ordner_uebernehmen")."\" class=\"showTooltip\" onClick=\"window.opener.document.getElementById('ordnerid').value='".$objSingleFolder->getSystemid()."'; window.opener.document.getElementById('".$strElement."').value='".$objSingleFolder->getStrName()."'; self.close(); \">".getImageAdmin("icon_accept.gif"));
					$strReturn .= $this->objToolkit->listRow2($objSingleFolder->getStrName(), $strAction, $intCounter++);
				}
			}

		}
		$strReturn .= $this->objToolkit->listFooter();

		//Pages could be sent too
		if($bitPages && $strPageid == "0") {
			$strReturn .= $this->objToolkit->divider();
			$arrPages = class_modul_pages_folder::getPagesInFolder($strFolder);
			if(count($arrPages) > 0) {
				$strReturn .= $this->objToolkit->listHeader();
				foreach($arrPages as $objSinglePage) {
					//Should we generate a link ?
					if($this->getParam("bit_link") != "")
						$arrSinglePage["name2"] = '_indexpath_'."?page=".$objSinglePage->getStrName();
					else
						$arrSinglePage["name2"] = $objSinglePage->getStrName();



					$strAction = $this->objToolkit->listButton(getLinkAdmin("folderview", "pagesFolderBrowser", "&folderid=".$strFolder."&form_element=".$strElement."&pageid=".$objSinglePage->getSystemid().($this->getParam("bit_link")  != "" ? "&bit_link=1" : "").($bitPages ? "&pages=1" : ""), $this->getText("seite_oeffnen"), $this->getText("seite_oeffnen"), "icon_folderActionOpen.gif"));
					$strAction .= $this->objToolkit->listButton("<a href=\"#\" title=\"".$this->getText("seite_uebernehmen")."\" class=\"showTooltip\" onClick=\"window.opener.document.getElementById('".$strElement."').value='".$arrSinglePage["name2"]."'; self.close(); \">".getImageAdmin("icon_accept.gif")."</a>");
					$strReturn .= $this->objToolkit->listRow2($objSinglePage->getStrName(), $strAction, $intCounter++);
				}
				$this->objToolkit->listFooter();
			}
		}

		//Load the list of pagelements available on the page
		if($strPageid != "0") {
		    $strReturn .= $this->objToolkit->divider();
            $arrPageelements = class_modul_pages_pageelement::getElementsOnPage($strPageid, true, $this->objSession->getAdminLanguage());
            $objPage = new class_modul_pages_page($strPageid);
            if(count($arrPageelements) > 0) {
                $strReturn .= $this->objToolkit->listHeader();
                foreach($arrPageelements as $objOnePageelement) {

                    //Should we generate a link ?
					if($this->getParam("bit_link") != "")
						$arrSinglePage["name2"] = '_indexpath_'."?page=".$objPage->getStrName()."#".$objOnePageelement->getSystemid();
					else
						$arrSinglePage["name2"] = $objPage->getStrName()."#".$objOnePageelement->getSystemid();

					$strAction = $this->objToolkit->listButton("<a href=\"#\" title=\"".$this->getText("seite_uebernehmen")."\" class=\"showTooltip\" onClick=\"window.opener.document.getElementById('".$strElement."').value='".$arrSinglePage["name2"]."'; self.close(); \">".getImageAdmin("icon_accept.gif")."</a>");
					$strReturn .= $this->objToolkit->listRow2($objOnePageelement->getStrTitle()."(".$objOnePageelement->getStrName().")", $strAction, $intCounter++);
                }
                $this->objToolkit->listFooter();
            }
		}

		return $strReturn;
	}

	/**
	 * Returns a list of available navigations
	 *
	 */
	private function navigationBrowser() {
		$strReturn = "";
		$intCounter = 1;
		//Load all navis
		include_once(_systempath_."/class_modul_navigation_tree.php");
		$arrNavis = class_modul_navigation_tree::getAllNavis();


		$strReturn .= $this->objToolkit->listHeader();
		foreach($arrNavis as $objOnenavigation) {
		    $strAction = $this->objToolkit->listButton("<a href=\"#\" title=\"".$this->getText("ordner_uebernehmen")."\" class=\"showTooltip\" onClick=\"window.opener.document.getElementById('navigation_name').value='".$objOnenavigation->getStrName()."'; window.opener.document.getElementById('navigation_id').value='".$objOnenavigation->getSystemid()."'; self.close(); \">".getImageAdmin("icon_accept.gif"));
			$strReturn .= $this->objToolkit->listRow2($objOnenavigation->getStrName(), $strAction, $intCounter++);
		}
        $strReturn .= $this->objToolkit->listFooter();
		return $strReturn;
	}
}
?>