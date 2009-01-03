<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2009 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$	                                        *
********************************************************************************************************/

// --- Module texts -------------------------------------------------------------------------------------

$lang["modul_titel"]				= "System";
$lang["modul_rechte"]				= "Modul-Rechte";
$lang["modul_rechte_root"]          = "Root-Rechte";
$lang["module_liste"]				= "Installierte Module";
$lang["modul_sortup"]               = "Nach oben verschieben";
$lang["modul_sortdown"]             = "Nach unten verschieben";
$lang["modul_status_disabled"]      = "Modul aktiv schalten (ist inaktiv)";
$lang["modul_status_enabled"]       = "Modul inaktiv schalten (ist aktiv)";
$lang["modul_status_system"]        = "Hmmm. Den System-Kernel deaktivieren? Zuvor bitte format c: ausführen!";
$lang["system_info"]				= "Systeminformationen";
$lang["system_settings"]			= "Systemeinstellungen";
$lang["systemTasks"]			    = "System-Tasks";
$lang["system_sessions"]            = "Sessions";
$lang["systemlog"]                  = "System-Log";
$lang["updatecheck"]                = "Update-Check";
$lang["about"]                      = "Über Kajona";

$lang["permissions_default_header"] = array(0 => "Anzeigen", 1 => "Bearbeiten", 2 => "Löschen", 3 => "Rechte", 4 => "", 5 => "", 6 => "", 7 => "", 8 => "");
$lang["permissions_root_header"]    = array(0 => "Anzeigen", 1 => "Bearbeiten", 2 => "Löschen", 3 => "Rechte", 4 => "Universal 1", 5 => "Universal 2", 6 => "Universal 3", 7 => "Universal 4", 8 => "Universal 5" );
$lang["permissions_header"]         = array(0 => "Anzeigen", 1 => "Bearbeiten", 2 => "Löschen", 3 => "Rechte", 4 => "Einstellungen",  5 => "Systemtasks", 6 => "Systemlog", 7 => "Updates", 8 => "");
            							
$lang["dateStyleShort"]             = "d.m.Y";            							
$lang["dateStyleLong"]              = "d M Y H:i:s"; 

$lang["status_active"]              = "Status ändern (ist aktiv)";
$lang["status_inactive"]            = "Status ändern (ist inaktiv)";

$lang["deleteButton"]               = "Löschen";

$lang["dialog_deleteHeader"]        = "Löschen bestätigen";
$lang["dialog_deleteButton"]        = "Ja, löschen";
$lang["dialog_cancelButton"]        = "abbrechen";

$lang["fehler_recht"]				= "Keine ausreichenden Rechte um diese Aktion durchzuführen";

$lang["gd"]							= "GD-Lib";
$lang["db"]							= "Datenbank";
$lang["php"]						= "PHP";
$lang["server"]						= "Webserver";
$lang["version"] 					= "Version";
$lang["geladeneerweiterungen"]	 	= "Geladene Erweiterungen";
$lang["executiontimeout"] 			= "Execution Timeout";
$lang["inputtimeout"] 				= "Input Timeout";
$lang["memorylimit"] 				= "Memory Limit";
$lang["errorlevel"] 				= "Error Level";
$lang["postmaxsize"] 				= "Post Max Size";
$lang["uploadmaxsize"] 				= "Upload Max Size";
$lang["uploads"] 					= "Uploads";

$lang["system"] 					= "System";
$lang["speicherplatz"] 				= "Speicherplatz";
$lang["diskspace_free"]             = " (frei/gesamt)";


$lang["datenbankserver"] 			= "Datenbankserver";
$lang["datenbankclient"] 			= "Datenbankclient";
$lang["datenbankverbindung"] 		= "Datenbankverbindung";
$lang["anzahltabellen"] 			= "Anzahl Tabellen";
$lang["groessegesamt"] 				= "Größe Gesamt";
$lang["groessedaten"] 				= "Größe Daten";
$lang["datenbanktreiber"] 			= "Datenbanktreiber";

$lang["keinegd"]					= "Keine GD-Lib installiert";
$lang["gifread"]					= "GIF Read Support";
$lang["gifwrite"]					= "GIF Write Support";
$lang["png"]						= "PNG Support";
$lang["jpg"]						= "JPG Support";

