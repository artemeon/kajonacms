<?php
/*"******************************************************************************************************
*   (c) 2004-2006 by MulchProductions, www.mulchprod.de                                                 *
*   (c) 2007-2009 by Kajona, www.kajona.de                                                              *
*       Published under the GNU LGPL v2.1, see /system/licence_lgpl.txt                                 *
*-------------------------------------------------------------------------------------------------------*
*	$Id$                                           *
********************************************************************************************************/

// --- Module texts -------------------------------------------------------------------------------------

$lang["modul_titel"]				= "Seiten";
$lang["modul_rechte"]				= "Modul-Rechte";
$lang["modul_liste"]				= "Liste";
$lang["modul_liste_alle"]			= "Flache Liste";
$lang["modul_neu"]					= "Neue Seite";
$lang["modul_neu_ordner"]			= "Neuer Ordner";
$lang["modul_elemente"]				= "Elemente";
$lang["modul_element_neu"]			= "Neues Element";
$lang["updatePlaceholder"]          = "Platzhalter anpassen";

$lang["permissions_header"]         = array(0 => "Anzeigen", 1 => "Bearbeiten", 2 => "Löschen", 3 => "Rechte", 4 => "Elemente", 5 => "Ordner", 6 => "Platzhalter", 7 => "", 8 => "");

$lang["browser"]					= "Browser öffnen";
$lang["klapper"]					= "Ordner ein-/ausblenden";

$lang["seite_bearbeiten"]			= "Seite bearbeiten";
$lang["liste_seiten_leer"]			= "Keine Seiten angelegt";
$lang["seite_inhalte"]				= "Seiteninhalte bearbeiten";
$lang["seite_loeschen_frage"]		= "Möchten Sie die Seite &quot;<b>%%element_name%%</b>&quot; wirklich löschen?";
$lang["seite_loeschen_erfolg"]		= "Seite erfolgreich gelöscht";
$lang["seite_rechte"]				= "Rechte bearbeiten";
$lang["seite_vorschau"]				= "Vorschau anzeigen";
$lang["seite_copy"]                 = "Seite kopieren";
$lang["lastuserTitle"]				= "Letzter Autor:";
$lang["lasteditTitle"]				= "Letzte Änderung:";
$lang["pageNameTitle"]				= "Seitenname:";

$lang["pages_hoch"]					= "Eine Ebene nach oben";
$lang["pages_ordner_oeffnen"]		= "Ordner öffnen";
$lang["ordner_anlegen_erfolg"]		= "Ordner erfolgreich angelegt";
$lang["ordner_loeschen_erfolg"]		= "Ordner erfolgreich gelöscht";
$lang["ordner_loeschen_fehler"]		= "Fehler beim Löschen des Ordners";
$lang["ordner_loschen_leer"]        = "Ordner kann nicht gelöscht werden, er ist nicht leer";
$lang["pages_ordner_rechte"]		= "Rechte bearbeiten";
$lang["pages_ordner_loeschen_frage"]= "Möchten Sie den Ordner &quot;<b>%%element_name%%</b>&quot; wirklich löschen?";

$lang["pages_ordner_edit"]			= "Ordner bearbeiten";

$lang["inhalte_titel"]				= "Seitenverwaltung - ";
$lang["inhalte_navi2"]				= "Seite: ";
$lang["inhalte_liste"]				= "Liste der Seiten";
$lang["inhalte_element"]			= "Seitenelemente verwalten";

$lang["fehler_recht"]				= "Keine ausreichenden Rechte um diese Aktion durchzuführen";
$lang["fehler_name"]				= "Kein Seitenname angegeben";

$lang["element_bearbeiten"]			= "Element bearbeiten";
$lang["element_install"]            = "Element installieren";
$lang["element_installer_hint"]     = "Gefundene Installer noch nicht installierter Elemente:";
$lang["element_anlegen"]			= "Element anlegen";
$lang["element_anlegen_fehler"]		= "Fehler beim Anlegen des Elements";
$lang["element_bearbeiten_fehler"]	= "Fehler beim Bearbeiten des Elements";

