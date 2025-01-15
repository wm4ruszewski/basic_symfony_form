<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface MessageRepositoryInterface
{
    /**
     * @param int $offset
     * @param int $pageSize
     * @return Paginator
     */
    public function getMessagePaginator(int $offset, int $pageSize): Paginator;

    /**
     * @param Message $message
     * @return void
     */
    public function save(Message $message): void;
}
