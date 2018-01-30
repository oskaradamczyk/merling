<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 23.11.17
 * Time: 03:37
 */

namespace CoreBundle\Form;

use CoreBundle\Model\Mail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType as BaseEmailType;

/**
 * Class MailType
 * @package CoreBundle\Form
 */
class MailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => 'core.email.subject',
                'required' => true
            ])
            ->add('from', BaseEmailType::class, [
                'label' => 'core.email.from',
                'required' => true
            ])
            ->add('content', TextareaType::class, [
                'label' => 'core.email.content',
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'core.email.submit'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mail::class
        ]);
    }
}