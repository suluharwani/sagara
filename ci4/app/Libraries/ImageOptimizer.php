<?php

namespace App\Libraries;

use CodeIgniter\Images\Handlers\GDHandler;
use Config\Services;

class ImageOptimizer
{
    protected $image;
    
    public function __construct()
    {
        $this->image = Services::image();
    }

    public function resize(string $path, int $width, int $height): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        try {
            $this->image->withFile($path)
                       ->resize($width, $height, true, 'height')
                       ->save($path);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Image resize failed: ' . $e->getMessage());
            return false;
        }
    }

    public function compress(string $path, int $quality = 80): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        try {
            $this->image->withFile($path)
                       ->withResource()
                       ->save($path, $quality);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Image compress failed: ' . $e->getMessage());
            return false;
        }
    }

    public function createThumbnail(string $path, int $size = 300): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        try {
            $thumbPath = dirname($path) . '/thumb_' . basename($path);
            $this->image->withFile($path)
                       ->resize($size, $size, true, 'height')
                       ->save($thumbPath);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Thumbnail creation failed: ' . $e->getMessage());
            return false;
        }
    }

    public function autoOptimize(string $path, int $maxWidth = 1200, int $quality = 80): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        try {
            $this->image->withFile($path)
                       ->resize($maxWidth, $maxWidth, true, 'width')
                       ->withResource()
                       ->save($path, $quality);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Auto optimize failed: ' . $e->getMessage());
            return false;
        }
    }

    public static function deleteOldFile(string $path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}