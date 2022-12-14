<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{
    private $entityManager;

    /**
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account/order", name="account_order")
     */
    public function index(Cart $cart): Response
    {

        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());


        return $this->render('account/order.html.twig', [
            'orders' => $orders,
            'cart' => $cart->getFull(),

        ]);
    }

    /**
     * @Route("/account/order/{reference}", name="account_order_show")
     */
    public function show($reference, Cart $cart): Response
    {

        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_order');
        }

        return $this->render('account/order_show.html.twig', [
            'order' => $order,
            'cart' => $cart->getFull(),
        ]);
    }
}
