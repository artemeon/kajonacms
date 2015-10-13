<?php
/*"******************************************************************************************************
*   (c) 2007-2015 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
********************************************************************************************************/

/**
 * The postacomment message-provider is able to send mails as soon as a new comment is available.
 * By default, all users with edit-permissions of the postacomment-module are notified.
 *
 * @author sidler@mulchprod.de
 * @package module_postacomment
 * @since 4.0
 */
class class_messageprovider_postacomment implements interface_messageprovider {



    /**
     * Returns the name of the message-provider
     *
     * @return string
     */
    public function getStrName() {
        return class_carrier::getInstance()->getObjLang()->getLang("messageprovider_postacomment_name", "postacomment");
    }

    /**
     * Returns a short identifier, mainly used to reference the provider in the config-view
     *
     * @return string
     */
    public function getStrIdentifier() {
        return "postacomment";
    }
}
