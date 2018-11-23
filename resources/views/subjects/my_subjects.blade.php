@extends('layouts.app')

@section('content')
    <div class="container">
        <button class="btn btn-outline-secondary my-3" onclick="showFormJoinSubject()">Join a course</button>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row" id="subjectContainer">
                    <div class="col-md-4" id="subjectTemplate" style="display: none">
                        <div class="card md-4 shadow-sm">
                            <a href="{{ url('my_subject/{id}') }}" style="text-decoration: none; color: inherit;">
                                <img class="card-img-top" src="{{ asset('svg/course-default.svg') }}" alt="Subject image">
                                <div class="card-body">
                                    <p class="card-text">{name}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            <a href="javascript:void(0)"></a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmQuit({id})">Quit</button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    @foreach($subjectsList as $subject)
                        <div class="col-md-4" id="tr-{{ $subject["id"] }}">
                            <div class="card mb-4 shadow-sm">
                                <a href="{{ url('my_subject/'.$subject["id"]) }}" style="text-decoration: none; color: inherit;">
                                <img class="card-img-top" src="{{ asset('svg/course-default.svg') }}" alt="Subject image">
                                <div class="card-body">
                                    <p class="card-text">{{$subject["name"]}}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            {{--A VALIDATION--}}
                                            <a href="javascript:void(0)"></a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmQuit({{$subject["id"]}})">Quit</button>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function showFormJoinSubject() {
                swal({
                    title: 'Subject code',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Join',
                    preConfirm: (id) => {
                        joinSubject(id);
                    }
                });
            }

            function joinSubject(subjectId) {
                var user = JSON.parse(sessionStorage.getItem('user'));

                var params = {
                    _token: '{{csrf_token()}}',
                    student_id: user.id,
                    subject_id: subjectId
                };

                $.ajax({
                    url: '/subjects/join',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            var subject = data.response;

                            var tr = $('<div class="col-md-4" id="tr-' + subject.id + '"></div>');

                            var subjectTemplate = $('#subjectTemplate').clone();

                            var html = subjectTemplate.html();
                            html = html.replace(/{id}/g, subject.id);
                            html = html.replace(/{name}/g, subject.name);

                            tr.html(html);

                            $('#subjectContainer').append(tr);
                        } else {
                            showError(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            }

            function confirmQuit(id) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, quit!'
                }).then((result) => {
                    if (result.value) {
                        quitSubject(id);
                    }
                });
            }

            function quitSubject(subjectId) {
                var user = JSON.parse(sessionStorage.getItem('user'));

                var params = {
                    _token: '{{csrf_token()}}',
                    student_id: user.id,
                    subject_id: subjectId
                };

                $.ajax({
                    url: '/subjects/quit',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            $('#tr-' + data.response).remove();
                        } else {
                            showError(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });

                return false;
            }
        </script>
    </div>
@endsection
