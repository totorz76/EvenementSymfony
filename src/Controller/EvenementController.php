<?php

namespace App\Controller;

use Dom\Entity;
use App\Entity\Evenement;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManager;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(EvenementRepository $evenementsRepository): Response
    {
        $events = $evenementsRepository->findAll();
        return $this->render('evenement/index.html.twig', [
            'evenements' => $events,
        ]);
    }
    #[Route('/evenement/new', name: 'new_event')]
    public function new(Request $request, EntityManagerInterface $entityManager){
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $evenement -> setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($evenement);
            $entityManager->flush();
            return $this->redirectToRoute('app_evenement');
        }
        return $this->render('evenement/new.html.twig',[
            'formevent' => $form
        ]);
    }
    #[Route('/evenement/{id}', name: 'show_event')]
    public function show(Evenement $event){
        return $this->render('evenement/show.html.twig', [
            'evenement' => $event
        ]);
    }
    #[Route('/evenement/edit/{id}', name: 'edit_event')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Evenement $evenement){
        // $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $evenement -> setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($evenement);
            $entityManager->flush();
            return $this->redirectToRoute('app_evenement');
        }
        return $this->render('evenement/edit.html.twig',[
            'formevent' => $form
        ]);
    }
}
