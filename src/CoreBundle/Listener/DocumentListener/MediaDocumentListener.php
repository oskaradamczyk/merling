<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Listener\DocumentListener;

use CoreBundle\Document\Media;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class MediaDocumentListener
 * @package CoreBundle\Listener\DocumentListener
 */
class MediaDocumentListener
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

    public function postLoad(LifecycleEventArgs $event)
    {
        if ($event->getObject() instanceof Media) {
            /** @var Media $media */
            $media = $event->getObject();
            if (!$media->getName()) {
                return false;
            }
            $this->getUrlForFiles($media);
        }

        return true;
    }

    private function getUrlForFiles(Media $media)
    {
        $media->setFileUrl(
            $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost() .
            $this->uploaderHelper->asset($media, 'file')
        );
    }
}
