<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 06.01.18
 * Time: 16:48
 */

namespace FrontendBundle\Twig;


use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Manager\SiteAffiliationManager;
use CoreBundle\Manager\SiteGroupManager;
use CoreBundle\Manager\SiteManager;

class SiteAffiliationManagerExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /** @var SiteAffiliationManager */
    private $affiliationManager;

    /**
     * SiteAffiliationManagerExtension constructor.
     * @param SiteAffiliationManager $affiliationManager
     */
    public function __construct(SiteAffiliationManager $affiliationManager)
    {
        $this->affiliationManager = $affiliationManager;
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        $globals = [];
        /** @var Site|SiteGroup $affiliation */
        if (($affiliation = $this->affiliationManager->getCurrentAffiliation())) {
            $globals = [
                'logo' => $affiliation->getLogo(),
                'favicon' => $affiliation->getFavicon(),
                'theme_color' => $affiliation->getThemeColor(),
                'secondary_color' => $affiliation->getSecondaryColor()
            ];
        }
        return $globals;
    }
}
