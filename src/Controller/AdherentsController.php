<?php

namespace App\Controller;

use App\Entity\Adherents;
use App\Repository\AdherentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/adherents')]
class AdherentsController extends AbstractController
{
    #[Route('', name: 'app_adherents', methods: 'GET')]
    #[Route('/list', name: 'app_adherents_list', methods: 'GET')]
    public function list(AdherentsRepository $adherentsRepository): Response
    {
        $adherents = $adherentsRepository->findAll();
        return $this->render('adherents/list.html.twig', compact('adherents'));
    }

    #[Route('/{id<[0-9]+>}', name: 'app_adherents_show', methods: 'GET')]
    public function show(Adherents $adherent): Response
    {
        return $this->render('adherents/show.html.twig', [
            'adherent' => $adherent
        ]);
    }


    // #[Route('/{id<[0-9]+>}/edit', name: 'app_adherents_edit', methods: 'GET|POST')]
    // public function edit(Adherents $adherent): Response
    // {
    //     return $this->render('adherents/edit.html.twig', [
    //         'adherent' => $adherent
    //     ]);
    // }

    #[Route('/{id<[0-9]+>}/edit', name: 'app_adherents_edit')]
    public function edit(Adherents $adherent, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createFormBuilder($adherent)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('tel', TelType::class)
            ->add('email', EmailType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_adherents');
        }

        return $this->render('adherents/edit.html.twig',  [
            'adherents' => $adherent,
            'form' => $form->createView()
        ]);
    }

    #[Route('/create', name: 'app_adherents_create', methods: 'GET|POST')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $adherent = new Adherents;

        $form = $this->createFormBuilder($adherent)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('tel', TelType::class)
            ->add('email', EmailType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($adherent);
            $em->flush();

            return $this->redirectToRoute('app_adherents');
        }

        return $this->render('adherents/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
