<?php
namespace App\Controller\PublicController;

use App\Entity\User;
use App\Form\RegisterFormType;
use App\Repository\PostRepositoryInterface;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;
use App\Security\LoginAuthenticator;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PublicController extends AbstractController{

    protected $userRepository;
    protected $ai;
    protected $log;
    protected $guard;
 
    protected $us;
    protected $PostRepository;
    
    public function __construct(PostRepositoryInterface $pri,UserRepository $ui,AuthenticationUtils $ai, UserService $us,LoginAuthenticator $login, GuardAuthenticatorHandler $guard)
    {
        $this->userRepository=$ui;
        
        $this->ai=$ai;
        $this->us=$us;
        $this->PostRepository = $pri;
        $this->log = $login ;
        $this->guard=$guard;
    }
    public function rendert(){
        return $this->redirectToRoute('home');
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
            $this->us->LoginUser($user,$this->log,$this->guard,$request);
            return null;
        }
        return $form->createView();
    } 
   
}