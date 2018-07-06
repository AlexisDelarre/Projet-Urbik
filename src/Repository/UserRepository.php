<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.name = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOrder()
    {

        return $this->createQueryBuilder('c')->orderBy('c.country', 'ASC')->getQuery()->getResult();

    }

    public function findCountry()
    {
        return $this->createQueryBuilder('c')->select('c.country')->distinct()->orderBy('c.country', 'ASC')->getQuery()->getResult();
    }

    public function findAdmin()
    {
        return $this->createQueryBuilder('c')->select('c.email')->where("c.admin = 1")->getQuery()->getResult();

    }


}