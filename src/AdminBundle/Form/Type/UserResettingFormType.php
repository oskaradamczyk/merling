<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 11.11.17
 * Time: 02:46
 */

namespace AdminBundle\Form\Type;


use FOS\UserBundle\Form\Type\ResettingFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class UserResettingFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => false,
                'attr' => [
                    'placeholder' => 'admin.fos_user.password',
                    'class' => 'form-control'
                ]
            ],
            'second_options' => [
                'label' => false,
                'attr' => [
                    'placeholder' => 'admin.fos_user.password_confirmation',
                    'class' => 'form-control'
                ]
            ],
            'invalid_message' => 'core.fos_user.create.password_confirmation_invalid',
        ]);
    }

    public function getParent()
    {
        return ResettingFormType::class;
    }

    public function getBlockPrefix()

    {
        return 'admin_user_resetting_form_type';
    }

    public function getName()

    {
        return $this->getBlockPrefix();
    }
}