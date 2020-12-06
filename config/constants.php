<?php
//Default Directory
define("BASE_URL", dirname(__DIR__));
define("CONTROLLERS", BASE_URL."/Controllers/");
define("VENDOR", BASE_URL."/vendor/");
define("MODELS", BASE_URL."/Models/");
define("CONFIG", BASE_URL."/config/");
define("VIEWS",BASE_URL."/Views/");
define("LAYOUT",VIEWS."/layout/");

//Default Controller
define("DEFAULT_CONTROLLER","index");
define("DEFAULT_ACTION","index");

//APP Config
define("APP", parse_ini_file(CONFIG."app.ini"));