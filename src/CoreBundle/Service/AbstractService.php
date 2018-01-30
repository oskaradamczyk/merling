<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 07.11.17
 * Time: 01:01
 */

namespace CoreBundle\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractService implements AbstractServiceInterface
{
    /** @var LoggerInterface */
    protected $logger;

    /** @var TranslatorInterface */
    protected $translator;

    /**
     * AbstractService constructor.
     * @param LoggerInterface $logger
     * @param TranslatorInterface $translator
     */
    public function __construct(LoggerInterface $logger, TranslatorInterface $translator)
    {
        $this->logger = $logger;
        $this->translator = $translator;
    }

    public function log(string $message): void
    {
        $this->logger->error($message);
    }

    public function translate(string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        return $this->translator->trans($id, $parameters, $domain, $locale);
    }
}