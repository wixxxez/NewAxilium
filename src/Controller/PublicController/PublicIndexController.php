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
    public function index(Request $request, $Reload = null ){
        $imPost = $this->PostRepository->getImmediantlyPost();
        try {
            $form = parent::getRegForm($request);
            $data  = [
                'Regform' =>$form,
                'last_username'=>'',
                'error'=>'',
                'Reload' => $Reload,
                'postIm'=>$imPost
            ];
            if($form == null ){
                return $this->redirectToRoute('home');
            }
            return $this->render('public/index.html.twig',$data);
        }catch(\TypeError $e){
            return $this->redirectToRoute('home');
        };
       
    }
    
}