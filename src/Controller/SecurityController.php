<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function new(AuthorizationCheckerInterface $checker, AuthenticationUtils $authenticationUtils)
    {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($checker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('advert');
        }

        // Le service authentication_utils permet de récupérer le nom d'utilisateur
        // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
        // (mauvais mot de passe par exemple)

        return $this->render('security/new.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

//    /**
//     * @Route("/security", name="security.delete")
//     */
//    public function delete()
//    {
//        return $this->render('security/index.html.twig', [
//            'controller_name' => 'SecurityController',
//        ]);
//    }
}
