<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Manager\DocumentManager;

use CoreBundle\Manager\AbstractManager;

/**
 * Manager for CMS page model
 *
 * @author oadamczyk
 */
class CmsPageManager extends AbstractManager
{

    protected $currentSite;

    public function setCurrentSite(Site $site): self
    {
        $this->currentSite = $site;
        return $this;
    }

}
