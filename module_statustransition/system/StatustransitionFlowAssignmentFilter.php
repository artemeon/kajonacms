<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
********************************************************************************************************/

namespace Kajona\Statustransition\System;

use Kajona\System\System\Database;
use Kajona\System\System\Exception;
use Kajona\System\System\FilterBase;
use Kajona\System\System\Model;

/**
 * StatustransitionFlowAssignmentFilter
 *
 * @author christoph.kappestein@artemeon.de
 */
class StatustransitionFlowAssignmentFilter extends FilterBase
{
    /**
     * @var string
     * @tableColumn flow_assign.assign_class
     * @tableColumnDatatype char20
     */
    protected $strClass;

    /**
     * @var string
     * @tableColumn flow_assign.assign_key
     * @tableColumnDatatype char20
     */
    protected $strKey;

    /**
     * @return string
     */
    public function getStrClass()
    {
        return $this->strClass;
    }

    /**
     * @param string $strClass
     */
    public function setStrClass($strClass)
    {
        $this->strClass = $strClass;
    }

    /**
     * @return string
     */
    public function getStrKey()
    {
        return $this->strKey;
    }

    /**
     * @param string $strKey
     */
    public function setStrKey($strKey)
    {
        $this->strKey = $strKey;
    }
}
