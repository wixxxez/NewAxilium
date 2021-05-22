<?php 
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageServiceInterface {


    /**
     * @param UploadedFile $file
     * @return string
     */
    public function uploadFile(UploadedFile $file) :string ;


    /**
     * @param string $filename
    
     */
    public function removeFile(string $filename);
}