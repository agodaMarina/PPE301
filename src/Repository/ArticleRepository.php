<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

  public function findOneByIdJoinedToSupplier(int $productId): ?Article
{
    $entityManager = $this->getEntityManager();

    $query = $entityManager->createQuery(
        'SELECT f.nomFournisseur
        FROM App\Entity\Article a
        INNER JOIN a.fournisseurs f
        WHERE a.id = :id'
    )->setParameter('id', $productId);

    return $query->getOneOrNullResult();
}

public function getNombre()
{
    $qb = $this->getEntityManager()->createQueryBuilder();

    $qb
        ->select('count(a.id)')
        ->from('App\Entity\Article', 'a')
    ;

    $query = $qb->getQuery();

    return $query->getSingleScalarResult();
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

public function getPrixEleve()
{
    $qb = $this->getEntityManager()->createQueryBuilder();

    $qb
        ->select('a')
        ->from('App\Entity\Article', 'a')
        ->where('a.prixArticle>2000')
    ;

    $query = $qb->getQuery();

    return $query->getResult();
}

}