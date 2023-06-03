<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Paper;
use App\Models\Question;
use App\Models\Exam;
use App\Models\Answer;
use App\Models\Course;
use App\Models\User;
use App\Models\Candidate;
use App\Helpers\CommonHelper;
use App\Helpers\ExamHelper;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show($examId)
    {
        $exam = Exam::find($examId);
        $linkUrl = ExamController::getExamUrl($exam->id, $exam->link_id);
        $candidates = Candidate::leftJoin('users', 'candidates.user_id', '=', 'users.id')
            ->where('exam_id', $examId)
            ->selectRaw('IF(users.id is null, candidates.name, users.name) as name, IF(users.id is null, candidates.email, users.email) as email, candidates.id, candidates.exam_id,candidates.start_datetime as startDatetime,candidates.end_datetime as endDatetime,
            (select sum(questions.marks) from answers inner join questions on answers.question_id = questions.id where answers.candidate_id = candidates.id and answers.is_correct = 1) as score')
            ->get();
        $exam->typeName = ExamHelper::getTakeTypes()->first(function($value, int $key) use($exam){
            return $value['id'] == $exam->type;
        })['text'];
        $exam->displayName = ExamHelper::getDisplayTypes()->first(function ($value, int $key) use ($exam){
            return $value['id'] == $exam->display;
        })['text'];
        return view('exam.show', compact('exam', 'linkUrl', 'candidates'));
    }
    
    function getExamUrl($examId, $linkId)
    {
        return route('answer.create', ['examId' => $examId, 'code'=> $linkId]); //CommonHelper::getBaseUrl() . '/exam/'. $linkId;
    }
    public function create($paperId)
    {
        $paper = Paper::find($paperId);
        $displayTypes = ExamHelper::getDisplayTypes();
        $takeTypes = ExamHelper::getTakeTypes();
        return view("exam.create", compact('paper', 'displayTypes', 'takeTypes'));
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
    // api
    public function getAllStudents($examId)
    {
        //return response()->json(['exam'=>$examId]);
        $users = User::leftJoin('candidates', function($join) use ($examId){
            $join->on('users.id', '=', 'candidates.user_id')
                ->where('candidates.exam_id', $examId);
            })
            ->where('users.role', 'student')
            ->selectRaw('users.id,users.name,users.email,IF(candidates.id is null, 0, 1) as isCandidate')
            ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Fetched',
            'data' => $users->toArray()
        ]);
    }
    public function addStudents(Request $request)
    {
        $data = $request->all();
        Candidate::where('exam_id', $data['examId'])->delete();
        $arr = [];
        foreach($data['students'] as $x => $val) {
            $arr[] = [
                'exam_id' => $data['examId'],
                'user_id' => $val
            ];
          }
        DB::table('candidates')->insert($arr);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully added!',
        ]);
        
    }

   
}
