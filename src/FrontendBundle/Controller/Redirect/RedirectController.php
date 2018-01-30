<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 30.09.17
 * Time: 15:03
 */

namespace FrontendBundle\Controller\Redirect;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Frontend default views controller
 *
 * @author oadamczyk
 *
 */
class RedirectController extends Controller
{

    /**
     * @Route("/", name="index_redirect")
     * @return Response
     */
    public function indexAction()
    {
        return new RedirectResponse($this->generateUrl('homepage'));
    }

}