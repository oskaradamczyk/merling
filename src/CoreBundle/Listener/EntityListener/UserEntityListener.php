<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace CoreBundle\Listener\EntityListener;

use CoreBundle\Entity\Config;
use CoreBundle\Entity\User;
use CoreBundle\Factory\SuperFactory;
use CoreBundle\Service\MailService;
use CoreBundle\Util\UniqueHashGenerator;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class UserEntityListener
 * @package CoreBundle\Listener\EntityListener
 */
class UserEntityListener
{

//    /** @var  RequestStack */
//    private $requestStack;
//
//    /** @var EmailService */
//    private $emailService;
//
//    /** @var TranslatorInterface */
//    private $translator;
//
//    /** @var SuperFactory */
//    private $superFactory;
//
//    /** @var string */
//    private $defaultLocale;
//
//    /**
//     * UserEntityListener constructor.
//     * @param RequestStack $requestStack
//     * @param EmailService $emailService
//     * @param TranslatorInterface $translator
//     * @param ConfigFactory $configFactory
//     * @param string $defaultLocale
//     */
//    public function __construct(
//        RequestStack $requestStack,
//        EmailService $emailService,
//        TranslatorInterface $translator,
//        ConfigFactory,
//        string $defaultLocale
//    )
//    {
//        $this->requestStack = $requestStack;
//        $this->emailService = $emailService;
//        $this->defaultLocale = $defaultLocale;
//        $this->translator = $translator;
//        $this->superFactory = $superFactory;
//    }
//
//    /**
//     * @param User $user
//     * @param LifecycleEventArgs $event
//     */
//    public function prePersist(User $user, LifecycleEventArgs $event)
//    {
//        $user->setConfirmationToken(UniqueHashGenerator::generateRandomBase64Hash());
//    }
//
//    /**
//     * @param User $user
//     * @param LifecycleEventArgs $event
//     */
//    public function postPersist(User $user, LifecycleEventArgs $event)
//    {
//        $config = new Config();
//        $config
//            ->setUser($user)
//            ->setLocale($this->defaultLocale)
//            ->setName($this->translator->trans('admin.config.default', [], null, $this->defaultLocale));
//        $this->
//    }
}
