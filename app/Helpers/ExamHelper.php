<?php

namespace App\Helpers;

use App\Models\Paper;

use Illuminate\Support\Collection;

class ExamHelper
{
    public static function getTakeTypes()
    {
        return collect 
        ([
            ['id' => 1, 'text' => 'Anonymous'],
            ['id' => 2, 'text' => 'Authorized']
        ]);
    }
    public static function getDisplayTypes()
    {
        return collect
        ([
            ['id'=> 1, 'text' => 'All Question in a Single Page'],
            ['id'=> 2, 'text' => 'One Question at a time'],
            ['id'=> 3, 'text' => 'Grouping. One Question at a time'],
        ]);
    }


}