<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * method to create student in db
     *
     * @param string $username
     *
     * @return Student
     */
    public function createStudent(string $username): Student
    {
        $studentObj = new  Student();
        $studentObj->setName($username)
            ->setCreatedAt(new \DateTime());
        $this->getEntityManager()->persist($studentObj);
        $this->getEntityManager()->flush();
        return $studentObj;
    }
}
