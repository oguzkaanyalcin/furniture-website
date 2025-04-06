<?php
class Session {
    public function __construct() {
        session_start();
    }

    public function __get($name) {
        if(isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    public function __set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function __isset($name) {
        return isset($_SESSION[$name]);
    }

    public function __unset($name) {
        unset($_SESSION[$name]);
    }
}

$session = new Session();
?>