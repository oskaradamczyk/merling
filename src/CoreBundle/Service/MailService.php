<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 07.11.17
 * Time: 01:01
 */

namespace CoreBundle\Service;

use CoreBundle\Model\Mail;
use Psr\Log\LoggerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MailService extends AbstractService implements MailServiceInterface
{
    /** @var \Swift_Mailer */
    private $mailer;

    /**
     * EmailService constructor.
     * @param LoggerInterface $logger
     * @param TranslatorInterface $translator
     * @param \Swift_Mailer $mailer
     */
    public function __construct(LoggerInterface $logger, TranslatorInterface $translator, \Swift_Mailer $mailer)
    {
        parent::__construct($logger, $translator);
        $this->mailer = $mailer;
    }

    public function send(Mail $email)
    {
        return true;
        //TODO
    }
}