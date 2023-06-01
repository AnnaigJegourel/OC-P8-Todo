<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * Render homepage
     *
     * @return void
     */
    #[Route(path: "/", name: "homepage")]
    public function indexAction()
    {
        return $this->render('default/index.html.twig');

    }


}
