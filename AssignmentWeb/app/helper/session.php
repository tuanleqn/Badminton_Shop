<?php
class Session {
    private static $instance = null;
    private $flash = [];

    private function __construct() {
        if (version_compare(phpversion(), '5.4.0', '>=')) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        } else {
            if (session_id() === '') {
                session_start();
            }
        }
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserialize
    public function __wakeup() {}

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
        if ($key === 'login' && $value === true) {
            $_SESSION['expire_time'] = time() + (9 * 60 * 60);
        }
    }

    public function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function checkSession() {
        if ($this->get("login") == false) {
            $this->destroy();
            header("Location: /Shop-badminton/AssignmentWeb/public/auth/login");
            exit();
        }
        
        if (isset($_SESSION['expire_time']) && time() > $_SESSION['expire_time']) {
            $this->destroy();
            header("Location: /Shop-badminton/AssignmentWeb/public/auth/login?expired=1");
            exit();
        }
    }

    public function checkLogin() {
        if ($this->get("login") == true) {
            header("Location: /Shop-badminton/AssignmentWeb/public/home/index");
            exit();
        }
    }

    public function destroy() {
        session_destroy();
        header("Location: /Shop-badminton/AssignmentWeb/public/home/index");
        exit();
    }

    public function setFlash($key, $message) {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][$key] = $message;
    }

    public function hasFlash($key) {
        return isset($_SESSION['flash'][$key]);
    }

    public function getFlash($key) {
        if (isset($_SESSION['flash'][$key])) {
            $message = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        return null;
    }
}