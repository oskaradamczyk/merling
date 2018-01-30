<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 06.10.17
 * Time: 21:52
 */

namespace AdminBundle\Security\Voter;

use CoreBundle\Entity\Group;
use CoreBundle\Entity\User;
use CoreBundle\Util\ActionTypeEnum;
use CoreBundle\Util\RoleEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    /** @var AccessDecisionManagerInterface */
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }


    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, ActionTypeEnum::getConstants())) {
            return false;
        }

        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case ActionTypeEnum::CREATE_TYPE:
                return $this->canCreate($token);
            case ActionTypeEnum::EDIT_TYPE:
                return $this->canEdit($subject, $token);
            case ActionTypeEnum::DELETE_TYPE:
                return $this->canDelete($token);
            case ActionTypeEnum::ROLE_TYPE:
                return $this->canManageRole($subject, $token);
            default:
                return false;
        }
    }

    /**
     * @param $subject
     * @param TokenInterface $token
     * @return bool
     */
    private function canEdit(User $subject, TokenInterface $token): bool
    {
        return ($this->decisionManager->decide($token, [RoleEnum::ADMIN]) || $subject === $token->getUser());
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    private function canCreate(TokenInterface $token): bool
    {
        return $this->decisionManager->decide($token, [RoleEnum::ADMIN]);
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    private function canDelete(TokenInterface $token): bool
    {
        return $this->decisionManager->decide($token, [RoleEnum::ADMIN]);
    }

    /**
     * @param User $subject
     * @param TokenInterface $token
     * @return bool
     */
    private function canManageRole(User $subject, TokenInterface $token)
    {
        $isAdmin = false;
        $isSuperAdmin = false;
        /** @var Group $group */
        foreach ($subject->getGroups() as $group) {
            if (in_array(RoleEnum::ADMIN, $group->getRoles())) {
                $isAdmin = true;
            }
            if (in_array(RoleEnum::SUPER_ADMIN, $group->getRoles())) {
                $isSuperAdmin = true;
            }
            if ($isAdmin && $isSuperAdmin) {
                break;
            }
        }
        return (
            $this->decisionManager->decide($token, [RoleEnum::SUPER_ADMIN]) ||
            $this->decisionManager->decide($token, [RoleEnum::ADMIN]) && !$isSuperAdmin && !$isAdmin
        );
    }
}
