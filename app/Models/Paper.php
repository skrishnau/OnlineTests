<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'start_datetime', 'duration_in_mins'];
    public function questions() {
    	return $this->hasMany(\App\Models\Question::class);
    }
}
