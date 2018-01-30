<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 21.11.17
 * Time: 22:42
 */

namespace CoreBundle\Factory;


use CoreBundle\Manager\AbstractManagerInterface;
use CoreBundle\Manager\MailManager;
use CoreBundle\Model\AbstractObjectInterface;
use CoreBundle\Service\AbstractServiceInterface;
use CoreBundle\Service\MailService;

class MailFactory extends AbstractFactory
{
    /** @var \Swift_Mailer */
    private $mailer;

    /**
     * @param \Swift_Mailer $mailer
     * @return MailFactory
     */
    public function setMailer(\Swift_Mailer $mailer): self
    {
        $this->mailer = $mailer;
        return $this;
    }

    /**
     * @param string $modelClass
     * @return AbstractManagerInterface
     */
    public function createManager(string $modelClass): AbstractManagerInterface
    {
        return new MailManager($this->validator, $this->createService(), $modelClass);
    }

    /**
     * @return AbstractServiceInterface
     */
    public function createService(): AbstractServiceInterface
    {
        return new MailService($this->logger, $this->translator, $this->mailer);
    }


}