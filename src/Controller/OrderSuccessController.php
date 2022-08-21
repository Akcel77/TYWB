<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use App\Entity\Ride;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
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
     * @Route("/order/success/{stripeSessionId}", name="order_success")
     */
    public function index($stripeSessionId, Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['stripeSessionId' => $stripeSessionId]);

        $moto_weight = $order->getMotoWeight();
        $passengers = $order->getPassengers();

        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        if(!$order->isIsPaid()){
            foreach ($cart->getFull() as $ride) {
                $ride['ride']->setMaxWeight( $ride['ride']->getMaxWeight() - $moto_weight);
                $ride['ride']->setMaxPeople( $ride['ride']->getMaxPeople() - $passengers);


            }
            $cart->remove();
            $order->setIsPaid(1);
            $this->entityManager->flush();
            //Envoyer un email a notre client pour lui confirmer la commande

            $mail = new Mail();
            $content = "<br> Bonjour " .$order->getUser()->getFirstName(). " <br> Merci pour votre réservation avec Travel With Your Bike <br>";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstName(), 'Votre réservation est bien validee', $content);
        }



        return $this->render('order_success/index.html.twig', [
            'cart' => $cart->getFull(),
            'order' => $order,
        ]);
    }
}
