<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/create", name="create-todo")
     */
    public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(TodoType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $todo = new Todo();
            $todo->setName($data->getName());
            $todo->setCategory($data->getCategory());
            $todo->setDescription($data->getDescription());
            $todo->setDueDate($data->getDueDate());
            $todo->setCreateDate($data->getCreateDate());

            $entityManager->persist($todo);
            $entityManager->flush();

            return $this->redirectToRoute('index-todo');
        }

        return $this->render('todo/create.html.twig', [
            'todo_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="index-todo")
     */
    public function index()
    {
        return $this->render('todo/index.html.twig');
    }
}
