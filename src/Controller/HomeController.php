<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Determine if the navigation system should be rendered. Default True
        $renderNav = true;
        if(isset($_GET['nav']) && $_GET['nav'] == "false") {
          $renderNav = false;
        }

        return $this->render('container.html.twig', [
            'renderNav' => $renderNav
        ]);
    }
}
