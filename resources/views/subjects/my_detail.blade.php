@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1>Contents</h1>
            <div class="col-md-12">
                <div class="row">
                    @foreach($contentsList as $content)
                        <div id="tr-{{$content["id"]}}" class="col-md-4" style="padding: 16px;">
                            <div class="card" style="padding: 16px">
                                <h2>{{$content["title"]}}</h2>
                                <p>{{$content["content"]}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <br>

        <div class="row justify-content-center col-10 offset-1">
            <div class="card">
                <h3 class="p-3"><b>Homeworks</b></h3>
                <table class="table table-striped homeworks-table">
                    <thead>
                        <tr>
                            <th>title</th>
                            <th>description</th>
                            <th>death line</th>
                            <th>max grade</th>
                            <th colspan="2">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($homeworksList as $homework)
                        <tr>
                            <td>{{$homework["title"]}}</td>
                            <td>{{$homework["description"]}}</td>
                            <td>{{$homework["death_line"]}}</td>
                            <td>{{$homework["max_grade"]}}</td>
                            <td>
                                <button class="btn btn-secondary" onclick="showSubmitForm({{$homework["id"]}})">Submit</button>
                            </td>
                            <td>
                                <button class="btn btn-secondary" onclick="viewScore({{$homework["id"]}})">View</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{--<h1>Homeworks</h1>--}}
        {{--<div class="row justify-content-center">--}}
            {{--<div class="col-md-12">--}}
                {{--<div class="row">--}}
                    {{--<table class="table">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<td>id</td>--}}
                            {{--<td>title</td>--}}
                            {{--<td>description</td>--}}
                            {{--<td>death line</td>--}}
                            {{--<td>max grade</td>--}}
                            {{--<td colspan="2">actions</td>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody id="homeworkContainer">--}}
                        {{--@foreach($homeworksList as $homework)--}}
                            {{--<tr id="tr-hw-{{$homework["id"]}}">--}}
                                {{--<td>{{$homework["id"]}}</td>--}}
                                {{--<td>{{$homework["title"]}}</td>--}}
                                {{--<td>{{$homework["description"]}}</td>--}}
                                {{--<td>{{$homework["death_line"]}}</td>--}}
                                {{--<td>{{$homework["max_grade"]}}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="javascript:void(0)"--}}
                                       {{--data-id="{{$homework["id"]}}"--}}
                                       {{--class="btn btn-secondary btnSubmitHomework">--}}
                                        {{--Submit--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<button class="btn btn-secondary" onclick="viewScore({{$homework["id"]}})">View</button>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="modal" id="modalSubmitHomework">--}}
                {{--<div class="modal-dialog" role="document">--}}
                    {{--<div class="modal-content">--}}
                        {{--<form id="submitHomeworkForm">--}}
                            {{--this is obligatory for security reasons--}}
                            {{--@csrf--}}
                            {{--<input id="homeworkId" type="text">--}}
                            {{--<div class="form-group">--}}
                                {{--<input id="btnSubmitHomework" class="btn btn-primary" value="Submit">--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>--}}
        <script type="text/javascript">
            $(document).ready(function() {
                $("#btnSubmitHomework").on('click', function() {
                    var user = JSON.parse(sessionStorage.getItem('user'));
                    var id = $(this).data('id');

                    var params = {
                        _token: '{{csrf_token()}}',
                        student_id: user.id,
                        homework_id: $('#homeworkId').val()
                    };

                    $.ajax({
                    url: '/homeworks/submit',
                        method: 'POST',
                        data: params,
                        success: function (data) {
                            data = JSON.parse(data);

                            if (data.success) {
                                $('#modalSubmitHomework').modal('hide');
                            } else {
                                alert(data.message);
                            }
                        }, error(e) {
                            console.log(e);
                        }
                    });
                });

                $(".btnSubmitHomework").on('click', function() {
                    var id = $(this).data('id');

                    $('#homeworkId').val(id);
                    $('#modalSubmitHomework').modal('show');
                });
            });

            function viewScore(homeworkId) {
                var user = JSON.parse(sessionStorage.getItem('user'));

                var params = {
                    homework_id: homeworkId,
                    student_id: user.id
                };

                $.ajax({
                    url: '/presentations/get_grade',
                    method: 'GET',
                    data: params,
                    success: function (data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            var presentation = data.response;

                            alert('your score i s ' + presentation.grade)
                        } else {
                            alert(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            }

            function showSubmitForm() {

            }

            function viewScore() {

            }
        </script>
    </div>
@endsection
