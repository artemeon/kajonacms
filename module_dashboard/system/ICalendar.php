<?php
/*"******************************************************************************************************
 *   (c) ARTEMEON Management Partner GmbH
 *       Published under the GNU LGPL v2.1
 ********************************************************************************************************/

namespace Kajona\Dashboard\System;

use Kajona\System\System\Carrier;
use Kajona\System\System\Date;
use Kajona\System\System\Model;
use Kajona\System\System\ModelInterface;
use Kajona\System\System\SystemSetting;

/**
 * Object which represents a ICalendar entry
 *
 * @package module_dashboard
 * @author andrii.konoval@artemeon.de
 * @targetTable agp_dashboard_ical.ical_id
 *
 * @module dashboard
 * @moduleId _dashboard_module_id_
 */
class ICalendar extends Model implements ModelInterface
{

    const ICAL_START = '-3 month';
    const ICAL_END = '+1 year';
    const ICAL_VALID_TIME = 15;
    const ICAL_LONG_FORMAT = 'Ymd\THis\Z';
    const ICAL_SHORT_FORMAT = 'Ymd\T000000';

    /**
     * @var string
     * @tableColumn agp_dashboard_ical.user_systemid
     * @tableColumnDatatype char20
     */
    private $strUserId = "";

    /**
     * @var string
     * @tableColumn agp_dashboard_ical.cache
     * @tableColumnDatatype longtext
     */
    private $strICalCache = "";

    /**
     * @var int|null
     * @tableColumn agp_dashboard_ical.create_date
     */
    private $longCreateDate;

    /**
     * Returns the name to be used when rendering the current object, e.g. in admin-lists.
     *
     * @return string
     */
    public function getStrDisplayName()
    {
        return "";
    }

    /**
     * @return string
     */
    public function getStrUserId()
    {
        return $this->strUserId;
    }

    /**
     * @param string $userId
     */
    public function setStrUserId($userId)
    {
        $this->strUserId = $userId;
    }

    /**
     * @return string
     */
    public function getStrICalCache()
    {
        return $this->strICalCache;
    }

    /**
     * @param string $iCalCache
     */
    public function setStrICalCache($iCalCache)
    {
        $this->strICalCache = $iCalCache;
    }

    /**
     * @return int
     */
    public function getLongCreateDate()
    {
        return $this->longCreateDate;
    }

    /**
     * @param int|null $createDate
     */
    public function setLongCreateDate($createDate)
    {
        $this->longCreateDate = $createDate;
    }

    /**
     * @param Date|null $startDate
     * @param Date|null $endDate
     * @return EventEntry[]
     */
    public function getCalendarEventsList(Date $startDate = null, Date $endDate = null): array
    {
        $events = [];
        $categories = EventRepository::getAllCategories();

        foreach ($categories as $category) {
            foreach ($category as $key => $value) {
                if (Carrier::getInstance()->getObjSession()->getSession($key) !== "disabled") {
                    $events = array_merge($events, EventRepository::getEventsByCategoryAndDate($key, $startDate, $endDate));
                }
            }
        }

        return $events;
    }


    /**
     * @param EventEntry[] $events
     * @return string
     */
    private function generate(array $events): string
    {
        $iCalendar = <<<ICALHEADER
BEGIN:VCALENDAR
VERSION:2.0
METHOD:PUBLISH
PRODID:-//AGP Events//DE\n
ICALHEADER;

        foreach ($events as $event) {
            if ($event->getObjStartDate() instanceof Date && $event->getObjEndDate() instanceof Date) {
                $eventStartDate = date(self::ICAL_LONG_FORMAT, $event->getObjStartDate()->getTimeInOldStyle());
                $eventEndDate = date(self::ICAL_LONG_FORMAT, $event->getObjEndDate()->getTimeInOldStyle());
            } elseif ($event->getObjValidDate() instanceof Date) {
                $eventStartDate = date(self::ICAL_SHORT_FORMAT, $event->getObjValidDate()->getTimeInOldStyle());
                $eventEndDate = date(self::ICAL_SHORT_FORMAT, $event->getObjValidDate()->getTimeInOldStyle());
            } else {
                continue;
            }
            $summary = strip_tags($event->getStrDisplayName());
            $description = $event->getStrHref();
            $iCalendar .= <<<ICALBODY
BEGIN:VEVENT
DTSTART:$eventStartDate
DTEND:$eventEndDate
SUMMARY:$summary
DESCRIPTION:$description
END:VEVENT\n
ICALBODY;
        }
        $iCalendar .= "END:VCALENDAR";

        return $iCalendar;
    }

    /**
     * Returns generated calDav calendar
     * @return string
     */
    public function getICalendar(): string
    {
        $calDavValidTime = SystemSetting::getConfigValue('_dashboard_cal_dav_valid_time_');
        $validTimeInterval = $calDavValidTime ?: self::ICAL_VALID_TIME;
        $validTime = strtotime("+$validTimeInterval min", strtotime($this->getLongCreateDate()));
        if ($validTime > strtotime('now')) {
            $iCalendar = $this->getStrICalCache();
        } else {
            $events = $this->getCalendarEventsList(new Date(strtotime(self::ICAL_START)), new Date(strtotime(self::ICAL_END)));
            $iCalendar = $this->generate($events);
            $this->setLongCreateDate((new Date())->getLongTimestamp());
            $this->setStrICalCache($iCalendar);
            $lifeCycleFactory = Carrier::getInstance()->getContainer()->offsetGet(\Kajona\System\System\ServiceProvider::STR_LIFE_CYCLE_FACTORY);
            $lifeCycleFactory->factory(get_class($this))->update($this);
        }

        return $iCalendar;
    }
}
