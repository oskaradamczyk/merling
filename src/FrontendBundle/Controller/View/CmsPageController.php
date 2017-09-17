<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FrontendBundle\Controller\View;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ODM\MongoDB\DocumentManager;
use CoreBundle\Document\CmsPage;

/**
 * CMS pages views controller
 *
 * @author oadamczyk
 */
class CmsPageController extends Controller
{

    /**
     * @Route("/cms/{slug}", name="cms_page")
     * @return Response
     */
    public function cmsPageAction($slug)
    {
        $data = [];
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $cmsPageRepository = $dm->getRepository(CmsPage::class);
        $data['content'] = $cmsPageRepository->findOneBy(['slug' => $slug]);
        return $this->render('FrontendBundle:CmsPage:cms_page.html.twig', ['data' => $data]);
    }

}
