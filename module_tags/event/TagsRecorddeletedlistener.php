<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                    *
********************************************************************************************************/

namespace Kajona\Tags\Event;

use Kajona\System\System\Carrier;
use Kajona\System\System\CoreEventdispatcher;
use Kajona\System\System\GenericeventListenerInterface;
use Kajona\System\System\OrmBase;
use Kajona\System\System\OrmDeletedhandlingEnum;
use Kajona\System\System\SystemEventidentifier;
use Kajona\System\System\SystemModule;
use Kajona\Tags\System\TagsFavorite;
use Kajona\Tags\System\TagsTag;

/**
 * Removes tag-assignments on record-deletions
 *
 * @package module_tags
 * @author sidler@mulchprod.de
 *
 */
class TagsRecorddeletedlistener implements GenericeventListenerInterface
{


    /**
     * Searches for tags assigned to the systemid to be deleted.
     *
     * @param string $strEventName
     * @param array $arrArguments
     *
     * @return bool
     * @throws \Kajona\System\System\Exception
     */
    public function handleEvent($strEventName, array $arrArguments)
    {
        //unwrap arguments
        list($strSystemid, $strSourceClass) = $arrArguments;

        $bitReturn = true;

        if ($strSourceClass == TagsTag::class && SystemModule::getModuleByName("tags") != null) {
            //delete matching favorites
            OrmBase::setObjHandleLogicalDeletedGlobal(OrmDeletedhandlingEnum::INCLUDED);
            $arrFavorites = TagsFavorite::getAllFavoritesForTag($strSystemid);
            foreach ($arrFavorites as $objOneFavorite) {
                if ($strEventName == SystemEventidentifier::EVENT_SYSTEM_RECORDDELETED_LOGICALLY) {
                    $bitReturn = $bitReturn && $objOneFavorite->deleteObject();
                }

                if ($strEventName == SystemEventidentifier::EVENT_SYSTEM_RECORDDELETED) {
                    $bitReturn = $bitReturn && $objOneFavorite->deleteObjectFromDatabase();

                    $bitReturn = $bitReturn && Carrier::getInstance()->getObjDB()->_pQuery("DELETE FROM agp_tags_member WHERE tags_tagid=?", array($strSystemid));
                }

            }
            OrmBase::setObjHandleLogicalDeletedGlobal(OrmDeletedhandlingEnum::EXCLUDED);
        }


        //delete memberships. Fire a plain query, faster then searching.
        if ($strEventName == SystemEventidentifier::EVENT_SYSTEM_RECORDDELETED) {
            $bitReturn = $bitReturn && Carrier::getInstance()->getObjDB()->_pQuery("DELETE FROM agp_tags_member WHERE tags_systemid=?", array($strSystemid));
        }

        return $bitReturn;
    }


    /**
     * Internal init to register the event listener, called on file-inclusion, e.g. by the class-loader
     * @return void
     */
    public static function staticConstruct()
    {
        CoreEventdispatcher::getInstance()->removeAndAddListener(SystemEventidentifier::EVENT_SYSTEM_RECORDDELETED, new TagsRecorddeletedlistener());
        CoreEventdispatcher::getInstance()->removeAndAddListener(SystemEventidentifier::EVENT_SYSTEM_RECORDDELETED_LOGICALLY, new TagsRecorddeletedlistener());
    }


}

TagsRecorddeletedlistener::staticConstruct();