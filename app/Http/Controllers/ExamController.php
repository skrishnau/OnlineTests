<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Paper;
use App\Models\Question;

class ExamController extends Controller
{
    //
    public function create($paperId)
    {
        $paper = Paper::where('id', $paperId)->first();
        $questions = Question::where('paper_id', $paper->id)
            ->orderBy('serial_number', 'asc')
            ->get();
        return view('exam.create', compact('paper', 'questions'));
    }

}
