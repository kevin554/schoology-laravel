@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form>
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">User type</label>

                                <div class="col-md-6">
                                    <input id="student" type="radio" name="type" value="student">Student
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">Teacher</label>

                                <div class="col-md-6">
                                    <input id="teacher" type="radio" name="type" value="teacher">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input id="btnRegister" class="btn btn-primary" style="background: #636b6f; border: #636b6f" value="Register">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btnRegister").on('click', function() {
                var params = {
                    _token: '{{csrf_token()}}',
                    name: $('#name').val(),
                    type: $('#student').is(':checked') ? 'student' : $('#teacher').is(':checked') ? 'teacher' : '',
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirm: $('#password-confirm').val()

                };

                $.ajax({
                    url: '/register',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            sessionStorage.setItem("user", JSON.stringify(data.response));

                            window.location.href = "/";
                        } else {
                            showError(data.message);
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            });
        });
    </script>
@endsection
