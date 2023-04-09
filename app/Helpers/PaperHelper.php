<?php

namespace App\Helpers;

use App\Models\Paper;

class PaperHelper
{
    public static function getAllPapers()
    {
        return Paper::select('id', 'name')//, 'start_datetime as startDatetime', 'end_datetime as endDatetime', 'duration_in_mins as durationInMins')
                ->get();
    }


}