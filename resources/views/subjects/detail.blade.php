@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Contents</h1>

        <div class="row justify-content-center">

            <button class="btn btn-secondary" onclick="showContentForm()">Add a content</button>
            {{-- THIS IS NECESSARY FOR SOME REQUESTS --}}
            <input id="subjectId" type="hidden" value="{{$id}}">

            <div class="col-md-12">
                <div id="contentContainer" class="row">
                    <div id="contentTemplate" class="col-md-4" style="padding: 16px; display: none;">
                        <div class="card" style="padding: 16px;">
                            <h2>{title}</h2>
                            <p>{content}</p>
                            <div class="btn-group" style="margin: 0 auto;">
                                <button class="btn btn-sm btn-outline-secondary" onclick='showContentForm({objContent})'>Edit</button>
                                <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteContent({id})">Delete</button>
                            </div>
                        </div>
                    </div>

                    @foreach($contentsList as $content)
                    <div id="tr-{{$content["id"]}}" class="col-md-4" style="padding: 16px;">
                        <div class="card" style="padding: 16px">
                            <h2>{{$content["title"]}}</h2>
                            <p>{{$content["content"]}}</p>
                            <div class="btn-group" style="margin: 0 auto;">
                                <button class="btn btn-sm btn-outline-secondary" onclick="showContentForm({{$content}})">Edit</button>
                                <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteContent({{$content["id"]}})">Delete</button>
                            </div>
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
                <button class="btn btn-outline-secondary" style="position: absolute; top: 1rem; right: 1rem;" onclick="showHomeworkForm()">Add a homework</button>
                <table class="table table-striped homeworks-table">
                    <thead class="">
                        <tr>
                            <th>title</th>
                            <th>description</th>
                            <th>death line</th>
                            <th>max grade</th>
                            <th colspan="3">actions</th>
                        </tr>
                    </thead>
                    <tbody id="homeworkContainer">
                        @foreach($homeworksList as $homework)
                        <tr id="tr-hw-{{$homework["id"]}}">
                            <td>{{$homework["title"]}}</td>
                            <td>{{$homework["description"]}}</td>
                            <td>{{$homework["death_line"]}}</td>
                            <td>{{$homework["max_grade"]}}</td>
                            <td>
                                <a href="{{ url('/presentationsOfHomework/'.$homework["id"]) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    Presentations
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary" onclick="showHomeworkForm({{$homework}})">Edit</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteHomework({{$homework["id"]}})">Delete</button>
                            </td>
                        </tr>
                        @endforeach

                        <tr id="homeworkTemplate" style="display: none">
                            <td>{title}</td>
                            <td>{description}</td>
                            <td>{death_line}</td>
                            <td>{max_grade}</td>
                            <td>
                                <a href="{{ url('/presentationsOfHomework/{id}') }}" class="btn btn-sm btn-outline-secondary">
                                    Presentations
                                </a>
                            </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" onclick="showHomeworkForm({objHomework})">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteHomework({id})">Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
        <script type="text/javascript">
            function confirmDeleteContent(id) {
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
                        deleteContent(id);
                    }
                });
            }

            function deleteContent(id) {
                var parameters = {
                    _token: '{{csrf_token()}}',
                    id: id,
                };

                $.ajax({
                    url: '/contents/destroy',
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

            function showContentForm(objContent) {
                swal({
                    title: objContent ? "Edit a content's info" : 'Add a new content',
                    html:
                        '<input id="swal-input1" placeholder="title" class="swal2-input">' +
                        '<input id="swal-input2" placeholder="content" class="swal2-input">' +
                        '<input id="swal-input3" placeholder="order" class="swal2-input">',
                    focusConfirm: false,
                    preConfirm: () => {
                        var title = document.getElementById('swal-input1').value;
                        var content = document.getElementById('swal-input2').value;
                        var order = document.getElementById('swal-input3').value;

                        if (!objContent) {
                            objContent = { }
                        }

                        objContent.title = title;
                        objContent.content = content;
                        objContent.order = order;
                        objContent.subject_id = $('#subjectId').val();

                        saveContent(objContent);
                    }
                });

                if (objContent) {
                    $('#swal-input1').val(objContent.title);
                    $('#swal-input2').val(objContent.content);
                    $('#swal-input3').val(objContent.order);
                }
            }

            function saveContent(objContent) {
                var params = {
                    _token: '{{csrf_token()}}',
                    id: objContent.id,
                    title: objContent.title,
                    content: objContent.content,
                    order: objContent.order,
                    subject_id: objContent.subject_id
                };

                $.ajax({
                    url: '/contents/store',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            var content = data.response;

                            var tr = $('#tr-' + content.id);
                            if (tr.length == 0) {
                                tr = $('<div id="tr-' + content.id + '" class="col-md-4" style="padding: 16px;"></div>');
                            }

                            var contentTemplate = $('#contentTemplate').clone();

                            var html = contentTemplate.html();
                            html = html.replace(/{id}/g, content.id);
                            html = html.replace('{title}', content.title);
                            html = html.replace('{content}', content.content);

                            /* I need to put an object */
                            var contentFormatted = JSON.stringify(content);
                            contentFormatted = contentFormatted.replace(/"/g, "'");
                            html = html.replace('{objContent}', contentFormatted);

                            tr.html(html);

                            if (!objContent.id) { /* if is new */
                                $('#contentContainer').append(tr);
                            }
                        } else {
                            showError(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            }

            function confirmDeleteHomework(id) {
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
                        deleteHomework(id);
                    }
                });
            }

            function deleteHomework(id) {
                var parameters = {
                    _token: '{{csrf_token()}}',
                    id: id,
                };

                $.ajax({
                    url: '/homeworks/destroy',
                    method: 'POST',
                    data: parameters,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            $('#tr-hw-' + data.response).remove();
                        } else {
                            showError(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });

                return false;
            }

            function showHomeworkForm(objHomework) {
                var date = new Date();
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();

                var formattedDate =  year + '-' + month + '-' + day;

                swal.mixin({
                    input: 'text',
                    confirmButtonText: 'Next &rarr;',
                    showCancelButton: true,
                    progressSteps: ['1', '2', '3', '4']
                }).queue([
                    {
                        title: 'Title',
                        inputValue: objHomework ? objHomework.title : ''
                    },
                    {
                        title: 'Description',
                        inputValue: objHomework ? objHomework.description : '',
                        text: "¿what's the homework about?"
                    },
                    {
                        title: 'End date',
                        inputValue: objHomework ? objHomework.death_line : '',
                        text: 'write it like this: ' + formattedDate
                    },
                    {
                        title: 'Max grade',
                        inputValue: objHomework ? objHomework.max_grade : ''
                    }
                ]).then((result) => {
                    if (result.value) {
                        /* an array of strings */
                        var title = result.value[0];
                        var description = result.value[1];
                        var endDate = result.value[2];
                        var maxGrade = result.value[3];

                        if (!objHomework) {
                            objHomework = {};
                        }

                        objHomework.title = title;
                        objHomework.description = description;
                        objHomework.death_line =  endDate;
                        objHomework.max_grade = maxGrade;

                        saveHomework(objHomework);
                    }
                })
            }

            function saveHomework(objHomework) {
                var params = {
                    _token: '{{csrf_token()}}',
                    id: objHomework.id,
                    title: objHomework.title,
                    description: objHomework.description,
                    death_line: objHomework.death_line,
                    max_grade: objHomework.max_grade,
                    subject_id: $('#subjectId').val()
                };

                $.ajax({
                    url: '/homeworks/store',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            var homework = data.response;

                            var tr = $('#tr-hw' + homework.id);
                            if (tr.length == 0) {
                                tr = $('<tr id="tr-hw-' + homework.id + '"></tr>');
                            }
                            var homeworkTemplate = $('#homeworkTemplate').clone();

                            var html = homeworkTemplate.html();
                            html = html.replace(/{id}/g, homework.id);
                            html = html.replace('{title}', homework.title);
                            html = html.replace('{description}', homework.description);
                            html = html.replace('{death_line}', homework.death_line);
                            html = html.replace('{max_grade}', homework.max_grade);

                            /* I need to put an object */
                            var homeworkFormatted = JSON.stringify(homework);
                            homeworkFormatted = homeworkFormatted.replace(/"/g, "'");
                            html = html.replace('{objHomework}', homeworkFormatted);
                            tr.html(html);

                            if (!objHomework.id) { /* if is new */
                                $('#homeworkContainer').append(tr);
                            }
                        } else {
                            showError(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            }
        </script>
    </div>
@endsection
