<?php
class URL {
    public static function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $baseFolder = '/Shop-badminton/AssignmentWeb';
        return $protocol . $host . $baseFolder;
    }

    public static function asset($path) {
        return self::getBaseUrl() . '/assets/' . ltrim($path, '/');
    }

    public static function to($path = '') {
        return self::getBaseUrl() . '/' . trim($path, '/');
    }
}