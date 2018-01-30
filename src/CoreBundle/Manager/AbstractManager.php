<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.11.17
 * Time: 22:59
 */

namespace CoreBundle\Manager;

use CoreBundle\Model\AbstractObjectInterface;
use CoreBundle\Service\AbstractServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractManager implements AbstractManagerInterface
{
    /** @var ValidatorInterface */
    protected $validator;

    /** @var AbstractServiceInterface */
    protected $service;

    /** @var string */
    protected $modelClass;

    /**
     * AbstractManager constructor.
     * @param ValidatorInterface $validator
     * @param AbstractServiceInterface|null $service
     * @param string $modelClass
     */
    public function __construct(
        ValidatorInterface $validator,
        AbstractServiceInterface $service,
        string $modelClass
    )
    {
        $this->validator = $validator;
        $this->service = $service;
        $this->modelClass = $modelClass;
    }

    /**
     * @param AbstractObjectInterface $model
     * @return Collection
     */
    public function validate(AbstractObjectInterface $model): Collection
    {
        $errors = new ArrayCollection();
        foreach ($this->validator->validate($model) as $error) {
            $errors->add($error);
        }
        return $errors;
    }

    /**
     * @return AbstractServiceInterface
     */
    public function getService(): AbstractServiceInterface
    {
        return $this->service;
    }
}