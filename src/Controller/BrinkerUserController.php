<?php

namespace App\Controller;

use App\Entity\BrinkerUser;
use App\Form\BrinkerUserType;
use App\Service\ApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class BrinkerUserController extends AbstractController
{

    #[Route('/profile', name: 'profile')]
    public function profile(UserInterface $user): Response
    {
        if (!$user instanceof BrinkerUser) {
            throw $this->createNotFoundException('User not found.');
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/edit_user', name: 'edit_user')]
    public function edit(Request $request, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        if (!$user instanceof BrinkerUser) {
            throw $this->createNotFoundException('User not found.');
        }
        $form = $this->createForm(BrinkerUserType::class, $user, [
            'validation_groups' => ['Default', 'edit'],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/delete_user', name: 'delete_user')]
    public function delete(Request $request, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        if (!$user instanceof BrinkerUser) {
            throw $this->createNotFoundException('User not found.');
        }
        $this->container->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_logout');
    }
}
