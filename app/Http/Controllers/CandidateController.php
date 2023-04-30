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
}
