<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignedStudentController extends Controller
{

    public function kick(Request $request) {
        $studentId = $request->get('student_id');
        $subjectId = $request->get('subject_id');

        DB::statement('delete from signed_students where student_id = '.$studentId.' and subject_id = '.$subjectId);

        $response = [
            'success' => true,
            'response' => '',
            'message' => ''
        ];

        return json_encode($response);
    }
}
