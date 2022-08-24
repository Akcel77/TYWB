<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermsController extends AbstractController
{
    /**
     * @Route("/terms", name="terms")
     */
    public function index(Cart $cart): Response
    {
        return $this->render('terms/index.html.twig', [
            'cart' => $cart->getFull(),
        ]);
    }
}
