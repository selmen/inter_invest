<?php

namespace App\Repository;

use App\Entity\Logs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Logs>
 *
 * @method Logs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logs[]    findAll()
 * @method Logs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logs::class);
    }

    public function save(Logs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Logs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**     
     *
     * @param string|null $className
     * @param integer|null $id
     * @return void
     */
    public function findLogsByNameEntityAndId(?string $className, ?int $id)
    {
        $qb = $this->createQueryBuilder('l');
        $expr = $qb->expr();
        return
            $qb                
                ->where(
                    $expr->eq('l.nameEntity', ':className')                    
                )
                ->andWhere(                    
                    $expr->eq('l.createById', ':idObject') 
                )
                ->setParameters([
                    'className' => $className,
                    'idObject' => $id
                ])                               
                ->getQuery()->getResult();
    }
}