$lang["browser"]					= "Seitenbrowser";

$lang["speichern"]                  = "Speichern";

$lang["warnung_settings"]           = "!! ACHTUNG !!<br />Bei folgenden Einstellungen können falsche Werte das System unbrauchbar machen!";
$lang["settings_updated"]           = "Einstellungen wurden geändert.";

$lang["settings_true"]				= "Ja";
$lang["settings_false"]				= "Nein";

$lang["session_loggedin"]           = "Angemeldet";
$lang["session_loggedout"]          = "Gast";
$lang["session_admin"]              = "Administration, Modul: ";
$lang["session_portal"]             = "Portal, Seite: ";
$lang["session_username"]           = "Benutzer";
$lang["session_valid"]              = "Gültig bis";
$lang["session_status"]             = "Status";
$lang["session_activity"]           = "Aktivität";
$lang["session_logout"]             = "Session beenden";

$lang["_system_portal_disable_"]            = "Portal deaktiviert:";
$lang["_system_portal_disable_hint"]        = "Diese Einstellung aktiviert/deaktiviert das gesamte Portal.";
$lang["_system_portal_disablepage_"]        = "Zwischenseite:";
$lang["_system_portal_disablepage_hint"]    = "Diese Seite wird angezeigt, wenn das Portal deaktiviert wurde.";
$lang["_bildergalerie_cachepfad_"]          = "Bildercache-Pfad:";
$lang["_bildergalerie_cachepfad_hint"]      = "Hier werden temporär erzeugte Bilder abgelegt.";
$lang["_system_dbdump_amount_"]             = "Anzahl DB-Dumps:";
$lang["_system_dbdump_amount_hint"]         = "Definiert, wie viele Datenbank-Sicherungen vorgehalten werden sollen.";
$lang["_system_mod_rewrite_hint"]           = "Schaltet URL-Rewriting für Nice-URLs ein oder aus. Das Apache-Modul \"mod_rewrite\" muss dazu installiert sein und in der .htaccess-Datei aktiviert werden!";
$lang["_system_mod_rewrite_"]               = "URL-Rewriting:";
$lang["_system_admin_email_hint"]           = "Falls ausgefüllt, wird im Fall eines schweren Fehlers eine E-Mail an diese Adresse gesendet.";
$lang["_system_admin_email_"]               = "Admin E-Mail:";
$lang["_system_lock_maxtime_"]              = "Maximale Sperrdauer:";
$lang["_system_lock_maxtime_hint"]          = "Nach der angegebenen Dauer in Sekunden werden gesperrte Datensätze automatisch wieder freigegeben.";
$lang["_system_output_gzip_"]               = "GZIP-Kompression der Ausgaben:";
$lang["_system_output_gzip_hint"]           = "Aktiviert das Komprimieren der Ausgaben per GZIP, bevor diese an den Browser gesendet werden. Besser: Aktivieren der Kompressionseinstellungen in der .htaccess-Datei.";
$lang["_admin_nr_of_rows_"]                 = "Anzahl Datensätze pro Seite:";
$lang["_admin_nr_of_rows_hint"]             = "Anzahl an Datensätzen in den Admin-Listen, sofern das Modul dies unterstützt. Kann von einem Modul überschrieben werden!";
$lang["_admin_only_https_"]                 = "Admin nur per HTTPS:";
$lang["_admin_only_https_hint"]             = "Bevorzugt die Verwendung von HTTPS im Adminbereich. Der Webserver muss hierfür HTTPS unterstützen.";
$lang["_system_use_dbcache_"]               = "Datenbankcache aktiv:";
$lang["_system_use_dbcache_hint"]           = "Aktiviert/deaktiviert den systeminternen Cache für Datenbankabfragen.";
$lang["_remoteloader_max_cachetime_"]       = "Cachedauer externer Quellen:";
$lang["_remoteloader_max_cachetime_hint"]   = "Cachedauer in Sekunden für extern nachgeladene Inhalte (z.B. RSS-Feeds).";
$lang["_system_release_time_"]              = "Dauer einer Session:";
$lang["_system_release_time_hint"]          = "Nach dieser Dauer in Sekunden wird eine Session automatisch ungültig.";


