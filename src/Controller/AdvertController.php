<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Service\Antispam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/", name="advert", methods={"GET"})
     */
    public function index()
    {
        // Notre liste d'annonce en dur
        $adverts = [
            [
                'title'   => 'Recherche développpeur Symfony',
                'id'      => 1,
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date'    => new \Datetime()],
            [
                'title'   => 'Mission de webmaster',
                'id'      => 2,
                'author'  => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date'    => new \Datetime()],
            [
                'title'   => 'Offre de stage webdesigner',
                'id'      => 3,
                'author'  => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date'    => new \Datetime()]
        ];

        // Et modifiez le 2nd argument pour injecter notre liste
        return $this->render('advert/index.html.twig', [
            'adverts' => $adverts
        ]);
    }

    /**
     * @Route("/new", name="advert.new", methods={"GET", "POST"})
     */
    public function new(Request $request, Antispam $antispam)
    {
        $text = '...';

        if ($antispam->isSpam($text)) {
            throw new \Exception('Votre message a été détecté comme spam !');
        }

        return $this->redirectToRoute('advert');
    }

    /**
     * @Route("/{id}", name="advert.show", methods={"GET"})
     */
    public function show($id)
    {
        $advert = new Advert;
        $advert->setContent("Recherche développeur Symfony3.");

        return $this->render('advert/show.html.twig', [
            'advert' => $advert
        ]);
    }

    /**
     * @Route("/{id}/edit", name="advert.edit", methods={"GET", "PUT"})
     */
    public function edit($id)
    {
        // ...

        $advert = [
            'title'   => 'Recherche développpeur Symfony',
            'id'      => $id,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()
        ];

        return $this->render('advert/edit.html.twig', [
            'advert' => $advert
        ]);
    }

    /**
     * @Route("/{id}", name="advert.delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        return $this->render('advert/index.html.twig', [
            'controller_name' => 'AdvertController',
        ]);
    }
}
