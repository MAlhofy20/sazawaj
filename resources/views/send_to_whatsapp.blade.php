<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta name="description" content="{{ settings('description') }}">
        <meta name="keywords" content="{{ settings('key_words') }}">
        <meta name="author" content="Abdelrahman">
        <meta name="robots" content="index/follow">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport"
              content="width=device-width, initial-scale=1,, shrink-to-fit=no, maximum-scale=1, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta property="og:title" content="{{ settings('site_name') }}" />
        <meta property="og:image" content="{{ url('' . settings('logo')) }}" />
        <meta property="og:description" content="{{ settings('site_name') }}" />
        <meta property="og:site_name" content="{{ settings('site_name') }}" />
        <link rel="shortcut icon" type="image/png" href="{{ static_path() }}/images/favicon.jpg" />
        <title>{{ settings('site_name') }}</title>

        <link rel="stylesheet" href="{{ static_path() }}/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ static_path() }}/css/font-awesome-5all.css">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <form action="{{route('post_send_to_whatsapp')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xs-12 text-center" style="width: 100%">
                        <label for="">كود الدولة</label>
                        <input type="tel" name="phone_code" id="" class="form-control phone">
                    </div>
                    <div class="col-xs-12 text-center" style="width: 100%">
                        <label for="">رقم الهاتف</label>
                        <input type="tel" name="mobile" id="" class="form-control phone">
                    </div>
                    <div class="col-xs-12 text-center" style="width: 100%">
                        <label for="">الرسالة</label>
                        <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="col-xs-12 text-center" style="width: 100%">
                        <button type="submit" class="form-control btn-success">ارسال</button>
                    </div>
                </form>

                {{--<form action="https://prowhats.app/api/send.php" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="text">
                    <input type="hidden" name="instance_id" value="61A4C674E801E">
                    <input type="hidden" name="access_token" value="d9a8212bd9b4bce2095a54711d9d6876">
                    --}}{{--<div class="col-xs-12 text-center" style="width: 100%">
                        <label for="">كود الدولة</label>
                        <input type="tel" name="phone_code" id="" class="form-control phone">
                    </div>--}}{{--
                    <div class="col-xs-12 text-center" style="width: 100%">
                        <label for="">رقم الهاتف</label>
                        <input type="tel" name="number" id="" class="form-control phone">
                    </div>
                    <div class="col-xs-12 text-center" style="width: 100%">
                        <label for="">الرسالة</label>
                        <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="col-xs-12 text-center" style="width: 100%">
                        <button type="submit" class="form-control btn-success">ارسال</button>
                    </div>
                </form>--}}
            </div>
        </div>

        <script src="{{ static_path() }}/js/jquery-3.2.1.min.js"></script>
        <script src="{{ static_path() }}/js/popper.min.js"></script>
        <script src="{{ static_path() }}/js/bootstrap.min.js"></script>
        <script src="{{ url('/public/notify.js') }}"></script>

        <script>
            $(document).ready(function() {
                // allow number only in inputs has class phone
                $(".phone").keydown(function(e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                        // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
            });
        </script>
    </body>

</html>
