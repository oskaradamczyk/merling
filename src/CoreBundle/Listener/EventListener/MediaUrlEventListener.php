<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CoreBundle\Listener\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use CoreBundle\Document\Image;

class MediaUrlEventListener
{

    /** @var  UploaderHelper */
    protected $uploaderHelper;

    /** @var  RequestStack */
    protected $requestStack;

    public function __construct(RequestStack $requestStack, UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
        $this->requestStack = $requestStack;
    }

    public function prePersist(\Doctrine\ODM\MongoDB\Event\LifecycleEventArgs $event)
    {
        dump('test');exit();
        if ($event->getObject() instanceof Image) {

            /** @var Image $image */
            $image = $event->getObject();

            if (!$image->getFile()) {
                return;
            }
            $request = $this->requestStack->getCurrentRequest();
            $image->setFileUrl(
                    $request->getSchemeAndHttpHost() .
                    $this->uploaderHelper->asset($image, 'file')
            );
        }
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        dump($event->getObject());exit();
        if ($event->getObject() instanceof Image) {

            /** @var Image $image */
            $image = $event->getObject();

            if (!$image->getFile()) {
                return;
            }
            $request = $this->requestStack->getCurrentRequest();
            $image->setFileUrl(
                    $request->getSchemeAndHttpHost() .
                    $this->uploaderHelper->asset($image, 'file')
            );
        }
    }

}
