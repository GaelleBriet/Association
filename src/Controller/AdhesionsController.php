<?php

namespace App\Controller;

use App\Entity\Adherents;
use App\Entity\Adhesions;
use App\Form\AdhesionType;
use App\Repository\AdhesionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdhesionsController extends AbstractController
{
    #[Route('/adhesions', name: 'app_adhesions')]
    public function index(AdhesionsRepository $adhesionsRepository): Response
    {

        $adhesion = $adhesionsRepository->findAll();
        return $this->render('adhesions/index.html.twig', [
            'adhesion' => $adhesion,
        ]);
    }

    // #[Route('/adhesions/{id}', name: 'app_adhesions_show')]
    // public function show(Adherents $adherent): Response
    // {
    //     $adherent->getAdhesions();
    //     // $adhesion->getAdhesionsFromAdherent($adherent);
    //     return $this->render('adhesions/show.html.twig', [
    //         'adherent' => $adherent,
    //     ]);
    // }


}
