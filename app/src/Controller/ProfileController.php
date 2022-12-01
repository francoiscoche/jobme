<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ImageFormType;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(ProfileRepository $profileRepository, Request $request, EntityManagerInterface $manager, Security $security): Response
    {
        $user = $this->getUser();
        $profile = $profileRepository->findOneBy(["user" => $user]);

        // if user has not profil pic
        if($profile == null) {
            $profile = new Profile();
            $profile->setUser($user);
        }

        $form = $this->createForm(ImageFormType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $img = $form->getData();
            $manager->persist($img);
            $manager->flush();

            return $this->redirectToRoute('app_profile');
        }
        return $this->render('pages/profile/index.html.twig', [
                'form' => $form->createView(),
                'profile' => $profile
        ]);
    }
}
