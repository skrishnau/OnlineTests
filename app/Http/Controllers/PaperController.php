<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Paper;
use App\Models\Question;
use App\Models\Exam;
use App\Helpers\CommonHelper;


class PaperController extends Controller
{
    //
    public function index()
    {
        $papers = Paper::
                select('id', 'name')//, 'start_datetime as startDatetime', 'end_datetime as endDatetime', 'duration_in_mins as durationInMins')
                ->get();
        return view('paper.index', compact('papers'));
    }
    
    public function show($id)//Paper $paper
    {
        $paper = Paper::where('id', $id)
            ->first();
        if(!$paper){
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }
        $linkUrl = PaperController::getExamUrl($paper->id, $paper->link_id);
        $questions = Question::where('paper_id', $paper->id)
            ->orderBy('serial_number', 'asc')
            ->get();
        $canEdit = $paper->start_datetime == null;
        return view('paper.show', compact('paper', 'questions', 'linkUrl', 'canEdit'));
    }

    function getExamUrl($paperId, $linkId)
    {
        return route('exam.create', ['paperId' => $paperId, 'code'=> $linkId]); //CommonHelper::getBaseUrl() . '/exam/'. $linkId;
    }
    
    public function create()
    {
        $paper = null;
        return view('paper.create', compact('paper'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:papers|max:255',
        ]);

        $isEditMode = CommonHelper::isEditMode($data["id"]);
        if($validator->fails()){
            if($isEditMode){
                return redirect()
                    ->route('paper.edit', $data['id'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                return redirect('paper/create')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        
        if($isEditMode){
            $paper = Paper::updateOrCreate(
                ['id' => $data["id"]],
                [
                    "name" => $data["name"],
                ]
            );
        } else {
            // $linkId = null;
            // while(!$linkId) {
            //     $linkId = CommonHelper::generateRandomString();
            //     if(Paper::where('link_id', $linkId)->count() > 0){
            //         $linkId = null;
            //     }
            // }
            $paper = Paper::create([
                "name" => $data["name"],
                //'link_id' => $linkId
            ]);
        }
        return redirect()->route('paper.show', $paper->id);
        //return redirect()->route('paper.index');
    }

    public function edit($id)
    {
        $paper = Paper::find($id);
        if($paper) {
            return view('paper.create', compact('paper'));
        } else {
            $message = "Not found!";
            return view('layout.error', compact('message'));
        }
    }
    public function startTest(Request $request)
    {
        $data = $request->all();
        $paper = Paper::find($data['paperId']);
        if(isset($paper->start_datetime)){
            return response()->json([
                'status' => 'error',
                'message' => 'This paper\'s exam has already been started! Reload!'
            ]);
        }
        $paper->start_datetime = Carbon::now();
        // TODO: also store deadline, exam-duration inputs
        $paper->save();
        
        return response()->json([
            'status' => 'success',
            'message' => "Started successfully!",
            'data' => [
                'startDatetime' => $paper->start_datetime,
            ]
        ]);
    }
    
    public function endTest(Request $request)
    {
        $data = $request->all();
        $paper = Paper::find($data['paperId']);
        if(isset($paper->end_datetime)){
            return response()->json([
                'status' => 'error',
                'message' => 'This paper\'s exam has already ended! Reload!'
            ]);
        }
        $paper->end_datetime = Carbon::now();
        $paper->save();
        
        return response()->json([
            'status' => 'success',
            'message' => "Ended successfully!",
            'data' => [
                'endDatetime' => $paper->end_datetime,
            ]
        ]);
    }
    

    public function update(Request $request, Algorithm $algorithm)
    {
       
    }

    public function destroy(Algorithm $algorithm)
    {
        //
    }
}