$lang["errorintro"]                 = "Bitte alle benötigten Felder ausfüllen!";
$lang["pageview_forward"]           = "Weiter";
$lang["pageview_backward"]          = "Zurück";
$lang["pageview_total"]             = "Gesamt: ";

$lang["systemtask_run"]             = "Ausführen";

$lang["log_empty"]                  = "Keine Einträge im Logfile vorhanden";

$lang["update_nodom"]               = "Diese PHP-Installation unterstützt kein XML-DOM. Dies ist für den Update-Check erforderlich.";
$lang["update_nourlfopen"]          = "Für diese Funktion muss der Wert &apos;allow_url_fopen&apos; in der PHP-Konfiguration auf &apos;on&apos; gesetzt sein!";
$lang["update_module_name"]         = "Modul";
$lang["update_module_localversion"] = "Diese Installation";
$lang["update_module_remoteversion"]= "Verfügbar";
$lang["update_available"]           = "Bitte updaten!";
$lang["update_nofilefound"]         = "Die Liste der Updates konnte nicht geladen werden.<br />Gründe hierfür können sein, dass auf diesem System der PHP-Config-Wert 'allow_url_fopen' auf 'off' gesetzt wurde, oder das System keine Unterstützung für Sockets bietet.";
$lang["update_invalidXML"]          = "Die Antwort vom Server war leider nicht korrekt. Bitte versuchen Sie die letzte Aktion erneut.";

$lang["about_part1"]                = "<h2>Kajona V3 - Open Source Content Management System</h2>Kajona V 3.1.1, Codename \"taskforce\"<br /><br /><a href=\"http://www.kajona.de\" target=\"_blank\">www.kajona.de</a><br /><a href=\"mailto:info@kajona.de\" target=\"_blank\">info@kajona.de</a><br /><br />Für weitere Infomationen, Support oder bei Anregungen besuchen Sie einfach unsere Webseite.<br />Support erhalten Sie auch in unserem <a href=\"http://board.kajona.de/\" target=\"_blank\">Forum</a>.";

$lang["about_part2"]                = "<h2>Entwicklungsleitung</h2><ul><li><a href=\"mailto:sidler@kajona.de\" target=\"_blank\">Stefan Idler</a> (Projektleitung, Technische Leitung, Entwicklung)</li><li><a href=\"mailto:jschroeter@kajona.de\" target=\"_blank\">Jakob Schröter</a> (Leitung Frontend, Entwicklung)</li></ul><h2>Contributors / Entwickler</h2><ul><li>Thomas Hertwig</li><li><a href=\"mailto:tim.kiefer@kojikui.de\" target=\"_blank\">Tim Kiefer</a></li></ul>";

$lang["about_part3"]                = "<h2>Credits</h2><ul><li>Icons:<br />Everaldo Coelho (Crystal Clear, Crystal SVG), <a href=\"http://everaldo.com/\" target=\"_blank\">http://everaldo.com/</a><br />Steven Robson (Krystaline), <a href=\"http://www.kde-look.org/content/show.php?content=17509\" target=\"_blank\">http://www.kde-look.org/content/show.php?content=17509</a><br />David Patrizi, <a href=\"mailto:david@patrizi.de\">david@patrizi.de</a></li><li>browscap.ini:<br />Gary Keith, <a href=\"http://browsers.garykeith.com/downloads.asp\" target=\"_blank\">http://browsers.garykeith.com/downloads.asp</a></li><li>FCKeditor:<br />Frederico Caldeira Knabben, <a href=\"http://www.fckeditor.net/\" target=\"_blank\">http://www.fckeditor.net/</a></li><li>JpGraph:<br />Aditus, <a href=\"http://www.aditus.nu/jpgraph/\" target=\"_blank\">http://www.aditus.nu/jpgraph/</a></li><li>DejaVu Fonts:<br />DejaVu Team, <a href=\"http://dejavu.sourceforge.net\" target=\"_blank\">http://dejavu.sourceforge.net</a></li><li>Yahoo! User Interface Library:<br />Yahoo!, <a href=\"http://developer.yahoo.com/yui/\" target=\"_blank\">http://developer.yahoo.com/yui/</a></li></ul>";

