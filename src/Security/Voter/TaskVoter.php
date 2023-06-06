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
        return in_array($attribute, [self::MODIFY])
            && $subject instanceof \App\Entity\Task;

    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // If the user is anonymous, do not grant access.
        if ($user instanceof UserInterface === false) {
            return false;
        }

        // Check conditions and return true to grant permission.
        switch ($attribute) {
            case self::MODIFY:

                // L'auteur peut modifier uniquement ses propres tâches.
                if ($user === $subject->getAuthor()) {
                    return true;
                }

                // Une tâche sans auteur (affiché 'anonyme') peut être modifiée uniquement par un/e admin.
                if ($subject->getAuthor() === null && $this->security->isGranted('ROLE_ADMIN') === true) {
                    return true;
                }
                break;
        }

        return false;

    }


}
