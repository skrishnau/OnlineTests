<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Paper;
use App\Models\Question;


class PaperController extends Controller
{
    //
    public function index()
    {
        $papers = Paper::
                select('id', 'name', 'start_datetime as startDateTime', 'duration_in_mins as durationInMins')
                ->get();
        // foreach($papers as $paper){
        //     $paper->linkUrl = PaperController::getBaseUrl()."/exam/".$paper->linkUrl;
        // }
        return view('paper.index', compact('papers'));
    }
    
    public function show($id)//Paper $paper
    {
        $paper = Paper::where('id', $id)
            ->select('id', 'name', 'link_id as linkUrl')
            ->first();
        $paper->linkUrl = PaperController::getBaseUrl()."/exam/".$paper->linkUrl;
        $questions = Question::where('paper_id', $paper->id)
            ->orderBy('serial_number', 'asc')
            ->get();
        $paper->link_id = PaperController::getBaseUrl() . '/exam/' . $paper->link_id;
        return view('paper.show', compact('paper', 'questions'));
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
        $paper->start_datetime = Carbon::now();
        $paper->link_id = PaperController::generateRandomString();
        $paper->save();
        $url = PaperController::getBaseUrl();
        // Append the requested resource location to the URL   
        $url.= '/exam/'. $paper->link_id;
        
        return response()->json([
            'status' => 'success',
            'message' => "Saved successfully!",
            'data' => [
                'linkUrl' => $url,
            ]
        ]);
    }
    function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function getBaseUrl()
    {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
            $url = "https://";   
        else  
            $url = "http://";   
        // Append the host(domain name, ip) to the URL.   
        $url.= $_SERVER['HTTP_HOST'];
        return $url;
    }

    public function update(Request $request, Algorithm $algorithm)
    {
       
    }

    public function destroy(Algorithm $algorithm)
    {
        //
    }
}
