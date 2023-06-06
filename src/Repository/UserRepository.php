<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * User object constructor
     *
     * @param ManagerRegistry $registry param
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);

    }

    /**
     * Save the User object to the database
     *
     * @param User    $entity param
     * @param boolean $flush  param
     *
     * @return void
     */
    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }

    }


    /**
     * Delete the User object from the database
     *
     * @param User    $entity param
     * @param boolean $flush  param
     *
     * @return void
     */
    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }

    }


}
