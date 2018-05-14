<?php

$coremessages = include BASE_PATH."/vendor/rnt-forest/core/messages/en.php";
$dnsmessages = include BASE_PATH."/vendor/rnt-forest/dns/messages/en.php";

$messages = [

    // examples
    "hi"      => "Hello",
    "bye"     => "Good Bye",
    "hi-name" => "Hello %name%",
    "song"    => "This song is %song%",

    // index
    "index_dashboard" => "Dashboard",
    "index_welcome" => "Welcome to the world of the DNS control panel",
    "index_pdfsummary_text" => "Product overview as PDF",
    "index_view_details" => "Show details",
    
    // Menu
    "menu_basedata" => "Basedata",
    "menu_not_found" => "No menu entries found for this login",
];

$messages = array_merge($coremessages,$dnsmessages,$messages);
