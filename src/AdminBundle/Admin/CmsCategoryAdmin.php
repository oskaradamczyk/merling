<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 30.11.17
 * Time: 01:09
 */

namespace AdminBundle\Admin;


use CoreBundle\Document\CmsCategory;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * SonataAdmin class for CmsCategory model.
 *
 * @author oadamczyk
 */
class CmsCategoryAdmin extends CategoryAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('admin.main')
            ->add('parentCategory', 'sonata_type_model', [
                'class' => CmsCategory::class,
                'required' => false,
                'btn_add' => false
            ])
            ->reorder(['site', 'siteGroup', 'parentCategory']);
        parent::configureFormFields($formMapper);
    }
}