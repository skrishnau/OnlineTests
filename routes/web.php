<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
Route::get('/unauthorized', function(){
    return view('layout.unauthorized');
})->name("unauthorized");

Route::get('/paper', [PaperController::class, 'index'])->name('paper.index');
Route::get('/paper/create', [PaperController::class, 'create'])->name('paper.create');
Route::get('/paper/edit/{id}', [PaperController::class, 'edit'])->name('paper.edit');
Route::post('/paper/store', [PaperController::class, 'store'])->name('paper.store');
Route::get('/paper/show/{id}', [PaperController::class, 'show'])->name('paper.show');

Route::get('/question/create/{paperId}/{questionId}', [QuestionController::class, 'create'])->name('question.create');
Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
Route::post('/question/updateSerialNumber', [QuestionController::class, 'updateSerialNumber'])->name('question.updateSerialNumber');
Route::post('/question/destroy', [QuestionController::class, 'destroy'])->name('question.destroy');

Route::get('/exam/show/{examId}', [ExamController::class, 'show'])->name('exam.show');
Route::get('/exam/create/{paperId}', [ExamController::class, 'create'])->name('exam.create');
Route::post('/exam/store', [ExamController::class, 'store'])->name('exam.store');
Route::post('/exam/startTest', [ExamController::class, 'startTest'])->name('exam.startTest');
Route::post('/exam/endTest', [ExamController::class, 'endTest'])->name('exam.endTest');
Route::get('/exam/getAllStudents/{examId}', [ExamController::class, 'getAllStudents'])->name('exam.getAllStudents');
Route::post('/exam/addStudents', [ExamController::class, 'addStudents'])->name('exam.addStudents');


Route::get('/answer/create/{examId}', [AnswerController::class, 'create'])->name('answer.create');
Route::post('/answer/store', [AnswerController::class, 'store'])->name('answer.store');
Route::get('/answer/success/{examId}', [AnswerController::class, 'success'])->name('answer.success');

Route::get('/candidate/show/{id}', [CandidateController::class, 'show'])->name('candidate.show');

//Route::get('/paper', 'App\Http\Controllers\PaperController@index');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/show/{id}', [UserController::class, 'show'])->name('user.show');
// update later to a search query


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


