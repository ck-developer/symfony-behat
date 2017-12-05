<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function home()
    {
        return $this->render('Page/home.html.twig');
    }
}
