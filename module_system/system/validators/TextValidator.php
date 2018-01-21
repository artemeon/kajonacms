<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                   *
********************************************************************************************************/

namespace Kajona\System\System\Validators;

use Kajona\System\System\StringUtil;
use Kajona\System\System\ValidatorInterface;


/**
 * A simple validator to validate a string.
 * By default, the string must contain a single char, the max length is unlimited.
 *
 * @author sidler@mulchprod.de
 * @since 4.0
 * @package module_system
 */
class TextValidator implements ValidatorInterface
{

    /**
     * Validates the passed chunk of data.
     * In most cases, this'll be a string-object.
     *
     * @param string $objValue
     * @return bool
     */
    public function validate($objValue)
    {

        if (!is_string($objValue) && !is_numeric($objValue)) {
            return false;
        }

        $intMin = 1;
        $intMax = 0;//todo does not makes sense here as the else part will never be reached?extract intMax to class variable?

        $intLen = StringUtil::length($objValue);
        if ($intMax == 0) {
            if ($intLen >= $intMin) {
                return true;
            }
        } else {
            if ($intLen >= $intMin && $intLen <= $intMax) {
                return true;
            }
        }
        return false;
    }
}
