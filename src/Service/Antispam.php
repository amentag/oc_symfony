<?php

namespace App\Service;

class Antispam
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    private $locale;
    /**
     * @var int
     */
    private $limit;

    public function __construct(\Swift_Mailer $mailer, int $limit)
    {
        $this->mailer = $mailer;
        $this->limit = $limit;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
   * Vérifie si le texte est un spam ou non
   *
   * @param string $text
   * @return bool
   */
  public function isSpam($text)
  {
    return strlen($text) < $this->limit;
  }
}