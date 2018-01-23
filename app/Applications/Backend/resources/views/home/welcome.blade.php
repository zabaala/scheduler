<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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

            .title>small{
                display: block;
                font-size: 24px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .badges{
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('backend.login') }}">Login</a>
                        <a href="{{ route('backend.register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Scheduler
                    <small>by Mauricio Rodrigues</small>
                </div>

                <div class="links">
                    <a href="{{ route('backend.register') }}">Try it!</a>
                    <a href="https://gitlab.com/zabaala/scheduler/" target="_blank">View Source</a>
                    <a href="https://www.linkedin.com/in/mauriciovsr/" target="_blank">LinkedIn Profile</a>
                    <a href="https://github.com/zabaala" target="_blank">Github Profile</a>
                </div>

                <div class="badges">
                    <a href="https://gitlab.com/zabaala/scheduler/badges/master/" target="_blank"><img src="https://gitlab.com/zabaala/scheduler/badges/master/build.svg" alt=""></a>
                    <a class="badge-align" href="https://www.codacy.com/app/zabaala/scheduler?utm_source=gitlab.com&amp;utm_medium=referral&amp;utm_content=zabaala/scheduler&amp;utm_campaign=Badge_Grade" target="_blank"><img src="https://api.codacy.com/project/badge/Grade/40a57d730910461a8d5f00011c1347b9"/></a>
                </div>
            </div>
        </div>
    </body>
</html>
