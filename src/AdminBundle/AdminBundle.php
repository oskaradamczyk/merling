<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 01.09.17
 * Time: 06:56
 */

namespace AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Description of AdminBundle
 *
 * @author oadamczyk
 */
class AdminBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
