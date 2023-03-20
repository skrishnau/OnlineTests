<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Paper;
use App\Models\Question;
use App\Models\Exam;
use App\Models\Answer;

class ExamController extends Controller
{
    //
    public function create($paperId)
    {
        $paper = Paper::where('id', $paperId)->first();
        if(!$paper){
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }
        $questions = Question::where('paper_id', $paper->id)
            ->orderBy('serial_number', 'asc')
            ->get();
        return view('exam.create', compact('paper', 'questions'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $exam = Exam::create([
            'candidate_name' => $data['candidateName'],
            'candidate_email' => $data['candidateEmail'],
            'paper_id' => $data['paperId'],
        ]);
        foreach($data['answers'] as $ans){
            $answerEntity = Answer::create([
                'exam_id' => $exam->id,
                'question_id' => $ans['questionId'],
                'selected_option_id' => isset($ans['optionId']) ? $ans['optionId'] : null,
                'answer_text' => isset($ans['optionId']) ? null : (isset($ans['answerText']) ? $ans['answerText'] : null)
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => "Submitted successfully!",
            'data' => [
                'redirectUrl' => route('exam.success')
            ]
        ]);
    }

}
