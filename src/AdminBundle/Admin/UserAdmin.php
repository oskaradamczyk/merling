<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace AdminBundle\Admin;

use CoreBundle\Entity\Config;
use CoreBundle\Entity\Group;
use CoreBundle\Entity\User;
use CoreBundle\Util\ActionTypeEnum;
use CoreBundle\Util\RoleEnum;
use CoreBundle\Util\UniqueHashGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * SonataAdmin class for User model.
 *
 * @author oadamczyk
 */
class UserAdmin extends CustomAbstractAdmin
{
    /** @var AuthorizationChecker */
    private $authorizationChecker;

    /** @var UserManagerInterface */
    private $userManager;

    /**
     * @return \Symfony\Component\Form\FormBuilder
     */
    public function getFormBuilder()
    {
        $this->formOptions['data_class'] = $this->getClass();
        /** @var User $user */
        $user = $this->getSubject();
        $options = $this->formOptions;
        if (!$user || !$this->id($user)) {
            $options['validation_groups'] = ['Create'];
        }
        $formBuilder = $this->getFormContractor()->getFormBuilder($this->getUniqid(), $options);
        $this->defineFormBuilder($formBuilder);
        return $formBuilder;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var User $user */
        $user = $this->getSubject();
        /** @var User $authUser */
        $authUser = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $hasAccess = $this->authorizationChecker->isGranted(ActionTypeEnum::CREATE_TYPE, $user);
        $formMapper
            ->add('username')
            ->add('email', 'email')
            ->add('plainPassword', 'hidden', ['empty_data' => UniqueHashGenerator::generateRandomSha1Hash()]);
        if ($this->id($user)) {
            $hasAccess = $this->authorizationChecker->isGranted(ActionTypeEnum::EDIT_TYPE, $user);
            if ($user === $authUser) {
                $formMapper
                    ->remove('plainPassword')
                    ->add('plainPassword', RepeatedType::class, [
                        'type' => PasswordType::class,
                        'invalid_message' => 'admin.fos_user.create.password_confirmation_invalid',
                        'required' => false,
                        'first_options' => ['label' => 'admin.fos_user.password'],
                        'second_options' => ['label' => 'admin.fos_user.password_confirmation']
                    ]);
            }
        }
        if (!$hasAccess) {
            throw new AccessDeniedException('Access denied.');
        }

        $roles = RoleEnum::getConstants();
        if (!$this->authorizationChecker->isGranted(RoleEnum::SUPER_ADMIN, $authUser)) {
            if (($key = array_search(RoleEnum::SUPER_ADMIN, $roles)) !== false) {
                unset($roles[$key]);
            }
            if (($key = array_search(RoleEnum::ADMIN, $roles)) !== false) {
                unset($roles[$key]);
            }
        }
        $hasAccess = $this->authorizationChecker->isGranted(ActionTypeEnum::ROLE_TYPE, $user);
        if ($hasAccess) {
            $formMapper->add('groups', null, [
                'by_reference' => false,
                'multiple' => true,
                'required' => true,
                'query_builder' => function (EntityRepository $er) use ($roles) {
                    $qb = $er->createQueryBuilder('g');
                    foreach ($roles as $key => $role) {
                        $qb
                            ->orWhere('g.roles LIKE :role_' . $key)
                            ->setParameter('role_' . $key, '%' . $role . '%');
                    }
                    return $qb;

                }
            ]);
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('createdAt')
            ->add('createdBy');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        /** @var User $user */
        $user = new User();
        $listMapper
            ->add('username');
        parent::configureListFields($listMapper);
        $listMapper
            ->remove('name')
            ->remove('_action')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => ['template' => 'AdminBundle:CRUD/User:list__action_edit.html.twig'],
                ]
            ]);
        if (!$this->authorizationChecker->isGranted(ActionTypeEnum::DELETE_TYPE, $user)) {
            $listMapper
                ->remove('_action')
                ->add('_action', 'actions', [
                    'actions' => [
                        'show' => [],
                        'edit' => ['template' => 'AdminBundle:CRUD/User:list__action_edit.html.twig'],
                    ]
                ]);
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username')
            ->add('email')
            ->add('groups');
        parent::configureShowFields($showMapper);
        $showMapper->remove('name');
    }

    /**
     * @return UserManagerInterface
     */
    public function getUserManager(): UserManagerInterface
    {
        return $this->userManager;
    }

    /**
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param AuthorizationChecker $authorizationChecker
     */
    public function setAuthorizationChecker(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @return AuthorizationChecker
     */
    public function getAuthorizationChecker(): AuthorizationChecker
    {
        return $this->authorizationChecker;
    }
}
