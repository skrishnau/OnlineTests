<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Paper;
use App\Models\Question;
use App\Models\Exam;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Candidate;
use App\Helpers\CommonHelper;

class ExamController extends Controller
{
    public function show($examId)
    {
        $exam = Exam::find($examId);
        $linkUrl = ExamController::getExamUrl($exam->paper->id, $exam->link_id);
        $candidates = Candidate::where('exam_id', $examId)
            ->get();
        return view('exam.show', compact('exam', 'linkUrl', 'candidates'));
    }
    
    function getExamUrl($paperId, $linkId)
    {
        return route('exam.create', ['paperId' => $paperId, 'code'=> $linkId]); //CommonHelper::getBaseUrl() . '/exam/'. $linkId;
    }
    public function create($paperId)
    {
        $paper = Paper::find($paperId);
        return view("exam.create", compact('paper'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $paper = Paper::find($data['paperId']);
        if(isset($paper->start_datetime)){
            return response()->json([
                'status' => 'error',
                'message' => 'This paper\'s exam has already been started! Reload!'
            ]);
        }
        
        // $paper->start_datetime = Carbon::now();
        // // TODO: also store deadline, exam-duration inputs
        // $paper->save();
        $course = null;
        if(isset($data['courseId'] )){
            $course = Course::first($data['courseId']);
        } else {
            $course = Course::firstOrCreate([
                'name' => $data['course']
            ]);
        }
        

        $exam = Exam::create([
            'course_id' => $course->id,
            'paper_id' => $data['paperId'],
            'type' => $data['type'],
            //'start_datetime' => Carbon::now(),
            'end_datetime' => null,
            'duration_in_mins' => isset($data['durationInMins']) ? $data['durationInMins'] : null,
            'link_id' => CommonHelper::generateRandomString()
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => "Started successfully!",
            'data' => [
                'startDatetime' => $paper->start_datetime,
                'redirectUrl' => route("paper.show", ['paperId' => $data['paperId']])
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
