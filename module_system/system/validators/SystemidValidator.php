<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                   *
********************************************************************************************************/

namespace Kajona\System\System\Validators;

use Kajona\System\System\ValidatorInterface;


/**
 * A simple validator to validate a systemid.
 *
 * @author sidler@mulchprod.de
 * @since 4.0
 * @package module_system
 */
class SystemidValidator implements ValidatorInterface {

    /**
     * Validates the passed chunk of data.
     * In most cases, this'll be a string-object.
     *
     * @param string $objValue
     * @return bool
     */
    public function validate($objValue) {


        if(!is_string($objValue))
            return false;

        return validateSystemid($objValue);
    }


}
