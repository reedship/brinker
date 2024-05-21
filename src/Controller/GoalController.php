<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\GoalRepository;
use App\Entity\BrinkerUser;
use App\Entity\Goal;
use App\Form\GoalFormType;
use Symfony\Component\Security\Core\User\UserInterface;

class GoalController extends AbstractController
{
    #[Route('/user_goals', name: 'user_goals')]
    public function index(GoalRepository $repository, UserInterface $user): Response
    {
        if (!$user instanceof BrinkerUser) {
            throw $this->createAccessDeniedException('You must be logged in to access goals');
        }

        $goals = $repository->findGoalsByUser($user);
        return $this->render('goal/index.html.twig', [
            'goals' => $goals,
        ]);
    }

    #[Route('/user_goals/new', name: 'new_goal')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        $goal = new Goal();
        $goal->setUser($user);
        $form = $this->createForm(GoalFormType::class, $goal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($goal);
            $entityManager->flush();
            return $this->redirectToRoute('user_goals');
        }

        return $this->render('goal/new.html.twig', [
            'goalForm' => $form,
        ]);
    }

    #[Route('/user_goals/{id}', name: 'show_goal')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $goal = $entityManager->getRepository(Goal::class)->find($id);
        if (!$goal) {
            throw $this->createNotFoundException('No goal found for id '.$id);
        }
        return $this->render('goal/show.html.twig', [
            'goal' => $goal,
        ]);
    }

    #[Route('/user_goals/{id}/delete', name: 'delete_goal')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $goal = $entityManager->getRepository(Goal::class)->find($id);
        if (!$goal) {
            throw $this->createNotFoundException('No goal found for id '.$id);
        }
        $entityManager->remove($goal);
        $entityManager->flush();
        return $this->redirectToRoute('user_goals');
    }

    #[Route('/user_goals/{id}/edit', name: 'edit_goal')]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $goal = $entityManager->getRepository(Goal::class)->find($id);
        if (!$goal) {
            throw $this->createNotFoundException('No goal found for id '.$id);
        }
        $form = $this->createForm(GoalFormType::class, $goal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('show_goal', ['id'=> $goal->getId()]);
        }
        return $this->render('goal/edit.html.twig', [
            'goal' => $goal,
            'form' => $form
        ]);
    }

    private function createDeleteForm(Goal $goal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_goal', ['id' => $goal->getId()]))
            ->setMethod('POST')
            ->getForm();
    }
}
