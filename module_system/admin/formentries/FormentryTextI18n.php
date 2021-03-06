<?php
/*"******************************************************************************************************
 *   (c) ARTEMEON Management Partner GmbH
 *       Published under the GNU LGPL v2.1
 ********************************************************************************************************/

declare(strict_types=1);

namespace Kajona\System\Admin\Formentries;

/**
 * I18n implementation of a simple text-input
 *
 * @author  stefan.idler@artemeon.de
 * @since   7.1
 */
class FormentryTextI18n extends AbstractFormentryI18n
{
    private $strOpener = "";

    /**
     * @param string $strFormName
     * @param string $strSourceProperty
     * @param mixed $objObject
     * @throws \Kajona\System\System\Exception
     */
    protected function buildFormEntries($strFormName, $strSourceProperty, $objObject)
    {
        foreach ($this->getPossibleI18nLanguages() as $lang) {
            $entry = new FormentryText($strFormName, "{$strSourceProperty}_{$lang}");
            $entry->setObjSourceObject($objObject);
            $entry->setStrOpener($this->getStrOpener());
            $entry->setStrLabel($this->getStrLabel()." ({$lang})");
            $entry->setStrHint($this->getStrHint());
            $entry->setBitMandatory($this->getBitMandatory());
            $entry->setBitHideLongHints($this->getBitHideLongHints());
            $this->arrEntries[$lang] = $entry;
        }
    }


    /**
     * @param string $strOpener
     * @return FormentryTextI18n
     */
    public function setStrOpener(string $strOpener): FormentryBase
    {
        /** @var FormentryText $objEntry */
        foreach ($this->arrEntries as $lang => $objEntry) {
            $objEntry->setStrOpener($strOpener);
        }
        $this->strOpener = $strOpener;
        return $this;
    }

    /**
     * @return string
     */
    public function getStrOpener(): string
    {
        return $this->strOpener;
    }
}
