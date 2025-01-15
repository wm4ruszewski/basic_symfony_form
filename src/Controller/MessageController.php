<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends AbstractController
{

    #[Route('/', name: 'app_message', methods: ['GET', 'POST'])]
    public function index(Request $request, MessageService $messageService): Response
    {
        $isSent = false;
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();

            $file = $form->get('attachment')->getData();
            $messageService->receiveFile($message, $file);

            try {
                $messageService->sendAndSave($message);
            } catch (ExceptionInterface $e) {
                $this->addFlash('error', 'Nie udało się wysłać wiadomości');
            }

            $form = $this->createForm(MessageType::class);
            $isSent = true;
        }

        return $this->render('message/form.html.twig', [
            'form' => $form->createView(),
            'sent_status' => $isSent,
        ]);
    }
}
