<?php 
namespace App\Service;



class PostService {

    /**
     * @return array[]
     */
    public function getAmount($post) :array {
        $procent = ($post->getProgress()/ $post->getGoalSumm())*100;
        $subProcent = substr($procent,0,4);
        return [
            'procent'=>$procent,
            'subProcent'=>$subProcent
        ];
    }
}