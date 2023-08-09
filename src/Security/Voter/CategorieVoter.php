<?php

namespace App\Security\Voter;

use App\Entity\Categorie;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CategorieVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const DELETE = 'POST_DELETE';
    private $security;

    public function __construct( SecurityBundleSecurity $security
    ) {
        $this->security= $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Categorie) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN')) return true;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            
            case self::EDIT:
                // logic to determine if the user can VIEW
                return $this->canedit();
                break;
            case self::DELETE:
                // logic to determine if the user can VIEW
                return $this->candelete();
                break;
        }

        return false;
    }
    private function canedit(){
        return $this->security->isGranted('ROLE_GESTIONNAIRESTOCK');
    }
    private function candelete(){
        return $this->security->isGranted('ROLE_GESTIONNAIRESTOCK');
    }
}