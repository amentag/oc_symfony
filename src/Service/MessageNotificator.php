<?php

namespace App\Service;

use Symfony\Component\Security\Core\User\UserInterface;

class MessageNotificator
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notifyByEmail($message, UserInterface $user)
    {
        $message = (new \Swift_Message())
            ->setSubject("Nouveau message d'un utilisateur surveillé")
            ->setFrom('admin@votresite.com')
            ->setTo('mentaga.developer@gmail.com')
            ->setBody("L'utilisateur surveillé '".$user->getUsername()."' a posté le message suivant : '".$message."'")
        ;

        $this->mailer->send($message);
    }
}