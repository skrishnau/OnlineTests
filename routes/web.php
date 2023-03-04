<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\QuestionController;


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
Route::post('/paper/store', [PaperController::class, 'store'])->name('paper.store');
Route::get('/paper/show/{id}', [PaperController::class, 'show'])->name('paper.show');

Route::get('/question/create/{paperId}/{questionId}', [QuestionController::class, 'create'])->name('question.create');
Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');

//Route::get('/paper', 'App\Http\Controllers\PaperController@index');
