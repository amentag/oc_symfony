<?php

namespace App\Service;

class Antispam
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, $locale)
    {
        $this->mailer = $mailer;
    }

    /**
   * Vérifie si le texte est un spam ou non
   *
   * @param string $text
   * @return bool
   */
  public function isSpam($text)
  {
    return strlen($text) < 5;
  }
}