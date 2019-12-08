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
                                <a href="javascript:void(0)" class="btnSubmit" data-id="{{ $homework["id"] }}">Sub</a>
                                <button class="btn btn-secondary" >Submit</button>
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

            <div class="modal" id="modalSubmitHomework">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="submitHomeworkForm" enctype="multipart/form-data" method="POST" action="{{ url('/homeworks/submit') }}">
                            @csrf
                            <input id="student_id" name="student_id" type="hidden">
                            <input id="homework_id" name="homework_id" type="hidden">
                            <div class="form-group">
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <button type="submit" class="btn btn-primary" value="Submit"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        {{--</div>--}}

        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var user = JSON.parse(sessionStorage.getItem('user'));

                $('#student_id').val(user.id);

                $("#btnSubmitHomework").on('click', function() {
                    if (1 == 1) {

                        return;
                    }

                    var user = JSON.parse(sessionStorage.getItem('user'));
                    var id = $(this).data('id');

                    var formData = new FormData();
                    formData.append('_token', '{{csrf_token()}}');
                    formData.append('file', $('#file').val());

                    var params = {
                        _token: '{{csrf_token()}}',
                        // student_id: user.id,
                        // homework_id: $('#homeworkId').val(),
                        file: $('#file').val()
                    };

                    $.ajax({
                    url: '/homeworks/submit',
                        method: 'POST',
                        data: formData,
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

            async function showSubmitForm() {
                if (1 == 1) {
                    $('#modalSubmitHomework').modal('show');
                    return;
                }

                const {value: file} = await swal({
                    title: 'Select image',
                    input: 'file',
                    inputAttributes: {
                        'aria-label': 'Upload your profile picture'
                    }
                });



                $.ajax({
                    url: '/homeworks/submit',
                    method: 'POST',
                    data: {
                        _token: '{{csrf_token()}}',
                        file: e.target.result
                    },
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            var subject = data.response;

                            showFormSubject(id, subject.name);
                        } else {
                            showError(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });



                    // const reader = new FileReader;
                    //
                    // reader.onload = (e) => {
                    //     swal({
                    //         title: 'Your uploaded picture',
                    //         imageUrl: e.target.result,
                    //         imageAlt: 'The uploaded picture'
                    //     })
                    // };
                    //
                    // reader.readAsDataURL(file)
                // }
            }

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

                            swal({
                                type: "info",
                                title: "Your score is " + presentation.grade
                            })
                        } else {
                            showError(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            }

            $(document).on('click', '.btnSubmit', function () {
                var id = $(this).data('id');
                var user = JSON.parse(sessionStorage.getItem('user'));

                $('#student_id').val(user.id);
                $('#homework_id').val(id);

                $('#modalSubmitHomework').modal('show');

               return false;
            });
        </script>
    </div>
@endsection
