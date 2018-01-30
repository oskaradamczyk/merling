<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace AdminBundle\Admin;

use CoreBundle\Document\CmsCategory;
use CoreBundle\Document\Page;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollection;
use CoreBundle\Document\Cms;
use CoreBundle\Document\Media;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use CoreBundle\Entity\Site;
use CoreBundle\Entity\SiteGroup;
use CoreBundle\Document\Gallery;

/**
 * Class CmsAdmin
 * @package AdminBundle\Admin
 */
class PageAdmin extends CmsAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper->remove('category');
    }

    protected function updateGalleries($object, bool $isPersist = false)
    {
    }

    /**
     * @param Page $object
     */
    public function preRemove($object)
    {
    }
}
