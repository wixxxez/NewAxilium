<?php 
namespace App\Service;

use App\Entity\User;
use App\Security\LoginAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;

class UserService {


    private $security;
    private $session;
    private $login;
    private $guard;
    private $request;
    public function __construct(Security $security, SessionInterface $s)
    {
        $this->security=$security;
        $this->session = $s;
   
    }
    public function getLoggedUser(){

        return $this->security->getUser();
    }
    public function LoginUser(User $user, $log,$guard, $request){
        $guard->authenticateUserAndHandleSuccess($user,$request,$log,'main');
        
    }
    public function setToken($email,$token){
        
    }
    public function setUser(User $user) {

        //return $this->guard->authenticateUserAndHandleSuccess($user,$this->request,$this->login,'main');
        
    }
}