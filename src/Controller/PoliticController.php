<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PoliticController extends AbstractController
{
    /**
     * @Route("/politic", name="politic")
     */
    public function index(Cart $cart): Response
    {
        return $this->render('politic/index.html.twig', [
            'cart' => $cart->getFull(),
        ]);
    }
}
