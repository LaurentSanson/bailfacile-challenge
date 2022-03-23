<?php

namespace App\Repository;

use App\Entity\Document;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Document $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Document $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findDocumentsGreaterThanCreatedAt(DateTimeImmutable $createdAt): mixed
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt < :val')
            ->setParameter('val', $createdAt)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findDocumentsGreaterThanUpdateddAt(DateTimeImmutable $updatedAt): mixed
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.updatedAt < :val')
            ->setParameter('val', $updatedAt)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
}
