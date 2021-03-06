<?php

namespace App\Listener;

use App\Service\BetaHTMLAdder;
use DateTime;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class BetaListener
{
    /**
     * @var BetaHTMLAdder
     */
    private $betaHTMLAdder;

    /**
     * @var DateTime
     */
    private $endDate;

    public function __construct(BetaHTMLAdder $betaHTMLAdder, string $endDate)
    {
        $this->betaHTMLAdder = $betaHTMLAdder;
        $this->endDate = new DateTime($endDate);
    }

    // le nom de la méthode doit correspondre au nom de l'événement sur lequel le listener écoute
    // ex: event: kernel.response => method; onKernelResponse
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $today = new DateTime('today');

        if ($today > $this->endDate) {
            return;
        }

        $remainingDays = $today->diff($this->endDate)->days;

        $response = $event->getResponse();

        $content = $this->betaHTMLAdder->prepend($response->getContent(), $remainingDays);

        $response->setContent($content);
    }
}