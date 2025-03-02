@extends('site.master')
@section('title') اتصل بنا @endsection
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
                    <form action="{{route('site_sendcontact')}}" id="addServiceForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>الاسم</label>
                            <input type="text" name="name" value="{{empty(Auth::user()->name) ? Auth::user()->full_name_ar : Auth::user()->name}}" class="form-control" required>
                        </div>
                         <div class="form-group">
                            <label>رقم الجوال</label>
                            <input type="text" name="phone" value="{{Auth::user()->phone}}" class="form-control phone" required>
                        </div>
                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>الرسالة</label>
                            <textarea name="message" id="message" class="form-control inputs" rows="3" required></textarea>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%" class="btn btn-sm btn-success save" onclick="addService()">إرسال</button>
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
