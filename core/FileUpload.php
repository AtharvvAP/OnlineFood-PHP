<?php
/**
 * Secure File Upload Handler
 * With validation and sanitization
 */

class FileUpload {
    private $file;
    private $errors = [];
    private $uploadPath;
    
    public function __construct($file, $uploadPath = null) {
        $this->file = $file;
        $this->uploadPath = $uploadPath ?? UPLOAD_PATH;
    }
    
    public function validate() {
        // Check if file was uploaded
        if (!isset($this->file['tmp_name']) || empty($this->file['tmp_name'])) {
            $this->errors[] = "No file uploaded";
            return false;
        }
        
        // Check for upload errors
        if ($this->file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = $this->getUploadErrorMessage($this->file['error']);
            return false;
        }
        
        // Check file size
        if ($this->file['size'] > UPLOAD_MAX_SIZE) {
            $this->errors[] = "File size exceeds maximum allowed size";
            return false;
        }
        
        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $this->file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
            $this->errors[] = "Invalid file type. Only images are allowed";
            return false;
        }
        
        // Check if it's a real image
        if (!getimagesize($this->file['tmp_name'])) {
            $this->errors[] = "File is not a valid image";
            return false;
        }
        
        return true;
    }
    
    public function upload($newName = null) {
        if (!$this->validate()) {
            return false;
        }
        
        // Create upload directory if it doesn't exist
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
        $filename = $newName ?? uniqid('img_', true) . '.' . $extension;
        $destination = $this->uploadPath . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($this->file['tmp_name'], $destination)) {
            // Set proper permissions
            chmod($destination, 0644);
            return $filename;
        }
        
        $this->errors[] = "Failed to move uploaded file";
        return false;
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    private function getUploadErrorMessage($errorCode) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
        ];
        
        return $errors[$errorCode] ?? 'Unknown upload error';
    }
    
    public static function delete($filename, $path = null) {
        $path = $path ?? UPLOAD_PATH;
        $filepath = $path . $filename;
        
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        
        return false;
    }
}
