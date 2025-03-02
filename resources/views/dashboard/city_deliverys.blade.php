@extends('dashboard.master')
@section('title') {{ Translate('اسعار الطلبات') }} @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('updatecitydelivery') }}" id="updateServiceForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="city_id" value="{{ $city_id }}">

                        @foreach ($cities as $city_to)
                            <div class="form-group">
                                <label>السعر من : {{ $city->title_ar }} - الى : {{ $city_to->title_ar }}</label>
                                <input type="tel" name="prices[{{ $city_to->id }}]" class="form-control phone"
                                    value="{{ get_order_price($city_id, $city_to->id) }}">
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%" onclick="updateService()"
                                class="btn btn-sm btn-success save">{{ Translate('حفظ') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(function() {
            $(document).on("change", ".file-input", function() {
                let input = $(this),
                    uploadedImage = input.siblings(".uploaded-image"),
                    placeHolder = input.siblings(".placeholder"),
                    fileName = input.parent().find(".file-name"),
                    plus = input.siblings("i.fas.fa-camera");
                if (input.val() === "") {
                    fileName.empty();
                    uploadedImage.empty();
                    placeHolder.removeClass("active");
                    plus.fadeIn(100);
                } else {
                    plus.fadeOut(100);
                    fileName.text(input.val().replace("C:\\fakepath\\", ""));
                    uploadedImage.empty();
                    uploadedImage.append('<img src="' + URL.createObjectURL(event.target.files[0]) + '">');
                }
            });

            $(document).on("click", ".file-name", function() {
                $(this).siblings(".file-input").click();
            });

            $(document).on("click", ".uploaded-image", function() {
                $(this).addClass("active");
            });

            $("body").on("click", function() {
                $('.uploaded-image').removeClass("active");
            });

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
                $('#label-switch').bootstrapSwitch('onText', 'I');
                $('#label-switch').bootstrapSwitch('offText', 'O');
            });

        });

        //CKEDITOR.replace( 'desc_ar' );
        //CKEDITOR.replace( 'desc_en' );

        // Classicupdateor
        //     .create( document.querySelector( '#desc_ar' ) )
        //     .catch( error => {
        //         console.error( error );
        //     } );

        // Classicupdateor
        //     .create( document.querySelector( '#desc_en' ) )
        //     .catch( error => {
        //         console.error( error );
        //     } );

        function additems() {
            let old_counter = parseInt($('#counter').val());
            $('#counter').val(old_counter + 1);
            let counter = parseInt($('#counter').val());
            $('.imgDescDiv').append('<div class="col-6"><input type="text" name="img_titles[' + counter +
                ']" class="form-control" placeholder="العنوان"></div><div class="col-6"><input type="text" name="img_descs[' +
                counter + ']" class="form-control" placeholder="التفاصيل"></div>');
        }


        function updateService() {
            event.preventDefault();
            start_loader();
            $.ajax({
                type: 'POST',
                url: '{{ route('updatecitydelivery') }}',
                datatype: 'json',
                async: false,
                processData: false,
                contentType: false,
                data: new FormData($("#updateServiceForm")[0]),
                success: function(msg) {
                    if (msg.value == '0') {
                        stop_loader();
                        $('.save').notify(
                            msg.msg, {
                                position: "top"
                            }
                        );
                    } else {
                        document.location.assign("{{ route('citys') }}");
                    }
                }
            });
        }

        $(document).on("click", ".uploaded-image", function() {
            $(this).addClass("active");
        });

        $("body").on("click", function() {
            $('.uploaded-image').removeClass("active");
        });

    </script>
@endsection
