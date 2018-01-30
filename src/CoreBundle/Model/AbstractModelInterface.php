<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 22.01.18
 * Time: 01:43
 */

namespace CoreBundle\Model;


/**
 * Interface AbstractModelInterface
 * @package CoreBundle\Model
 */
interface AbstractModelInterface extends AbstractObjectInterface, NameableModelInterface, IdentityModelInterface, TimestampableModelInterface, BlameableModelInterface
{

}
