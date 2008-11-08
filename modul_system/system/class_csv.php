<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2008 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                               *
********************************************************************************************************/

/**
 * class_csv, used to access data stored in csv-files.
 * This class can either be used to write to write to csv-files, or to read from csv-files
 *
 * @package modul_system
 */
class class_csv {

    private $arrMapping = null;
    private $arrData = null;
    private $strFilename = null;
    private $strDelimiter = null;
    private $strTextEncloser = null;
    private $objFileHandle = null;


    /**
     * Use a ';' as delimiter
     *
     * @var string
     */
    public static $str_delimiter_semikolon = ";";

    /**
     * Use a ',' as delimiter
     *
     * @var stirng
     */
    public static $str_delimiter_comma = ",";



	/**
	 * Constructor
	 *
	 */
	public function __construct($strDelimiter = "") {
		$this->arrModul["name"] 		= "class_csv";
		$this->arrModul["author"] 		= "sidler@mulchprod.de";
		$this->arrModul["moduleId"]		= _system_modul_id_;

		if($strDelimiter == "")
		  $this->strDelimiter = class_csv::$str_delimiter_comma;

	    // Try to overwrite PHP memory-limit so also large images can be processed
		if (class_carrier::getInstance()->getObjConfig()->getPhpIni("memory_limit") < 50)
			@ini_set("memory_limit", "50M");
	}


	/**
	 * Creates an array containing the rows given in the csv-file
	 *
	 * @return bool
	 * @throws class_exception
	 */
	public function createArrayFromFile() {
	    //all needed params given?
	    if($this->arrMapping != "" && $this->strFilename != "") {
	        //load file-content
	        $strFileContent = file_get_contents(_realpath_.$this->strFilename);
	        //empty file?
	        if($strFileContent == "") {
	            $this->arrData = array();
	            return true;
	        }
	        //regular file. explode rows
	        $arrRowsInFile = explode("\n", $strFileContent);
	        //reset fileContent
	        $strFileContent = "";
	        //first row are the headers
	        $strHeader = array_shift($arrRowsInFile);
	        $arrHeader = explode($this->strDelimiter, $strHeader);

	        $arrFinalArray = array();
	        //loop over every row
	        foreach($arrRowsInFile as $intKey => $strOneRow) {
	            if(uniStrlen($strOneRow) > 0) {
    	            $arrOneRow = explode($this->strDelimiter, $strOneRow);
                    $arrCSVRow = array();
                    foreach($arrHeader as $intKey => $strHeader) {
                        //include the mapping specified
                        if($strHeader != "") {
                            //add an encloser?
                            if($this->strTextEncloser != null) {
                                $strHeader = uniStrReplace($this->strTextEncloser, "", trim($strHeader));
                            }
                            $strRowKey = $this->arrMapping[$strHeader];
                            $strValue = $arrOneRow[$intKey];
                            //remove an encloser?
                            if($this->strTextEncloser != null) {
                                $strValue = uniStrReplace($this->strTextEncloser, "", trim($strValue));
                            }
                            $arrCSVRow[$strRowKey] = $strValue;
                        }
                    }
                    //add to final array
                    $arrFinalArray[] = $arrCSVRow;
	            }
	            //Reset row to 0 to decrease memory consumption
	            $arrRowsInFile[$intKey] = "";
	        }
	        $this->setArrData($arrFinalArray);
	        return true;
	    }
	    else {
	        throw new class_exception("cant proceed, needed values missing", class_exception::$level_ERROR);
	    }
	}


