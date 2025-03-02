<!DOCTYPE html>
<html @if(App::getLocale() == 'en') lang="en" @else lang="ar" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Abdelrahman">
    <meta name="robots" content="index/follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1,, shrink-to-fit=no, maximum-scale=1, user-scalable=no">
    <meta name="HandheldFriendly" content="true">

    <title>{{settings('site_name')}} | @yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <style>
        /* remove increase and decrease arrows from number input */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            font-family: 'Montserrat', sans-serif
        }

        body {
            padding: 5px
        }

        p {
            margin: 0%
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            overflow: hidden
        }

        .box-1 {
            max-width: 450px;
            padding: 10px 40px;
            user-select: none
        }

        .box-1 img.pic {
            width: 20px;
            height: 20px;
            object-fit: cover
        }

        .box-1 img.mobile-pic {
            width: 100%;
            height: 200px;
            object-fit: cover
        }

        .box-1 .name {
            font-size: 11px;
            font-weight: 600
        }

        .dis {
            font-size: 12px;
            font-weight: 500
        }

        .box-2 {
            max-width: 450px;
            padding: 10px 40px
        }

        .box-2 .box-inner-2 input.form-control {
            font-size: 12px;
            font-weight: 600
        }

        .box-2 .box-inner-2 .inputWithIcon {
            position: relative
        }

        .box-2 .box-inner-2 .inputWithIcon span {
            position: absolute;
            left: 15px;
            top: 8px
        }

        .box-2 .box-inner-2 .inputWithcheck {
            position: relative
        }

        .box-2 .box-inner-2 .inputWithcheck span {
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: green;
            font-size: 12px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            right: 15px;
            top: 6px
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            outline: none;
            border: 1px solid #7700ff
        }

        .border:focus-within {
            border: 1px solid #7700ff !important
        }

        .box-2 .card-atm .form-control {
            border: none;
            box-shadow: none
        }

        .form-select {
            border-radius: 0;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px
        }

        .address .form-control.zip {
            border-radius: 0;
            border-bottom-left-radius: 10px
        }

        .address .form-control.state {
            border-radius: 0;
            border-bottom-right-radius: 10px
        }

        .box-2 .box-inner-2 .btn.btn-outline-primary {
            width: 120px;
            padding: 10px;
            font-size: 11px;
            padding: 0% !important;
            display: flex;
            align-items: center;
            border: none;
            border-radius: 0;
            background-color: whitesmoke;
            color: black;
            font-weight: 600
        }

        .box-2 .box-inner-2 .btn.btn-primary {
            background-color: #7700ff;
            color: whitesmoke;
            font-size: 14px;
            display: flex;
            align-items: center;
            font-weight: 600;
            justify-content: center;
            border: none;
            padding: 10px
        }

        .box-2 .box-inner-2 .btn.btn-primary:hover {
            background-color: #7a34ca
        }

        .box-2 .box-inner-2 .btn.btn-primary .fas {
            font-size: 13px !important;
            color: whitesmoke
        }

        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%
        }

        .carousel-inner {
            width: 100%;
            height: 200px
        }

        .carousel-item img {
            object-fit: cover;
            height: 100%
        }

        .carousel-control-prev {
            transform: translateX(-50%);
            opacity: 1
        }

        .carousel-control-prev:hover .fas.fa-arrow-left {
            transform: translateX(-5px)
        }

        .carousel-control-next {
            transform: translateX(50%);
            opacity: 1
        }

        .carousel-control-next:hover .fas.fa-arrow-right {
            transform: translateX(5px)
        }

        .fas.fa-arrow-left,
        .fas.fa-arrow-right {
            font-size: 0.8rem;
            transition: all .2s ease
        }

        .icon {
            width: 30px;
            height: 30px;
            background-color: #f8f9fa;
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transform-origin: center;
            opacity: 1
        }

        .fas.fa-times {
            color: red
        }

        .fas,
        .fab {
            color: #6d6c6d
        }

        ::placeholder {
            font-size: 12px
        }

        .couponCode {
            text-transform: uppercase;
            font-size: 0.7rem
        }

        #code {
            pointer-events: none;
            font-weight: 600
        }

        .close {
            cursor: pointer
        }

        .info {
            transform: translateX(-500px);
            animation: moving 1.5s;
            animation-fill-mode: forwards
        }

        .updates {
            transform: translateX(-500px);
            animation: moving 1.7s;
            animation-fill-mode: forwards
        }

        .different {
            transform: translateX(-500px);
            animation: moving 1.9s;
            animation-fill-mode: forwards
        }

        .black {
            transform: translateX(-500px);
            animation: moving 2.1s;
            animation-fill-mode: forwards
        }

        .white {
            transform: translateX(-500px);
            animation: moving 2.3s;
            animation-fill-mode: forwards
        }

        .pastel {
            transform: translateX(-500px);
            animation: moving 2.5s;
            animation-fill-mode: forwards
        }

        .footer {
            transform: translateX(-500px);
            animation: moving 2.6s;
            animation-fill-mode: forwards
        }

        @keyframes moving {
            0% {
                opacity: 0;
                transform: translateX(-500px)
            }

            100% {
                opacity: 1;
                transform: translateX(0px)
            }
        }

        .box-2 {
            transform: translateY(-500px);
            animation: img-top 2.5s;
            animation-fill-mode: forwards
        }

        .user {
            transform: translateY(-500px);
            animation: img-top 2.5s;
            animation-fill-mode: forwards
        }

        .userdetails {
            transform: translateY(-500px);
            animation: img-top 2.0s;
            animation-fill-mode: forwards
        }

        .imgdetails {
            transform: translateY(-500px);
            animation: img-top 1.5s;
            animation-fill-mode: forwards
        }

        @keyframes img-top {
            0% {
                opacity: 0;
                transform: translateY(-500px)
            }

            100% {
                opacity: 1;
                transform: translateY(0px)
            }
        }

        @media (max-width:768px) {
            .container {
                max-width: 700px;
                margin: 10px auto
            }

            .box-1,
            .box-2 {
                max-width: 600px;
                padding: 20px 90px;
                margin: 20px auto
            }

            .box-2 {
                transform: translateX(-500px);
                animation: box-side 2.6s;
                animation-fill-mode: forwards
            }

            @keyframes box-side {
                0% {
                    opacity: 0;
                    transform: translateX(-500px)
                }

                100% {
                    opacity: 1;
                    transform: translateX(0px)
                }
            }
        }

        @media (max-width:426px) {

            .box-1,
            .box-2 {
                max-width: 400px;
                padding: 20px 10px
            }

            ::placeholder {
                font-size: 9px
            }
        }
    </style>
