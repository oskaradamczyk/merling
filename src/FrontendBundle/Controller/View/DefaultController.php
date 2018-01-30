<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace FrontendBundle\Controller\View;

use CoreBundle\Document\Gallery;
use CoreBundle\Manager\SiteManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Frontend default views controller
 *
 * @author oadamczyk
 *
 */
class DefaultController extends Controller
{

    /**
     * @param Request $request
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction(Request $request)
    {
        /** @var RouterInterface $router */
        $router = $this->get('router');
//        dump($this->get(SiteManager::class));exit;
//        echo $request->getBaseUrl(); echo '@test';exit;
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $data['data'] = 'test';
        return $this->render('FrontendBundle:Default:homepage.html.twig', $data);
    }

}