	/**
	 * Writes the current array of data to the given csv-file.
	 * Make sure to have set all needed values before, otherwise
	 * an exception is thrown
	 *
	 * @return bool
	 * @throws class_exception
	 */
	public function writeArrayToFile() {
	    //all needed values set before?
	    if($this->arrData != null && $this->arrMapping != null && $this->strFilename != null) {
	        //create file-content. use a file-pointer to avoid max-mem-errors
	        include_once(_systempath_."/class_filesystem.php");
	        $objFilesystem = new class_filesystem();
	        //open file
	        $objFilesystem->openFilePointer($this->strFilename);
	        //the first row should contain the row-names
	        $strRow = "";
	        foreach ($this->arrMapping as $strSourceCol => $strTagetCol) {
	            //add enclosers?
                if($this->strTextEncloser != null) {
                    $strTagetCol = $this->strTextEncloser.$strTagetCol.$this->strTextEncloser;
                }
	            $strRow .= $strTagetCol.$this->strDelimiter;
	        }
	        //remove last delimiter, eol
	        $strRow = uniSubstr($strRow, 0, (uniStrlen($this->strDelimiter))*-1);
	        //add a linebreak
	        $strRow .= "\n";
	        //write header to file
	        $objFilesystem->writeToFile($strRow);
	        //iterate over the data array tp write it to the file
	        foreach ($this->arrData as $arrOneRow) {
	            $strRow = "";
	            foreach($this->arrMapping as $strSourceCol => $strTargetCol) {
	                if(isset($arrOneRow[$strSourceCol])) {
	                    $strEntry = $arrOneRow[$strSourceCol];
	                    //escape the delimiter maybe occuring in the text
	                    $strEntry = uniStrReplace($this->strDelimiter, "\\".$this->strDelimiter, $strEntry);
	                    //add enclosers?
	                    if($this->strTextEncloser != null) {
	                        $strEntry = $this->strTextEncloser.$strEntry.$this->strTextEncloser;
	                    }
	                }
	                else
	                   $strEntry = "";

	                $strRow .= $strEntry.$this->strDelimiter;
	            }
	            //remove last delimiter, eol
	            $strRow = uniSubstr($strRow, 0, (uniStrlen($this->strDelimiter))*-1);
	            //add linebreak
	            $strRow .= "\n";
	            //and write to file
	            $objFilesystem->writeToFile($strRow);
	        }
	        //anc close the filepointer...
	        $objFilesystem->closeFilePointer();
	        return true;
	    }
	    else {
	        throw new class_exception("cant proceed, needed values missing", class_exception::$level_ERROR);
	    }
	    return false;
	}

	/**
	 * Set the type of delimiter of the source or target file
	 * Use the static class-vars to use valid delimiters
	 *
	 * @param string $strDelimiter
	 */
	public function setStrDelimiter($strDelimiter) {
	    $this->strDelimiter = $strDelimiter;
	}


	/**
	 * Set an array of rows to write to a csv-file
	 *
	 * @param mixed $arrData
	 */
	public function setArrData($arrData) {
	    if(count($arrData) > 0) {
	        $this->arrData = $arrData;
	    }
	}

	/**
	 * Returns the current arrData
	 *
	 * @return array
	 */
	public function getArrData() {
	    return $this->arrData;
	}

	/**
	 * Set the filename of the source or target file
	 *
	 * @param string $strFilename
	 */
	public function setStrFilename($strFilename) {
	    //replace realpath?
	    if(uniStrpos($strFilename, _realpath_) !== false) {
	        $strFilename = uniStrReplace(_realpath_, "", $strFilename);
	    }
	    $this->strFilename = $strFilename;
	}


	/**
	 * Set an array of column.mappings. Usedfull if you want different column names or
	 * to limit the columns to read / write.
	 * The array is build like
	 * array( "sourceCol1" => "targetCol1",
	 *        "sourceCol2" => "targetCol2");
	 *
	 * @param array $arrMapping
	 */
	public function setArrMapping($arrMapping) {
	    if(count($arrMapping) > 0) {
	        $this->arrMapping = $arrMapping;
	    }
	}

	/**
	 * Sets an encloser to sourround the values.
	 * Example: " --> "value1","value2"
	 *
	 * @param string $strEncloser
	 */
	public function setTextEncloser($strEncloser) {
	    if($strEncloser == "")
	       $strEncloser = null;

	    $this->strTextEncloser = $strEncloser;
	}

} // class_csv

?>