<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*   $Id$                                     *
********************************************************************************************************/

namespace Kajona\System\System;

/**
 * Interface for all installers
 *
 * @package module_system
 */
interface SamplecontentInstallerInterface {


    /**
     * Does the hard work: installs the module and registers needed constants
     *
     * @return String
     */
    public function install();

    /**
     * Returns the assigned module
     *
     * @return string
     */
    public function getCorrespondingModule();

    /**
     * Checks if the samplecontent is already installed or should be installed.
     * @return bool
     */
    public function isInstalled();

}
