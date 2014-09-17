<?php
/*"******************************************************************************************************
*   (c) 2013-2014 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                           *
********************************************************************************************************/

/**
 * This class contains the data for a series and their specific options.
 *
 * @package module_jqplot
 * @since 4.3
 * @author stefan.meyer1@yahoo.de
 */
class class_graph_jqplot_seriesdata {

    private $arrDataArray = null;
    private $intChartType = null;
    private $intSeriesDataOrder = null;



    //contains specific options for this series
    private $arrSeriesOptions = array(
        "renderer" => null,
        "rendererOptions" => array(
            "showDataLabels" => null,
            "fillToZero" => null,
            "highlightMouseOver" => false
        ),
        "markerOptions" => array(
            "style" => null
        ),
        "label" => null,
        "pointLabels" => array(
            "show" => false,
            "labels" =>null
        )
    );


    public function __construct($strChartType, $intSeriesDataOrder, &$arrGlobalOptions) {
        $this->intSeriesDataOrder = $intSeriesDataOrder;
        $this->intChartType = $strChartType;

        if($strChartType == class_graph_jqplot_charttype::LINE) {
            $this->arrSeriesOptions["renderer"] = "$.jqplot.LineRenderer";
        }
        elseif($strChartType == class_graph_jqplot_charttype::BAR) {
            $this->arrSeriesOptions["renderer"] = "$.jqplot.BarRenderer";
            $this->arrSeriesOptions["rendererOptions"]["fillToZero"] = true;
            $this->arrSeriesOptions["rendererOptions"]["shadow"] = false;

            //additionally set required global options
            $arrGlobalOptions["axes"]["xaxis"]["tickOptions"]["showGridline"] = false;
        }
        elseif($strChartType == class_graph_jqplot_charttype::BAR_HORIZONTAL) {
            $this->arrSeriesOptions["renderer"] = "$.jqplot.BarRenderer";
            $this->arrSeriesOptions["rendererOptions"]["barDirection"] = "horizontal";
            $this->arrSeriesOptions["rendererOptions"]["fillToZero"] = true;
            $this->arrSeriesOptions["rendererOptions"]["shadow"] = false;

            //additionally set required global options
            $arrGlobalOptions["seriesDefaults"]["renderer"] = "$.jqplot.BarRenderer";
            $arrGlobalOptions["seriesDefaults"]["rendererOptions"]["barDirection"] = "horizontal";
        }
        elseif($strChartType == class_graph_jqplot_charttype::STACKEDBAR) {
            $this->arrSeriesOptions["renderer"] = "$.jqplot.BarRenderer";
            $this->arrSeriesOptions["rendererOptions"]["fillToZero"] = true;
            $this->arrSeriesOptions["rendererOptions"]["shadow"] = false;

            $this->arrSeriesOptions["pointLabels"]["show"] = true;

            //additionally set required global options
            $arrGlobalOptions["axes"]["xaxis"]["tickOptions"]["showGridline"] = false;
        }
        elseif($strChartType == class_graph_jqplot_charttype::STACKEDBAR_HORIZONTAL) {
            $this->arrSeriesOptions["renderer"] = "$.jqplot.BarRenderer";
            $this->arrSeriesOptions["rendererOptions"]["barDirection"] = "horizontal";
            $this->arrSeriesOptions["rendererOptions"]["fillToZero"] = true;
            $this->arrSeriesOptions["rendererOptions"]["shadow"] = false;

            $this->arrSeriesOptions["pointLabels"]["hideZeros"] = true;
            $this->arrSeriesOptions["pointLabels"]["formatString"] = '%s';
            $this->arrSeriesOptions["pointLabels"]["show"] = true;

            //additionally set required global options
            $arrGlobalOptions["seriesDefaults"]["renderer"] = "$.jqplot.BarRenderer";
            $arrGlobalOptions["seriesDefaults"]["rendererOptions"]["barDirection"] = "horizontal";
        }
        elseif($strChartType == class_graph_jqplot_charttype::PIE) {
            $this->arrSeriesOptions["renderer"] = "$.jqplot.PieRenderer";
            $this->arrSeriesOptions["rendererOptions"]["showDataLabels"] = true;
            $this->arrSeriesOptions["rendererOptions"]["sliceMargin"] = 2;
            $this->arrSeriesOptions["rendererOptions"]["shadowOffset"] = 0;
            $this->arrSeriesOptions["rendererOptions"]["highlightMouseOver"] = true;
        }
        else {
            throw new class_exception("Not a valid chart type", class_exception::$level_ERROR);
        }
    }


    /**
     * @param bool $bitWriteValues
     */
    public function setBitWriteValues($bitWriteValues = false) {
        $this->arrSeriesOptions["pointLabels"]["show"] = $bitWriteValues;
    }

    /**
     * @return int
     */
    public function getIntChartType() {
        return $this->intChartType;
    }


    /**
     * @return int
     */
    public function getIntSeriesDataOrder() {
        return $this->intSeriesDataOrder;
    }


    /**
     * @param array $arrDataArray
     */
    public function setArrDataArray($arrDataArray) {
        $this->arrDataArray = $arrDataArray;

        //now process array -> all values which are not numeric will be converted to a 0
        $this->arrDataArray = array_map(function($objElement) {
                if(!is_numeric($objElement)) {
                    return 0;
                }
                return $objElement;
            }
        ,$this->arrDataArray);

    }

    /**
     * @return array
     */
    public function getArrDataArray() {
        return $this->arrDataArray;
    }

    /**
     * @param string $strSeriesLabel
     */
    public function setStrSeriesLabel($strSeriesLabel) {
        $this->arrSeriesOptions["label"] = $strSeriesLabel;
    }

    /**
     * @return string
     */
    public function getStrSeriesLabel() {
        return $this->arrSeriesOptions["label"];
    }

    /**
     * Converts the php array to a JSON string for jqplot
     *
     * @return string
     */
    public function optionsToJSON() {
        return json_encode($this->arrSeriesOptions);
    }

    /**
     * @return array
     */
    public function getArrSeriesOptions() {
        return $this->arrSeriesOptions;
    }

    /**
     * @param array $arrSeriesOptions
     */
    public function setArrSeriesOptions($arrSeriesOptions) {
        $this->arrSeriesOptions = $arrSeriesOptions;
    }
}