<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SeessionController extends AbstractController
{
    /**
     * @Route("/seession", name="app_seession")
     */
    public function index(SessionInterface  $session): Response
    {
        //$session->start();
        $session = new Session();
        if ($session->has('nbVisite')) {
            $nbVisite = $session->get('nbVisite') + 1 ;

        }else {
            $nbVisite = 1 ;
        }
        $session ->set('nbVisite',$nbVisite);

        return $this->render('seession/index.html.twig',['visites' => $nbVisite]);
    }
}
