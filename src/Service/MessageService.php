<?php

namespace App\Service;

use App\Entity\Message;
use http\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class MessageService
{
    /**
     * @param MessageBusInterface $messageBus
     */
    public function __construct(private MessageBusInterface $messageBus, private SluggerInterface $slugger, private string $uploadDir)
    {
    }

    /**
     * @param Message $message
     * @return void
     * @throws ExceptionInterface
     */
    public function sendAndSave(Message $message): void
    {
        $this->messageBus->dispatch($message);
    }

    /**
     * @param UploadedFile $file
     * @return Message
     */
    public function receiveFile(Message $message, UploadedFile $file): Message
    {
        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

            try {
                $file->move(
                    $this->uploadDir,
                    $newFilename
                );
                $message->setFilename($newFilename);
            } catch (\Exception $e) {
                throw new RuntimeException('error', 'Nie udało się przesłać pliku.');
            }
        }

        return $message;
    }
}
