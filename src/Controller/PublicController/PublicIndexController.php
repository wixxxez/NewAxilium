<?php

namespace App\Controller\PublicController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublicIndexController extends PublicController {
    /**
     * @Route("/",name="home")
     */
    public function index(Request $request){
        $form = parent::getRegForm($request);
        $data  = [
            'form' =>$form
        ];
        return $this->render('public/index.html.twig',$data);
    }
    
}