$lang["element_loeschen_frage"]		= "Möchten Sie das Element &quot;<b>%%element_name%%</b>&quot; wirklich löschen?";
$lang["element_loeschen_fehler"]	= "Fehler beim Löschen des Elements";
$lang["element_hoch"]				= "Element nach oben verschieben";
$lang["element_runter"]				= "Element nach unten verschieben";
$lang["element_status_aktiv"]		= "Status ändern (ist aktiv)";
$lang["element_status_inaktiv"]		= "Status ändern (ist inaktiv)";
$lang["element_liste_leer"]			= "Keine Elemente im Template vorhanden";
$lang["elemente_liste_leer"]		= "Keine Elemente installiert";

$lang["option_ja"]					= "Ja";
$lang["option_nein"]				= "Nein";

$lang["ds_gesperrt"]				= "Der Datensatz ist momentan gesperrt";
$lang["ds_seite_gesperrt"]			= "Die Seite kann nicht gelöscht werden, da sie gesperrte Datensätze beinhaltet";
$lang["ds_entsperren"]				= "Datensatz entsperren";

$lang["warning_elementsremaining"]  = "ACHTUNG<br>Im System befinden sich Seitenelemente, die keinem Platzhalter zugeordnet werden können. Dies kann der Fall sein, wenn ein Platzhalter im Template umbenannt oder gelöscht wurde. Um Platzhalter auch im System umzubenennen, können Sie die Funktion \"Platzhalter anpassen\" verwenden. Eine Liste der betroffenen Elemente befindet sich unter dieser Warnung.";

$lang["placeholder"]                = "Platzhalter: ";

$lang["name"]						= "Name (sprachunabhängig):";
$lang["beschreibung"]				= "Beschreibung:";
$lang["keywords"]					= "Keywords:";
$lang["ordner_name"]				= "Ordner:";
$lang["ordner_name_parent"]			= "Übergeordneter Ordner:";
$lang["template"]					= "Template:";
$lang["browsername"]                = "Browsertitel:";
$lang["seostring"]                  = "SEO-URL-Keywords:";
$lang["templateNotSelectedBefore"]  = "ACHTUNG: Für diese Seite wurde noch kein Template gewählt!";

$lang["element_name"]				= "Name:";
$lang["element_admin"]				= "Admin-Klasse:";
$lang["element_portal"]				= "Portal-Klasse:";
$lang["element_repeat"]				= "Wiederholbar:";
$lang["submit"]						= "Speichern";
$lang["element_cachetime"]          = "Max. Cachedauer:";
$lang["element_cachetime_hint"]     = "in Sekunden (-1 = kein Caching)";

$lang["_pages_templatewechsel_"]        = "Templatewechsel erlaubt:";
$lang["_pages_templatewechsel_hint"]    = "Definiert, ob das Template einer Seite geändert werden darf, wenn diese bereits Elemente enthält. Wird dies erlaubt, kann es zu unerwarteten Nebeneffekten führen!";

$lang["_pages_maxcachetime_"]       = "Maximale Cachedauer:";
$lang["_pages_maxcachetime_hint"]   = "Gibt an, wie viele Sekunden eine Seite im Cache maximal gültig ist.";

$lang["_pages_portaleditor_"]       = "Portaleditor aktiv:";

$lang["_pages_newdisabled_"]        = "Neue Seiten inaktiv:";
$lang["_pages_newdisabled_hint"]    = "Wenn diese Option aktiviert wird, sind neu angelegte Seiten inaktiv";

$lang["_pages_cacheenabled_"]       = "Seitencache aktiv:";

$lang["_pages_startseite_"]         = "Startseite:";
$lang["_pages_fehlerseite_"]        = "Fehlerseite:";
$lang["_pages_defaulttemplate_"]    = "Standardtemplate:";

