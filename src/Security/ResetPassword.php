<?php
namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepositoryInterface;
class ResetPassword {

    private $em;
    private $userRep;
    public function __construct(EntityManagerInterface $em, UserRepositoryInterface $uri){
        $this->em=$em;
        $this->userRep=$uri;
    }

    public function generateToken(){
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = uniqid($characters[rand(0, strlen($characters)- 1)]);
        return $randomString;
    }
    public function checkEmail($email){
        $res =  $this->em->createQuery("SELECT e FROM App\Entity\User e WHERE e.email = :email ")->setParameter("email",$email);
        $user = $res->getResult();
        if(!empty($user)){
            
            
            return $user;
        }
        else{
            return null;
        }
       
    }
    public function setUserToken(User $user,string $token){
        $user->setToken($token);
        $this->em->persist($user);
        $this->em->flush();
    }
    public function getUserFromToken(string $token){
        $result = $this->em->createQuery("SELECT u FROM App\Entity\User u WHERE u.token = :token ")->setParameter('token',$token);
        $user = $result->getResult();
        if(!empty($user)){
            return $user[0];
        }
        else {
            return null;
        }
    }
}