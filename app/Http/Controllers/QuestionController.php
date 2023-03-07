<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Paper;
use App\Models\Question;
use App\Models\Option;


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
        $isEdit = $data['id'] ? $data['id'] == '0' ? false : true : false;
        
        $question = Question::updateOrCreate(
            ['id' => $data['id']],
            [
                'description' => $data['description'],
                'serial_number' => 1,
                'type' => $data['type'],
                'tag' => $data['tag'],
                'group' => $data['group'],
                'paper_id' => $data['paperId'],
            ]
        );
        if(isset($data['options'])){
            foreach($data['options'] as $opt){
                $option = Option::updateOrCreate(
                    ['id' => $opt['id']],
                    [
                        'question_id' => $question->id,
                        'description' => $opt['description'],
                        'is_correct' => $opt['isCorrect'] == 'yes'
                    ]
                );
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => "Saved successfully!"
        ]);
    }

}
