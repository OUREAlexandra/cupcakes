<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('home/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{category}", name="category_show")
     * @ParamConverter("category", class="App\Entity\Category", options={"mapping": {"category": "slug"}})
     */
    public function showCategory(Category $category, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'categories' => $categories
        ]);
    }
}
