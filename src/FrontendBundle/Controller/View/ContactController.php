<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 21.11.17
 * Time: 22:30
 */

namespace FrontendBundle\Controller\View;


use CoreBundle\Factory\MailFactory;
use CoreBundle\Form\MailType;
use CoreBundle\Model\Mail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @param Request $request
     * @Route("/contact", name="contact")
     * @Method("GET")
     * @return Response
     */
    public function contactAction(Request $request)
    {
        /** @var MailFactory $emailFactory */
        $mailFactory = $this->get(MailFactory::class);
        $mail = new Mail();
        $mailManager = $mailFactory->createManager(new Mail());
        $data = [];
        $data['form'] = $this->createForm(MailType::class)->createView();
        return $this->render('FrontendBundle:Contact:contact.html.twig', $data);
    }
}