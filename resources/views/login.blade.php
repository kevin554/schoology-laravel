@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form id="loginForm">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <input id="btnLogin" class="btn btn-primary" style="background: #636b6f; border: #636b6f" value="Login">
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
            $("#btnLogin").on('click', function() {
                var params = {
                    _token: '{{csrf_token()}}',
                    email: $('#email').val(),
                    password: $('#password').val()
                };

                $.ajax({
                    url: '/login',
                    method: 'POST',
                    data: params,
                    success: function(data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            sessionStorage.setItem("user", JSON.stringify(data.response));
                            window.location.href = "/";
                        } else {
                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: data.message
                            });
                        }
                    }, error(e) {
                        console.log(e);
                    }
                });
            });
        });
    </script>
@endsection
