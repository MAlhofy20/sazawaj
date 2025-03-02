@extends('site.master')
@section('title') {{Translate('السلة')}} @endsection
@section('style')
    <style>
        /* remove increase and decrease arrows from number input */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .cycle-div{
            background: rgb(0, 0, 0);
            position: absolute;
            display: block;
            font-size: 14px;
            border-radius: 50%;
            width: 15px;
            height: 15px;
            text-align: center;
            line-height: 15px;
        }
    </style>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <div class="col-12 text-center">
                    <div class="btns header-buttons">
                        @if(count($cart) > 0)
                            <button class="btn bg-teal data-full" title="" data-toggle="modal" data-target="#add-admin">
                                {{Translate('اطلب الان')}}
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-12 text-center">
                    <span style="color: red">{{Translate('السعر الإجمالي :')}}</span>
                    <span id="totalSpan">{{$total}}</span> <span style="color: red">{{Translate('ريال سعودي')}}</span>
                    <p id="alertMsg" @if(count($cart) > 0) style="color: red;display:none" @else style="color: red" @endif>{{Translate('لا يوجد منتجات بالسلة')}}</p>

                    <input type="hidden" id="variable_rate" value="{{settings('variable_rate')}}">
                </div>
            </div>
            <!-- /.card-header -->
            @if(count($cart) > 0)
                <div class="card-body data-full">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr style="text-align: center">
                                    {{-- <th>#</th> --}}
                                    <th>{{Translate('الصورة')}}</th>
                                    <th>{{Translate('اسم المنتج')}}</th>
                                    <th>{{Translate('الكمية')}}</th>
                                    <th>
                                        {{Translate('السعر')}}
                                        <p style="color: red">{{Translate('يمكن التعديل بالزيادة او الخصم بنسبة ')}} {{settings('variable_rate')}} %</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $i=>$item)
                                    <?php
                                        $cart = App\Models\Cart::where('user_id', Auth::id())->where('section_id', $item->id)->first();
                                        $quantity   = (int)  $item->quantity;
                                        $cart_count = 0;
                                        if (isset($cart)) {
                                            $count      = (int) $cart->count;
                                            $quantity   = $quantity - $count;
                                            $cart_count = $cart->count;
                                        }
                                    ?>
                                    <tr style="text-align: center" id="tr{{$item->id}}">
                                        {{-- <td>{{ ++$i }}</td> --}}
                                        <td>
                                            <a data-fancybox data-caption="{{is_null($item->Section) ? '' : $item->Section->title}}" href="{{is_null($item->Section) ? url('public/none.png') : url($item->Section->Images->first()->image) }}">
                                                <img src="{{is_null($item->Section) ? url('public/none.png') : url($item->Section->Images->first()->image) }}" height="40px" width="35px" alt="" class="img-circle">
                                            </a>
                                        </td>
                                        <td>{{is_null($item->Section) ? '' : $item->Section->title_ar}}</td>
                                        <td>
                                            <div>
                                                <span class="cycle-div">
                                                    <a href="" class="" style="color: #fff;" onclick="updateCartData({{$item->id}} ,'count' , '-' , event)">-</a>
                                                </span>
                                                <input type="tel" class="phone" name="" value="{{$item->count}}" id="count{{$item->id}}" style="text-align: center" disabled>
                                                <span class="cycle-div">
                                                    <a href="" class="" style="color: #fff;" onclick="updateCartData({{$item->id}} ,'count' , '+' , event)">+</a>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="cycle-div">
                                                    <a href="" class="" style="color: #fff;" onclick="updateCartData({{$item->id}} ,'total' , '-' , event)">-</a>
                                                </span>

                                                <input type="hidden" id="max_total{{$item->id}}" value="{{is_null($item->Section) ? 0 : ($item->Section->price * $item->count) + (($item->Section->price * $item->count) * settings('variable_rate') / 100)}}">
                                                <input type="hidden" id="min_total{{$item->id}}" value="{{is_null($item->Section) ? 0 : ($item->Section->price * $item->count) - (($item->Section->price * $item->count) * settings('variable_rate') / 100)}}">
                                                <input type="hidden" id="price{{$item->id}}" value="{{is_null($item->Section) ? 0 : $item->Section->price}}">

                                                <input type="tel" class="phone" name="" value="{{$item->total}}" id="total{{$item->id}}" style="text-align: center" disabled>
                                                <span class="cycle-div">
                                                    <a href="" class="" style="color: #fff;" onclick="updateCartData({{$item->id}} ,'total' , '+' , event)">+</a>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                <form id="updateCartForm">
                                    @csrf
                                    <input type="hidden" name="cart_id" id="cart_id">
                                    <input type="hidden" name="count" id="count">
                                    <input type="hidden" name="total" id="total">
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- add-admin modal-->
    <div class="modal fade" id="add-admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{Translate('طلب جديد')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" id="addAdminForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>{{Translate('الاسم')}}</label>
                    <input type="text" name="name" class="form-control">
                </div>
                {{-- <div class="form-group">
                    <label>{{Translate('البريد الإلكتروني')}}</label>
                    <input type="email" name="email" class="form-control">
                </div> --}}
                <div class="form-group">
                    <label>{{Translate('الجوال')}}</label>
                    <input type="tel" name="phone" class="form-control phone">
                </div>
                <div class="form-group">
                    <label>{{Translate('الواتس اب')}}</label>
                    <input type="tel" name="whatsapp" class="form-control phone">
                </div>
                <div class="form-group">
                    <label>{{Translate('الملاحظات')}}</label>
                    <textarea name="comment" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>{{Translate('الدولة - المدينة')}}</label>
                    <select name="city_id" id="" class="form-control">
                        @foreach ($cities as $item)
                            <option value="{{$item->id}}">{{$item->Country->title_ar}} - {{$item->title_ar}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group">
                    <label>{{Translate('التاريخ')}}</label>
                    <input type="text" name="date" class="form-control datepicker">
                </div>
                <div class="form-group">
                    <label>{{Translate('الوقت')}}</label>
                    <input type="time" name="time" class="form-control">
                </div> --}}
                <div class="form-group">
                    <label>{{Translate('العنوان')}}</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="form-group" style="position: relative;">
                    {{-- <input class="controls" id="pac-input" name="pac-input" value="" placeholder="{{Translate('اكتب موقعك')}}"/> --}}
                    <input type="hidden" name="lat" id="lat" value="24.774265" readonly />
                    <input type="hidden" name="lng" id="lng" value="46.738586" readonly />
                    <div class="col-sm-12" id="add_map"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" onclick="addAdmin()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--end add-admin modal-->
