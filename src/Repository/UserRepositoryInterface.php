<?php
namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface {

    /**
     * @param int $id
     * @return User
     */
    public function getOne(int $id):object;

    /**
     * @return User[]
     */
    public function getAll():array;
    /**
     * @param User $user
     * @return user
     */
    public function createNewUser(User $user):object;
}