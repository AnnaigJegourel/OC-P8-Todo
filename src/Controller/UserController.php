<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * Display the list of all app users
     *
     * @param UserRepository $userRepository param
     * @return void
     */
    #[Route(path: "/users", name: "user_list")]
    public function listAction(UserRepository $userRepository)
    {
        return $this->render(
            'user/list.html.twig',
            [
                'users' => $userRepository->findAll()
            ]
        );

    }


    /**
     * Manage the form & pages to create a user
     *
     * @param Request                     $request param
     * @param UserRepository              $userRepositoryn param
     * @param UserPasswordHasherInterface $passwordHasher param
     * @return void
     */
    #[Route(path: "/users/create", name: "user_create")]
    public function createAction(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() === true && $form->isValid() === true) {
            $plaintextPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);

            $roles = [$form->get('roles')->getData()];
            $user->setRoles($roles);

            $userRepository->save($user, true);
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);

    }


    /**
     * Manage the form & pages to edit a user profile
     *
     * @param User                        $user param
     * @param Request                     $request param
     * @param UserRepository              $userRepository param
     * @param UserPasswordHasherInterface $passwordHasher param
     * @return void
     */
    #[Route(path: "/users/{id}/edit", name: "user_edit")]
    public function editAction(User $user, Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() === true && $form->isValid() === true) {
            $plaintextPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);

            $roles = [$form->get('roles')->getData()];
            $user->setRoles($roles);

            $userRepository->save($user, true);
            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);

    }


}
