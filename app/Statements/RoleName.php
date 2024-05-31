<?php

namespace App\Statements;

use ReflectionClass;

class RoleName
{
    const TEACHER = 'teacher';

    const STUDENT = 'student';

    const ADMIN = 'admin';

    public static function getRoles()
    {
        $oClass = new ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }
}
