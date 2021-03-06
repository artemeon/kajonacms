<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
********************************************************************************************************/

namespace Kajona\System\Admin\Formentries;

use Kajona\System\Admin\FormentryPrintableInterface;
use Kajona\System\System\Carrier;
use Kajona\System\System\Reflection;
use Kajona\System\System\Validators\TextValidator;
use Kajona\System\View\Components\Formentry\Wysiwygeditor\WysiwygEditor;


/**
 * @author sidler@mulchprod.de
 * @since 4.3
 */
class FormentryWysiwyg extends FormentryBase implements FormentryPrintableInterface
{

    protected $strToolbarset = "standard";
    private $strOpener = "";


    const STR_CONFIG_ANNOTATION = "@wysiwygConfig";


    public function __construct($strFormName, $strSourceProperty, $objSourceObject = null)
    {
        parent::__construct($strFormName, $strSourceProperty, $objSourceObject);

        //set the default validator
        $this->setObjValidator(new TextValidator());
    }

    /**
     * Renders the field itself.
     * In most cases, based on the current toolkit.
     *
     * @return string
     */
    public function renderField()
    {

        if ($this->getObjSourceObject() != null && $this->getStrSourceProperty() != "") {
            $objReflection = new Reflection($this->getObjSourceObject());

            //try to find the matching source property
            $strSourceProperty = $this->getCurrentProperty(self::STR_CONFIG_ANNOTATION);
            if ($strSourceProperty != null) {
                $this->strToolbarset = $objReflection->getAnnotationValueForProperty($strSourceProperty, self::STR_CONFIG_ANNOTATION);
            }
        }


        $objToolkit = Carrier::getInstance()->getObjToolkit("admin");
        $strReturn = "";
        if ($this->getStrHint() != null) {
            $strReturn .= $objToolkit->formTextRow($this->getStrHint());
        }

        $wysiwygEditor = new WysiwygEditor($this->getStrEntryName(), $this->getStrLabel(), $this->getStrValue(), $this->strToolbarset, $this->getBitReadonly(), $this->strOpener);
        $strReturn .= $wysiwygEditor->renderComponent();

        return $strReturn;
    }

    /**
     * Returns a textual representation of the formentries' value.
     * May contain html, but should be stripped down to text-only.
     *
     * @return string
     */
    public function getValueAsText()
    {
        return $this->getStrValue();
    }

    /**
     * @return string
     */
    public function getStrToolbarset()
    {
        return $this->strToolbarset;
    }

    /**
     * @param string $strToolbarset
     * @return $this
     */
    public function setStrToolbarset($strToolbarset)
    {
        $this->strToolbarset = $strToolbarset;
        return $this;
    }

    /**
     * @param string $strOpener
     */
    public function setStrOpener(string $strOpener)
    {
        $this->strOpener = $strOpener;
    }


}
