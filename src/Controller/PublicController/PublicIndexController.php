<?php

namespace App\Controller\PublicController;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PublicIndexController extends PublicController {
    /**
     * @Route("/",name="home")
     */
    public function index(Request $request){
        try {
            $form = parent::getRegForm($request);
            $data  = [
                'Regform' =>$form,
                'last_username'=>'',
                'error'=>''
            ];
        
                $logForm = parent::getLogForm($this->ai);
                $data['last_username']=$logForm['last_username'];
                $data['error']=$logForm['error'];
                
           
           
            //var_dump($data['error']);
            return $this->render('public/index.html.twig',$data);
        }catch(\TypeError $e){
            return $this->redirectToRoute('home');
        };
       
    }
    
}