<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\AdvertRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * Return the list of categories ny Slug
     *
     * @param CategoryRepository $categoryRepository
     * @param Category $category
     * @param AdvertRepository $advertRepository
     * @return Response
     */
    #[Route('/category/{slug}', name: 'app_category', methods:['GET'])]
    public function index(CategoryRepository $categoryRepository, Category $category, AdvertRepository $advertRepository): Response
    {
        $list =  $advertRepository->findbycategory($category);
        $allCategories = $categoryRepository->findAll();

        return $this->render('pages/category/index.html.twig', [
            'categoria' => $category->getName(),
            'list' => $list,
            'allCategories' => $allCategories
        ]);
    }
}
