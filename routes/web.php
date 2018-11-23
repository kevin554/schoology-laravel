<?php

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
// 0
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'GlobalController@showLogin');

Route::post('/login', 'GlobalController@login');

Route::get('/register', 'GlobalController@showRegister');

Route::post('/register', 'GlobalController@register');

Route::get('/subjects/{teacherId}', 'SubjectController@index');

Route::post('/subjects/store', 'SubjectController@store');

Route::post('/subjects/destroy', 'SubjectController@destroy');

Route::get('/subject', 'SubjectController@get');

Route::get('/studentsSigned/{subjectId}', 'StudentController@getOfSubject');
// 10
Route::get('/subject/{id}', 'SubjectController@getById');

Route::get('/content', 'ContentController@get');

Route::post('/contents/destroy', 'ContentController@destroy');

Route::post('/contents/store', 'ContentController@store');

Route::post('/homeworks/destroy', 'HomeworkController@destroy');

Route::get('/homework', 'HomeworkController@get');

Route::post('/homeworks/store', 'HomeworkController@store');

Route::get('/presentationsOfHomework/{homeworkId}', 'PresentationController@getOfHomework');

Route::get('/presentation', 'PresentationController@get');

Route::post('/presentations/store', 'PresentationController@store');
// 20
Route::get('/subjects/of/{student_id}', 'SubjectController@getOf');

Route::post('/subjects/join', 'SubjectController@join');

Route::post('/subjects/quit', 'SubjectController@quit');

Route::get('/my_subject/{id}', 'SubjectController@getOfStudentBySubjectId');

Route::post('/homeworks/submit', 'HomeworkController@submit');

Route::get('/presentations/get_grade', 'PresentationController@getGrade');

Route::post('/signedStudents/kick', 'SignedStudentController@kick');
