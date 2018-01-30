<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 09.10.17
 * Time: 04:28
 */

namespace AdminBundle\Security\Voter;

use CoreBundle\Entity\Config;
use CoreBundle\Util\ActionTypeEnum;
use CoreBundle\Util\RoleEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ConfigVoter extends Voter
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

        if (!$subject instanceof Config) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case ActionTypeEnum::EDIT_TYPE:
                return $this->canEdit($subject, $token);
            default:
                return false;
        }
    }

    /**
     * @param $subject
     * @param TokenInterface $token
     * @return bool
     */
    private function canEdit(Config $subject, TokenInterface $token): bool
    {
        return ($this->decisionManager->decide($token, [RoleEnum::STAFF]) && $subject->getUser() === $token->getUser());
    }
}