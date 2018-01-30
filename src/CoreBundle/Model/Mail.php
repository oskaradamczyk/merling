<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 02.11.17
 * Time: 03:51
 */

namespace CoreBundle\Model;


use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Mail
 * @package CoreBundle\Model
 */
class Mail implements AbstractObjectInterface
{
    /**
     * @var string
     * @Assert\NotBlank
     */
    private $receiver;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $content;

    /** @var array */
    private $data;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $subject;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $from;

    /**
     * @return string
     */
    public function getReceiver(): string
    {
        return $this->receiver;
    }

    /**
     * @param string|null $receiver
     * @return Mail
     */
    public function setReceiver($receiver): Mail
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return Mail
     */
    public function setContent($content): Mail
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return Mail
     */
    public function setData(array $data): Mail
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     * @return Mail
     */
    public function setSubject($subject): Mail
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @return Mail|null
     */
    public function setFrom($from): Mail
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $result = '';
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator(get_object_vars($this))) as $var) {
            $result .= (string)$var;
            $result .= ', ';
        }
        return $result;
    }
}