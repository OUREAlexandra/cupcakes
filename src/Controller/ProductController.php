<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\Slugify;
use App\Data\SearchProductData;
use App\Form\SearchProductType;
use Symfony\Component\Mime\Email;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends AbstractController
{
    /**
     * @Route("/produits", name="products")
     */
    public function index(PaginatorInterface $paginator, ProductRepository $productRepository, Request $request): Response
    {
        $search = new SearchProductData();
        $searchForm = $this->createForm(SearchProductType::class, $search);
        $searchForm->handleRequest($request);

        $results = [];
        $products = $productRepository->findAll();

        $donnees = $this->getDoctrine()->getRepository(Product::class)->findBy([],['id' => 'desc']);


        // Paginate the results of the query
        $products = $paginator->paginate(
            // Doctrine Query, not results
            $donnees,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            12
        );

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $results = $productRepository->searchProduct($search);
        }
  
        return $this->render('product/index.html.twig', [
            'products' => $results ? $results : $products,
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * The controller for the program add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request, Slugify $slugify,  MailerInterface $mailer): Response
    {
        // Create a new Program Object
        $product = new Product();
        // Create the associated Form
        $form = $this->createForm(ProductType::class, $product);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($product->getName());
            $product->setSlug($slug);
            // Persist Program Object
            $entityManager->persist($product);
            // Flush the persisted object
            $entityManager->flush();

            // Once the form is submitted, valid and the data inserted in database, you can define the success flash message
            $this->addFlash('success', 'Votre nouveau programme a bien été crée');

            $email = (new Email())

                ->from($this->getParameter('mailer_from'))

                ->to('your_email@example.com')

                ->subject('Une nouvelle série vient d\'être publiée !')

                ->html($this->renderView('program/newProgramEmail.html.twig', 
                ['product' => $product]));


        $mailer->send($email);

            // Finally redirect to programs list
            return $this->redirectToRoute('product_index');
        }
        // Render the form
        return $this->render('product/index.html.twig', [
            'product' => $product,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/produits/{slug}", name="product_show")
     */
    public function showProduct(Product $product, ProductRepository $productRepository): Response
    {
        $categories = $product->getCategory();
        
        return $this->render('product/show.html.twig', [
       'product' => $product,
       'categories' => $categories,
       ]);
    }
}
