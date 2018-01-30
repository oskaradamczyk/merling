<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 29.09.17
 * Time: 16:41
 */

namespace CoreBundle\Validator\Constraints;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ProperMimeTypeValidator extends ConstraintValidator
{
    /**
     * @param UploadedFile $uploadedFile
     * @param Constraint $constraint
     */
    public function validate($uploadedFile, Constraint $constraint)
    {
        $allowedMimeTypes = $this->context->getObject()->getAllowedMimeTypes();
        $valid = implode(", ", $allowedMimeTypes);
        if (
            ($uploadedFile instanceof UploadedFile) &&
            !in_array($uploadedFile->getClientMimeType(), $allowedMimeTypes)
        ) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ valid }}', $valid)
                ->addViolation();
        }
    }
}
