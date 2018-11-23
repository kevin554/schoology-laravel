<?php

namespace App\Http\Controllers;

use App\Homework;
use App\Presentation;
use App\Student;
use Illuminate\Http\Request;

class PresentationController extends Controller
{

    public function getOfHomework($id) {
        $homework = Homework::find($id);
        $presentationsList = $homework->presentations;

        foreach ($presentationsList as $presentation) {
            $presentation["student_name"] = Student::find($presentation["student_id"])->name;
        }

        return view('presentations.home', compact('presentationsList'));
    }

    public function get(Request $request) {
        $presentation = Presentation::find($request->get('id'));

        $response = [
            'success' => true,
            'response' => $presentation,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function store(Request $request) {
        $presentation = Presentation::find($request->get('id'));

        $presentation->homework_id = $request->get('homework_id');
        $presentation->student_id = $request->get('student_id');
        $presentation->grade = $request->get('grade');
        $presentation->presentation_date = $request->get('presentation_date');

        $presentation->save();

        $response = [
            'success' => true,
            'response' => $presentation,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function getGrade(Request $request) {
        $homeworkId = $request->get('homework_id');
        $studentId = $request->get('student_id');

        $presentation = Presentation::where('homework_id', $homeworkId)->where('student_id', $studentId)->first();

        $response = [
            'success' => true,
            'response' => $presentation,
            'message' => ''
        ];

        return json_encode($response);
    }
}
