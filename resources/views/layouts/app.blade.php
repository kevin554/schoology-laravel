<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .topRightLinksStudent, .topRightLinksTeacher {
            display: none;
        }

        .evernote-green th {
            background: #2dbe60 !important;
            color: white !important
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background: #fbfbfb;
        }

        .homeworks-table thead {
            text-transform: uppercase;
        }

        .homeworks-table th {
            color: #d2d2d2 !important;
        }

        .homeworks-table td {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div id="app">

    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto ">
                    {{--GUEST LINKS--}}
                    <li class="nav-item topRightLinksGuestUser">
                        <a class="nav-link" href="{{ url('login') }}">Login</a>
                    </li>
                    <li class="nav-item topRightLinksGuestUser">
                        <a class="nav-link" href="{{ url('register') }}">Register</a>
                    </li>
                    {{--STUDENT LINKS--}}
                    <li class="nav-item topRightLinksStudent">
                        <a class="nav-link" href="javascript:void(0)" onclick="subjects()">Subjects</a>
                    </li>
                    <li class="nav-item topRightLinksStudent">
                        <a href="javascript:void(0)" class="nav-link btnLogout">Logout</a>
                    </li>
                    {{--TEACHER LINKS--}}
                    <li class="nav-item topRightLinksTeacher">
                        <a class="nav-link btnAddSubject" href="javascript:void(0)" onclick="showFormSubject()">Add a subject</a>
                    </li>
                    <li class="nav-item topRightLinksTeacher">
                        <a class="nav-link" href="javascript:void(0)" onclick="subjects()">Subjects</a>
                    </li>
                    <li class="nav-item dropdown topRightLinksTeacher">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle txt-username" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item btnLogout" href="javascript:void(0)">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        checkUserLogged();

        $('.btnLogout').on('click', function () {
            sessionStorage.removeItem('user');
            window.location.href = "/";
        });
    });

    function checkUserLogged() {
        var user = JSON.parse(sessionStorage.getItem('user'));

        if (user) {
            $('.topRightLinksGuestUser').hide();
            $('.txt-username').text(user.name);

            switch (user.type) {
                case "student":
                    $('.topRightLinksStudent').show();
                    break;

                case "teacher":
                    $('.topRightLinksTeacher').show();

                    break;

                default:
                    break;
            }
        } else {
            $('.topRightLinksGuestUser').show();
            $('.topRightLinksTeacher').hide();
            $('.topRightLinksStudent').hide();
        }

        return user;
    }

    function subjects() {
        let user = checkUserLogged();

        if (user) {
            switch (user.type) {
                case "student":
                    window.location.href = "/subjects/of/" + user.id;
                    break;

                case "teacher":
                    window.location.href = "/subjects/" + user.id;
                    break;

                default:
                    break;
            }
        }
    }

    function showError(message) {
        swal({
            type: 'error',
            title: 'Oops...',
            text: message
        });
    }
</script>
</html>
