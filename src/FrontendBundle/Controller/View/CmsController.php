<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace FrontendBundle\Controller\View;

use CoreBundle\Document\Cms;
use CoreBundle\Factory\CmsFactory;
use CoreBundle\Manager\CmsManager;
use CoreBundle\Manager\SiteAffiliationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CmsController
 * @package FrontendBundle\Controller\View
 */
class CmsController extends Controller
{
    /**
     * @param string $slug
     * @Route("/cms/{slug}", name="cms_view")
     * @return Response
     */
    public function CmsViewAction(string $slug)
    {
        /** @var CmsFactory $factory */
        $factory = $this->get(CmsFactory::class);

        /** @var CmsManager $manager */
        $manager = $factory->createManager(Cms::class);

        /** @var SiteAffiliationManager $affiliationManager */
        $affiliationManager = $this->get(SiteAffiliationManager::class);
        if ($cms = $manager->getFeatureForAffiliation(new ParameterBag([
            'slug' => $slug,
            'affiliation' => $affiliationManager->getCurrentAffiliation()
        ]))) {
            return $this->render('FrontendBundle:Cms:cms.html.twig', ['cms' => $cms]);
        }
        throw $this->createNotFoundException();
    }

    /**
     * @param string $slug
     * @Route("/cms-category/{slug}", name="cms_category_view")
     * @return Response
     */
    public function cmsCategoryViewAction(string $slug)
    {
        $data = [];
        return $this->render('FrontendBundle:Cms:cms.html.twig', ['data' => $data]);
    }

}
