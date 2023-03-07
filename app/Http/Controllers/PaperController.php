<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Paper;
use App\Models\Question;


class PaperController extends Controller
{
    //
    public function index()
    {
        $papers = Paper::
                select('id', 'name', 'start_datetime as startDateTime', 'duration_in_mins as durationInMins', 'link_url as linkUrl')
                ->get();
        return view('paper.index', compact('papers'));
    }
    
    public function show($id)//Paper $paper
    {
        $paper = Paper::where('id', $id)->first();
        $questions = Question::where('paper_id', $paper->id)
            ->orderBy('serial_number', 'asc')
            ->get();
        return view('paper.show', compact('paper', 'questions'));
    }


    public function create()
    {
        return view('paper.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:papers|max:255',
        ]);

        if($validator->fails()){
            return redirect('paper/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $paper = Paper::create([
            "name" => $data["name"]
        ]);
        // return redirect()->route('paper.show', $paper->id);
        return redirect()->route('paper.index');
    }

    public function edit(Algorithm $algorithm)
    {
        //
    }

    public function update(Request $request, Algorithm $algorithm)
    {
        //
    }

    public function destroy(Algorithm $algorithm)
    {
        //
    }
}
