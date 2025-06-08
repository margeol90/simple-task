<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tasks')]
final class TaskController extends AbstractController
{
    #[Route('', name: 'task_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $tasks = $em->getRepository(Task::class)->findBy(
            ['deleted_at' => null],
            ['updated_at' => 'DESC']
        );

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('', name: 'task_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $title = $request->request->get('title');

        if (!empty($title)) {
            $task = new Task();
            $task->setTitle($title);
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'Task created successfully!');
        }

        return $this->redirectToRoute('task_index');

    }

    #[Route('/{id}/toggle', name: 'task_toggle', methods: ['POST'])]
    public function toggle(Task $task, EntityManagerInterface $em): Response
    {
        if(!$task->isDone()) {
            $task->setIsDone(true);
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'Task status updated successfully!');
        }


        return $this->redirectToRoute('task_index');
    }

    #[Route('/{id}/delete', name: 'task_delete', methods: ['POST'])]
    public function delete(Task $task, EntityManagerInterface $em): Response
    {
        $task->setDeletedAt(new \DateTime());
        $em->persist($task);
        $em->flush();

        $this->addFlash('error', 'Task deleted successfully!');

        return $this->redirectToRoute('task_index');
    }
}
