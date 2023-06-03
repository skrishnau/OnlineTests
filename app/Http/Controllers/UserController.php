<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Helpers\CommonHelper;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::get();
        return view('user.index', compact('users'));
    }
    public function create()
    {
        $user = null;
        return view('user.create', compact('user'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $isEditMode = CommonHelper::isEditMode($data["id"]);
        if($isEditMode){
            if(User::where('id', '!=', $data['id'])->where('email', $data['email'])->count() > 0){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already exists!'
                ]);
            }
            $user = User::updateOrCreate(
                ['id' => $data["id"]],
                [
                    "name" => $data["name"],
                    "password" => Hash::make($data["password"]),
                    "email" => $data["email"],
                    "role" => $data["role"],
                ]
            );
        } else {
            if(User::where('email', $data['email'])->count() > 0){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already exists!'
                ]);
            }
            $user = User::create([
                "name" => $data["name"],
                "password" => Hash::make($data["password"]),
                "email" => $data["email"],
                "role" => $data["role"],
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => "Saved successfully!",
            'data' => [
                'redirectUrl' => route("user.index", ['id' => $user->id])
            ]
        ]);
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('user.show', compact('user'));
    }

    // api
    // public function list($role)
    // {
    //     $users = User::where('role', $role)->get();
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Fetched',
    //         'data' => $users->toArray()
    //     ]);
    // }
}
