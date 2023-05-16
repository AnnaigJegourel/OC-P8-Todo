<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    // condition: connecté / role user
    #[Route(path: "/tasks", name: "task_list")]
    public function listAction(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $taskRepository->findBy([
                // 'author' => $this->getUser(),
                'isDone' => 0
            ])
        ]);
    }

    // condition: connecté / role user
    #[Route("/tasks/done", name: "task_done")]
    public function listDoneAction(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $taskRepository->findBy([
                // 'author' => $this->getUser(),
                'isDone' => 1
            ])
        ]);
    }

    // condition: connecté / role user
    #[Route(path: "/tasks/create", name: "task_create")]
    public function createAction(Request $request, TaskRepository $taskRepository)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setAuthor($this->getUser());
            
            $taskRepository->save($task, true);
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route(path: "/tasks/{id}/edit", name: "task_edit")]
    public function editAction(Task $task, Request $request, TaskRepository $taskRepository)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($task->getAuthor() !== $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez modifier que vos propres tâches.');

            return $this->redirectToRoute('homepage');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->save($task, true);

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route(path: "/tasks/{id}/toggle", name: "task_toggle")]
    public function toggleTaskAction(Task $task, TaskRepository $taskRepository)
    {
        if ($task->getAuthor() !== $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez modifier que vos propres tâches.');

            return $this->redirectToRoute('homepage');
        }

        $task->toggle(!$task->isDone());
        $taskRepository->save($task, true);

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route(path: "/tasks/{id}/delete", name: "task_delete")]
    public function deleteTaskAction(Task $task, TaskRepository $taskRepository)
    {
        if ($task->getAuthor() !== $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez supprimer que vos propres tâches.');

            return $this->redirectToRoute('homepage');
        }

        $taskRepository->remove($task, true);

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}