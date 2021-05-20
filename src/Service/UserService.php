<?php 
namespace App\Service;

use Symfony\Component\Security\Core\Security;

class UserService {

    private $security;
    public function __construct(Security $security)
    {
        $this->security=$security;
    }
    public function getLoggedUser(){

        return $this->security->getUser();
    }
}