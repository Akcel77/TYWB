<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Ride;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
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
     * @Route("/order", name="order")
     */
    public function index(Cart $cart, Request $request): Response
    {
        if (!$this->getUser()->getMotos())
        {
            return $this->redirectToRoute('account_moto_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }

    /**
     * @Route("/order/summary", name="order_recap", methods={"POST"})
     */
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        //verifie si la commande est existante
        if ($form->isSubmitted() && $form->isValid()) {
            //initialisation de la date
            $date = new \DateTimeImmutable();

            $moto = $form->get('motos')->getData();
            $moto_weight = $moto->getWeight();
            $moto_content = $moto->getBrand().' '.$moto->getModel();
            $moto_content .= '<br/>'.$moto->getMatriculation();
            $moto_content .= '<br/>'. $moto->getWeight().' kg';

            //enregistrer ma commande Order()
            $order = new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setMoto($moto_content);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            //enregistrer mes produits OrderDetails()
            foreach ($cart->getFull() as $ride) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setRide($ride['ride']->getTitle());
                $orderDetails->setPrice($ride['ride']->getPrice());
                $this->entityManager->persist($orderDetails);
//                $ride['ride']->setMaxWeight( $ride['ride']->getMaxWeight() - $moto_weight);


            }

            $this->entityManager->flush();

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'moto' => $moto_content,
                'reference' => $order->getReference(),
            ]);
        }

        //sinon renvoi vers le panier
        return $this->redirectToRoute('cart');
    }
}
