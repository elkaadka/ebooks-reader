<?php

namespace AppBundle\Controller;

use AppBundle\Form\NewBook;
use AppBundle\Service\FileUpload;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Route("/books", name="mybooks")
     */
    public function indexAction(Request $request)
    {
        $bookRepository = $this->getDoctrine()->getRepository('AppBundle:Book');
        $books = $bookRepository->findBy([], ['createdAt' => 'desc']);

        return $this->render('default/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/books/new", name="newbook")
     */
    public function newBookAction(Request $request)
    {

        $form = $this->createForm(NewBook::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get(NewBook::FILE)->getData();
            $name = $file->getClientOriginalName();

            $fileUpload = new FileUpload($this->container->getParameter('upload_dir'));
            $fileUpload->upload($file);
            die('ok');
        }

        return $this->render('default/add.html.twig', ['form' => $form->createView()]);
    }

}
