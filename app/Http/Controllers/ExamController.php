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
        $linkUrl = ExamController::getExamUrl($exam->id, $exam->link_id);
        $candidates = Candidate::where('exam_id', $examId)
            ->get();
        return view('exam.show', compact('exam', 'linkUrl', 'candidates'));
    }
    
    function getExamUrl($examId, $linkId)
    {
        return route('answer.create', ['examId' => $examId, 'code'=> $linkId]); //CommonHelper::getBaseUrl() . '/exam/'. $linkId;
    }
    public function create($paperId)
    {
        $paper = Paper::find($paperId);
        return view("exam.create", compact('paper'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        //$paper = Paper::find($data['paperId']);
        // if(isset($paper->start_datetime)){
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'This paper\'s exam has already been started! Reload!'
        //     ]);
        // }
        
        // // TODO: also store deadline, exam-duration inputs

        $course = null;
        if(isset($data['courseId'] )){
            $course = Course::first($data['courseId']);
        } else {
            $course = Course::firstOrCreate([
                'name' => $data['course']
            ]);
        }
        
        $linkId = null;
        while(!$linkId) {
            $linkId = CommonHelper::generateRandomString();
            if(Exam::where('link_id', $linkId)->count() > 0){
                $linkId = null;
            }
        }

        $exam = Exam::create([
            'course_id' => $course->id,
            'paper_id' => $data['paperId'],
            'type' => $data['type'],
            'display' => $data['display'],
            //'start_datetime' => Carbon::now(),
            'end_datetime' => null,
            'duration_in_mins' => isset($data['durationInMins']) ? $data['durationInMins'] : null,
            'link_id' => $linkId
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => "Created successfully!",
            'data' => [
                'startDatetime' => $exam->start_datetime,
                'redirectUrl' => route("paper.show", ['id' => $data['paperId']])
            ]
        ]);
    }

    public function startTest(Request $request)
    {
        $data = $request->all();
        $exam = Exam::find($data['examId']);
        if(isset($exam->start_datetime)){
            return response()->json([
                'status' => 'error',
                'message' => 'This exam has already started! Reload!'
            ]);
        }
        $exam->start_datetime = Carbon::now();
        $exam->save();
        
        return response()->json([
            'status' => 'success',
            'message' => "Started successfully!",
            'data' => [
                'startDatetime' => $exam->start_datetime,
            ]
        ]);
    }
    
    public function endTest(Request $request)
    {
        $data = $request->all();
        $exam = Exam::find($data['examId']);
        if(isset($exam->end_datetime)){
            return response()->json([
                'status' => 'error',
                'message' => 'This paper\'s exam has already ended! Reload!'
            ]);
        }
        $exam->end_datetime = Carbon::now();
        $exam->save();
        
        return response()->json([
            'status' => 'success',
            'message' => "Ended successfully!",
            'data' => [
                'endDatetime' => $exam->end_datetime,
            ]
        ]);
    }


}
