<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Paper;

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
    
    public function show(Paper $paper)
    {
        //
        var_dump($paper);
    }


    public function create()
    {
        return view('paper.create');
        //
        // $name = $request->query('name');

        // if($name) {
        //     $terminal = Terminal::find($terminalId);
        //     $subject = Subject::find($subjectId);
        //     $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();
        //     $subjectSyllabi = SubjectSyllabus::where(['terminal_id'=>$terminalId, 'subject_id'=>$subjectId])->get();
        //     $sets = Set::get();
        //     $schools = School::get();
        //     return view('question_paper.create', compact('sets', 'terminal', 'subject', 'academicYears', 'subjectSyllabi', 'schools'));

        // } else {
        //     return redirect()->route("home");
        // }
        
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // $isValid = true;
        // if(!$data['name']){
        //     $isValid = false;
        // }
        //$isValid = !$validator->fails();

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:papers|max:255',
            //'body' => 'required',
        ]);

        if($validator->fails()){
            return redirect('paper/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $paper = Paper::create([
            "name" => $data["name"],
            // "academic_year_id" => $data["academic_year_id"],
            // "set_id" => $data["set_id"],
            // "school_id" => $data["school_id"],
            // "exam_date" => $data["exam_date"],
            // "full_marks" => $data["full_marks"],
            // "pass_marks" => $data["pass_marks"]
        ]);

        return redirect()->route('paper.show', $paper->id);
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
