<?php

namespace App\Http\Controllers;

use App\SignedStudent;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function getOfSubject($subjectId) {
        $subject = Subject::find($subjectId);
        $signedStudents = $subject->signedStudents;

        $studentsList = array();

        foreach ($signedStudents as $signedStudent) {
            $student = Student::find($signedStudent->student_id);
            $studentsList[] = $student;
        }

        return view('signedStudents.home', compact('studentsList', 'subjectId'));
    }
}
