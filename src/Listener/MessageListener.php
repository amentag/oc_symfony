<?php

namespace App\Listener;

use App\Event\MessagePostEvent;
use App\Service\MessageNotificator;

class MessageListener
{
    /**
     * @var MessageNotificator
     */
    private $notificator;
    private $listUsers;

    public function __construct(MessageNotificator $notificator, $listUsers)
    {
        $this->notificator = $notificator;
        $this->listUsers = $listUsers;
    }

    public function processMessage(MessagePostEvent $event)
    {
        if (!in_array($event->getUser()->getUsername(), $this->listUsers)) {
            return;
        }

        $this->notificator->notifyByEmail($event->getMessage(), $event->getUser());
    }
}