<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 23.11.17
 * Time: 03:01
 */

namespace CoreBundle\Service;

use CoreBundle\Model\Mail;

interface MailServiceInterface
{
    /**
     * @param Mail $email
     * @return mixed
     */
    public function send(Mail $email);
}