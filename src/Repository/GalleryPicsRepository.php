<?php

namespace App\Repository;

use App\Entity\GalleryPics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GalleryPics>
 *
 * @method GalleryPics|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryPics|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryPics[]    findAll()
 * @method GalleryPics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryPicsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalleryPics::class);
    }

    public function findTwoPerCategory(): array
    {
        $categories = ["Bouquet", "Composition", "Mariage", "Hommage"];
        
        $qb = $this->createQueryBuilder('gp');

        $results = [];
        foreach ($categories as $category) {
            $results = array_merge(
                $results,
                $qb->andWhere('gp.category = :category')
                    ->setParameter('category', $category)
                    ->setMaxResults(2)
                    ->getQuery()
                    ->getResult()
            );
        }

        return $results;
    }

//    /**
//     * @return GalleryPics[] Returns an array of GalleryPics objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GalleryPics
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
