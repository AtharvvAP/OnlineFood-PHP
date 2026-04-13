<?php
/**
 * Simple File-Based Cache System
 * For improved performance
 */

class Cache {
    private static $cacheDir = __DIR__ . '/../cache/';
    
    public static function get($key) {
        if (!CACHE_ENABLED) {
            return null;
        }
        
        $filename = self::$cacheDir . md5($key) . '.cache';
        
        if (!file_exists($filename)) {
            return null;
        }
        
        $data = unserialize(file_get_contents($filename));
        
        if ($data['expires'] < time()) {
            self::delete($key);
            return null;
        }
        
        return $data['value'];
    }
    
    public static function set($key, $value, $lifetime = null) {
        if (!CACHE_ENABLED) {
            return false;
        }
        
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0755, true);
        }
        
        $lifetime = $lifetime ?? CACHE_LIFETIME;
        $filename = self::$cacheDir . md5($key) . '.cache';
        
        $data = [
            'value' => $value,
            'expires' => time() + $lifetime
        ];
        
        return file_put_contents($filename, serialize($data)) !== false;
    }
    
    public static function delete($key) {
        $filename = self::$cacheDir . md5($key) . '.cache';
        
        if (file_exists($filename)) {
            return unlink($filename);
        }
        
        return false;
    }
    
    public static function clear() {
        if (!is_dir(self::$cacheDir)) {
            return true;
        }
        
        $files = glob(self::$cacheDir . '*.cache');
        
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        
        return true;
    }
    
    public static function remember($key, $callback, $lifetime = null) {
        $value = self::get($key);
        
        if ($value !== null) {
            return $value;
        }
        
        $value = $callback();
        self::set($key, $value, $lifetime);
        
        return $value;
    }
}
