<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * Task object constructor
     *
     * @param ManagerRegistry $registry param
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);

    }

    /**
     * Save the Task object to the database
     *
     * @param Task    $entity param
     * @param boolean $flush  param
     *
     * @return void
     */
    public function save(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }

    }

    /**
     * Delete the Task object from the database
     *
     * @param Task    $entity param
     * @param boolean $flush  param
     *
     * @return void
     */
    public function remove(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }

    }


}
