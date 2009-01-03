<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2009 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                       *
********************************************************************************************************/

// --- Module texts -------------------------------------------------------------------------------------

$lang["modul_titel"]				= "Downloads";
$lang["modul_rechte"]				= "Module permissions";
$lang["modul_liste"]				= "List";
$lang["archiv_neu"]					= "Create archive";
$lang["logbuch"]					= "Logfile";
$lang["browser"]					= "Browse folders";
$lang["archive_masssync"]           = "Synchronize all";

$lang["permissions_header"]         = array(0 => "View", 1 => "Edit", 2 => "Delete", 3 => "Permissions", 4 => "Sync", 5 => "Download", 6 => "Logs", 7 => "Rating", 8 => "");

$lang["logbuch_loeschen_link"]		= "Flush logfile";

$lang["archiv_anzeigen"]			= "Open archive";
$lang["archiv_bearbeiten"]			= "Edit archive";
$lang["archiv_loeschen_frage"]		= "Do you really want to delete the archive &quot;<b>%%element_name%%</b>&quot;? <br /> All stored details will be deleted!";
$lang["archiv_loeschen_erfolg"]		= "The archive was delete successfully";
$lang["archiv_loeschen_fehler"]		= "Because of missing permissions the archive couldn't be deleted";
$lang["archiv_rechte"]				= "Edit permissions";
$lang["archiv_syncro"]				= "Synchronize archive";
$lang["syncro_ende"]				= "Synchronization finished successfully<br />";

$lang["archive_title"]              = "Title:";
$lang["archive_path"]               = "Path:";

$lang["speichern"]                  = "Save";

$lang["downloads_name"]             = "Name:";
$lang["downloads_description"]      = "Description:";
$lang["downloads_max_kb"]           = "Max downloadspeed in kb/s (0=unlimited):";

$lang["sortierung_hoch"]			= "Shift one position up";
$lang["sortierung_runter"]			= "Shift one position down";

$lang["ordner_oeffnen"]				= "Show folder";
$lang["ordner_hoch"]				= "One level up";

$lang["datei_bearbeiten"]			= "Edit details";
$lang["datei_speichern_fehler"]		= "An error occured while saving details";

$lang["fehler_recht"]				= "Not enough permissions to perform this action";

$lang["liste_leer_archive"]			= "No archives available";
$lang["liste_leer_dl"]				= "No downloads available";

$lang["header_id"]                  = "Download-ID";
$lang["header_date"]                = "Date";
$lang["header_file"]                = "File";
$lang["header_user"]                = "User";
$lang["header_ip"]                  = "IP/Hostname";
$lang["header_amount"]              = "Amount";

$lang["stats_title"]                = "Downloads";
$lang["stats_toptitle"]             = "Top downloads";

$lang["sync_add"]                   = "Added: ";
$lang["sync_del"]                   = " Deleted: ";
$lang["sync_upd"]                   = " Updated: ";



$lang["datum"]                      = "Date:";
$lang["hint_datum"]                 = "Deletes all logbook entries recorded before the given date.";

$lang["_downloads_suche_seite_"]         = "Result page:";
$lang["_downloads_suche_seite_hint"]     = "This page shows the list of downloads found by the search";

$lang["required_archive_title"]     = "Title of the archive";
$lang["required_archive_path"]      = "Path of the archive";
$lang["required_downloads_name"]    = "Name";
$lang["required_downloads_max_kb"]  = "Downloadspeed";


// --- Quickhelp texts ----------------------------------------------------------------------------------

$lang["quickhelp_newArchive"]       = "The basic data of a archive is captured by this form.<br />This includes the title and the corresponding start-path on the filesystem.";
$lang["quickhelp_editArchive"]      = "The basic data of a archive is captured by this form.<br />This includes the title and the corresponding start-path on the filesystem.";
$lang["quickhelp_list"]             = "All set up archives are included in this list.<br />Using the action 'synchronize' the files on the filesystem will be synchronized with the database records. New files on the filesystem will be added to the database, deleted files will be removed from the database. Modified files will be updated to the database.";
$lang["quickhelp_showArchive"]      = "Files and folders contained by the before selected archive are listed in this view.";
$lang["quickhelp_editFile"]         = "A file or folder could be extended by a set of additional informations.<br />When editing a file, a maximal download speed can be defined. This limits the download speed when users are downloading this file in the portal.";
?>