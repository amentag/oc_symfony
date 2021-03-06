<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Event\MessagePostEvent;
use App\Event\PlatformEvents;
use App\Form\AdvertEditType;
use App\Form\AdvertType;
use App\Repository\AdvertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function new(Request $request, EntityManagerInterface $em, UploadableManager $uploadableManager, EventDispatcherInterface $eventDispatcher)
    {
        $advert = new Advert();
        $form = $this->createForm(AdvertType::class, $advert);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $advert->getImage();

            if ($image->getFile() instanceof UploadedFile) {
                $uploadableManager->markEntityToUpload($image, $image->getFile());
            }

            $event = new MessagePostEvent($advert->getContent(), $advert->getAuthor());

            // On déclenche l'évènement
            $eventDispatcher->dispatch(PlatformEvents::POST_MESSAGE, $event);

            // On récupère ce qui a été modifié par le ou les listeners, ici le message
            $advert->setContent($event->getMessage());

            $em->persist($advert);
            $em->flush();

            $this->addFlash('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('advert.show', ['id' => $advert->getId()]);
        }

        return $this->render('advert/new.html.twig', [
            'form' => $form->createView()
        ]);
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
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_AUTHOR')", message="Accès limité aux admins et auteurs.")
     * https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/security.html
     */
    public function edit(Advert $advert, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AdvertEditType::class, $advert, [
            'method' => Request::METHOD_PUT
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('notice', 'Annonce bien modifiée.');

            return $this->redirectToRoute('advert.show', ['id' => $advert->getId()]);
        }

        return $this->render('advert/edit.html.twig', [
            'advert' => $advert,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="advert.delete", methods={"DELETE"})
     * @Security("has_role('ROLE_ADMIN')", message="Accès limité aux admins.")
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
