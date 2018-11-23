<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GlobalController extends Controller
{

    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {
        $student = Student::where('email', $request->get('email'))->first();
        $teacher = Teacher::where('email', $request->get('email'))->first();

        $user = $student ? $student : $teacher;

        $response = [
            'success' => false,
            'response' => '',
            'message' => ''
        ];

        if (!$user) {
            $response["message"] = "There is no user registered with those credentials";
            return json_encode($response);
        }

        if (Hash::check($request->get('password'), $user->password)) {
            $user->type = $student ? 'student' : 'teacher';

            $response["success"] = true;
            $response["response"] = $user;

            return json_encode($response);
        }

        $response["message"] = "There is no user registered with those credentials";
        return json_encode($response);
    }

    public function showRegister() {
        return view('register');
    }

    public function register(Request $request) {
        $response = [
            'success' => false,
            'response' => '',
            'message' => ''
        ];

        if ($request->get('password') != $request->get('password_confirm')) {
            $response['message'] = "The password doesn't match";
            return json_encode($response);
        }

        if ($request->get('type') == "student") {
            $user = new Student();
        } else {
            $user = new Teacher();
        }

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));

        $user->save();

        $response['success'] = true;
        $response['response'] = $user;

        return json_encode($response);
    }
}
