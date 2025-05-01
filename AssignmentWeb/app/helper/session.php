<?php
class Session {
    public static function init() {
        // Check PHP version and start session if not already started
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

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
        if ($key === 'login' && $value === true) {
            // Set session expiration to 2 hours from now
            $_SESSION['expire_time'] = time() + (2 * 60 * 60);
        }
    }

    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public static function checkSession() {
        self::init();
        if (self::get("login") == false) {
            self::destroy();
            header("Location: /Shop-badminton/AssignmentWeb/public/auth/login");
            exit();
        }
        
        // Check if session has expired
        if (isset($_SESSION['expire_time']) && time() > $_SESSION['expire_time']) {
            self::destroy();
            header("Location: /Shop-badminton/AssignmentWeb/public/auth/login?expired=1");
            exit();
        }
    }

    public static function checkLogin() {
        if (self::get("login") == true) {
            header("Location: /Shop-badminton/AssignmentWeb/public/home/index");
            exit();
        }
    }

    public static function destroy() {
        session_destroy();
        header("Location: /Shop-badminton/AssignmentWeb/public/home/index");
        exit();
    }
}