<?php

namespace App\Controller;

use App\Entity\Commentary;
use App\Form\CommentaryType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\returnArgument;

class CommentaryController extends AbstractController
{
    /**
     * @Route("{id}/commentary/new", name="comm_new", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function new(Request $request, $id, BookRepository $bookRepository): Response
    {
        $comm = new Commentary();
        $book = $bookRepository->find($id);
        if(!$book)
            return $this->redirectToRoute("home");
        $comm->setBook($book);
        $form = $this->createForm(CommentaryType::class, $comm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comm);
            $entityManager->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentary/index.html.twig', [
            'comm' => $comm,
            'form' => $form,
        ]);
    }
}
