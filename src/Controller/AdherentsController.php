<?php

namespace App\Controller;

use App\Repository\AdherentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/adherents')]
class AdherentsController extends AbstractController
{
    #[Route('', name: 'app_adherents')]
    #[Route('/list', name: 'app_adherents_list')]
    public function list(AdherentsRepository $adherentsRepository): Response
    {
        $adherents = $adherentsRepository->findAll();
        return $this->render('adherents/list.html.twig', compact('adherents'));
    }

    #[Route('/show', name: 'app_adherents_show')]
    public function show(): Response
    {
        return $this->render('adherents/show.html.twig');
    }

    #[Route('/edit', name: 'app_adherents_edit')]
    public function edit(): Response
    {
        return $this->render('adherents/edit.html.twig');
    }

    #[Route('/add', name: 'app_adherents_add')]
    public function add(): Response
    {
        return $this->render('adherents/edit.html.twig');
    }
}
