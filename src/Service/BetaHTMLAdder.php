<?php

namespace App\Service;

use Twig\Environment;

class BetaHTMLAdder
{
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function prepend(string $content, int $remainingDays)
    {
        return str_replace(
            '<body>',
            '<body>' . $this->environment->render('beta.html.twig', ['remainingDays' => $remainingDays]),
            $content
        );
    }
}