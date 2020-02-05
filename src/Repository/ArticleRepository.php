<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
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

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param string|null $search
     * @param Category $category
     * @return Article[] Returns an array of Article objects
     */

    public function findLikeName(?string $search = '', ?Category $category = null) // ? et ='' renvoie une valeur par defaut non null, récupère un objet category
    {
        $qb = $this->createQueryBuilder('a') // alias a pour la table article
        ->andWhere('a.title LIKE :title')
            ->setParameter('title', '%' . $search . '%'); // les % permettent de donner la recherche avec le LIKE
        if ($category) {
            $qb->andWhere('a.category = :category') //dans entity Article, relation avec category
            ->setParameter('category', $category);
        }
        $qb->orderBy('a.date', 'DESC')
            ->setMaxResults(5);

        return $qb->getQuery()->getResult();
    }
}
