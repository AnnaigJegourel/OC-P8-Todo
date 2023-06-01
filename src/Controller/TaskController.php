<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    /**
     * Display the list of tasks that must be done
     *
     * @param TaskRepository $taskRepository
     * @return void
     */
    #[Route(path: "/tasks", name: "task_list")]
    public function listAction(TaskRepository $taskRepository)
    {
        return $this->render(
            'task/list.html.twig', 
            ['tasks' => $taskRepository->findBy(['isDone' => 0])]
        );

    }


    /**
     * Display the list of tasks that have been completed
     *
     * @param TaskRepository $taskRepository
     * @return void
     */
    #[Route("/tasks/done", name: "task_done")]
    public function listDoneAction(TaskRepository $taskRepository)
    {
        return $this->render(
            'task/list.html.twig',
            ['tasks' => $taskRepository->findBy(['isDone' => 1])]
        );

    }


    /**
     * Manage the form & pages to create a task
     *
     * @param Request $request
     * @param TaskRepository $taskRepository
     * @return void
     */
    #[Route(path: "/tasks/create", name: "task_create")]
    public function createAction(Request $request, TaskRepository $taskRepository)
    {

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() === true && $form->isValid() === true) {
            $task->setAuthor($this->getUser());
            $taskRepository->save($task, true);
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);

    }


    /**
     * Manage the form & pages to edit a task
     *
     * @param Task $task
     * @param Request $request
     * @param TaskRepository $taskRepository
     * @return void
     */
    #[Route(path: "/tasks/{id}/edit", name: "task_edit")]
    #[IsGranted('TASK_MODIFY', subject: 'task')]
    public function editAction(Task $task, Request $request, TaskRepository $taskRepository)
    {

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() === true && $form->isValid() === true) {
            $taskRepository->save($task, true);
            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render(
            'task/edit.html.twig', 
            [
                'form' => $form->createView(),
                'task' => $task,
            ]
        );

    }


    /**
     * Manage the feature to change task status (done or not)
     *
     * @param Task $task
     * @param TaskRepository $taskRepository
     * @return void
     */
    #[Route(path: "/tasks/{id}/toggle", name: "task_toggle")]
    #[IsGranted('TASK_MODIFY', subject: 'task')]
    public function toggleTaskAction(Task $task, TaskRepository $taskRepository)
    {
        $task->toggle(!$task->isDone());
        $taskRepository->save($task, true);
        $this->addFlash(
            'success',
            sprintf(
                'La tâche %s a bien été marquée comme faite.',
                $task->getTitle()
            )
        );

        return $this->redirectToRoute('task_list');

    }


    /**
     * Manage the feature to delete a task
     *
     * @param Task $task
     * @param TaskRepository $taskRepository
     * @return void
     */
    #[Route(path: "/tasks/{id}/delete", name: "task_delete")]
    #[IsGranted('TASK_MODIFY', subject: 'task')]
    public function deleteTaskAction(Task $task, TaskRepository $taskRepository)
    {
        $taskRepository->remove($task, true);
        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');

    }


}
