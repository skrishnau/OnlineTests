<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function create($paperId, Request $request)
    {
        $show = $request->input('show');
        $paper = Paper::where('id', $paperId)->first();
        if(!$paper){
            $message = 'Not found!';
            return view('layout.error', compact('message'));
        }
        $isPreview = false;
        // NOTE: in case of examination we should not show breadcrumbs and other links of the site
        $showBreadCrumbs = true;
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
            // don't show breadcrumbs
            $showBreadCrumbs = false;
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
        return view('exam.create', compact('paper', 'questions', 'isPreview', 'showBreadCrumbs'));
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
}
