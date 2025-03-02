@extends('master')
@section('title') {{Translate('تواصل معنا')}} @endsection
@section('style')

@endsection

@section('content')
    <!-- services  -->
    <section id="services-section" class="services">
        <div class="container">
            <h2 class="section-tit">
                {{Translate('تواصل معنا')}}
            </h2>
            <div class="section-child">

            </div>
            <div class="hold-servicesForm">
                <div class="servicesForm-tabs-content" data-serv="1">
                    <div class="in-servicesForm">
                        <form action="{{route('site_sendcontact')}}" id="addServiceForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>{{Translate('الاسم')}}</label>
                                <input type="text" name="name" value="{{auth()->check() ? auth()->user()->first_name : ''}}" class="form-control inputs" required>
                            </div>
                            <div class="form-group">
                                <label>{{Translate('رقم الجوال')}}</label>
                                <input type="text" name="phone" value="{{auth()->check() ? auth()->user()->phone : ''}}" class="form-control inputs phone" required>
                            </div>
                            <div class="form-group">
                                <label>{{Translate('البريد الإلكتروني')}}</label>
                                <input type="email" name="email" value="{{auth()->check() ? auth()->user()->email : ''}}" class="form-control inputs" required>
                            </div>
                            <div class="form-group">
                                <label>{{Translate('الرسالة')}}</label>
                                <textarea name="message" id="message" class="form-control inputs" rows="3" required></textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" style="width:100%" class="btn btn-sm btn-success save" onclick="addService()">{{Translate('إرسال')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--  services  -->
@endsection

@section('script')
    <script>
        function addService() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('site_sendcontact') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addServiceForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "top"
                            }
                        );
                    }else{
                        $.notify(msg.msg, 'success');
                        $('.inputs').val('');
                    }
                }
            });
        }
    </script>
@endsection
