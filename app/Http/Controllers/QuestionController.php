<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Paper;
use App\Models\Question;

class QuestionController extends Controller
{
    public function create($paperId)
    {
        $paper = Paper::where('id', $paperId)->first();

        return view('question.create', compact('paper'));
    }

    public function store()
    {
        

    }
}
