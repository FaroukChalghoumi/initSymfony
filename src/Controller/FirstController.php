<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    /**
     * @Route("/first", name="app_first")
     */
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            //'controller_name' => 'FirstController',
            'name' => 'Farouk',
            'firstname' => 'Chalghoumi' ,
        ]);
    }
    /**
     * @Route("/hello", name="app_hello")
     */
    public function sayHello(): Response
    {
        $reddict = 1 ;
        if ($reddict == 1)
            return $this->redirectToRoute('app_first');
        return $this->render('first/hello.html.twig', [
            //'controller_name' => 'FirstController',
            'name' => 'Farouk',
            'firstname' => 'Chalghoumi' ,
        ]);
    }
}
