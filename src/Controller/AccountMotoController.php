<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Moto;
use App\Form\MotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountMotoController extends AbstractController
{
    private $entityManager;

    /**
     * AccountMotoController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account/bike", name="account_moto")
     */
    public function index(): Response
    {
        return $this->render('account/moto.html.twig', [

        ]);
    }


    /**
     * @Route("/account/add-a-bike", name="account_moto_add")
     */
    public function add(Cart $cart, Request $request): Response
    {
        $moto = new Moto();
        $form = $this->createForm(MotoType::class, $moto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moto->setUser($this->getUser());
            $this->entityManager->persist($moto);
            $this->entityManager->flush();
            if ($cart->get()){
                return $this->redirectToRoute('order');
            }else{
                return $this->redirectToRoute('account_moto');
            }
        }

        return $this->render('account/moto_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account/modify-a-bike/{id}", name="account_moto_edit")
     */
    public function edit(Request $request, $id): Response
    {
        $moto = $this->entityManager->getRepository(Moto::class)->findOneById($id);

        if (!$moto || $moto->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_moto');
        }
        $form = $this->createForm(MotoType::class, $moto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('account_moto');
        }

        return $this->render('account/moto_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account/delete-a-bike/{id}", name="account_moto_delete")
     */
    public function delete($id): Response
    {
        $moto = $this->entityManager->getRepository(Moto::class)->findOneById($id);

        if ($moto && $moto->getUser() == $this->getUser()) {
            $this->entityManager->remove($moto);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('account_moto');
    }
}
