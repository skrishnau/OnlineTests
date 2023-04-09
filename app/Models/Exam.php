<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function questions() {
    	return $this->hasMany(\App\Models\Answer::class);
    }

    public function paper()
    {
        return $this->belongsTo(\App\Models\Paper::class);
    }
    
    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class);
    }
}
