<?php

namespace App\Controller;

use App\Entity\Message; // Import the Message entity
use App\Repository\MessageRepository; // Import the MessageRepository
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Import the AbstractController
use Symfony\Component\HttpFoundation\Response; // Import the Response
use Symfony\Component\Routing\Annotation\Route; // Import the Route

#[Route('/messages', name: 'message_')] // Define the route prefix for all methods in the controller
class MessageController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])] // Define the route for the index method
    public function index(MessageRepository $messageRepository): Response // Inject the MessageRepository
    {
        $messages = $messageRepository->findAll(); // Use the MessageRepository to fetch all messages
        return $this->json($messages); // Return the messages as JSON
    }
}

