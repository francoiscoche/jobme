<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class JobberController extends AbstractController
{
    #[Route('/jobber', name: 'app_jobber')]
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {


        $query = $userRepository->findUsers('ROLE_JOBBER');
    
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );



        
        return $this->render('pages/jobber/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/jobber/{id}', name:'app_details', methods: ['GET'])]
    public function details(User $user): Response
    {
        return $this->render('pages/jobber/details.html.twig', [
            'user' => $user
        ]);
    }
}
