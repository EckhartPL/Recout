<?php

namespace App\Controller;

use App\Entity\Reviewer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render('main_page/main.html.twig');
    }

    /**
     * @Route("/reviewer", name="create_reviewer")
     */
    public function createReviewer() : Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $reviewer = new Reviewer();
        $reviewer->setName('Mateusz');
        $reviewer->setSurname('Masek');
        $reviewer->setPassword('qwerty12345');
        $reviewer->setMail('mateusz.masek@wp.pl');

        $entityManager->persist($reviewer);
        $entityManager->flush();

        return new Response('Saved new Reviewer with ID: '.$reviewer->getId());
    }
}
