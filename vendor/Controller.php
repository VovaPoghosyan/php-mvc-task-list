<?php

class Controller
{
    protected $layout = "main";
    public static $name;

    protected $isAdmin = false;

    public function __construct()
    {
        if ($id = Session::get('userId')) {
            $user = new User();
            $currentUser = $user->get(false, ["role"])->simple(["id" => $id])->query();
            $isAdmin = isset($currentUser[0]) && $currentUser[0]['role'] === 'admin' ? true : false;
        } else {
            $isAdmin = false;
        }
        $this->isAdmin = $isAdmin;
    }

    public function checkAdmin()
    {
        if(!$this->isAdmin) {
            $this->redirect("tasks"); 
        }
    }

    public function redirect($url)
    {
        $url_string = APP['SiteURL'] . $url;
        header("Location:$url_string");
        exit();
    }

    public function checkSessionTime($key = "message", $type = "error")
    {
        $sessionTime = Session::get($key . "_time");
        if($sessionTime && $sessionTime + 1 < time()) {
            Session::set($type . "_" . $key, []);
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
