<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdvertMenuController extends AbstractController
{
    /**
     * @Route("/advert/menu", name="advert_menu")
     */
    public function index()
    {
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !
        $adverts = [
            ['id' => 2, 'title' => 'Recherche développeur Symfony'],
            ['id' => 5, 'title' => 'Mission de webmaster'],
            ['id' => 9, 'title' => 'Offre de stage webdesigner']
        ];

        return $this->render('advert_menu/index.html.twig', [
            // Tout l'intérêt est ici : le contrôleur passe
            // les variables nécessaires au template !
            'adverts' => $adverts
        ]);
    }
}
