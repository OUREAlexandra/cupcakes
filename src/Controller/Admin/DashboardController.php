<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Command;
use App\Entity\Invoice;
use App\Entity\Product;
use App\Entity\Shipping;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cupcakes');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Admin Yummy Cupcake', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Gestion des produits');
        yield MenuItem::linkToCrud('Produits', 'fas fa-cookie-bite', Product::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-clipboard-list', Category::class);
        yield MenuItem::section('Gestion de la clientèle');
        yield MenuItem::linkToCrud('Clients', 'far fa-address-book', User::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-list', Command::class);
        // yield MenuItem::linkToCrud('Départements', 'fas fa-globe-europe', County::class);
        yield MenuItem::linkToCrud('Factures', 'fas fa-sticky-note', Invoice::class);
        yield MenuItem::section('Gestion des livraisons');
        yield MenuItem::linkToCrud('Livraisons', 'fas fa-shipping-fast', Shipping::class);
    }
}
