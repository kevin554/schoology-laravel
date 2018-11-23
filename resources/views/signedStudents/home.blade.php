@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <input id="subjectId" type="hidden" value="{{$subjectId}}">
            <div class="col-md-6">
                @if($studentsList)
                    <h1 class="text-center">Signed students</h1>
                @endif
                <ul class="list-group">
                    @foreach($studentsList as $student)
                        <li id="tr-{{$student['id']}}" class="list-group-item d-flex justify-content-between">
                            <h5>{{$student["name"]}}</h5>
                            <button class="btn btn-outline-danger btn-sm" onclick="confirmKickStudent({{$student["id"]}})">Kick</button>
                        </li>
                    @endforeach
                </ul>
                <div class="col-md-6 offset-3" style="padding-top: 100px;">
                    @if(!$studentsList)
                        <img src="{{ asset('svg/list.svg') }}" alt="no students">
                        <h4 class="text-center">It seems like there are no students signed.</h4>
                    @endif
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
        <script type="text/javascript">
            function confirmKickStudent(id) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, kick!'
                }).then((result) => {
                    if (result.value) {
                        kickStudent(id);
                    }
                });
            }

            function kickStudent(id) {
                var parameters = {
                    _token: '{{csrf_token()}}',
                    student_id: id,
                    subject_id: $('#subjectId').val()
                };

                $.ajax({
                    url: '/signedStudents/kick',
                    method: 'POST',
                    data: parameters,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            $('#tr-' + id).remove();
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
