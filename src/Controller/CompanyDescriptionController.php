<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyDescriptionController extends AbstractController
{
    /**
     * @Route("/company/description", name="company_description")
     */
    public function index(Cart $cart): Response
    {
        return $this->render('company_description/index.html.twig', [
            'cart' => $cart->getFull(),
        ]);
    }
}
