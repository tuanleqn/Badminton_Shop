<?php
class URL {
    public static function getBaseURL() {
        return 'http://localhost/Shop-badminton/AssignmentWeb/public';
    }

    public static function to($path = '') {
        return self::getBaseURL() . '/' . trim($path, '/');
    }
} 