$lang["page_element_placeholder_title"] = "Interner Titel:";
$lang["page_element_system_folder"] = "Optionale Felder ein/ausblenden";
$lang["page_element_start"]         = "Anzeigezeitraum Start:";
$lang["page_element_end"]           = "Anzeigezeitraum Ende:";
$lang["element_pos"]                = "Position am Platzhalter:";
$lang["element_first"]              = "Am Anfang des Platzhalters";
$lang["element_last"]               = "Am Ende des Platzhalters";
$lang["page_element_placeholder_language"] = "Sprache:";

$lang["required_ordner_name"]       = "Name des Ordners";
$lang["required_element_name"]      = "Name des Elements";
$lang["required_element_cachetime"] = "Cachedauer des Elements";
$lang["required_name"]              = "Name der Seite";
$lang["required_elementid"]         = "Ein Element mit diesem Namen exisitiert bereits.";

$lang["plUpdateHelp"]               = "Hier können die in der Datenbank gespeicherten Platzhalter aktualisiert werden.<br />Dies kann dann nötig werden, wenn ein Platzhalter um ein weiteres mögliches Seitenelement erweitert wurde. In diesem Fall erscheinen die Seitenelement zwar beim Bearbeiten der Seite, nicht aber im Portal. Um dies zu ändern müssen die in der Datenbank hinterlegten Platzhalter an die neuen Platzhalter angepasst werden.<br /> Hierfür ist es notwendig, den Namen des veränderten Templates, den Titel des alten Platzhalters (name_element), sowie des neuen Platzhalters (name_element|element2) anzugeben. Platzhaler sind ohne Prozentzeichen anzugeben.";
$lang["plRename"]                   = "Anpassen";
$lang["plToUpdate"]                 = "Alter Platzhalter:";
$lang["plNew"]                      = "Neuer Platzhalter:";
$lang["plUpdateTrue"]               = "Das Umbenennen war erfolgreich.";
$lang["plUpdateFalse"]              = "Beim Umbenennen ist ein Fehler aufgetreten.";


// portaleditor

$lang["pe_edit"]                            = "Bearbeiten";
$lang["pe_new"]                             = "Neues Element";
$lang["pe_delete"]                          = "Löschen";
$lang["pe_shiftUp"]                         = "Nach oben";
$lang["pe_shiftDown"]                       = "Nach unten";

$lang["pe_status_page"]                     = "Seite:";
$lang["pe_status_status"]                   = "Status:";
$lang["pe_status_autor"]                    = "Letzter Autor:";
$lang["pe_status_time"]                     = "Letzte Änderung:";

$lang["pe_icon_edit"]                       = "Seite in der Administration öffnen";
$lang["pe_icon_page"]                       = "Grunddaten der Seite in der Administration bearbeiten";
$lang["pe_disable"]                         = "Den Portaleditor temporär deaktivieren";
$lang["pe_enable"]                          = "Den Portaleditor aktivieren";


$lang["systemtask_flushpagescache_name"]    = "Seitencache leeren";
$lang["systemtask_flushpagescache_done"]    = "Leeren abgeschlossen.";


// --- Quickhelp texts ----------------------------------------------------------------------------------

