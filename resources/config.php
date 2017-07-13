<?php

ob_start();

session_start();
//DIRECTORY_SEPARATOR separates the directories within the path. Use it because:

// In different OS there is different directory separator. In Windows it's \ in Linux it's /. DIRECTORY_SEPARATOR is constant with that OS directory separator. Use it every time in paths.

defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR); // DIRECTORY_SEPARATOR = / OR \

//echo __DIR__;//The directory of the file.


defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT" , __DIR__ . DS . 'templates\front');

defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates\back"); 

//echo TEMPLATE_FRONT;

defined('DB_HOST') ? null : define('DB_HOST' , 'localhost');

defined('DB_USER') ? null : define('DB_USER' , 'root');


defined('DB_PASS') ? null : define('DB_PASS' , '');

defined('DB_NAME') ? null : define('DB_NAME' , 'ecom_db');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

require_once ("functions.php");//require is identical to include except upon failure it will also produce a fatal E_COMPILE_ERROR level error. In other words, it will halt the script whereas include only emits a warning (E_WARNING) which allows the script to continue.
?>

