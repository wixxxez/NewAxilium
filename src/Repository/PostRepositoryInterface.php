<?php
namespace App\Repository;

use App\Entity\Post;

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

    /**
     * @return array
     */
    public function getImmediantlyPost():array;
    
    /**
     * @param int $id
     * @return Post[]
     */
    public function getAllUserPosts(int $id):array;
}