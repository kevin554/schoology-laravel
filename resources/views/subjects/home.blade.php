@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row" id="subjectContainer">
                    <div class="col-md-4" id="subjectTemplate" style="display: none">
                        <div class="card md-4 shadow-sm">
                            <a href="{{ url('subject/{id}') }}" style="text-decoration: none; color: inherit;">
                                <img class="card-img-top" src="{{ asset('svg/course-default.svg') }}" alt="Subject image">
                                <div class="card-body">
                                    <p class="card-text">{name}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="{{ url('/studentsSigned/{id}') }}" class="btn btn-sm btn-outline-secondary">Students</a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-outline-secondary" onclick="editSubject({id})">Edit</a>
                                        </div>
                                        <div class="text-muted">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({id})">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    @foreach($subjectsList as $subject)
                        <div class="col-md-4" id="tr-{{ $subject["id"] }}">
                            <div class="card mb-4 shadow-sm">
                                <a href="{{ url('subject/'.$subject["id"]) }}" style="text-decoration: none; color: inherit;">
                                <img class="card-img-top" src="{{ asset('svg/course-default.svg') }}" alt="Subject image">
                                <div class="card-body">
                                    <p class="card-text">{{$subject["name"]}}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="{{ url('/studentsSigned/'.$subject->id) }}" class="btn btn-sm btn-outline-secondary">Students</a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-outline-secondary" onclick="editSubject({{$subject["id"]}})">Edit</a>
                                        </div>
                                        <div class="text-muted">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{$subject["id"]}})">Delete</button>
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
            function showFormSubject(id, name) {
                swal({
                    title: 'Name',
                    input: 'text',
                    inputValue: name ? name : '',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: id ? 'Edit subject' : 'Add subject',
                    preConfirm: (name) => {
                        saveSubject(id, name);
                    }
                });
            }

            function editSubject(id) {
                $.ajax({
                    url: '/subject/',
                    method: 'GET',
                    data: {
                        id: id
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

                return false;
            }

            function saveSubject(id, name) {
                var user = JSON.parse(sessionStorage.getItem('user'));

                var params = {
                    _token: '{{csrf_token()}}',
                    id: id,
                    name: name,
                    teacher_id: user.id
                };

                var isNew = id == null;

                $.ajax({
                    url: '/subjects/store',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            var subject = data.response;

                            var tr = $('#tr-' + subject.id);
                            if (tr.length == 0) {
                                tr = $('<div class="col-md-4" id="tr-' + subject.id + '"></div>');
                            }
                            var subjectTemplate = $('#subjectTemplate').clone();

                            var html = subjectTemplate.html();
                            html = html.replace(/{id}/g, subject.id);
                            html = html.replace('{name}', subject.name);

                            tr.html(html);

                            if (isNew) {
                                $('#subjectContainer').append(tr);
                            }
                        } else {
                            showError(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            }

            function confirmDelete(id) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        deleteSubject(id);
                    }
                });
            }

            function deleteSubject(id) {
                var parameters = {
                    _token: '{{csrf_token()}}',
                    id: id,
                };

                $.ajax({
                    url: '/subjects/destroy',
                    method: 'POST',
                    data: parameters,
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
