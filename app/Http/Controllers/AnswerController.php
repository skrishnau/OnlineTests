<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Candidate;
use App\Models\Answer;
use App\Models\Paper;
use App\Models\Option;

use App\Helpers\ExamHelper;
use App\Helpers\UserHelper;

class AnswerController extends Controller
{
    public function create($examId, Request $request)
    {
        $dt = date('Y-m-d H:i:s');
        $show = $request->input('show');
        
        $isPreview = false;
        $isAnswer = false;
        // NOTE: in case of examination we should not show breadcrumbs and other links of the site
        $showBreadCrumbs = true;
        $exam = null;
        $paper = null;
        $candidateId = $request->input('candidateId');
        $candidate = new Candidate;
        if(UserHelper::isStudent(Auth::user())){
            $candidate = Candidate::where('exam_id', $examId)->where('user_id', Auth::user()->id)
                ->first();
                     
        // var_dump($candidate->exam->end_datetime);
        // return;
            if($candidate){
                if(isset($candidate->end_datetime) || (isset($candidate->exam->end_datetime) && $candidate->exam->end_datetime < $dt)){
                    $show = 'answer';
                    $candidateId = $candidate->id;
                    $examId = '0';
                }
            }else {
                $candidate = new Candidate;
            }
        }
        
        

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
            if($exam->type == ExamHelper::AUTHORIZED && Auth::user()->role != 'student'){
                return view('layout.unauthorized');
            }
            if($exam->type == ExamHelper::AUTHORIZED ){
                $candidate = Candidate::where('exam_id', $examId)
                    ->where('user_id', Auth::user()->id)
                    ->first();
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
        } else if($show == 'answer'){
            $isAnswer = true;
            $candidate = Candidate::find($candidateId);
            $exam = $candidate->exam;
            $paper = $exam->paper;
            $showBreadCrumbs = false;
        } else {
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }

       


        $questions = Question::where('paper_id', $paper->id);
        if($show == 'answer'){
            $questions = $questions->leftJoin('answers', 'questions.id', '=', 'answers.question_id')
            ->where('answers.candidate_id', $candidateId)
            ->select('questions.*', 'answers.candidate_id', 'answers.selected_option_id', 'answers.is_correct', 'answers.answer_text')
            ->get()
            ;
        } else {
            $questions = $questions->orderBy('serial_number', 'asc')
            ->get();
        }
        
        return view('answer.create', compact('exam', 'paper', 'candidate', 'questions', 'isPreview', 'isAnswer', 'showBreadCrumbs'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $exam = Exam::find($data['examId']);
        $dt = date('Y-m-d H:i:s');
        if(!$exam){
            return response()->json([
                'status' => 'error',
                'message' => "Not found!"
            ]);
        }
        $candidate = null;
        if($exam->type == 1 && !isset($data['candidateId'])){
            // anonymous
            $candidate = Candidate::create([
                'name' => $data['candidateName'],
                'email' => $data['candidateEmail'],
                'exam_id' => $data['examId'],
                'start_datetime'=> $data['startDatetime']
            ]);
        } else if(isset($data['candidateId'])){
            // user id is available in the login session, get candidate from the session
            $candidate = Candidate::find($data['candidateId']);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "No access!",
            ]);
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

        $candidate->end_datetime = $dt;
        $candidate->save();

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
        if(Auth::check()){
            return redirect()->route("home");
        }
        return view('answer.success', compact('exam'));
    }

    public function start(Request $request)
    {
        $examId = $request->input('examId');
        $exam = Exam::where('id', $examId)->first();
        if(!$exam){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found!",
            ]);
        }
        $dt = date('Y-m-d H:i:s');
        if($exam->type == ExamHelper::AUTHORIZED && Auth::check()){
            $candidate = Candidate::where('exam_id', $examId)
                ->where('user_id', Auth::user()->id)
                ->first();
            if(!$candidate){
                return response()->json([
                    'status' => 'error',
                    'message' => "You don't have access to this exam!",
                ]);
            }
            if(!isset($candidate->start_datetime)){
                $candidate->start_datetime = $dt;
                $candidate->save();
                //$candidate->update('start_datetime', date('Y-m-d H:i:s'));
            } 
            return response()->json([
                'status' => 'success',
                'message' => "Started",
                'data' => [
                    'startDatetime' => $dt
                ]
            ]);
            
        }else if($exam->type == ExamHelper::ANONYMOUS){
            return response()->json([
                'status' => 'success',
                'message' => "Started",
                'data' => [
                    'startDatetime' => $dt
                ]
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => "Access Denied!",
        ]);

    }
}
