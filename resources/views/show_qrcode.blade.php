<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{settings('site_name')}} | QR COde</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
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
                flex-direction: column;
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
        </style>
    </head>
    <body>

        <div class="flex-center position-ref full-height">
            <div class="m-b-md">
                <button style="font-size: 20px;padding: 5px" onclick="print_this_page()">طباعة</button>
            </div>
            <div class="content">
                <div class="title m-b-md">
                    {{-- <img class="img-fluid"
                        src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{route('site_menu', ['user_id' => $user_id, 'table' => $id])}}&choe=UTF-8"
                        title="iOrder"/> --}}

                    <img class="img-fluid"
                         src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{route('site_new_order', $id)}}&choe=UTF-8"
                         title="services" />
                </div>
            </div>
        </div>
        <script>
            function print_this_page() {
                window.print();
            }
        </script>
    </body>
</html>
