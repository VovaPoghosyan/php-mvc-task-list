<?php

class Controller
{
    protected $layout = "main";
    public static $name;

    public function redirect($url)
    {
        $url_string = APP['SiteURL'] . $url;
        header("Location:$url_string");
        exit();
    }

    public function checkErrorTime()
    {
        $messageTime = Session::get("message_time");
        if($messageTime && $messageTime + 1 < time()) {
            Session::set("error_messages", []);
        }
    }

    public function render($view, $params = array())
    {
        $view = trim($view);
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        $view_parts = explode("/", $view);
        if (!empty($view_parts[0]) && count($view_parts) > 1) {
            if (file_exists(VIEWS . $view . ".php")) {
                ob_start();
                include(VIEWS . $view . ".php");
                $content = ob_get_clean();
                include(LAYOUT . $this->layout . ".php");
            } else {
                try {
                    throw new Exception(VIEWS . $view . ".php file is not found", 404);
                } catch (Exception $e) {
                    echo "Message: " . $e->getMessage();
                }
            }
        } else {
            if (file_exists(VIEWS . self::$name . "/" . $view . ".php")) {
                ob_start();
                include(VIEWS . self::$name . "/" . $view . ".php");
                $content = ob_get_clean();
                include(LAYOUT . $this->layout . ".php");
            } else {
                try {
                    throw new Exception(VIEWS . self::$name . $view . ".php file is not found", 404);
                } catch (Exception $e) {
                    echo "Message: " . $e->getMessage();
                }
            }
        }
    }
}
