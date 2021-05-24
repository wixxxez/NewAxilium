<?php 

namespace App\Controller\PublicController;

use App\Form\EditProfileType;
use App\Form\ImageFormType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use PDOException;
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
        $EditForm = null;
        $error = null;
        $userPosts = $this->PostRepository->getAllUserPosts($id);
        if($this->getUser()->getId() == $user->getId() ){
            $status = "true";

            $ImageForm = $this->createForm(ImageFormType::class,$user);
            $ImageForm->handleRequest($request);

            
            try{
                $EditProfileForm=$this->createForm(EditProfileType::class,$user);
                $EditProfileForm->handleRequest($request);
                if($EditProfileForm->isSubmitted() && $EditProfileForm->isValid()){
                    $this->userRepository->updateUser($user);
                    return $this->redirectToRoute('profile', [ 'id'=> $user->getId() ]);
                 }
                 
            }catch(Exception $exec){
                $error['email'] = 'This e-mail is already used ';
            }
           
            $EditForm = $EditProfileForm->createView();
            if($ImageForm->isSubmitted() && $ImageForm->isValid()){
                $image = $ImageForm->get('profile_photo')->getData();
                $this->userRepository->updateImage($user,$image);
                return $this->redirectToRoute('profile', [ 'id'=> $user->getId() ]);
            }
            $imgForm =  $ImageForm->createView();
           
            
        }
        if($this->getUser()->getId() != $user->getId()) {
            $user = $this->userRepository->setViews($user);
        }
        
            $form = parent::getRegForm($request);
            $data  = [
                'Regform' =>$form,
                'last_username'=>'',
                'error'=>$error,
                'user'=>$user,
                'status'=>$status,
                'ImageForm' =>   $imgForm,
                'EditForm' => $EditForm,
                'posts'=>$userPosts
                
                
            ];
            if($form == null ){
                return $this->redirectToRoute('profile', [ 'id'=> $user->getId() ]);
            }
            return $this->render('public/profile.html.twig',$data);
        
       
    }
    
}