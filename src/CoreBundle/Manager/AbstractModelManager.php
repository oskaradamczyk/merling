<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.11.17
 * Time: 22:58
 */

namespace CoreBundle\Manager;


use CoreBundle\Model\AbstractModelInterface;
use CoreBundle\Model\AbstractObjectInterface;
use CoreBundle\Service\AbstractServiceInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractModelManager
 * @package CoreBundle\Manager
 */
abstract class AbstractModelManager extends AbstractManager implements AbstractModelManagerInterface
{
    /** @var ObjectManager */
    protected $om;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var ObjectRepository */
    protected $modelRepository;

    /**
     * AbstractModelManager constructor.
     * @param ValidatorInterface $validator
     * @param AbstractServiceInterface $service
     * @param ObjectManager $om
     * @param EventDispatcherInterface $eventDispatcher
     * @param string $modelClass
     */
    public function __construct(
        ValidatorInterface $validator,
        AbstractServiceInterface $service,
        ObjectManager $om,
        EventDispatcherInterface $eventDispatcher,
        string $modelClass
    )
    {
        parent::__construct($validator, $service, $modelClass);
        $this->om = $om;
        $this->modelRepository = $om->getRepository($modelClass);
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param AbstractModelInterface $model
     */
    public function save(AbstractModelInterface $model): void
    {
        $this->om->persist($model);
        $this->om->flush();
    }

    /**
     * @param Collection $models
     */
    public function saveMany(Collection $models): void
    {
        /** @var AbstractModelInterface $model */
        foreach ($models as $model) {
            $this->om->persist($model);
        }
        $this->om->flush();
    }

    /**
     * @param AbstractModelInterface $model
     */
    public function remove(AbstractModelInterface $model): void
    {
        $this->om->remove($model);
        $this->om->flush();
    }

    /**
     * @param Collection $models
     */
    public function removeMany(Collection $models): void
    {
        /** @var AbstractModelInterface $model */
        foreach ($models as $model) {
            $this->om->remove($model);
        }
        $this->om->flush();
    }

    /**
     * @return ObjectRepository
     */
    public function getModelRepository(): ObjectRepository
    {
        return $this->modelRepository;
    }
}
