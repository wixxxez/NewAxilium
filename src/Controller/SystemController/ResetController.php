<?php
namespace App\Controller\SystemController; 

use App\Controller\PublicController\PublicController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\ResetPassword;
use Symfony\Component\HttpFoundation\Session\Session;

class ResetController extends PublicController {

    /**
     * @Route("/reset/{email}", name="reset_usr")
     */
    public function index(ResetPassword $res,string $email, Session $session){

        $newToken = $res->generateToken();
        $user = $res->checkEmail($email);
        if($user!=[]){
            $res->setUserToken($user[0],$newToken);
            $session->getFlashBag()->add('success',"Check your e-mail");
        }
        else {
            $session->getFlashBag()->add('danger',"Wrong e-mail");
        }
        $this->addFlash('succes',"Check your email!");
       
  
        return $this->redirectToRoute('home');
    }
}