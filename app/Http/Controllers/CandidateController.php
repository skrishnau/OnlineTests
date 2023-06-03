<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Candidate;
use App\Helpers\UserHelper;


class CandidateController extends Controller
{
    
    public function show($id, Request $request)
    {
        // to have request => the user needs to be teacher or it should be the same student
        $hasAccess = UserHelper::isTeacher($request->user())
            || $id == $request->user()->id;
        if(!$hasAccess){
            return view('layout.unauthorized');
        }
        //return view('layout.unauthorized');
        return redirect()->route('answer.create', ['examId'=> 0, 'show' => 'answer', 'candidateId' => $id]);


    }
    public function Exams(Request $request)
    {
        $userId = $request->user()->id;
        $exams = Candidate::
            join('exams', 'candidates.exam_id', '=', 'exams.id')
            ->join('papers', 'exams.paper_id', '=', 'papers.id')
            ->join('courses', 'exams.course_id', '=', 'courses.id')
            ->where('candidates.user_id', $userId)
            ->whereNotNull('exams.start_datetime')
            ->orderBy('exams.start_datetime')
            ->selectRaw('papers.id as paperId,papers.name as paperName,
                exams.id as examId,courses.name as examName,
                exams.start_datetime as examStartDatetime,
                exams.end_datetime as examEndDatetime,
                exams.link_id as examLinkId,
                candidates.start_datetime as startDatetime,
                candidates.end_datetime as endDatetime')
            
            ->get();
        //    var_dump($exams);
        return view('candidate.exams', compact('exams'));
    }
}
