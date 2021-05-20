<?php
namespace App\Controller\PublicController;

use App\Entity\User;
use App\Form\RegisterFormType;
use App\Repository\UserRepositoryInterface;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PublicController extends AbstractController{

    protected $userRepository;
    protected $ai;
    protected $us;
    public function __construct(UserRepositoryInterface $ui,AuthenticationUtils $ai, UserService $us)
    {
        $this->userRepository=$ui;
        $this->ai=$ai;
        $this->us=$us;
    }
    public function rendert(){
        return $this->redirectToRoute('home');
    }
    
    public function getLogForm(AuthenticationUtils $authenticationUtils){
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return [
            "last_username" => $lastUsername,
            'error'=>$error
        ];
    }
    /**
     * 
     * @param Request $request
     */
    public function getRegForm(Request $request){
        $user = new User;
        $form = $this->createForm(RegisterFormType::class,$user);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->userRepository->createNewUser($user);
            return null;
        }
        return $form->createView();
    } 
   
}