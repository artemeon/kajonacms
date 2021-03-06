<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*   $Id$                                        *
********************************************************************************************************/

namespace Kajona\System\Admin\Systemtasks;

use Kajona\System\System\Lifecycle\ServiceLifeCycleFactory;
use Kajona\System\System\SystemCommon;
use Kajona\System\System\SystemModule;


/**
 * A systemtask to set the status of a given record
 *
 * @package module_system
 * @author sidler@mulchprod.de
 * @since 3.4
 */
class SystemtaskSystemstatus extends SystemtaskBase implements AdminSystemtaskInterface
{


    /**
     * @inheritdoc
     */
    public function getGroupIdentifier()
    {
        return "database";
    }

    /**
     * @inheritdoc
     */
    public function getStrInternalTaskName()
    {
        return "systemstatus";
    }

    /**
     * @inheritdoc
     */
    public function getStrTaskName()
    {
        return $this->getLang("systemtask_systemstatus_name");
    }

    /**
     * @inheritdoc
     */
    public function executeTask()
    {

        if (!SystemModule::getModuleByName("system")->rightRight2()) {
            return $this->getLang("commons_error_permissions");
        }

        //try to load and update the systemrecord
        if (validateSystemid($this->getParam("systemstatus_systemid"))) {
            $objRecord = new SystemCommon($this->getParam("systemstatus_systemid"));
            $objRecord->setIntRecordStatus($this->getParam("systemstatus_status"));
            ServiceLifeCycleFactory::getLifeCycle(get_class($objRecord))->update($objRecord);

            return $this->objToolkit->getTextRow($this->getLang("systemtask_status_success"));
        }

        return $this->objToolkit->getTextRow($this->getLang("systemtask_status_error"));
    }

    /**
     * @inheritdoc
     */
    public function getAdminForm()
    {
        $strReturn = "";

        $arrDropdown = array(
            1 => $this->getLang("systemtask_systemstatus_active"),
            0 => $this->getLang("systemtask_systemstatus_inactive")
        );

        $strReturn .= $this->objToolkit->formInputText("systemstatus_systemid", $this->getLang("systemtask_systemstatus_systemid"));
        $strReturn .= $this->objToolkit->formInputDropdown("systemstatus_status", $arrDropdown, $this->getLang("systemtask_systemstatus_status"));

        return $strReturn;
    }

    /**
     * @inheritdoc
     */
    public function getSubmitParams()
    {
        return "&systemstatus_systemid=".$this->getParam("systemstatus_systemid")."&systemstatus_status=".$this->getParam("systemstatus_status");
    }
}
