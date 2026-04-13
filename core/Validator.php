<?php
/**
 * Input Validation Class
 * Comprehensive validation with security focus
 */

class Validator {
    private $errors = [];
    private $data = [];
    
    public function __construct($data) {
        $this->data = $data;
    }
    
    public function required($field, $message = null) {
        if (empty($this->data[$field])) {
            $this->errors[$field][] = $message ?? ucfirst($field) . " is required";
        }
        return $this;
    }
    
    public function email($field, $message = null) {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = $message ?? "Invalid email format";
        }
        return $this;
    }
    
    public function min($field, $length, $message = null) {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field][] = $message ?? ucfirst($field) . " must be at least {$length} characters";
        }
        return $this;
    }
    
    public function max($field, $length, $message = null) {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->errors[$field][] = $message ?? ucfirst($field) . " must not exceed {$length} characters";
        }
        return $this;
    }
    
    public function numeric($field, $message = null) {
        if (!empty($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field][] = $message ?? ucfirst($field) . " must be numeric";
        }
        return $this;
    }
    
    public function match($field, $matchField, $message = null) {
        if ($this->data[$field] !== $this->data[$matchField]) {
            $this->errors[$field][] = $message ?? ucfirst($field) . " must match " . ucfirst($matchField);
        }
        return $this;
    }
    
    public function unique($field, $table, $column, $message = null) {
        $db = Database::getInstance();
        $result = $db->query("SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?", [$this->data[$field]])->fetch();
        
        if ($result['count'] > 0) {
            $this->errors[$field][] = $message ?? ucfirst($field) . " already exists";
        }
        return $this;
    }
    
    public function sanitize($field) {
        if (isset($this->data[$field])) {
            $this->data[$field] = htmlspecialchars(strip_tags(trim($this->data[$field])), ENT_QUOTES, 'UTF-8');
        }
        return $this;
    }
    
    public function isValid() {
        return empty($this->errors);
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function getFirstError() {
        foreach ($this->errors as $fieldErrors) {
            return $fieldErrors[0];
        }
        return null;
    }
    
    public function getData() {
        return $this->data;
    }
}
