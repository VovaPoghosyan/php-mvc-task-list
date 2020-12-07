<?php

class Session
{
    public static function set($key, $value)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function destroy()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        session_destroy();
    }
}
