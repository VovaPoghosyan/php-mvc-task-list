<?php
include_once("../config/constants.php");
include_once("Controller.php");
include_once("Model.php");
include_once("Session.php");
include_once("Request.php");
include_once("Route.php");
include_once("../routes/web.php");

class App
{
    public static function run()
    {
        self::loadModels();

        // Run the router
        Route::run('/');
    }

    #auto loader Models
    public static function loadModels()
    {
        $models = glob(MODELS . "*.php");
        foreach ($models as $model) {
            include(MODELS . basename($model));
        }
    }

    public static function baseUrl($url)
    {
        return APP['SiteURL'] . $url;
    }

    # test for injection;
    public static function test_input($data)
    {
        $data = trim($data);
        $data = str_replace(" ", "", $data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
