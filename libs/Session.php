<?php
 
class Session
{
    public static function init() {
		SessionManager::sessionStart('Operation_Braveheart', 0, '/', 'localhost', true);
		//session_start();
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        else
            return MY_SESSION_NOT_SET;
    }

    public static function destroy() {
        unset($_SESSION);
        session_destroy();
    }
}