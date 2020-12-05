<?php
include_once ("../config/constants.php");
include_once ("Controller.php");
include_once ("Model.php");
include_once ("Session.php");
include_once ("Request.php");

class App
{

    public static function run()
    {
        self::loadModels();
        
    }

    #auto loader Models
    public static function loadModels()
    {
        $models = glob(MODELS . "*.php");
        foreach ($models as $model) {
            include(MODELS . basename($model));
        }
    }
}