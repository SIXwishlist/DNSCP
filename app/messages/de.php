<?php

$coremessages = include BASE_PATH."/vendor/rnt-forest/core/messages/de.php";
$dnsmessages = include BASE_PATH."/vendor/rnt-forest/dns/messages/de.php";

$messages = [

    // examples
    "hi"      => "Hallo",
    "bye"     => "Auf Wiedersehen",
    "hi-name" => "Hallo %name%",
    "song"    => "Dieser Song ist %song%",
    
    // index
    "index_dashboard" => "Dashboard",
    "index_welcome" => "Willkommen in der Welt des DNS Control Panel.",
    "index_pdfsummary_text" => "Produkteübersicht als PDF",
    "index_view_details" => "Details anzeigen",
    
    // Menu
    "menu_basedata" => "Stammdaten",
    "menu_not_found" => "Keine Menüeinträge für dieses Login gefunden",
];

$messages = array_merge($coremessages,$dnsmessages,$messages);
