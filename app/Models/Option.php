<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $guarded = [];
    //protected $fillable = ['question_id', 'description', 'serial_number', 'is_correct']; 

}
