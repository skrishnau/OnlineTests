<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Candidate;
use App\Models\Answer;
use App\Models\Paper;

class AnswerController extends Controller
{
    public function create($examId, Request $request)
    {
        $show = $request->input('show');
        
        $isPreview = false;
        // NOTE: in case of examination we should not show breadcrumbs and other links of the site
        $showBreadCrumbs = true;
        $exam = null;
        $paper = null;
        if($show == null){
            $exam = Exam::where('id', $examId)->first();
            if(!$exam){
                $message = 'Not found!';
                return view('layout.error', compact('message'));
            }
            // its an exam (not a preview)
            if($exam->start_datetime == null){
                $message = 'This exam has not been started yet.';
                return view('layout.error', compact('message'));    
            }
            if($exam->end_datetime !== null){
                $message = 'This exam has already ended.';
                return view('layout.error', compact('message'));    
            }
            // NOTE: if it's an actual exam then there must be 'code' param present in the url 
            if($exam->link_id != $request->input('code')){
                $message = 'Not found!';
                return view('layout.error', compact('message'));  
            }
            $paper = $exam->paper;
            // don't show breadcrumbs
            $showBreadCrumbs = false;
        } else if($show == 'preview') {
            // its a preview
            $isPreview = true;
            $paper = Paper::find($request->input("paperId"));
            $exam = new Exam;
            $exam->name = "Sample Exam";
            $exam->display = 1;
            $exam->type = 1;
        } else {
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }
        $questions = Question::where('paper_id', $paper->id)
            ->orderBy('serial_number', 'asc')
            ->get();
        return view('answer.create', compact('exam', 'paper', 'questions', 'isPreview', 'showBreadCrumbs'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $exam = Exam::find($data['examId']);
        if(!$exam){
            return response()->json([
                'status' => 'error',
                'message' => "Not found!"
            ]);
        }
        $candidate = null;
        // TODO: registered users
        if($exam->type == 1){
            // anonymous
            $candidate = Candidate::create([
                'candidate_name' => $data['candidateName'],
                'candidate_email' => $data['candidateEmail'],
                'exam_id' => $data['examId'],
            ]);
        } else {
            // user id is available in the login session, get candidate from the session
        }
        
        foreach($data['answers'] as $ans){
            $isCorrect = isset($ans['optionId']) 
                ? Option::where('id', $ans['optionId'])->where('is_correct', 1)->count() > 0
                : null;
            $answerEntity = Answer::create([
                'candidate_id' => $candidate->id,
                'question_id' => $ans['questionId'],
                'selected_option_id' => isset($ans['optionId']) ? $ans['optionId'] : null,
                'answer_text' => isset($ans['optionId']) ? null : (isset($ans['answerText']) ? $ans['answerText'] : null),
                'is_correct' => $isCorrect
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => "Submitted successfully!",
            'data' => [
                'redirectUrl' => route('answer.success', $data['paperId'])
            ]
        ]);
    }
    
    public function success($examId)
    {
        $exam = Exam::where('id', $examId)->first();
        if(!$exam){
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }
        return view('answer.success', compact('exam'));
    }
}
