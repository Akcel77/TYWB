<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Moto;
use App\Entity\Order;
use App\Entity\Ride;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/order/create-session/{reference}", name="stripe_create_session")
     */
    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference): Response
    {
        $product_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        $order = $entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);

        if(!$order){
            return $this->redirectToRoute('order');
        }

        $product  = $order->getOrderDetails()->getValues();

//        dd($product);
        foreach ($order->getOrderDetails()->getValues() as $product) {

            $moto = $entityManager->getRepository(Ride::class)->findOneBy(['title' => $product->getRide()]);

            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $moto->getPrice(),
                    'product_data' => [
                        'name' => $moto->getTitle(),
                    ],
                ],
                'quantity' => 1,
            ];
//            dd($moto);
//            $moto['ride']->setMaxWeight( $ride['ride']->getMaxWeight() - $moto_weight);
        }

        Stripe::setApiKey('sk_test_51LG57CEVG9yfXzpI8HwOcrrAjHVh6gX6UKmn1k9otYwdm7ftZLaAzpt94Sjr0cwznt3GWD91btG1pWWyGg5jbKr400B5tIoPZi');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [
                $product_for_stripe
            ],
            'payment_method_types' => [
                'card',
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);

//        $order->setStripeSessionId($checkout_session->id);
//        $entityManager->flush();

        return $this->redirect($checkout_session->url);
    }
}
