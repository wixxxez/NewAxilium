<?php 

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService implements ImageServiceInterface {
    private $imageDirectory;

    public function __construct($imageDirectory)
    {
        $this->imageDirectory=$imageDirectory;
    }
    /**
     * @return mixed
     */
    public function getDirectory(){
        return $this->imageDirectory;
    }
    /**
     * @param UploadedFile $file
     * @return string
     */
    public function uploadFile(UploadedFile $file): string
    {   
        $fileName = 'uploads/profile/'.uniqid().'.'.$file->guessExtension();
        try {
            $file->move($this->getDirectory(),$fileName);
        }catch(FileException $execption){
            return $execption;
        }
        return $fileName;
    }
    /**
     * @param string $filename
     */
    public function removeFile(string $filename)
    {
        $fs = new Filesystem();
       
        $fs->remove($filename);

        
    }
}