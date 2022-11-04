<?php

namespace App\Controller;


use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="app_student")
     */
    public function index(  \Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository( Student::class ) ;
        $list = $repository->findAll ( );

//$form = $form = $this->createForm(Personne::class);
        return $this->render('student/index.html.twig' , ["listStudent"=>$list]);
    }

    /**
     * @Route("/formstudent", name="app-form-student")
     */
    public function formStudent(  \Doctrine\Persistence\ManagerRegistry $Doc , Request  $request): Response
    {
        //$repository = $doctrine->getRepository( Student::class ) ;
        $Student = new Student();
        $form = $this->createForm(StudentType::class , $Student);
        $form->handleRequest( $request ) ;
        if ( $form->isSubmitted() ) {
            $entityManager = $Doc->getManager();
            $entityManager->persist($Student);
            $entityManager->flush();
            $this->addFlash('success', " added with success ");
            return $this->redirectToRoute('app_student');

        }

        return $this->render('student/formStudent.html.twig' , ['formStudent' => $form->createView()]);
    }
    /**
     * @Route("student/updatestudent{id?0}", name="app-updatestudent")
     */
    public function Updatestudent(  $id, \Doctrine\Persistence\ManagerRegistry $Doc , Request  $request): Response
    {

        $entityManager = $Doc->getManager();
        $Student = $Doc->getRepository(Student::class)->find($id);
            $form = $this->createForm(StudentType::class , $Student);
            $form->handleRequest($request);
            if ( $form->isSubmitted() ) {

                $entityManager->persist($Student);
                $entityManager->flush();
                $this->addFlash('success', " updated with success ");
                return $this->redirectToRoute('app_student');

            }
            else {
                return $this->render('student/formStudent.html.twig' , ['formStudent' => $form->createView()]);
            }


    }





}
