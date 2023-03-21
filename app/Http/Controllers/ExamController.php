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
    public function create($paperId, Request $request)
    {
        $show = $request->input('show');
        $paper = Paper::where('id', $paperId)->first();
        if(!$paper){
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }
        $isPreview = false;
        if($show == null){
            // its an exam (not a preview)
            if($paper->start_datetime == null){
                $message = 'This exam has not been started yet.';
                return view('layout.error', compact('message'));    
            }
            if($paper->end_datetime !== null){
                $message = 'This exam has already ended.';
                return view('layout.error', compact('message'));    
            }
            // NOTE: if it's an actual exam then there must be 'code' param present in the url 
            if($paper->link_id != $request->input('code')){
                $message = 'Not found!';
                return view('layout.error', compact('message'));  
            }
        } else if($show == 'preview') {
            // its a preview
            $isPreview = true;
        } else {
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }
        $questions = Question::where('paper_id', $paper->id)
            ->orderBy('serial_number', 'asc')
            ->get();
        return view('exam.create', compact('paper', 'questions', 'isPreview'));
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
                'redirectUrl' => route('exam.success', $data['paperId'])
            ]
        ]);
    }

    public function success($paperId)
    {
        $paper = Paper::where('id', $paperId)->first();
        if(!$paper){
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }
        return view('exam.success', compact('paper'));
    }

}
