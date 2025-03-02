@extends('site.master')
@section('title') {{Translate('المحفظة')}} @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <!-- /.card-header -->
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <p>
                            <span>اجمالي المبالغ : </span>
                            <span>{{(float) Auth::user()->commission_total}}</span>
                            <span> ريال </span>
                        </p>
                        <p>
                            <span>اجمالي المبالغ المنتظرة : </span>
                            <span>{{(float) Auth::user()->wait_commission}}</span>
                            <span> ريال </span>
                        </p>
                        <p>
                            <span>اجمالي الover price المنتظرة : </span>
                            <span>{{ (float) App\Models\Order::where('user_id' , Auth::id())->whereIn('status' , ['pre-new' , 'new' , 'in_way'])->sum('over_price') }}</span>
                            <span> ريال </span>
                        </p>
                        
                    </div>
                    
                    
                    <div class="col-6">
                        <p>
                            <span>اجمالي مبالغ الهدايا : </span>
                            <span>{{(float) Auth::user()->gift_total}}</span>
                            <span> ريال </span>
                        </p>
                        <p>
                            <span>اجمالي المبالغ المستلمة : </span>
                            <span>{{(float) Auth::user()->commission_done}}</span>
                            <span> ريال </span>
                        </p>
                        <p>
                            <span>اجمالي المبالغ المستحقة : </span>
                            <span>{{(float) Auth::user()->commission}}</span>
                            <span> ريال </span>
                        </p>
                        {{-- <p>
                            <span>عدد النقاط : </span>
                            <span>{{(float) Auth::user()->point_total}}</span>
                            <span> نقطة </span>
                        </p>
                        <p>
                            <span>عدد علب الادوية المستهلكة : </span>
                            <span>{{(float) Auth::user()->done_gifts}}</span>
                            <span> علبة </span>
                        </p>
                        <p>
                            <span>عدد علب الادوية المتبقية : </span>
                            <span>{{(float) Auth::user()->total_gifts - (float) Auth::user()->done_gifts}}</span>
                            <span> علبة </span>
                        </p> --}}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h3>طلب تحويل مبلغ</h3>
                <div class="table-responsive">
                    <form action="{{route('marketer_send_money_request')}}" id="addServiceForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="message" id="message" class="form-control inputs phone" placeholder="{{Translate('المبلغ المطلوب')}}">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" style="width:100%" class="btn btn-sm btn-success save" onclick="addService()">{{Translate('إرسال')}}</button>
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
                url         : '{{ route('marketer_send_money_request') }}' ,
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
