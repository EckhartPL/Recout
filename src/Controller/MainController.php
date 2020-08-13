<?php

namespace App\Controller;

use App\Entity\Reviewer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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

    /**
     * @Route("/reviewer/{id}", name="get_reviewer")
     */
    public function getReviewer($id)
    {
        $reviewer = $this->getDoctrine()
        ->getRepository(Reviewer::class)
        ->find($id);

        if(!$reviewer){
            throw $this->createNotFoundException(
                'No reviewer found for id '.$id
            );
        }

        return $this->render('reviewer/get_reviewer.html.twig', 
        ['name' => $reviewer->getName(),
        'mail' => $reviewer->getMail()]);
    }

    /**
     * @Route("/testing/{num}", name="testing")
     */
    public function testing($num)
    {
        //$searchedName = 'Mateusz';

        //$names = $this->getDoctrine()->getRepository(Reviewer::class)->findAllWithName($searchedName);
        //return new Response($names);
        $arr = array(2, 4, 6, 7);
        $this->render('testing.html.twig', 
        ['arr' => $arr]);
        //$repository= $this->getDoctrine()->getRepository(Reviewer::class)->findByExampleField($num);
    }

    /**
     * @Route("/no", name="no")
     */
    public function noParameters(): Response
    {
        return $this->render('no_parameters.html.twig');
    }

    /**
     * @Route("/mailer", name="mailer")
     */
    public function sentMail()
    {
        $mail = (new TemplatedEmail())
        ->from('mateusz.masek@wp.pl')
        ->to('mateusz.masek@szynaka-living.pl')
        ->subject('Wiadomośc testowa mailer twig')

        //path of the twig template to render
        ->htmlTemplate('emails/signup.html.twig')

        //pass variables (name => value) to the template
        ->context([
            'expiration_date' => new \DateTime('+7 Days'),
            'username' => 'foo',
        ]);

        return new Response("Mail sent");
    }
}