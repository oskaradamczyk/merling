<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 29.09.17
 * Time: 16:41
 */

namespace CoreBundle\Validator\Constraints;

use CoreBundle\Factory\SuperFactory;
use CoreBundle\Manager\AbstractModelManagerInterface;
use CoreBundle\Model\OnePerSiteInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class OnePerSiteValidator extends ConstraintValidator
{
    /** @var RouterInterface */
    private $router;

    /** @var SuperFactory */
    private $factory;

    /**
     * OnePerSiteValidator constructor.
     * @param SuperFactory $factory
     * @param RouterInterface $router
     */
    public function __construct(SuperFactory $factory, RouterInterface $router)
    {
        $this->router = $router;
        $this->factory = $factory;
    }

    /**
     * @param OnePerSiteInterface $model
     * @param Constraint $constraint
     */
    public function validate($model, Constraint $constraint)
    {
        $class = get_class($model);
        if (!in_array($model->getType(), SuperFactory::getConstants())) {
            throw new \InvalidArgumentException(sprintf('%s model type is invalid for %s validation.', $class, OnePerSiteInterface::class));
        }
        /** @var AbstractModelManagerInterface $manager */
        $manager = $this->factory::createFactory($model->getType())->createManager($class);
        $mRepo = $manager->getModelRepository();
        if (
            ($model->getSite() && ($alreadyExisting = $mRepo->findOneBy(['siteId' => (string)$model->getSite()->getId()])) && $alreadyExisting !== $model)
            || ($model->getSiteGroup() && ($alreadyExisting = $mRepo->findOneBy(['siteGroupId' => (string)$model->getSiteGroup()->getId()])) && $alreadyExisting !== $model)
        ) {
            $url = $this->router->generate(
                sprintf('admin_core_%s_edit', $model->getType()),
                ['id' => $alreadyExisting->getId()],
                Router::ABSOLUTE_URL
            );
            $name = $alreadyExisting->getName();
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ model }}', sprintf('<a href="%s" title="%s">%s</a>', $url, $name, $name))
                ->addViolation();
        }
    }
}
