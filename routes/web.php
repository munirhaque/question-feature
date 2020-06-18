<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('/logout','HomeController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/questions', 'QuestionController@index')->name('questions.index');
Route::get('/questions/manage', 'QuestionController@manage')->name('questions.manage');
Route::get('/questions/get_subject/{id}', 'QuestionController@getSubject')->name('questions.get_subject');
Route::get('/questions/new/{class}/{subject}', 'QuestionController@create')->name('questions.new');
Route::get('/questions/upload/{class}/{subject}', 'QuestionController@upload')->name('questions.upload');
Route::post('/questions/save/{class}/{subject}', 'QuestionController@store')->name('questions.save');
Route::get('/questions/details/{id}', 'QuestionController@details')->name('questions.details');
Route::delete('/questions/delete', 'QuestionController@destroy')->name('questions.delete');

Route::post('/questions/save_upload', 'QuestionController@save_upload')->name('questions.save_upload');


Route::get('/questions-banks/', 'QuestionBankController@index')->name('questions-banks.index');
Route::get('/questions-banks/new', 'QuestionBankController@create')->name('questions-banks.new');
Route::get('/questions-banks/manage/{id}', 'QuestionBankController@manage')->name('questions-banks.manage');
Route::get('/questions-banks/chapter/{id}', 'QuestionBankController@getChapter')->name('questions-banks.chapter');
Route::get('/questions-banks/topic/{id}', 'QuestionBankController@getTopic')->name('questions-banks.topic');
Route::get('/questions-banks/number_of_question/{id}', 'QuestionBankController@countQuestion')->name('questions-banks.number_of_question');
Route::post('/questions-banks/set-question/{id}', 'QuestionBankController@setQuestion')->name('questions-banks.set-question');



Route::post('/questions-banks/save', 'QuestionBankController@store')->name('questions-banks.save');


