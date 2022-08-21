<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Ride;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Cart $cart): Response
    {
        $rides = $this->entityManager->getRepository(Ride::class)->findBy(['isBest' => 1]);

        return $this->render('home/index.html.twig', [
            'rides' => $rides,
            'cart' => $cart->getFull(),
        ]);
    }
}
