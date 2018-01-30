<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.11.17
 * Time: 22:57
 */

namespace CoreBundle\Factory;

use CoreBundle\Model\AbstractModelInterface;
use CoreBundle\Service\AbstractServiceInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractFactory implements AbstractFactoryInterface
{
    /** @var ObjectManager */
    protected $om;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var ValidatorInterface */
    protected $validator;

    /** @var TranslatorInterface */
    protected $translator;

    /** @var LoggerInterface */
     protected $logger;

    /**
     * AbstractFactory constructor.
     * @param ObjectManager $om
     * @param EventDispatcherInterface $eventDispatcher
     * @param TranslatorInterface $translator
     * @param ValidatorInterface $validator
     * @param LoggerInterface $logger
     *
     */
    public function __construct(
        ObjectManager $om,
        EventDispatcherInterface $eventDispatcher,
        TranslatorInterface $translator,
        ValidatorInterface $validator,
        LoggerInterface $logger
    )
    {
        $this->om = $om;
        $this->eventDispatcher = $eventDispatcher;
        $this->translator = $translator;
        $this->validator = $validator;
        $this->logger = $logger;
    }
}