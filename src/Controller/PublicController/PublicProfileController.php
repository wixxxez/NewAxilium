<?php 

namespace App\Controller\PublicController;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PublicProfileController extends PublicController {
    /**
     * @Route("/profile/{id}",name="profile")
     * @param Request $request
     * @param int $id
     */
    public function index(int $id, Request $request ){
        $user = $this->userRepository->getOne($id);
        
            $form = parent::getRegForm($request);
            $data  = [
                'Regform' =>$form,
                'last_username'=>'',
                'error'=>'',
                'user'=>$user,
                'status'=>'true'
                
            ];
            if($form == null ){
                return $this->redirectToRoute('profile', [ 'id'=> $user->getId() ]);
            }
            return $this->render('public/profile.html.twig',$data);
        
       
    }
    
}