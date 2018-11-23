<?php

namespace App\Http\Controllers;

use App\Homework;
use App\Presentation;
use App\Subject;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{

    public function destroy(Request $request) {
        $id = $request->get('id');
        $homework = Homework::find($id);
        $homework->delete();

        $response = [
            'success' => true,
            'response' => $id,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function get(Request $request) {
        $homework = Homework::find($request->get('id'));

        $response = [
            'success' => true,
            'response' => $homework,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function store(Request $request) {
        if ($request->get('id')) {
            $homework = Homework::find($request->get('id'));
        } else {
            $homework = new Homework();
        }

        $homework->title = $request->get('title');
        $homework->description = $request->get('description');
        $homework->death_line = $request->get('death_line');
        $homework->max_grade = $request->get('max_grade');
        $homework->subject_id = $request->get('subject_id');

        $homework->save();

        $response = [
            'success' => true,
            'response' => $homework,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function submit(Request $request) {
        $presentation = new Presentation();
        $presentation->student_id = $request->get('student_id');
        $presentation->homework_id = $request->get('homework_id');
        $presentation->grade = 0;
        $presentation->presentation_date = date("Y-m-d H:i:s");

        $presentation->save();

        $response = [
            'success' => true,
            'response' => '',
            'message' => ''
        ];

        return json_encode($response);
    }
}
