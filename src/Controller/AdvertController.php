<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Repository\AdvertRepository;
use App\Service\Antispam;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(AdvertRepository $advertRepository, Request $request)
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 5);

        $adverts = $advertRepository->findAllPaginator($page, $limit);

        // Et modifiez le 2nd argument pour injecter notre liste
        return $this->render('advert/index.html.twig', [
            'adverts' => $adverts,
            'page' => $page,
            'pages' => ceil($adverts->count() / $limit),
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
    public function show(Advert $advert)
    {
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
    public function delete(Advert $advert, EntityManagerInterface $em)
    {
        foreach ($advert->getAdvertSkills() as $advertSkill) {
            $em->remove($advertSkill);
        }

        $em->remove($advert);

        $em->flush();

        return $this->redirectToRoute('advert');
    }
}