$lang["quickhelp_list"]             = "In dieser Ansicht können Sie durch die Seitenstruktur Ihres Systems navigieren. <br />Die Seiten können hierfür in virtuellen Ordnern gegliedert werden.<br />In der Listenansicht beim Bearbeiten der Seiteninhalte können Elemente an einem Platzhalter angelegt, bearbeitet oder gelöscht werden.";
$lang["quickhelp_listAll"]			= "In der flachen Liste werden alle Seiten, die im System angelegt wurden, angezeigt.<br />Die Ordnerstruktur wird dabei ignoriert und ausgeblendet.<br />Die Ansicht kann zum schnellen Auffinden von Seiten im System hilfreich sein.";
$lang["quickhelp_newPage"]			= "Mit Hilfe dieses Formulars können die Grunddaten einer Seite erfasst oder bearbetet werden.<br />Hierfür können die folgenden Felder erfasst werden:<br /><ul><li>Name: Der Seitenname der Seite. Über diesen wird die Seite später im Portal aufgerufen.</li><li>Browsertitel: Das Browserfenster wird im Portal mit diesem Titel versehen.</li><li>SEO-URL-Keywords: Search-Engine-Optimization, geben Sie hier passende Keywords zur Optimierung der Seite im Hinblick auf Suchmaschinen an. Die Keywords werden der URL angehängt.</li><li>Beschreibung: Eine knappe Beschreibung der Seite. Dieser Text wird u.A. in den Suchergebnissen ausgegeben.</li><li>Keywords: Die hier eingegebene, kommaseparierte Liste an Keywords wird in den Quelltext der Seite eingebettet. Auch dies ist für Suchmaschinen relevant.</li><li>Ordner: Der interne Ordner, in dem die Seite abgelegt wird.</li><li>Template: Das der Seite zu Grunde liegende Template. Das Feld kann in der Regel nur verändert werden, wenn auf der Seite keine Inhalte hinterlegt wurden.</li></ul>";
$lang["quickhelp_newFolder"]		= "Zum Anlegen oder Umbenennen eines Ordners kann hier der Name des Ordners definiert werden.";
$lang["quickhelp_editFolder"]		= "Zum Anlegen oder Umbenennen eines Ordners kann hier der Name des Ordners definiert werden.";
$lang["quickhelp_listElements"]		= "In dieser Liste befinden sich alle momentam im System verfügbaren Seitenelemente.<br />Der Name des Elements enstpricht hierbei dem hinteren Teil eines Platzhalters im Template.<br />Findet das System Installer von Elementen, die bisher noch nicht installiert sind, so werden diese am Ende der Liste zu Installation angeboten.";
$lang["quickhelp_newElement"]		= "Dieses Formular dient zum Anlegen und Bearbeiten der Grunddaten von Seitenelementen. Hierfür stehen die folgenden Eingabefelder zur Verfügung:<br /><ul><li>Name: Titel des Elements</li><li>Max. Cachedauer: Zeitdauer in Sekunden, die das Element maximal gecached werden darf.<br />Nach Ablauf dieses Zeitraums wird die Seite neu generiert.</li><li>Admin-Klasse: Klasse, die das Admin-Formular bereitstellt.</li><li>Portal-Klasse: Klasse, die die Portal-Ausgabe übernimmt.</li><li>Wiederholbar: Legt fest, ob ein Element an einem Platzhalter mehrfach angelegt werden darf.</li></ul>";
$lang["quickhelp_editElement"]		= "Dieses Formular dient zum Anlegen und Bearbeiten der Grunddaten von Seitenelementen. Hierfür stehen die folgenden Eingabefelder zur Verfügung:<br /><ul><li>Name: Titel des Elements</li><li>Max. Cachedauer: Zeitdauer in Sekunden, die das Element maximal gecached werden darf.<br />Nach Ablauf dieses Zeitraums wird die Seite neu generiert.</li><li>Admin-Klasse: Klasse, die das Admin-Formular bereitstellt.</li><li>Portal-Klasse: Klasse, die die Portal-Ausgabe übernimmt.</li><li>Wiederholbar: Legt fest, ob ein Element an einem Platzhalter mehrfach angelegt werden darf.</li></ul>";
$lang["quickhelp_flushCache"]		= "Herzlichen Glückwunsch - der Seitencache wurde soeben geleert ;-)";
$lang["quickhelp_updatePlaceholder"] = "ACHTUNG! Diese Aktion wird nur dann benötigt, wenn im Template ein Platzhalter erweitert wurde.<br />Wird im Template ein Platzhalter verändern, so werden die zugeordneten Inhalte von nun an im Portal nicht mehr ausgegeben, da im System noch der alte Platzhalter hinterlegt ist. Um die Platzhalter im System anzupassen, können diese hier ersetzt werden.";

?>