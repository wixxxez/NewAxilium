<?php
namespace App\Repository;

interface PostRepositoryInterface {
    /**
     * @return Post[]
     */
    public function getAll() : array;

    /**
     * @param int $id
     * @return Post
     */
    public function getOne(int $id):object;

    
}