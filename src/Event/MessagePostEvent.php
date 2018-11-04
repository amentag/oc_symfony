<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class MessagePostEvent extends Event
{
    private $message;

    /**
     * @var UserInterface|User
     */
    private $user;

    public function __construct($message, UserInterface $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return UserInterface|User
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }
}