<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoter extends Voter
{
    public const MODIFY = 'TASK_MODIFY';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::MODIFY])
            && $subject instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::MODIFY:
                // L'auteur peut modifier uniquement ses propres tâches.
                if ($user === $subject->getAuthor()) {
                    return true;
                }
                // Une tâche sans auteur (affiché 'anonyme') peut être modifiée uniquement par un/e admin.
                if($subject->getAuthor() === null && $this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }
                break;
            // case self::DELETE:
                // logic to determine if the user can VIEW
                // return true or false
                // break;
        }

        return false;
    }
}
