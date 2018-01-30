<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 29.09.17
 * Time: 16:39
 */

namespace CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class OnePerSite extends Constraint
{
    public $message = 'core.one_per_site.create.site_or_site_group_already_occupied {{ model }}';

    public function validatedBy()
    {
        return OnePerSiteValidator::class;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
