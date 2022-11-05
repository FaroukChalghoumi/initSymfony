<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="app_classroom")
     */
    public function Display(ManagerRegistry $doctrine , Request $request): Response
    {
        $classroom = $doctrine->getRepository(Classroom::class)->findAll();
        return $this->render('classroom/index.html.twig', [
            'classroomList' => $classroom,
        ]);
    }

    /**
     * @Route("/classroom/add", name="app_classroomadd")
     */
    public function Add(ManagerRegistry $doctrine , Request $request): Response
    {
        $manager = $doctrine->getManager();
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class , $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $manager->persist($classroom);
            $manager->flush();
            return $this->redirectToRoute('app_classroom');
        }
        return $this->renderForm("classroom/add.html.twig", ["formulaire" => $form]);

    }

    /**
     * @Route("classroom/remove/{id}", name="app_classroomremove")
     */
    public function ClassroomRemove(ManagerRegistry $em, $id): Response
    {

        $manager = $em->getManager();
        $repository = $em->getRepository(Classroom::class);
        $student = $repository->find($id);
        $manager->remove($student);
        $manager->flush();
        return $this->redirectToRoute('app_classroom');


    }


}
