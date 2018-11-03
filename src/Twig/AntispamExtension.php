<?php

namespace App\Twig;

use App\Service\Antispam;

class AntispamExtension extends \Twig_Extension
{
    /**
     * @var Antispam
     */
    private $antispam;

    public function __construct(Antispam $antispam)
    {
        $this->antispam = $antispam;
    }

    public function checkIfArgumentIsSpam($text)
    {
        return $this->antispam->isSpam($text);
    }

    // Twig va exécuter cette méthode pour savoir quelle(s) fonction(s) ajoute notre service
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('checkIfSpam', [$this, 'checkIfArgumentIsSpam']),
        );
    }

    // todo: j'ai vue dans le cours d'OC qu'il était obligatoire d'ajouter la methode getName().
    //       tout marche bien sans, ce n'est peut etre plus obligatoire
}