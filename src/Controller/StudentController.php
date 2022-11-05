<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\MinMaxType;
use App\Form\MinMoyeneType;
use App\Form\SearchByClassroomType;
use App\Form\SearchByNameType;
use App\Form\StudentType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="app_student")
     */
    public function Display( ManagerRegistry $doctrine , Request $request): Response
    {
        $student = $doctrine->getRepository(Student::class)->findAll();
        $studentEnabled = $doctrine->getRepository(Student::class)->searchEnabled();
        $sorted_students = $doctrine->getRepository(Student::class)->sorted_student();

        $form = $this->createForm(SearchByNameType::class );
        $form2 = $this->createForm(SearchByClassroomType::class );
        $form3 = $this->createForm(MinMaxType::class );
        $form->handleRequest($request);
        $form2->handleRequest($request);
        $form3->handleRequest($request);
        if ($form->isSubmitted())
        {
            $name = $form['name']->getData();
            $StudentByname = $doctrine->getRepository(Student::class)->searchByname($name);

            return $this->renderForm('student/index.html.twig',['formSearchByClassroom' => $form2,'forminMax' => $form3,
                'formSearch' => $form,'studentList' => $StudentByname,'studentListEnabled' => $studentEnabled] );
        }

        if ($form2->isSubmitted())
        {
            $classroom = $form2['classroom']->getData();
            $StudentByclassroom = $doctrine->getRepository(Student::class)->searchByClassroom($classroom);

            return $this->renderForm('student/index.html.twig',['formSearch' => $form,'formSearchByClassroom' => $form2,
                'forminMax' => $form3,'studentList' => $StudentByclassroom
                ,'studentListEnabled' => $studentEnabled] );
        }

        if ($form3->isSubmitted())
        {
            $min = $form3['min']->getData();
            $max = $form3['max']->getData();
            $StudentMinMax = $doctrine->getRepository(Student::class)->findStudentByMaxMin($min,$max);

            return $this->renderForm('student/index.html.twig',['formSearch' => $form,'formSearchByClassroom' => $form2,'forminMax' => $form3,'studentList' => $StudentMinMax
                ,'studentListEnabled' => $studentEnabled] );
        }
        return $this->renderForm('student/index.html.twig', ['formSearch' => $form,'formSearchByClassroom' => $form2,'forminMax' => $form3,
            'studentList'=>$sorted_students,'studentListEnabled' => $studentEnabled]);
    }


    /**
     * @Route("/student/date/{min}/{max}", name="app_student_min_max")
     * @ParamConverter("min", options={"format": "Y-m-d"})
     * @ParamConverter("max", options={"format": "Y-m-d"})
     */
    public function productBypricemaxmin(ManagerRegistry $doctrine,$min,$max,Request $request): Response
    {

        $repository=$doctrine->getRepository(Student::class);
        $student=$repository-> findDatetByMaxMin($min,$max);
        return $this->renderForm('student/mimmax.html.twig', [
            'studentListDate'=>$student,]);

    }





    /**
     * @Route("/student/add", name="app_studentadd")
     */
    public function Add(ManagerRegistry $doctrine , Request $request): Response
    {
        $manager = $doctrine->getManager();
        $student = new Student();
        $form = $this->createForm(StudentType::class , $student);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $manager->persist($student);
            $manager->flush();
            return $this->redirectToRoute('app_student');
        }
        return $this->renderForm("student/add.html.twig", ["formulaire" => $form]);

    }

    /**
     * @Route("student/remove/{id}", name="app_studentremove")
     */
//seance 5
    public function ProductRemove(ManagerRegistry $em, $id): Response
    {

        $manager = $em->getManager();
        $repository = $em->getRepository(Student::class);
        $student = $repository->find($id);
        $manager->remove($student);
        $manager->flush();
        return $this->redirectToRoute('app_student');


    }

    /**
     * @Route("student/update/{id}", name="app_studentupdate")
     */
    public function StudentUpdate(ManagerRegistry $em, $id, Request $req): Response
    {

        // $manager = $em->getManager();
        $manager = $em->getManager();


        $student=$em->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $manager->persist($student);
            $manager->flush();
            return $this->redirectToRoute('app_student');
        }

        return $this->renderForm("student/add.html.twig", ["formulaire" => $form]);

    }




}
