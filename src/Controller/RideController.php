<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Ride;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $rides = $this->entityManager->getRepository(Ride::class)->findWithSearch($search);
        }else{
            $rides = $this->entityManager->getRepository(Ride::class)->findAll();
        }

        return $this->render('ride/index.html.twig', [
            'rides' => $rides,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ride/{slug}", name="ride")
     */
    public function show($slug)
    {
        $ride = $this->entityManager->getRepository(Ride::class)->findOneBy(array('slug' => $slug));

        if (!$ride){
            return $this->redirectToRoute('rides');
        }
        return $this->render('ride/show.html.twig', [
            'ride' => $ride,
        ]);
    }
}
