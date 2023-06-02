<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Manage login form
     *
     * @param AuthenticationUtils $authenticationUtils param
     *
     * @return Response
     */
    #[Route(path: "/login", name: "login")]
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() === true) {
            return $this->redirectToRoute('homepage');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );

    }


    /**
     * Check login
     *
     * @return void
     */
    #[Route(path: "/login_check", name: "login_check")]
    public function loginCheck()
    {
        // This code is never executed.

    }


    /**
     * Check logout
     *
     * @return void
     */
    #[Route(path: "/logout", name: "logout")]
    public function logoutCheck()
    {
        // This code is never executed.

    }


}
