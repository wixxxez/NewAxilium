<?php 

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CommentService {

    public function getFileName(int $id){
        return "patients/comments/".$id."idcom.json";
    }
    public function getFile(int $id){
        $filename = "patients/comments/".$id.'idcom.json';
        if(file_exists($filename)){
            $string = file_get_contents($filename);
            return json_decode($string,true);
        }
        else{
            $string = $this->createFile($id);
            return json_decode($string,true);
        }
        
    }
    public function createFile(int $id){
        $filename = fopen("patients/comments/".$id."idcom.json",'a+');
        fwrite($filename,'[]');
        fclose($filename);
        return "patients/comments/".$id."idcom.json";
    }
    public function addComment(User $user,$filename,$text){
        $data = json_decode(file_get_contents($filename),true);
        $newData = [
            'time'=>date("F d, Y  H:i"),
            'text'=>$text,
            'id'=>$user->getId(),
            'nickname'=>$user->getName(),
            'userImage'=>$user->getPhoto()
        ];
        $data[]=$newData;
        $newjson = json_encode($data);
        if(file_put_contents($filename,$newjson)){
            return json_decode($newjson,true);
        }
        else {
            return "Not valid comment";
        }
    }
}