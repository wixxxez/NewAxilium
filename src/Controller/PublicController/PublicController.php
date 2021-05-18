<?php
namespace App\Controller\PublicController;

use App\Entity\User;
use App\Form\RegisterFormType;
use App\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PublicController extends AbstractController{

    protected $userRepository;
    public function __construct(UserRepositoryInterface $ui)
    {
        $this->userRepository=$ui;
    }
    /**
     * @param Request $request
     */
    public function getRegForm(Request $request){
        $user = new User;
        $form = $this->createForm(RegisterFormType::class,$user);
  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->userRepository->createNewUser($user);
           // return $this->redirectToRoute("home");
        }
        return $form->createView();
    } 
   
}