<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace AdminBundle\Admin;

use CoreBundle\Entity\Config;
use CoreBundle\Util\ActionTypeEnum;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * SonataAdmin class for Config model.
 *
 * @author oadamczyk
 */
class ConfigAdmin extends CustomAbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var Config $config */
        $config = $this->getSubject();
        /** @var AuthorizationChecker $authorizationChecker */
        $authorizationChecker = $this->getConfigurationPool()->getContainer()->get('security.authorization_checker');
        if (!$authorizationChecker->isGranted(ActionTypeEnum::EDIT_TYPE, $config)) {
            throw new AccessDeniedException('Access denied.');
        }
        parent::configureFormFields($formMapper);
        $formMapper
            ->tab('admin.main')
            ->add('locale', ChoiceType::class, [
                'choices' => $this->getLanguageChoices()
            ])
            ->end()
            ->end();
    }

    /**
     * @return \Generator
     */
    private function getLanguageChoices()
    {
        $languages = $this->getConfigurationPool()->getContainer()->getParameter('core.languages');
        foreach ($languages as $language) {
            yield $language => $language;
        }
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['edit']);
    }

    /**
     * @param Config $object
     */
    public function postUpdate($object)
    {
        /** @var SessionInterface $session */
        $session = $this->getConfigurationPool()->getContainer()->get('session');
        $session->set('_locale', $object->getLocale());
    }
}
