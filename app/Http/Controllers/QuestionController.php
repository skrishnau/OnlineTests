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
        $paper = Paper::find($paperId);
        if(!$paper){
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }
        if(isset($paper->start_datetime)){
            $message = 'This paper\'s exam has already been started! You can\'t add/edit questions.';
            return view('layout.error', compact('message'));
        }
        $question = Question::where('id', $questionId)->first();
        return view('question.create', compact('paper', 'question'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $paper = Paper::find($data['paperId']);
        if(isset($paper->start_datetime)){
            return response()->json([
                'status' => 'error',
                'message' => 'This paper\'s exam has already been started! You can\'t add/edit questions.'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'description' => 'required|min:1',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors ()->first()
            ]);
        }
        $isEdit = CommonHelper::isEditMode($data['id']);//$data['id'] ? $data['id'] == '0' ? false : true : false;
        $serialNumber = 0;
        if(!$isEdit) {
            $query = Question::where('paper_id', $data['paperId']);
            if($query->count() > 0){
                $serial_number = $query->max('serial_number') + 1;
            } else {
                $serial_number = 1;
            }
        }
        $question = Question::updateOrCreate(
            ['id' => $data['id']],
            [
                'description' => $data['description'],
                'tag' => $data['tag'],
                'group' => $data['group'],
                'paper_id' => $data['paperId'],
            ]
        );
        if(!$isEdit) {
            $question->serial_number = $serial_number;
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
    public function destroy(Request $request)
    {
        $data = $request->all();
        $que = Question::find($data['id']);
        if(!$que){
            return response()->json([
                'status' => 'error',
                'message' => 'Record doesn\'t exists',
            ]);
        }
        $paper = Paper::find($que->paper_id);
        if(isset($paper->start_datetime)){
            return response()->json([
                'status' => 'error',
                'message' => 'This paper\'s exam has already been started! You can\'t delete questions.'
            ]);
        }
        $opts = Option::where('question_id', $data['id'])->delete();
        $sn = $que->serial_number;
        $que->delete();

        $higherQues = Question::where('serial_number', '>', $sn)->get();
        foreach($higherQues as $hq)
        {
            $hq->serial_number = $hq->serial_number - 1;
            $hq->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Deleted successfully!',
        ]);
    }
}
