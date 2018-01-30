<?php
/**
 * Created by PhpStorm.
 * User: oadamczyk
 * Date: 07.10.17
 * Time: 01:37
 */

namespace CoreBundle\Util;

/**
 * Action types for f.e. security voters.
 */
class ActionTypeEnum
{
    use Enum;

    const CREATE_TYPE   = 'create';
    const EDIT_TYPE     = 'edit';
    const VIEW_TYPE     = 'view';
    const DELETE_TYPE   = 'delete';
    const ROLE_TYPE     = 'role';
}