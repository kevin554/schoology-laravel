<?php

namespace App\Http\Controllers;

use App\SignedStudent;
use App\Student;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{

    public function index($teacherId) {
        $teacher = Teacher::find($teacherId);
        $subjectsList = $teacher->subjects;

        return view('subjects.home', compact('subjectsList'));
    }

    public function store(Request $request) {
        if ($request->get('id')) {
            $subject = Subject::find($request->get('id'));
        } else {
            $subject = new Subject();
        }

        $subject->name = $request->get('name');
        $subject->teacher_id = $request->get('teacher_id');

        $subject->save();

        $response = [
            'success' => true,
            'response' => $subject,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $subject = Subject::find($id);
        $subject->delete();

        $response = [
            'success' => true,
            'response' => $id,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function get(Request $request) {
        $subject = Subject::find($request->get('id'));

        $response = [
            'success' => true,
            'response' => $subject,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function getById($id) {
        $subject = Subject::find($id);
        $contentsList = $subject->contents->sortBy('order');
        $homeworksList = $subject->homeworks;

        return view('subjects.detail', compact('id', 'contentsList', 'homeworksList'));
    }

    public function getOf($studentId) {
        $student = Student::find($studentId);
        $signedInList = $student->signedIn;

        $subjectsList = array();

        foreach ($signedInList as $signedIn) {
            $subject = Subject::find($signedIn->subject_id);
            $subjectsList[] = $subject;
        }

        return view('subjects.my_subjects', compact('subjectsList'));
    }

    public function join(Request $request) {
        $signedStudent = new SignedStudent();

        $signedStudent->student_id = $request->get('student_id');
        $signedStudent->subject_id = $request->get('subject_id');

        $signedStudent->save();

        $subject = Subject::find($request->get('subject_id'));

        $response = [
            'success' => true,
            'response' => $subject,
            'message' => ''
        ];

        return json_encode($response);
    }


    public function quit(Request $request) {
        $studentId = $request->get('student_id');
        $subjectId = $request->get('subject_id');

        DB::statement('delete from signed_students where student_id = '.$studentId.' and subject_id = '.$subjectId);

        $response = [
            'success' => true,
            'response' => $subjectId,
            'message' => ''
        ];

        return json_encode($response);
    }


    public function getOfStudentBySubjectId($id) {
        $subject = Subject::find($id);
        $contentsList = $subject->contents;
        $homeworksList = $subject->homeworks;

        return view('subjects.my_detail', compact('id', 'contentsList', 'homeworksList'));
    }

}
