<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
********************************************************************************************************/

namespace Kajona\System\Event;

use Kajona\System\System\CoreEventdispatcher;
use Kajona\System\System\GenericeventListenerInterface;
use Kajona\System\System\SystemChangelog;
use Kajona\System\System\SystemEventidentifier;

/**
 * Creates changelog entries after sending content to the browser
 *
 * @package module_system
 * @author sidler@mulchprod.de
 *
 * @since 4.6
 *
 */
class SystemChangelogAftercontentsendlistener implements GenericeventListenerInterface
{


    /**
     * Searches for languagesets containing the current systemid. either as a language or a referenced record.
     * Called whenever a records was deleted using the common methods.
     * Implement this method to be notified when a record is deleted, e.g. to to additional cleanups afterwards.
     * There's no need to register the listener, this is done automatically.
     * Make sure to return a matching boolean-value, otherwise the transaction may be rolled back.
     *
     * @param string $strEventName
     * @param array $arrArguments
     *
     * @return bool
     */
    public function handleEvent($strEventName, array $arrArguments)
    {
        $objChangelog = new SystemChangelog();
        return $objChangelog->processCachedInserts();
    }


    /**
     * Internal init to register the event listener, called on file-inclusion, e.g. by the class-loader
     *
     * @return void
     */
    public static function staticConstruct()
    {
    }
}

CoreEventdispatcher::getInstance()->removeAndAddListener(SystemEventidentifier::EVENT_SYSTEM_REQUEST_AFTERCONTENTSEND, new SystemChangelogAftercontentsendlistener());
