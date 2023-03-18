<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Paper;
use App\Models\Question;
use App\Models\Option;
use App\Helpers\CommonHelper;


class QuestionController extends Controller
{
    public function create($paperId, $questionId)
    {
        $paper = Paper::where('id', $paperId)->first();
        $question = Question::where('id', $questionId)->first();
        return view('question.create', compact('paper', 'question'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'description' => 'required|min:1',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors ()->first()
            ]);
        }
        $isEdit = CommonHelper::isEditMode($data['id']);//$data['id'] ? $data['id'] == '0' ? false : true : false;

        $question = Question::updateOrCreate(
            ['id' => $data['id']],
            [
                'description' => $data['description'],
                'type' => $data['type'],
                'tag' => $data['tag'],
                'group' => $data['group'],
                'paper_id' => $data['paperId'],
            ]
        );
        if(!$isEdit){
            $query = Question::where('paper_id', $data['paperId']);
            if($query->count() > 0){
                $question->serial_number = $query->max('serial_number') + 1;
            } else {
                $question->serial_number = 1;
            }
            $question->save();
        }
        if(isset($data['options'])){
            foreach($data['options'] as $opt){
                $option = Option::updateOrCreate(
                    ['id' => $opt['id']],
                    [
                        'question_id' => $question->id,
                        'description' => $opt['description'],
                        'serial_number' => $opt['serialNumber'],
                        'is_correct' => $opt['isCorrect'] == 'yes'
                    ]
                );
                $isOptionEdit = $opt['id'] ? $opt['id'] == '0' ? false : true : false;
                if(!$isOptionEdit){
                    $option->serial_number = Option::where('question_id', $question->id)->max('serial_number');
                    $option->save();
                }
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => "Saved successfully!"
        ]);
    }

    public function updateSerialNumber(Request $request)
    {
        $data = $request->all();
        // TODO: need to get serial Number from DB instead of request data
        $serialNumber = Question::where('id', $data['id'])->select('serial_number')->first()->serial_number;
        $action = $data['action'];
        $newSerialNumber = null;
        if($action == 'up'){
            $newSerialNumber = $serialNumber - 1;
        } else if($action == 'down'){
            $newSerialNumber = $serialNumber + 1;
        } else {
            return response()->json([
                'status' => 'info',
                'message' => "Invalid action!"
            ]);
        }
        // first update the corresponding entity
        Question::where('serial_number', $newSerialNumber)
                ->update(['serial_number' => $serialNumber]);
        // second update the respective entity
        Question::where('id', $data['id'])
                ->update(['serial_number' => ($newSerialNumber > 0 ? $newSerialNumber : 1)]);
                
        return response()->json([
            'status' => 'success',
            'message' => "Saved successfully!",
        ]);
    }
}
