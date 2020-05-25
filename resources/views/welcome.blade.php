<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #3490dc;
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
                font-size: 5em;
            }

            .title a {
                font-size: inherit;
                text-align: inherit;
                color: inherit;
                text-decoration: none;
            }

            .links > a {
                color: #343fdc;
                padding: 0 25px;
                font-size: 1em;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            @media only screen and (max-width: 700px) {
                .title {
                    font-size: 4em;
                }

                .links > a {
                    font-size: 0.9em;
                }
            }

            @media only screen and (max-width: 500px) {
                .title {
                    font-size: 3em!important;
                }

                .links > a {
                    font-size: 0.8em;
                }
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <a href="{{ route('laptops.index') }}">usedLaptops</a>
                </div>

                <div class="links">
                    <a href="https://dimitrisganotis.gr/" target="_blank">Portfolio</a>
                    <a href="https://www.linkedin.com/in/dimitrisgan97/" target="_blank">LinkedIn</a>
                    <a href="https://github.com/dimitrisganotis/usedLaptops/" target="_blank">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
