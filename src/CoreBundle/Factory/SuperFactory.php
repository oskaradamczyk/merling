<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 02.11.17
 * Time: 01:21
 */

namespace CoreBundle\Factory;


use CoreBundle\Util\Enum;
use CoreBundle\Util\StringHumanizer;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SuperFactory
{
    use Enum;

    const USER_FACTORY_TYPE = 'user';
    const CONFIG_FACTORY_TYPE = 'config';
    const MAIL_FACTORY_TYPE = 'mail';
    const CMS_FACTORY_TYPE = 'cms';
    const CATEGORY_FACTORY_TYPE = 'category';
    const LOGO_FACTORY_TYPE = 'logo';
    const FAVICON_FACTORY_TYPE = 'favicon';
    const SITE_FACTORY_TYPE = 'site';
    const SITE_GROUP_FACTORY_TYPE = 'site_group';

    /** @var EntityManagerInterface */
    private static $em;

    /** @var DocumentManager */
    private static $dm;

    /** @var EventDispatcherInterface */
    private static $eventDispatcher;

    /** @var TranslatorInterface */
    private static $translator;

    /** @var ValidatorInterface */
    private static $validator;

    /** @var LoggerInterface */
    private static $logger;

    /** @var RequestStack */
    private static $requestStack;

    /**
     * SuperFactory constructor.
     * @param TranslatorInterface $translator
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @param DocumentManager $dm
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface $logger
     * @param RequestStack $requestStack
     */
    public function __construct(
        TranslatorInterface $translator,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        DocumentManager $dm,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger,
        RequestStack $requestStack
    )
    {
        self::$em = $em;
        self::$dm = $dm;
        self::$eventDispatcher = $eventDispatcher;
        self::$translator = $translator;
        self::$validator = $validator;
        self::$logger = $logger;
        self::$requestStack = $requestStack;
    }

    public static function createFactory(string $factoryType)
    {
        $factoryType = StringHumanizer::deHumanize($factoryType);
        $factoryClass = sprintf('CoreBundle\\Factory\\%sFactory', ucfirst($factoryType));
        $entityClassName = sprintf('CoreBundle\\Entity\\%s', ucfirst($factoryType));
        $documentClassName = sprintf('CoreBundle\\Document\\%s', ucfirst($factoryType));
        if (class_exists($entityClassName) && class_exists($documentClassName)) {
            throw new MappingException(sprintf('Model classes "%s" doubled for documents and entities.', ucfirst($factoryType)));
        }
        $om = self::$em;
        if (!class_exists($entityClassName)) {
            $om = self::$dm;
        }
        $factory = new $factoryClass($om, self::$eventDispatcher, self::$translator, self::$validator, self::$logger);
        if ($factory instanceof SiteAffiliationAwareInterface) {
            $factory->setRequestStack(self::$requestStack);
        }
        return $factory;
    }
}
