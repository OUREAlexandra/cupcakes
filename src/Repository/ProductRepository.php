<?php

namespace App\Repository;

use App\Entity\Product;
use App\Data\SearchProductData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    /**
     * @return PaginationInterface
     */
    public function searchProduct(SearchProductData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('product')
            ->from($this->_entityName, 'p')
            ->innerJoin('product.category', 'category');

        if (!empty($search->category)) {
            $query = $query
                ->andWhere('category.id IN (:category)')
                ->setParameter('category', $search->category);
        }

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('product.name LIKE :q 
                OR product.description LIKE :q
                OR category.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        $query = $query->getQuery()->getResult();
        return $this->paginator->paginate(
            $query,
            1,
            12
        );
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
