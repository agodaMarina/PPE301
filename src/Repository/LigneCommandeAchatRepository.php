<?php

namespace App\Repository;

use App\Entity\LigneCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneCommandeAchat>
 *
 * @method LigneCommandeAchat|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneCommandeAchat|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneCommandeAchat[]    findAll()
 * @method LigneCommandeAchat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneCommandeAchatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneCommandeAchat::class);
    }

    public function save(LigneCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LigneCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getPrixTotal()
{
    $qb = $this->getEntityManager()->createQueryBuilder();

    $qb
        ->select('sum(a.prixArticle)')
        ->from('App\Entity\Article', 'a')
    ;

    $query = $qb->getQuery();

    return $query->getSingleScalarResult();
}

//    /**
//     * @return LigneCommandeAchat[] Returns an array of LigneCommandeAchat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LigneCommandeAchat
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
