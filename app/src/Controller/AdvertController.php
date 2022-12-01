<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Form\AdvertType;
use App\Repository\AdvertRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdvertController extends AbstractController
{
    
    #[Route('/advert', name: 'app_advert', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_RICHIEDENTE')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $advert = new Advert();

        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $advert = $form->getData();
            $em->persist($advert);
            $em->flush();

            $this->addFlash(
                'success',
                'Il tuo annuncio è stato creato con successo !'
            );

            return $this->redirectToRoute('app_list');
        }

        return $this->renderForm('pages/advert/index.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/list', name: 'app_list', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function list(CategoryRepository $categoryRepository, AdvertRepository $advertRepository): Response
    {
        $allCategories = $categoryRepository->findAll();
        $list = $advertRepository->findAll();

        return $this->render('pages/advert/list.html.twig', [
            'list' => $list,
            'allCategories' => $allCategories
        ]);
    }

    #[Route('/advert/{id}', name: 'app_advert_detail', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function detail(Advert $advert):Response
    {
        return $this->render('pages/advert/detail.html.twig', [
            'advert' => $advert,
        ]); 
    }
}