$lang["setAbsolutePosOk"]           = "Speichern der Position erfolgreich";
$lang["setStatusOk"]                = "Ändern des Status erfolgreich";
$lang["setStatusError"]             = "Fehler beim Ändern des Status";

$lang["toolsetCalendarMonth"]       = "\"Januar\", \"Februar\", \"M\\u00E4rz\", \"April\", \"Mai\", \"Juni\", \"Juli\", \"August\", \"September\", \"Oktober\", \"November\", \"Dezember\"";
$lang["toolsetCalendarWeekday"]     = "\"So\", \"Mo\", \"Di\", \"Mi\", \"Do\", \"Fr\", \"Sa\"";

// --- Quickhelp texts ----------------------------------------------------------------------------------

$lang["quickhelp_title"]            = "Schnellhilfe";

$lang["quickhelp_list"]				= "Die Liste der Module gibt eine schnelle Übersicht über die aktuell im System installierten Module.<br />Zusätzlich werden die aktuell installierten Versionen der installierten Module genannt, ebenso das ursprüngliche Installationsdatum des Moduls.<br />Über die Rechte des Moduls kann der Modul-Rechte-Knoten bearbeitet werden, von welchem die Inhalte bei aktivierter Rechtevererbung ihre Einstellungen erben.<br />Durch Verschieben der Module in der Liste lässt sich die Reihenfolge in der Modulnavigation anpassen.";
$lang["quickhelp_moduleList"]       = "Die Liste der Module gibt eine schnelle Übersicht über die aktuell im System installierten Module.<br />Zusätzlich werden die aktuell installierten Versionen der installierten Module genannt, ebenso das ursprüngliche Installationsdatum des Moduls.<br />Über die Rechte des Moduls kann der Modul-Rechte-Knoten bearbeitet werden, von welchem die Inhalte bei aktivierter Rechtevererbung ihre Einstellungen erben.<br />Durch Verschieben der Module in der Liste lässt sich die Reihenfolge in der Modulnavigation anpassen.";
$lang["quickhelp_systemInfo"]		= "Kajona versucht an dieser Stelle, ein paar Informationen über das System heraus zu finden, auf welchem sich die Installation befindet.";
$lang["quickhelp_systemSettings"]	= "Hier können grundlegende Einstellungen des Systems vorgenommen werden. Hierfür kann jedes Modul beliebige Einstellungsmöglichkeiten anbieten. Die hier vorgenommenen Einstellungen sollten mit Vorsicht verändert werden, falsche Einstellungen können das System im schlimmsten Fall unbrauchbar machen.<br /><br />Hinweis: Werden Werte an einem Modul geändert, so muss für JEDES Modul der Speichern-Button gedrückt werden. Ein Abändern der Einstellungen verschiedener Module wird beim Speichern nicht übernommen. Es werden nur die Werte der zum Speichern-Button zugehörigen Felder übernommen.";
$lang["quickhelp_systemTasks"]		= "Systemtasks sind kleine Programme, die alltägliche Aufaben wie Wartungsarbeiten im System übernehmen.<br />Hierzu gehört das Sichern der Datenbank und ggf. das Rückspielen einer Sicherung in das System.";
$lang["quickhelp_systemlog"]		= "Das Systemlogbuch gibt die Einträge des Logfiles aus, in welche die Module Nachrichten schreiben können.<br />Die Feinheit des Loggings kann in der config-Datei (/system/config/config.php) eingestellt werden.";
$lang["quickhelp_updateCheck"]		= "Mit der Aktion Updatecheck werden die Versionsnummern der im System installierten Module mit den Versionsnummern der aktuell verfügbaren Module verglichen. Sollte ein Modul nicht mehr in der neusten Verion installiert sein, so gibt Kajona in der Zeile dieses Moduls einen Hinweis hierzu aus.";


//--- systemtasks ---------------------------------------------------------------------------------------

