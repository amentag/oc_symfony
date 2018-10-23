<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdvertController
 * @package App\Controller
 *
 * @Route("/advert")
 */
class AdvertController extends AbstractController
{
    /**
     * @Route("/", name="advert")
     */
    public function index()
    {
        return $this->render('advert/index.html.twig', [
            'controller_name' => 'AdvertController',
        ]);
    }

    /**
     * @Route("/new", name="advert.new")
     */
    public function new()
    {
        return $this->render('advert/index.html.twig', [
            'controller_name' => 'AdvertController',
        ]);
    }

    /**
     * @Route("/{id}", name="advert.show")
     */
    public function show()
    {
        return $this->render('advert/index.html.twig', [
            'controller_name' => 'AdvertController',
        ]);
    }
}
