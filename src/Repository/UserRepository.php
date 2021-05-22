<?php

namespace App\Repository;

use App\Entity\User;
use App\Service\ImageServiceInterface;
use App\Service\UserService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Query\Lexer;
use PhpParser\Node\Expr\Cast\Double;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserRepositoryInterface
{
    private $em;
    private $psw;
    private $userServ;
    private $img;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em,ImageServiceInterface $img, UserPasswordEncoderInterface $psw,UserService $userServ)
    {
        $this->em = $em;
        $this->psw=$psw;
        $this->userServ = $userServ;
        $this->img = $img;
        parent::__construct($registry, User::class);

    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function getOne(int $id):object {
        return parent::find($id);
    }
    public function getAll():array {

        return parent::findAll();
    }
    public function updateImage(User $user,$file){
        if($file){
            $newFile = $this->img->uploadFile($file);
            $oldPhoto = $user->getPhoto();
            if($oldPhoto != 'icons/img/profile.png') {
                $this->img->removeFile($oldPhoto);
            }
            $user->setPhoto($newFile);
            $this->em->persist($user);
            $this->em->flush();
        }
        
    }
    public function setViews(User $user){
        $query = $this->em->createQuery(
            "UPDATE App\Entity\User u SET u.views = :views WHERE u.id = :id"
        )->setParameter('views',$user->getViews()+floatval(0.5))->setParameter('id',$user->getId());
        $query->getResult();
        return $user;
    }
    public function createNewUser(User $user): object
    {
        $password = $this->psw -> encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $this->em->persist($user);
        $this->em->flush();
        
        return $user;
    }
    /**
     * @param User $user
     * @return User
     */
    public function updateUser(User $user): object
    {
        if($user->getPlainPassword()){
            $password = $this->psw->encodePassword($user,$user->getPlainPassword());
            $user->setPassword($password);
        }
    
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }
    
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
