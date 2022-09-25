<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Search;
use App\Entity\Ride;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RideController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/ride", name="rides")
     */
    public function index(PaginatorInterface $paginator, Request $request, Cart $cart): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $rides = $paginator->paginate(
                $this->entityManager->getRepository(Ride::class)->findWithSearch($search),
                $request->query->getInt('page', 1), /*page number*/
                9 /*limit per page*/
            );
        }else{
            $rides = $paginator->paginate(
                $this->entityManager->getRepository(Ride::class)->findAll(),
                $request->query->getInt('page', 1), /*page number*/
                9 /*limit per page*/
            );
        }

        return $this->render('ride/index.html.twig', [
            'rides' => $rides,
            'form' => $form->createView(),
            'cart' => $cart->getFull(),
        ]);
    }

    /**
     * @Route("/ride/{slug}", name="ride")
     */
    public function show($slug, Cart $cart)
    {
        $ride = $this->entityManager->getRepository(Ride::class)->findOneBy(array('slug' => $slug));

        if (!$ride){
            return $this->redirectToRoute('rides');
        }
        return $this->render('ride/show.html.twig', [
            'ride' => $ride,
            'cart' => $cart->getFull(),
        ]);
    }
}
