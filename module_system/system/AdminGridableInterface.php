<?php
/*"******************************************************************************************************
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                          *
********************************************************************************************************/

namespace Kajona\System\System;

/**
 * A grid-element is a subset of the listables.
 * Compares to a listable-element, a grid-element is represented by a large image.
 * Mostly used for images / galleries.
 *
 * @package module_system
 * @author sidler@mulchprod.de
 * @since 4.0
 */
interface AdminGridableInterface extends AdminListableInterface
{

    /**
     * Returns the image the be used in a grid-view.
     * Make sure to return the full url, otherwise the
     * img-tag may be broken
     *
     * @abstract
     * @return string the full url to the image that should be embedded into the grid
     */
    public function getStrGridIcon();

}
