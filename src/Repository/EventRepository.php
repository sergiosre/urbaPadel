<?php

namespace App\Repository;

use App\Entity\Event;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getEvents($today)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.date > :today')
            ->setParameter('today', $today);

        $query = $qb->getQuery();

        return $query->execute();
    }

    public function checkIfPlayerIsInEvent(int $eventId, int $userId)
    {
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.id = :eventId')
            ->andWhere('e.player_1 = :userId')
            ->orWhere('e.player_2 = :userId')
            ->orWhere('e.player_3 = :userId')
            ->orWhere('e.player_4 = :userId')
            ->setParameter('userId', $userId)
            ->setParameter('eventId', $eventId);

        $query = $qb->getQuery();

        return $query->execute();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
