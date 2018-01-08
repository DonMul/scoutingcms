<?php

namespace Lib\Core;

/**
 * Class Uploader
 * @package Lib\Core
 */
final class Imager
{
    /**
     * @param string $tmpName
     * @param string $destination
     */
    public function uploadImage($tmpName, $destination)
    {
        $this->ensureDestinationPath($destination);
        move_uploaded_file($tmpName, $destination);

        $this->uploadToCdn($destination);
    }

    /**
     * @param string $destination
     */
    private function uploadToCdn($destination)
    {
        $cdnData = Settings::getInstance()->get('cdn');
        if (\Lib\Core\Util::arrayGet($cdnData, 'enabled', false) !== true) {
            return;
        }

        $ftp = new \Lib\Ftp\Client(
            $cdnData['host'],
            $cdnData['username'],
            $cdnData['password']
        );

        $ftp->upload(realpath($destination), str_replace('/subdomains/scoutingflg/public/upload/', '', realpath($destination)));
    }

    /**
     * @param string $destination
     */
    private function ensureDestinationPath($destination)
    {
        $exploded = explode(DIRECTORY_SEPARATOR, $destination);
        array_pop($exploded);
        $path = '';
        foreach ($exploded as $part) {
            $path .= DIRECTORY_SEPARATOR . $part;
            if (!file_exists($path)) {
                mkdir($path);
            }
        }
    }

    /**
     * @param string $location
     * @param int $maxWidth
     * @param int $maxHeight
     * @return bool
     */
    public function resizeImage($location, $maxWidth, $maxHeight)
    {
        if (!function_exists('getimagesize')) {
            return false;
        }

        $fileType = $this->getFileType($location);
        $newLocation = realpath($location);
        list($width, $height) = getimagesize($location);
        if ($fileType == 'png') {
            $location = imagecreatefrompng($newLocation);
        } elseif ($fileType == 'jpg' || $fileType == 'jpeg') {
            $location = imagecreatefromjpeg($newLocation);
        } else {
            return false;
        }

        if ($maxWidth >= $width && $maxHeight >= $height) {
            $ratio = 1;
        } elseif ($width > $height) {
            $ratio = $maxWidth / $width;
        } else {
            $ratio = $maxHeight / $height;
        }

        $newWidth = round($width * $ratio);
        $newHeight = round($height * $ratio);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $location, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        if ($fileType == 'png') {
            return imagepng($newImage, $newLocation);
        } elseif ($fileType == 'jpg' || $fileType == 'jpeg') {
            return imagejpeg($newImage, $newLocation);
        }

        return false;
    }

    /**
     * @param string $location
     * @return string
     */
    private function getFileType($location)
    {
        $exploded = explode('.', $location);
        $lastPart = array_pop($exploded);
        return strtolower($lastPart);
    }
}