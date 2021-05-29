<?php

namespace App\Controller\SystemController;

use App\Controller\PublicController\PublicController;
use App\Form\ResetType;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\ResetPassword;
use Symfony\Component\HttpFoundation\Session\Session;

class ConfirmResetController extends PublicController{
    private $res;
    public function __construct(ResetPassword $res)
    {
        $this->res = $res;
    }
    /**
     * @Route("/confirm_reset/{token}", name="conf_res")
     */
    public function index(string $token,Request $request,Session $session, UserRepositoryInterface $userRep){

        $user = $this->res->getUserFromToken($token);
        if($user!=null){
            $name = $user->getName();
            
        }
        else {
            return $this->redirectToRoute('home');
        }
        $Confform =$this->createForm(ResetType::class,$user);
        $Confform->handleRequest($request);
        if($Confform->isSubmitted() && $Confform->isValid()){
           
            $user = $userRep->updatePassword($user);
            $session->getFlashBag()->add('success',"Your password is changed!");
            return $this->redirectToRoute('home');
        }
        $Confform = $Confform->createView();
        $form = parent::getRegForm($request);
            $data  = [
                'Regform' =>$form,
                'ConfirmForm'=>$Confform
                
            ];
        return $this->render("system/reset.html.twig",$data);
    }
}