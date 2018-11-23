<?php

namespace App\Http\Controllers;

use App\Content;
use App\Subject;
use Illuminate\Http\Request;

class ContentController extends Controller
{

    public function get(Request $request) {
        $content = Content::find($request->get('id'));

        $response = [
            'success' => true,
            'response' => $content,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function destroy(Request $request) {
        $id = $request->get('id');
        $content = Content::find($id);
        $content->delete();

        $response = [
            'success' => true,
            'response' => $id,
            'message' => ''
        ];

        return json_encode($response);
    }

    public function store(Request $request) {
        if ($request->get('id')) {
            $content = Content::find($request->get('id'));
        } else {
            $content = new Content();
        }

        $content->title = $request->get('title');
        $content->order = $request->get('order');
        $content->content = $request->get('content');
        $content->subject_id = $request->get('subject_id');

        $content->save();

        $response = [
            'success' => true,
            'response' => $content,
            'message' => ''
        ];

        return json_encode($response);
    }
}