$lang["systemtask_dbconsistency_name"]               = "Datenbankkonsistenz überprüfen";
$lang["systemtask_dbconsistency_curprev_ok"]         = "Alle Eltern-Kind Beziehungen sind korrekt";
$lang["systemtask_dbconsistency_curprev_error"]      = "Folgende Eltern-Kind Beziehungen sind fehlerhaft (fehlender Elternteil):";
$lang["systemtask_dbconsistency_right_ok"]           = "Alle Rechte-Records haben einen zugehörigen System-Record";
$lang["systemtask_dbconsistency_right_error"]        = "Folgende Rechte-Records sind fehlerhaft (fehlender System-Record):";
$lang["systemtask_dbconsistency_date_ok"]            = "Alle Datum-Records haben einen zugehörigen System-Record";
$lang["systemtask_dbconsistency_date_error"]         = "Folgende Datum-Records sind fehlerhaft (fehlender System-Record):";

$lang["systemtask_dbexport_name"]   = "Datenbank sichern";
$lang["systemtask_dbexport_success"]= "Sicherung erfolgreich angelegt";
$lang["systemtask_dbexport_error"]  = "Fehler beim Sichern der Datenbank";

$lang["systemtask_dbimport_name"]   = "Datenbank importieren";
$lang["systemtask_dbimport_success"]= "Sicherung erfolgreich eingespielt";
$lang["systemtask_dbimport_error"]  = "Fehler beim Einspielen der Sicherung";
$lang["systemtask_dbimport_file"]   = "Sicherung:";

$lang["systemtask_flushpiccache_name"]               = "Bildercache leeren";
$lang["systemtask_flushpiccache_done"]               = "Leeren abgeschlossen.";
$lang["systemtask_flushpiccache_deleted"]            = "<br />Anzahl gelöschter Bilder: ";
$lang["systemtask_flushpiccache_skipped"]            = "<br />Anzahl übersprungener Bilder: ";

$lang["systemtask_flushremoteloadercache_name"]      = "Remoteloadercache leeren";
$lang["systemtask_flushremoteloadercache_done"]      = "Leeren abgeschlossen.";


//--- MODULE RIGHTS -------------------------------------------------------------------------------------

// --- Module texts -------------------------------------------------------------------------------------
$lang["moduleRightsTitle"]          = "Rechte";

$lang["titel_root"]                 = "Rechte-Root-Satz";
$lang["titel_leer"]                 = "<em>Kein Titel hinterlegt</em>";
$lang["titel_erben"]                = "Rechte erben:";

$lang["fehler_setzen"]              = "Fehler beim Speichern der Rechte";
$lang["setzen_erfolg"]              = "Rechte erfolgreich gespeichert";

$lang["backlink"]                   = "Zurück";
$lang["desc"]                       = "Rechte ändern an:";
$lang["submit"]                     = "Speichern";


// --- Quickhelp texts ----------------------------------------------------------------------------------
$lang["quickhelp_change"]           = "Mit Hilfe dieses Formulares können die Rechte eines Datensatzes angepasst werden.<br />Je nach dem, welchem Modul der Datensatz zugeordnet wurde, kann die Anzahl der möglichen zu konfigurierenden Rechte variieren.";

//--- installer -----------------------------------------------------------------------------------------

$lang["installer_given"]            = "vorhanden";
$lang["installer_missing"]          = "fehlen";
$lang["installer_nloaded"]          = "fehlt";
$lang["installer_loaded"]           = "geladen";
$lang["installer_next"]             = "Nächster Schritt >";
$lang["installer_prev"]             = "< Vorheriger Schritt";
$lang["installer_install"]          = "Installieren";
$lang["installer_installpe"]        = "Seitenelemente installieren";
$lang["installer_update"]           = "Update auf ";
$lang["installer_systemlog"]        = "System Log";
$lang["installer_versioninstalled"] = "Installierte Version: ";

$lang["installer_phpcheck_intro"]   = "<b>Herzlich Willkommen</b><br /><br />";
$lang["installer_phpcheck_lang"]    = "Um den Installer in einer anderen Sprache zu laden, bitte einen der folgenden Links verwenden:<br /><br />";
$lang["installer_phpcheck_intro2"]  = "<br />Die Installation des Systems erfolgt in mehreren Schritten: <br />Rechtepüfung, DB-Konfiguration, Zugangsdaten zur Administration, Modulinstallation, Elementinstallation und Installation der Beispielinhalte.<br /><br />Je nach Modulauswahl kann die Anzahl dieser Schritte abweichen.<br /><br />Es werden die Schreibrechte einzelner Dateien und Verzeichnisse sowie<br />die Verfügbarkeit benötigter PHP-Module überprüft:<br />";
$lang["installer_phpcheck_folder"]  = "<br />Schreibrechte auf ";
$lang["installer_phpcheck_module"]  = "<br />PHP-Modul ";