@endsection

@section('script')
    <script>
        function updateCartData(cart_id , id = 'count' , operate = '' , event) {
            event.preventDefault();
            let variable_rate = parseFloat($('#variable_rate').val());
            let price         = parseFloat($('#price' + cart_id).val());
            let max_total     = parseFloat($('#max_total' + cart_id).val());
            let min_total     = parseFloat($('#min_total' + cart_id).val());

            if(id == 'count'){ // count change
                if(operate == '+') $('#count' + cart_id).val(parseFloat($('#count' + cart_id).val()) + 1);
                else $('#count' + cart_id).val(parseFloat($('#count' + cart_id).val()) - 1);

                let count = parseFloat($('#count' + cart_id).val());
                $('#total' + cart_id).val(price * count);
                let total = parseFloat($('#total' + cart_id).val());
                let dis   = total * variable_rate / 100;

                $('#max_total' + cart_id).val(total + dis);
                $('#min_total' + cart_id).val(total - dis);

            }else{ // total change
                let newTotal = parseFloat($('#total' + cart_id).val());
                if(operate == '+') newTotal = parseFloat($('#total' + cart_id).val()) + 1;
                else newTotal = parseFloat($('#total' + cart_id).val()) - 1;

                let count = $('#count' + cart_id).val();
                let total = $('#total' + cart_id).val();

                if(newTotal < min_total ){
                    $.notify('لا يمكن الخصم لقد وصلت للحد الأدنى ', 'danger');
                    if(operate == '') $('#total' + cart_id).val(count * price);
                    return false;
                }

                if(newTotal > max_total){
                    $.notify('لا يمكن الزيادة لقد وصلت للحد الأقصى', 'danger');
                    if(operate == '') $('#total' + cart_id).val(count * price);
                    return false;
                }

                $('#total' + cart_id).val(newTotal);
            }



            count = $('#count' + cart_id).val();
            total = $('#total' + cart_id).val();

            $('#cart_id').val(cart_id);
            $('#count').val(count);
            $('#total').val(total);

            $.ajax({
                type        : 'POST',
                url         : '{{ route('marketer_update_cart') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateCartForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $.notify(msg.msg, 'danger');
                        $('#count' + cart_id).val(msg.count);
                        $('#total' + cart_id).val(msg.total);
                        $('#totalSpan').html(msg.total_cart);
                    }else if(msg.value == '2'){
                        $('#tr' + cart_id).hide();
                        $('#totalSpan').html(msg.total_cart);
                        if(msg.total_cart == 0){
                            $('#alertMsg').show();
                            $('.data-full').hide();
                        }
                    }else{
                        $('#totalSpan').html(msg.total_cart);
                    }
                }
            });
        }

        function addAdmin() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('store_order') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addAdminForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        $('.save').notify(
                            msg.msg, {
                                position: "bottom"
                            }
                        );
                    }else{
                        window.location.reload();
                    }
                }
            });
        }
    </script>
@endsection
