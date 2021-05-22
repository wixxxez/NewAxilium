<?php
namespace App\Controller\PublicController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublicPostController extends PublicController  {

    /**
     * @Route("/post", name="post")
     */
    public function index(Request $request){
        try {
            $form = parent::getRegForm($request);
            $data  = [
                'Regform' =>$form,
                'last_username'=>'',
                'error'=>'',
               
            ];
            if($form == null ){
                return $this->redirectToRoute('home');
            }
            return $this->render('public/post.html.twig',$data);
        }catch(\TypeError $e){
            return $this->redirectToRoute('home');
        };
        return $this->render("/public/post.html.twig");
    }
}