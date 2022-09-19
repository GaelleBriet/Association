<?php

namespace App\Controller;

use App\Entity\Adherents;
use App\Form\AdherentsCreateType;
use App\Repository\AdherentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Route('/adherents')]
class AdherentsController extends AbstractController
{
    #[Route('', name: 'app_adherents', methods: 'GET')]
    #[Route('/list', name: 'app_adherents_list', methods: 'GET')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function list(AdherentsRepository $adherentsRepository): Response
    {
        $adherents = $adherentsRepository->findAllWithLastAdhesion();

        // je crée un tableau qui contiendra les index à mettre à la fin
        $avirer = [];

        // Pour chaque adhérent...
        foreach ($adherents as $key => $adherent) {
            // je vérifie si la dernière adhesion existe ou pas
            if (!$adherent['derniere_adhesion']) {
                // si elle n'existe pas, j'ajoute l'index à la liste des index à virer
                $avirer[] = $key;
            }
        }

        // Ensuite pour chaque index du tableau des index à mettre à la fin
        foreach ($avirer as $key => $value) {
            // je copie l'entrée du tableau qui est dans avirer
            $copie = $adherents[$value];
            // je supprime l'entrée du tableau qui est dans avirer
            unset($adherents[$value]);
            // je rajoute ma copie à la fin du tableau
            array_push($adherents, $copie);
        }


        $today = new \DateTime();
        $today->add(new \DateInterval('P31D'));

        return $this->render('adherents/list.html.twig', [
            'adherent' => $adherents,
            'today' => $today,
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
    #[Security("is_granted('ROLE_ADMIN')")]
    public function delete(Adherents $adherent, EntityManagerInterface $em): Response
    {
        $this->addFlash('info', 'Adhérent supprimé avec succès!');
        $em->remove($adherent);
        $em->flush();

        return $this->redirectToRoute('app_adherents');
    }


    #[Route('/{id<[0-9]+>}/edit', name: 'app_adherents_edit', methods: "GET|PUT")]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function edit(Adherents $adherent, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(AdherentsCreateType::class, $adherent, [
            'method' => 'PUT',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Adhérent modifié avec succes!');

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

        $form = $this->createForm(AdherentsCreateType::class, $adherent);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($adherent);
            $em->flush();

            $this->addFlash('succes', 'Adhérent créé avec success!');

            return $this->redirectToRoute('app_adherents');
        }

        return $this->render('adherents/create.html.twig', [
            'adherent' => $adherent,
            'form' => $form->createView()
        ]);
    }

    // #[Route('/{id<[0-9]+>}/adhesion', name: 'app_adhesion_create', methods: "GET|POST")]
    // #[Security("is_granted('ROLE_ADMIN')")]
    // public function addAdhesion(Request $request, EntityManagerInterface $em): Response
    // {
    //     $adhesion = new Adhesions();

    //     $form = $this->createForm(AdhesionAddType::class, $adhesion);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em->persist($adhesion);
    //         $em->flush();

    //         return $this->redirectToRoute('app_adherents');
    //     }

    //     return $this->render('adhesions/index.html.twig', [
    //         'adhesion' => $adhesion,
    //         'form' => $form->createView()
    //     ]);
    // }

    // #[Route('/{id<[0-9]+>}/deleteAdhesion', name: 'app_adherents_deleteAdhesion', methods: 'GET')]
    // public function deleteAdhesion(Adhesions $adhesion, EntityManagerInterface $em): Response
    // {
    //     $em->remove($adhesion);
    //     $em->flush();

    //     return $this->redirectToRoute('app_adherents');
    // }
}
