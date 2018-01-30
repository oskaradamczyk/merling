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
class ProperMimeType extends Constraint
{
    public $message = 'core.media.proper_mime_type_invalid {{ valid }}';

    public function validatedBy()
    {
        return ProperMimeTypeValidator::class;
    }

}
