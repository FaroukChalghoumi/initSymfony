<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function add(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function searchByname($name) : array {
        return $this->createQueryBuilder('s')
            ->where('s.name LIKE :name')
            ->setParameter('name',$name)
            ->getQuery()
            ->getResult();
    }

    public function searchByClassroom($id) : array {
        return $this->createQueryBuilder('p')
            ->join('p.classroom','c')
            ->where('c.email = :email')
            ->setParameter('email',$id)
            ->getQuery()
            ->getResult();
    }

    public function searchEnabled() : array {
        return $this->createQueryBuilder('p')
            ->where('p.enabled = 1')
            ->getQuery()
            ->getResult();
    }

    public function findStudentByMaxMin($min,$max)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.moyene >= :min and p.moyene <= :max')
            ->setParameters(['min'=>$min,'max'=>$max])
            // ->orderBy('p.label','ASC')
//            ->setParameter('min', $min)
//            ->setParameter('max', $max)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findDatetByMaxMin($min,$max)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.creation_date >= :min and p.creation_date <= :max')
            ->setParameters(['min'=>$min,'max'=>$max])
            // ->orderBy('p.label','ASC')
//            ->setParameter('min', $min)
//            ->setParameter('max', $max)
            ->getQuery()
            ->getResult()
            ;
    }



    public function sorted_student()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.name','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Student[] Returns an array of Student objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
