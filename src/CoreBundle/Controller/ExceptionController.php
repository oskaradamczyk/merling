<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 07.01.18
 * Time: 01:11
 */

namespace CoreBundle\Controller;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController as AbstractController;

/**
 * Class ExceptionController
 * @package Symfony\Bundle\TwigBundle\Controller
 */
class ExceptionController extends AbstractController
{
    /**
     * @param Request $request
     * @param FlattenException $exception
     * @param DebugLoggerInterface|null $logger
     * @return Response
     */
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        $currentContent = $this->getAndCleanOutputBuffering($request->headers->get('X-Php-Ob-Level', -1));
        $showException = $request->attributes->get('showException', $this->debug);

        $code = $exception->getStatusCode();

        return new Response(
            $this->twig->render($this->findTemplate($request, $request->getRequestFormat(), $code, $showException), [
                    'status_code' => $code,
                    'status_text' => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                    'exception' => $exception,
                    'logger' => $logger,
                    'currentContent' => $currentContent,
                ]
            )
        );
    }

    /**
     * @param Request $request
     * @param string $format
     * @param int $code
     * @param bool $showException
     * @return string
     */
    protected function findTemplate(Request $request, $format, $code, $showException)
    {
        $name = $showException ? 'exception' : 'error';
        if ($showException && 'html' == $format) {
            $name = 'exception_full';
            return sprintf('@Twig/Exception/%s.html.twig', $name);
        }

        if (!$showException) {
            $template = sprintf('CoreBundle:Exception:%s%s.%s.twig', $name, $code, $format);
            if ($this->templateExists($template)) {
                return $template;
            }
        }

        $template = sprintf('CoreBundle:Exception:%s.%s.twig', $name, $format);
        if ($this->templateExists($template)) {
            return $template;
        }

        $request->setRequestFormat('html');

        return sprintf('CoreBundle:Exception:%s.html.twig', $showException ? 'exception_full' : $name);
    }
}
