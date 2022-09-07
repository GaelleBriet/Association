<?php

namespace App\Controller;

use App\Entity\Adhesions;
use App\Form\AdhesionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdhesionsController extends AbstractController
{
    #[Route('/adhesions', name: 'app_adhesions')]
    public function index(): Response
    {
        return $this->render('adhesions/index.html.twig', [
            'controller_name' => 'AdhesionsController',
        ]);
    }
}
