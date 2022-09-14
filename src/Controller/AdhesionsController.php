<?php

namespace App\Controller;

use App\Entity\Adherents;
use App\Entity\Adhesions;
use App\Form\AdhesionAddType;
use App\Repository\AdherentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdhesionsController extends AbstractController
{
    #[Route('/adhesion/{id<[0-9]+>}/delete', name: 'app_adhesion_delete', methods: 'GET')]
    public function delete(Adhesions $adhesion, EntityManagerInterface $em): Response
    {
        $em->remove($adhesion);
        $em->flush();

        return $this->redirectToRoute('app_adherents');
    }


    #[Route('/{id<[0-9]+>}/adhesion/create', name: 'app_adhesion_create', methods: "GET|POST")]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function create(Request $request, EntityManagerInterface $em, Adherents $adherents): Response
    {
        $adhesion = new Adhesions();
        $adhesion->setAdherent($adherents);

        $form = $this->createForm(AdhesionAddType::class, $adhesion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $adherents->getId();
            $em->persist($adhesion);
            $em->flush();

            return $this->redirectToRoute('app_adherents');
        }

        return $this->render('adhesions/index.html.twig', [
            'adhesion' => $adhesion,
            'form' => $form->createView()
        ]);
    }
}
