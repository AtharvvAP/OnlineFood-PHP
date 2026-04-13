<?php
/**
 * Modern Session Management Class
 * Secure session handling with CSRF protection
 */

class Session {
    
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
            ini_set('session.cookie_samesite', 'Strict');
            
            session_start();
            
            // Regenerate session ID periodically
            if (!isset($_SESSION['created'])) {
                $_SESSION['created'] = time();
            } else if (time() - $_SESSION['created'] > 1800) {
                session_regenerate_id(true);
                $_SESSION['created'] = time();
            }
        }
    }
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    public static function remove($key) {
        unset($_SESSION[$key]);
    }
    
    public static function destroy() {
        session_destroy();
        $_SESSION = [];
    }
    
    public static function flash($key, $value = null) {
        if ($value === null) {
            $value = self::get($key);
            self::remove($key);
            return $value;
        }
        self::set($key, $value);
    }
    
    public static function generateCSRFToken() {
        if (!self::has(CSRF_TOKEN_NAME)) {
            self::set(CSRF_TOKEN_NAME, bin2hex(random_bytes(32)));
        }
        return self::get(CSRF_TOKEN_NAME);
    }
    
    public static function validateCSRFToken($token) {
        return hash_equals(self::get(CSRF_TOKEN_NAME, ''), $token);
    }
    
    public static function isLoggedIn() {
        return self::has('user_id');
    }
    
    public static function isAdmin() {
        return self::has('adm_id');
    }
    
    public static function getUserId() {
        return self::get('user_id');
    }
    
    public static function getAdminId() {
        return self::get('adm_id');
    }
}
