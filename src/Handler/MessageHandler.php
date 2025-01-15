<?php

namespace App\Handler;

use App\Entity\Message;
use App\Repository\MessageRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'async')]
class MessageHandler
{
    public function __construct(private MessageRepositoryInterface $messageRepository)
    {
    }

    public function __invoke(Message $message): void
    {
        $this->messageRepository->save($message);
    }

}
