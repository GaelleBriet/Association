<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Adherents;
use App\Entity\Adhesions;
use App\Form\AdherentType;
use App\Form\AdhesionType;
use App\Repository\AdherentsRepository;
use App\Repository\AdhesionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/adherents')]
class AdherentsController extends AbstractController
{
    #[Route('', name: 'app_adherents', methods: 'GET')]
    #[Route('/list', name: 'app_adherents_list', methods: 'GET')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function list(AdherentsRepository $adherentsRepository, AdhesionsRepository $adhesionsRepository): Response
    {
        $adhesion = $adhesionsRepository->findAll();
        $adherent = $adherentsRepository->findAll();
        return $this->render('adherents/list.html.twig', [
            'adherent' => $adherent,
            'adhesion' => $adhesion,

        ]);
    }

    #[Route('/{id<[0-9]+>}', name: 'app_adherents_show', methods: 'GET')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function show(Adherents $adherent): Response
    {
        $adhesions = $adherent->getAdhesions();
        return $this->render('adherents/show.html.twig', [
            'adherent' => $adherent,
            'adhesion' => $adhesions,
        ]);
    }

    #[Route('/{id<[0-9]+>}/delete', name: 'app_adherents_delete', methods: 'GET')]
    public function delete(Adherents $adherent, EntityManagerInterface $em): Response
    {
        $em->remove($adherent);
        $em->flush();

        return $this->redirectToRoute('app_adherents');
    }


    #[Route('/{id<[0-9]+>}/edit', name: 'app_adherents_edit', methods: "GET|PUT")]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function edit(Adherents $adherent, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AdherentType::class, $adherent, [
            'method' => 'PUT',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_adherents');
        }

        return $this->render('adherents/edit.html.twig',  [
            'adherent' => $adherent,
            'form' => $form->createView()
        ]);
    }


    #[Route('/create', name: 'app_adherents_create', methods: 'GET|POST')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $adherent = new Adherents;

        $form = $this->createForm(AdherentType::class, $adherent);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($adherent);
            $em->flush();

            return $this->redirectToRoute('app_adherents');
        }

        return $this->render('adherents/create.html.twig', [
            'adherent' => $adherent,
            'form' => $form->createView()
        ]);
    }
}
