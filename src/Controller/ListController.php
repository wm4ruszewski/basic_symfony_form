<?php

namespace App\Controller;

use App\Repository\MessageRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ListController extends AbstractController
{
    private const int PAGE_SIZE = 10;

    #[Route('/list', name: 'app_list')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(MessageRepositoryInterface $messageRepository, Request $request): Response
    {
        $offset = $request->query->getInt('offset', 0);
        $paginator = $messageRepository->getMessagePaginator($offset, self::PAGE_SIZE);

        return $this->render('dashboard/list.html.twig', [
            'messages' => $paginator,
            'previous' => $offset - self::PAGE_SIZE,
            'next' => min(count($paginator), $offset + self::PAGE_SIZE),
        ]);
    }
}
