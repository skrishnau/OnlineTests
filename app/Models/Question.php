<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['paper_id', 'serial_number', 'description', 'type', 'tag', 'group']; //'id', 

    public function options() {
    	return $this->hasMany(\App\Models\Option::class);
    }
}