</head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                {{-- <h1 class="m-0 text-dark">Dashboard v2</h1> --}}
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                                    {{-- <li class="breadcrumb-item active">Dashboard v2</li> --}}
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Start Content -->
                <div class="container d-lg-flex">
                    <div class="box-2">
                        <div class="box-inner-2">
                            <div>
                                <p class="fw-bold">Payment Details</p>
                                <p class="dis mb-3">Complete your purchase by providing your payment details</p>
                            </div>
                            <form action="{{url('api/v1/bills/create')}}" method="post">
                                @csrf
                                <input type="hidden" name="application_id" value="1677">
                                <input type="hidden" name="application_secret" value="6A87J1sl9iJbOm5HKNw8">
                                <div class="mb-3">
                                    <p class="dis fw-bold mb-2">Email address</p> <input class="form-control" type="email" name="customer_email">
                                </div>
                                <div class="mb-3">
                                    <p class="dis fw-bold mb-2">Phone Number</p> <input class="form-control" type="tel" name="customer_mobile">
                                </div>
                                <div>
                                    <p class="dis fw-bold mb-2">Card details</p>
                                    <div class="my-3 cardname">
                                        <p class="dis fw-bold mb-2">Cardholder name</p> <input class="form-control" type="text" name="customer_name">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between card-atm border rounded">
                                        <div class="fab fa-cc-visa ps-3"></div> <input type="text" class="form-control" placeholder="Expiry Date">
                                        <div class="d-flex w-50"> <input type="text" class="form-control px-0" name="expiry_date" placeholder="MM/YY"> <input type="password" maxlength=3 class="form-control px-0" name="cvv" placeholder="CVV"> </div>
                                    </div>
                                    <div class="address">
                                        <div class="d-flex align-items-center justify-content-between card-atm border rounded">
                                            <div class="fab fa-cc-visa ps-3"></div> <input type="text" class="form-control" placeholder="Due Date">
                                            <div class="d-flex"> <input type="text" class="form-control px-0" name="due_date" placeholder="dd-mm-yyyy"></div>
                                        </div>
                                        <div class="d-flex flex-column dis">
                                            <button class="btn btn-primary mt-2">Pay<span class="fas fa-dollar-sign px-1"></span>16.80 </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Content -->

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            var valcode = document.querySelector("#discount")
            var namecode = document.querySelector("#code")
            namecode.textContent = valcode.value

            var closeBtn = document.querySelector(".close")
            var couponCode = document.querySelector(".couponCode")
            closeBtn.addEventListener("click", function () {
                close()
            })
            valcode.addEventListener("change", function () {
                checkDiscountCoupon()
            })

            function checkDiscountCoupon() {
                if (valcode.value.length === 0) {
                    // namecode.style.display = "none"
                    close()
                }
                else {
                    couponCode.classList.remove("d-none")
                    namecode.style.display = "inline"
                    namecode.textContent = valcode.value
                }
            }

            function close() {
                couponCode.classList.add("d-none")
                valcode.value = ""
            }
        </script>
    </body>
</html>
