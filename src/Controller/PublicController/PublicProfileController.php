<?php 

namespace App\Controller\PublicController;

use App\Form\ImageFormType;
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
        $status = 'false';
        $imgForm = null;
        if($this->getUser()->getId() == $user->getId() ){
            $status = "true";
            $ImageForm = $this->createForm(ImageFormType::class,$user);
            $ImageForm->handleRequest($request);
            if($ImageForm->isSubmitted() && $ImageForm->isValid()){
                $image = $ImageForm->get('profile_photo')->getData();
                $this->userRepository->updateImage($user,$image);
                return $this->redirectToRoute('profile', [ 'id'=> $user->getId() ]);
            }
            $imgForm =  $ImageForm->createView();
            
        }
        
            $form = parent::getRegForm($request);
            $data  = [
                'Regform' =>$form,
                'last_username'=>'',
                'error'=>'',
                'user'=>$user,
                'status'=>$status,
                'ImageForm' =>   $imgForm
                
            ];
            if($form == null ){
                return $this->redirectToRoute('profile', [ 'id'=> $user->getId() ]);
            }
            return $this->render('public/profile.html.twig',$data);
        
       
    }
    
}