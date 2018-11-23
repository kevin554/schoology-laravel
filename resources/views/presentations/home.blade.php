@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center col-10 offset-1">
                <div class="card">
                    <h3 class="p-3"><b>Presentations</b></h3>
                    <table class="table table-striped homeworks-table">
                        <thead>
                            <tr>
                                <th>student</th>
                                <th>presentation date</th>
                                <th>grade</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody id="presentationContainer">
                            @foreach($presentationsList as $presentation)
                            <tr id="tr-{{$presentation["id"]}}">
                                <td>{{$presentation["student_name"]}}</td>
                                <td>{{$presentation["presentation_date"]}}</td>
                                <td>{{$presentation["grade"] ? $presentation["grade"] : 'Not rated yet'}}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="showCheckPresentationForm({{$presentation}})">Open</button>
                                </td>
                            </tr>
                            @endforeach

                            <tr id="presentationTemplate" style="display: none">
                                <td>{student_name}</td>
                                <td>{presentation_date}</td>
                                <td>{grade}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="showCheckPresentationForm({id})">Open</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>

    </div>
        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
        <script type="text/javascript">
            function showCheckPresentationForm(objPresentation) {
                swal({
                    title: 'Grade',
                    input: 'number',
                    inputValue: objPresentation.grade ? objPresentation.grade : '',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: objPresentation.grade ? 'Edit check' : 'Check presentation',
                    preConfirm: (grade) => {
                        objPresentation.grade = grade;

                        checkPresentation(objPresentation);
                    }
                });
            }

            function checkPresentation(objPresentation) {
                var params = {
                    _token: '{{csrf_token()}}',
                    id: objPresentation.id,
                    student_id: objPresentation.student_id,
                    homework_id: objPresentation.homework_id,
                    grade: objPresentation.grade,
                    presentation_date: objPresentation.presentation_date
                };

                $.ajax({
                    url: '/presentations/store',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            var presentation = data.response;

                            var tr = $('#tr-' + presentation.id);

                            var presentationTemplate = $('#presentationTemplate').clone();

                            var html = presentationTemplate.html();
                            html = html.replace(/{id}/g, presentation.id);
                            html = html.replace('{student_name}', objPresentation.student_name);
                            html = html.replace('{grade}', presentation.grade);
                            html = html.replace('{presentation_date}', presentation.presentation_date);

                            /* I need to put an object */
                            var presentationFormatted = JSON.stringify(presentation);
                            presentationFormatted = presentationFormatted.replace(/"/g, "'");
                            html = html.replace('{objPresentation}', presentationFormatted);

                            tr.html(html);
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
