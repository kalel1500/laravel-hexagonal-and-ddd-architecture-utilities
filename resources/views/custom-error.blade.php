<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{--<title>@yield('title')</title>--}}
        <title>{{ __('serverError') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
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
                flex-direction: column;
            }

            .d-flex {
                display: flex;
            }

            .align-items-center {
                align-items: center;
            }

            .m-0 {
                margin: 0;
            }

            .code {
                border-right: 2px solid;
                font-size: 26px;
                padding: 0 15px 0 15px;
                text-align: center;
            }

            .message {
                font-size: 18px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="flex-center full-height">
            <div class="d-flex align-items-center">
                <div class="code">
                    {{--@yield('code')--}}
                    {{ $code }}
                </div>

                <div class="message" style="padding: 10px;">
                    {{--@yield('message')--}}
                    {!! $message !!}
                </div>
            </div>

            <div class="data" style="margin-top: 10px;">
                {{--@yield('data')--}}
                {{--<div>
                    <span>Variables:</span>
                    <ul class="m-0">
                        @foreach($data['data'] as $key => $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>--}}
            </div>
        </div>
    </body>
</html>
