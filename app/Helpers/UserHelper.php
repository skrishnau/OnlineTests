<?php

namespace App\Helpers;

use App\Models\User;

class UserHelper
{
    public static function isTeacher($user)
    {
        return $user && $user->role == 'teacher';
    }

    public static function isStudent($user)
    {
        return $user && $user->role == 'student';
    }

}