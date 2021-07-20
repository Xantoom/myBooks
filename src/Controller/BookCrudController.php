<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\CommentaryRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookCrudController extends AbstractController
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/book/new", name="book_crud_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_crud/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/book/{id}", name="book_crud_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show($id, CommentaryRepository $commentaryRepository): Response
    {
        $book = $this->bookRepository->find($id);
        if(!$book)
            return $this->redirectToRoute("home");
        return $this->render('book_crud/show.html.twig', [
            'book' => $book,
            'commentaries' => $book->getCommentaries()
        ]);
    }

    /**
     * @Route("/book/edit/{id}", name="book_crud_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_crud/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/book/delete/{id}", name="book_crud_delete", requirements={"id"="\d+"})
     */
    public function delete($id): Response
    {
        $book = $this->bookRepository->find($id);

        if(!$book)
            return $this->redirectToRoute("home");

        $entityManager = $this->getDoctrine()->getManager();
        foreach($book->getCommentaries() as $comm) {
            $entityManager->remove($comm);
        }
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
