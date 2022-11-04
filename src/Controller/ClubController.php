<?php

namespace App\Controller;

use App\Entity\Club;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/club")
 */
class ClubController extends AbstractController
{
    /**
     * @Route("/", name="app_club")
     */
    public function index(ManagerRegistry $doctrine ): Response
    {
        $repository = $doctrine->getRepository(Club::class);
        $list = $repository->findAll();
        return $this->render('club/index.html.twig' , ["listClub"=>$list]);
    }

}
