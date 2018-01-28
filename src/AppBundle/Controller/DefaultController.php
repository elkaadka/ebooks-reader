<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Form\NewBook;
use AppBundle\Service\FileUpload;
use Kanel\DropBox\Client as DropBox;
use Kanel\DropBox\Exceptions\DropBoxException;
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

            $fileUpload = new FileUpload($this->container->getParameter('upload_dir'));
            $filePath = $fileUpload->upload($file);

            $dropBox = new DropBox($this->container->getParameter('dropbox_access_token'));

            try {
                $dropBoxUploadData = $dropBox->upload($filePath, $this->container->getParameter('dropbox_folder'));
            } catch (DropBoxException $exception) {

            }

            $book = new Book();
            $book->setTitle($file->getClientOriginalName());
            $book->setDropBoxId($dropBoxUploadData->getId());

        }

        return $this->render('default/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/books/search", name="searchbook")
     */
    public function searchAction(Request $request)
    {

    }

    /**
     * @Route("/books/all", name="allbooks")
     */
    public function allBooksAction(Request $request)
    {

    }

}