$lang["installer_login_intro"]     = "<b>Admin-Benutzer einrichten</b><br /><br />Bitte geben Sie hier einen Benutzernamen und ein Passwort an.<br />Diese Daten werden später als Zugang zur Administration verwendet.<br />Aus Sicherheitsgründen sollten Sie Benutzernamen wie \"admin\" oder \"administrator\" vermeiden.<br /><br />";
$lang["installer_login_installed"]  = "<br />Das System wurde bereits mit einem Admin-Benutzer installiert.<br />";
$lang["installer_login_username"]   = "Benutzername:";
$lang["installer_login_password"]   = "Passwort:";
$lang["installer_login_save"]       = "Benutzer anlegen";

$lang["installer_config_intro"]     = "<b>Datenbankeinstellungen erfassen</b><br /><br />Anmerkung: Der Webserver benötigt Schreibrechte auf die Datei /system/config/config.php.<br />Leere Werte für den Datenbankserver, -benutzer, -passwort und -name sind nicht zugelassen.<br /><br />Für den Fall, dass Sie einen dieser Werte leer lassen möchten, bearbeiten Sie bitte die Datei /system/config/config.php manuell mit einem Texteditor, Näheres hierzu finden Sie im Handbuch.<br /><br /><b>ACHTUNG:</b> Der PostgreSQL Treiber befindet sich noch im Alpha-Stadium und sollte nur in Test-Umgebungen verwendet werden.<br /><br />";
$lang["installer_config_dbhostname"] = "Datenbankserver:";
$lang["installer_config_dbusername"] = "Datenbankbenutzer:";
$lang["installer_config_dbpassword"] = "Datenbankpasswort:";
$lang["installer_config_dbport"]     = "Datenbankport:";
$lang["installer_config_dbportinfo"] = "Für den Standardport bitte leer lassen";
$lang["installer_config_dbdriver"]   = "Datenbanktreiber:";
$lang["installer_config_dbname"]     = "Datenbankname:";
$lang["installer_config_dbprefix"]   = "Tabellenpräfix:";
$lang["installer_config_write"]      = "In config.php speichern";

$lang["installer_modules_found"]     = "<b>Installation/Update der Module</b><br /><br />Bitte wählen Sie die Module aus, die Sie installieren möchten:<br /><br />";
$lang["installer_modules_needed"]    = "Zur Installation benötigte Module: ";
$lang["installer_module_notinstalled"] = "Modul ist nicht installiert";
$lang["installer_systemversion_needed"] = "Minimal benötigte Systemversion: ";

$lang["installer_elements_found"]    = "<b>Installation der Seitenelemente</b><br /><br />Bitte wählen Sie die Seitenelemente aus, die Sie installieren möchten:<br /><br />";

$lang["installer_samplecontent"]     = "<b>Installation der Beispielinhalte</b><br /><br />Das Modul Samplecontent erstellt einige Standard-Seiten und Navigationen.<br />Je nach installierten Modulen werden verschiedene Beispielinhalte installiert.<br /><br /><br />";

$lang["installer_finish_intro"]      = "<b>Installation abgeschlossen</b><br /><br />";
$lang["installer_finish_hints"]      = "Sie sollten nun die Schreibrechte auf die Datei /system/config/config.php auf Leserechte zurücksetzen.<br />Zusätzlich sollte aus Sicherheitsgründen der Ordner /installer/ unbedingt komplett gelöscht werden.<br /><br /><br />Die Administrationsoberfläche erreichen Sie nun unter:<br />&nbsp;&nbsp;&nbsp;&nbsp;<a href=\""._webpath_."/admin\">"._webpath_."/admin</a><br /><br />Das Portal erreichen Sie unter:<br />&nbsp;&nbsp;&nbsp;&nbsp;<a href=\""._webpath_."/\">"._webpath_."</a><br /><br />";
$lang["installer_finish_closer"]     = "<br />Wir wünschen viel Spaß mit Kajona!";
?>
