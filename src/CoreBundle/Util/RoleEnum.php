<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 08.10.17
 * Time: 19:08
 */

namespace CoreBundle\Util;

class RoleEnum
{
    use Enum;

    const SUPER_ADMIN   = 'ROLE_SUPER_ADMIN';
    const ADMIN         = 'ROLE_ADMIN';
    const STAFF         = 'ROLE_STAFF';
    const GUEST         = 'ROLE_GUEST';
}