<?php

namespace App\Controller;

use App\Repository\AdvertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdvertMenuController extends AbstractController
{
    /**
     * @Route("/advert/menu", name="advert_menu")
     */
    public function index(AdvertRepository $advertRepository)
    {
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !
        $adverts = $advertRepository->findBy([], [], 3);

        return $this->render('advert_menu/index.html.twig', [
            // Tout l'intérêt est ici : le contrôleur passe
            // les variables nécessaires au template !
            'adverts' => $adverts
        ]);
    }
}
