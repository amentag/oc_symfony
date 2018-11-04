<?php

namespace App\Subscriber;

use App\Event\MessagePostEvent;
use App\Event\PlatformEvents;
use App\Service\MessageNotificator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MessageSubscriber implements EventSubscriberInterface
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

    public static function getSubscribedEvents()
    {
        return [
            PlatformEvents::POST_MESSAGE => 'processMessage',
            PlatformEvents::POST_OTHER_EVENT => 'otherMethod',
        ];
    }

    public function processMessage(MessagePostEvent $event)
    {
        // todo
    }

    public function otherMethod()
    {
        // todo
    }
}