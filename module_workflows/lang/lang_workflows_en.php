<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2016 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$					    *
********************************************************************************************************/
//Edited with Kajona Language Editor GUI, see www.kajona.de and www.mulchprod.de for more information
//Kajona Language Editor Core Build 398

//non-editable entries
$lang["permissions_header"]              = array(0 => "View", 1 => "Edit", 2 => "Delete", 3 => "Permissions", 4 => "Handlers", 5 => "Stats", 6 => "", 7 => "", 8 => "");


//editable entries
$lang["_workflows_trigger_authkey_"]     = "Auth-Key";
$lang["_workflows_trigger_authkey_hint"] = "Use the auth-key as a secret when triggering the workflow-engine. Only if the passed auth-key matches the saved auth-key, the workflows will be triggered. This avoids that third-party clients could trigger the workflows (DOS-attack).<br />Use the following URL to trigger the workflow engine, e.g. using a cron-job: <br />"._xmlpath_."?module=workflows&action=trigger&authkey=".\Kajona\System\System\SystemSetting::getConfigValue("_workflows_trigger_authkey_")."";
$lang["action_edit_handler"]             = "Edit default values";
$lang["action_instantiate_handler"]      = "Create a new workflow instance";
$lang["action_list_handlers"]            = "Workflow handlers";
$lang["action_show_details"]             = "Show details";
$lang["action_stats"]                    = "Statistics";
$lang["delete_question"]                 = "Do you really want to delete the workflow &quot;<b>%%element_name%%</b>&quot;?";
$lang["handler_instances"]               = "{0} instances";
$lang["handler_instatiate"]              = "Do you really want to create a new instance of the handler <b>{0}</b>?";
$lang["header_list_all"]                 = "All workflows";
$lang["header_list_my"]                  = "My workflows";
$lang["list_empty"]                      = "No workflows available";
$lang["message_messagesummary_body_indicator"] = "Message {0} of {1}";
$lang["message_messagesummary_intro"]    = "You have {0} unread messages. Following is a summary of the latest unread messages.";
$lang["message_messagesummary_subject"]  = "You have {0} unread messages";
$lang["messageprovider_workflows_summary"] = "Summary of new messages";
$lang["modul_titel"]                     = "Workflows";
$lang["module_list_handlers"]            = "Workflow-Handlers";
$lang["module_mylist"]                   = "My workflows";
$lang["module_trigger"]                  = "Trigger workflows";
$lang["myList_empty"]                    = "No workflows to process available.";
$lang["quickhelp_list"]                  = "This page shows all workflows currently exiting in the system.<br /> The workflows can be edited and they are listed by its due-date.";
$lang["quickhelp_list_handlers"]         = "Workflow-Handlers represent the technical part of a single workflow. Handlers are used to set up common parameters of a running instance. In most cases, handlers are available for system-administrators, only.";
$lang["quickhelp_my_list"]               = "This page shows all own workflows.<br /> The workflows can be edited and they are listed by its due-date.";
$lang["systemtask_runworkflows_name"]    = "Run workflows";
$lang["workflow_char1"]                  = "Char 1";
$lang["workflow_char2"]                  = "Char 2";
$lang["workflow_class"]                  = "Handler";
$lang["workflow_date1"]                  = "Date 1";
$lang["workflow_date2"]                  = "Date 2";
$lang["workflow_dbdump_val1"]            = "Interval in hours";
$lang["workflow_dbdumps_title"]          = "Periodic database backup";
$lang["workflow_general"]                = "Common values";
$lang["workflow_handler_val1"]           = "Value 1";
$lang["workflow_handler_val2"]           = "Value 2";
$lang["workflow_handler_val3"]           = "Value 3";
$lang["workflow_int1"]                   = "Number 1";
$lang["workflow_int2"]                   = "Number 2";
$lang["workflow_messagesummary_title"]   = "Summary of new messages";
$lang["workflow_messagesummary_val1"]    = "Resend after x days";
$lang["workflow_messagesummary_val2"]    = "Delivery time";
$lang["workflow_messagesummary_val3"]    = "Number of messages rendered with body";
$lang["workflow_owner"]                  = "Originator";
$lang["workflow_params"]                 = "Technical parameters";
$lang["workflow_responsible"]            = "Responsible person";
$lang["workflow_runs"]                   = "Executions";
$lang["workflow_status"]                 = "Status";
$lang["workflow_status_1"]               = "New";
$lang["workflow_status_2"]               = "Scheduled";
$lang["workflow_status_3"]               = "Finished";
$lang["workflow_systemid"]               = "Relevant systemid";
$lang["workflow_text"]                   = "Text";
$lang["workflow_text2"]                  = "Text 2";
$lang["workflow_text3"]                  = "Text 3";
$lang["workflow_trigger"]                = "Next execution";
$lang["workflow_ui"]                     = "Show edit-form for the current step";
$lang["stats_start"]                     = "Start";
$lang["stats_end"]                       = "End";
$lang["stats_duration"]                  = "Duration";
$lang["stats_amount"]                    = "Nr. of handlers";
$lang["stats_result"]                    = "Result";
$lang["stats_class"]                     = "Handler";
$lang["chart_handler"]                   = "Nr. of executed handlers";
$lang["chart_broken"]                    = "Nr. of broken controllers";
$lang["chart_handler_broken"]            = "Nr. of broken handlers";
$lang["chart_processed"]                 = "Nr. of successful controllers";