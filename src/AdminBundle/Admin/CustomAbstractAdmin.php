<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace AdminBundle\Admin;

use CoreBundle\Document\DocumentAbstractModel;
use CoreBundle\Entity\EntityAbstractModel;
use CoreBundle\Model\AbstractModelInterface;
use CoreBundle\Util\RecursiveInheritanceChecker;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use CoreBundle\Document\Traits\SeoFriendlyDocument;
use CoreBundle\Entity\Traits\SeoFriendlyEntity;

/**
 * Abstract sonata admin service to avoid code repetition
 *
 * @author oadamczyk
 */
abstract class CustomAbstractAdmin extends AbstractAdmin
{
    /** @var array */
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt',
    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('admin.main')
            ->with('admin.base_options')
            ->add('name', null, ['required' => false])
            ->end()
            ->end();
        if (RecursiveInheritanceChecker::recursiveIsImplementing(new \ReflectionClass($this->getSubject()), SeoFriendlyDocument::class, SeoFriendlyEntity::class)) {
            $formMapper
                ->tab('admin.seo')
                ->add('title', null, ['required' => false])
                ->add('metaKeywords', null, [
                    'required' => false,
                    'help' => 'admin.seo.help'
                ])
                ->add('metaDescription', 'textarea', ['required' => false])
                ->end()
                ->end();
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('createdBy');
        $class = $this->getClass();
        $reflection = new \ReflectionClass($class);
        if (!$reflection->isAbstract() && !(new $class() instanceof DocumentAbstractModel)) {
            $datagridMapper
                ->add('createdAt', 'doctrine_orm_date_range', ['field_type' => 'sonata_type_datetime_range_picker']);
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('createdAt')
            ->add('createdBy')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('createdAt')
            ->add('createdBy');
        if (RecursiveInheritanceChecker::recursiveIsUsing(new \ReflectionClass($this->getSubject()), SeoFriendlyDocument::class, SeoFriendlyEntity::class)) {
            $showMapper
                ->add('title', null, ['required' => false])
                ->add('metaKeywords', null, [
                    'required' => false,
                    'help' => 'admin.seo.help'
                ])
                ->add('metaDescription', 'textarea', ['required' => false]);
        }
    }
}
