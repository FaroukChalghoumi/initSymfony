<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/*/**
 * @Route("/classroom", name="app_classroom")
 */
class ClassroomController extends AbstractController
{
    /**
     * @Route("/list", name="app-list")
     */
    public function index(  \Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository( Classroom::class ) ;
        $list = $repository->findAll ( );

//$form = $form = $this->createForm(Personne::class);
        return $this->render('classroom/index.html.twig' , ["listClassroom"=>$list]);
    }

    /**
     * @Route("/form", name="app-form")
     */
    public function form(  \Doctrine\Persistence\ManagerRegistry $Doc , Request  $request): Response
    {
        //$repository = $doctrine->getRepository( Classroom::class ) ;
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class , $classroom);
        $form->handleRequest( $request ) ;
        if ( $form->isSubmitted() ) {
            $entityManager = $Doc->getManager();
            $entityManager->persist($classroom);
            $entityManager->flush();
            $this->addFlash('success', " added with success ");
            return $this->redirectToRoute('app-list');

        }

        return $this->render('classroom/form.html.twig' , ['form' => $form->createView()]);
    }

    /**
     * @Route("/update{id?0}", name="app-update")
     */
    public function Update( Classroom $classroom=null, \Doctrine\Persistence\ManagerRegistry $Doc , Request  $request): Response
    {
        if ( $classroom) {
            $form = $this->createForm(ClassroomType::class , $classroom);
            $form->handleRequest($request);
            if ( $form->isSubmitted() ) {
                $entityManager = $Doc->getManager();
                $entityManager->persist($classroom);
                $entityManager->flush();
                $this->addFlash('success', " updated with success ");
                return $this->redirectToRoute('app-list');

            }
            else {
                return $this->render('classroom/form.html.twig' , ['form' => $form->createView()]);
            }
        }
        else{
            $this->addFlash('error',"la personne n'existe pas ");
            return $this->redirectToRoute('app-list');
        }

    }





    /**
     * @Route("/Delete{id?0}", name="app-Delete")
     */
    public function delete( Classroom $classroom=null, \Doctrine\Persistence\ManagerRegistry $Doc , Request  $request): Response
    {
        if ( $classroom) {

            $entityManager = $Doc->getManager();
            $entityManager->remove($classroom);
            $entityManager->flush();
            $this->addFlash('success', " Deleted with success ");
            return $this->redirectToRoute('app-list');

        }
        else {
            $this->addFlash('error', " cant find ");
            return $this->redirectToRoute('app-list');            }
    }




}
