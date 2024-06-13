<?php

define("ROOT_DIR", dirname(__FILE__));
define("PRIVATE_DIR", ROOT_DIR . "/private/");
define("PUBLIC_DIR", ROOT_DIR . "/public/");


require_once PRIVATE_DIR . 'config/config.php';

//get Utility
require_once PRIVATE_DIR . '/utility.php';


//P(age) változó vizsgálata
$P = "display";

if (filter_has_var(INPUT_GET, 'P')) {
    $P = filter_input(INPUT_GET, 'P', FILTER_SANITIZE_SPECIAL_CHARS); //FILTER_SANITIZE_STRING deprecated
} elseif (filter_has_var(INPUT_POST, 'P')) {
    $P = filter_input(INPUT_POST, 'P', FILTER_SANITIZE_SPECIAL_CHARS);
}

$file = PRIVATE_DIR . '/classes/' . $P . '/' . $P . '.php';

if (file_exists($file)) {
    include_once $file;

    $fullClassName = APP_NAMESPACE . '\\' . $P;

    if (class_exists($fullClassName)) {
        $instance = new $fullClassName();
        $content = $instance->run();
    } else {
        die("Az osztály nem található: $fullClassName");
    }
} else {
    die("A fájl nem található: $file");
}


//render page
require_once PRIVATE_DIR . 'templates/master.php';