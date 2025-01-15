<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;


class MessageRepository extends ServiceEntityRepository implements MessageRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $manager)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * @param int $offset
     * @param int $pageSize
     * @return Paginator
     */
    public function getMessagePaginator(int $offset, int $pageSize): Paginator
    {
        $query = $this->createQueryBuilder('m')
            ->setMaxResults($pageSize)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    /**
     * @param Message $message
     * @return void
     */
    public function save(Message $message): void
    {
        $this->manager->persist($message);
        $this->manager->flush();
    }
}
