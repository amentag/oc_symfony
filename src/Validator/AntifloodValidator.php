<?php

namespace App\Validator;

use DateTime;
use App\Repository\AdvertRepository;
use App\Validator\Constraint\Antiflood;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AntifloodValidator extends ConstraintValidator
{
    /**
     * @var AdvertRepository
     */
    private $advertRepository;

    public function __construct(AdvertRepository $advertRepository)
    {
        $this->advertRepository = $advertRepository;
    }

    /**
     * @param DateTime $value
     * @param Constraint|Antiflood $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $last = $this->advertRepository->findOneBy([], ['date' => 'desc']);

        /** @var DateTime $date */
        $date = $last->getDate();

        $value->sub(new \DateInterval('PT15M'));

        // Pour l'instant, on considère comme flood tout message de moins de 3 caractères
        if ($date > $value) {
            // C'est cette ligne qui déclenche l'erreur pour le formulaire, avec en argument le message de la contrainte
            $this->context->addViolation($constraint->message);
        }
    }
}