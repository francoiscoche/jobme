<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobberController extends AbstractController
{
    #[Route('/jobber', name: 'app_jobber')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findUsers('ROLE_JOBBER');

        return $this->render('jobber/index.html.twig', [
            'users' => $users,
        ]);
    }
}
