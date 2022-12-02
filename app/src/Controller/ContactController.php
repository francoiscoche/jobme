<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\AdvertRepository;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * Return to send a message contact
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/contact', name: 'app_contact', methods: ['POST', 'GET'])]
    public function index(EntityManagerInterface $manager, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();

            return $this->redirectToRoute('app_list');
        }

        return $this->renderForm('pages/contact/index.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Return the list of messages posted and sent by user
     *
     * @param ContactRepository $contactRepository
     * @return Response
     */
    #[Route('/contact/list', name: 'app_contact_list', methods: ['GET'])]
    public function listMessages(ContactRepository $contactRepository): Response 
    {
        $messages = $contactRepository->findAll();

        return $this->render('pages/contact/list.html.twig', [
            'messages' => $messages
        ]);
    }

    /**
     * Get the list of advertisements posted by user into dashboard user
     *
     * @param AdvertRepository $advertRepository
     * @return Response
     */
    #[Route('/contact/list-advert', name: 'app_advert_list', methods: ['GET'])]
    public function listAdvert(AdvertRepository $advertRepository): Response
    {

        $user = $this->getUser();
        $advert = $advertRepository->findBy(['user' => $user]);

        return $this->render('pages/contact/advertList.html.twig', [
            'advert' => $advert
        ]);
    }
}
