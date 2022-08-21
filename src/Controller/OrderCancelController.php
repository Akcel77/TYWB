<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
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
     * @Route("/order/cancel/{stripeSessionId}", name="order_cancel")
     */
    public function index($stripeSessionId, Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['stripeSessionId' => $stripeSessionId]);

        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        //TO DO: Envoyer un email a notre client pour lui indiquer l'echec de paiement
        $mail = new Mail();
        $content = "<br> Bonjour " .$order->getUser()->getFirstName(). " <br> Une erreure s'est produite lors de votre commande <br>";
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstName(), 'Votre payement n\'a pas été validé ', $content);

        return $this->render('order_cancel/index.html.twig', [
            'cart' => $cart->getFull(),
            'order' => $order,
        ]);
    }
}
