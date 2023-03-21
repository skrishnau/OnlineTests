<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamController;


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
Route::get('/paper', [PaperController::class, 'index'])->name('paper.index');
Route::get('/paper/create', [PaperController::class, 'create'])->name('paper.create');
Route::get('/paper/edit/{id}', [PaperController::class, 'edit'])->name('paper.edit');
Route::post('/paper/store', [PaperController::class, 'store'])->name('paper.store');
Route::get('/paper/show/{id}', [PaperController::class, 'show'])->name('paper.show');
Route::post('/paper/startTest', [PaperController::class, 'startTest'])->name('paper.startTest');
Route::post('/paper/endTest', [PaperController::class, 'endTest'])->name('paper.endTest');

Route::get('/question/create/{paperId}/{questionId}', [QuestionController::class, 'create'])->name('question.create');
Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
Route::post('/question/updateSerialNumber', [QuestionController::class, 'updateSerialNumber'])->name('question.updateSerialNumber');
Route::post('/question/destroy', [QuestionController::class, 'destroy'])->name('question.destroy');

Route::get('/exam/create/{paperId}', [ExamController::class, 'create'])->name('exam.create');
Route::post('/exam/store', [ExamController::class, 'store'])->name('exam.store');
Route::get('/exam/success/{paperId}', [ExamController::class, 'success'])->name('exam.success');

//Route::get('/paper', 'App\Http\Controllers\PaperController@index');
