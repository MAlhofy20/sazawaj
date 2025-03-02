@extends('site.master')
@section('title') {{Translate('الطلبات')}} @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <div class="col-12">
                    <h3>
                        
                    </h3>
                </div>
                <div class="col-12">
                    <div class="btns header-buttons">
                        <label for="">{{Translate('عرض حسب :')}}</label>
                        <select name="" id="sortedBy" onchange="sortedBy()" class="form-control" style="width: 25%">
                        <option value="" {{$filter == '' ? 'selected' : ''}}>{{Translate('الكل')}}</option>
                        <option value="day" {{$filter == 'day' ? 'selected' : ''}}>{{Translate('هذا اليوم')}}</option>
                        {{-- <option value="week" {{$filter == 'week' ? 'selected' : ''}}>{{Translate('هذا الأسبوع')}}</option> --}}
                        <option value="month" {{$filter == 'month' ? 'selected' : ''}}>{{Translate('هذا الشهر')}}</option>
                        <option value="year" {{$filter == 'year' ? 'selected' : ''}}>{{Translate('هذه السنة')}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center">
                                {{-- <th>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input" id="checkedAll">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </th> --}}
                                <th>#</th>
                                <th>{{Translate('رقم الطلب')}}</th>
                                <th>{{Translate('اسم المسوق')}}</th>
                                <th>{{Translate('الاسم')}}</th>
                                <th>{{Translate('الجوال')}}</th>
                                <th>{{Translate('الواتس أب')}}</th>
                                {{-- <th>{{Translate('المنتجات')}}</th> --}}
                                <th>{{Translate('الأجمالي')}}</th>
                                <th>{{Translate('العنوان')}}</th>
                                <th>{{Translate('ملاحظات')}}</th>
                                <th>{{Translate('التاريخ')}}</th>
                                <th>{{Translate('حالة الطلب')}}</th>
                                <th>{{Translate('وقت التسجيل')}}</th>
                                <th>{{Translate('التحكم')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i=>$item)
                                <tr style="text-align: center">
                                    {{-- <td>
                                        <label class="custom-control material-checkbox" style="margin: auto">
                                            <input type="checkbox" class="material-control-input checkSingle" id="{{$item->id}}">
                                            <span class="material-control-indicator"></span>
                                        </label>
                                    </td> --}}
                                    <td>{{ ++$i }}</td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->user->first_name}} {{$item->user->last_name}}</td>
                                    <td>{{$item->name}}</td>
                                    <td><a href="tel:{{$item->phone}}" target="_blanck">{{$item->phone}}</a></td>
                                    <td><a href="https://wa.me/{{$item->whatsapp}}" target="_blanck">{{$item->whatsapp}}</a></td>
                                    {{-- <td>
                                        @foreach ($item->Items as $product)
                                            @if(!is_null($product->Section))
                                                * عدد {{$product->count}} من {{$product->Section->title_ar}} 
                                                <br>
                                            @endif
                                        @endforeach
                                    </td> --}}
                                    <td>{{ $item->Items->sum('total') }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->admin_comment }}</td>
                                    <td>{{date('Y-m-d',strtotime($item->date))}}</td>
                                    <td>
                                        @if($item->status == 'new') في انتظار موافقة مندوب 
                                        @elseif($item->status == 'pre-new') قيد المراجعة  
                                        @elseif($item->status == 'pending') معلق  
                                        @elseif($item->status == 'has_provider') قيد التنفيذ  
                                        @elseif($item->status == 'in_way') في الطريق 
                                        @elseif($item->status == 'finish') تم التسليم 
                                        @else تم الألغاء
                                        @endif
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-action">
                                            <a href="{{route('marketer_showorder' , $item->id)}}" class="btn btn-primary btn-sm" title="{{Translate('عرض')}}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- edit modal-->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{Translate('تعديل طلب')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{route('marketer_updatedata_order')}}" id="addAdminForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="">
                <div class="form-group">
                    <label>{{Translate('الاسم')}}</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                {{-- <div class="form-group">
                    <label>{{Translate('البريد الإلكتروني')}}</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div> --}}
                <div class="form-group">
                    <label>{{Translate('الجوال')}}</label>
                    <input type="tel" name="phone" id="phone" class="form-control phone" required>
                </div>
                <div class="form-group">
                    <label>{{Translate('الواتس اب')}}</label>
                    <input type="tel" name="whatsapp" id="whatsapp" class="form-control phone">
                </div>
                <div class="form-group">
                    <label>{{Translate('الملاحظات')}}</label>
                    <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>{{Translate('الدولة - المدينة')}}</label>
                    <select autocomplete="on" name="city_id" id="city_id" class="form-control">
                        @foreach ($cities as $item)
                            <option value="{{$item->id}}">{{$item->Country->title_ar}} - {{$item->title_ar}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group">
                    <label>{{Translate('التاريخ')}}</label>
                    <input type="text" name="date" id="date" class="form-control datepicker">
                </div>
                <div class="form-group">
                    <label>{{Translate('الوقت')}}</label>
                    <input type="time" name="time" id="time" class="form-control">
                </div> --}}
                <div class="form-group">
                    <label>{{Translate('العنوان')}}</label>
                    <input type="text" name="address" id="address" class="form-control" required>
                </div>
                <div class="form-group" style="position: relative;">
                    {{-- <input class="controls" id="pac-input" name="pac-input" value="" placeholder="{{Translate('اكتب موقعك')}}"/> --}}
                    <input type="hidden" name="lat" id="lat" value="24.774265" readonly />
                    <input type="hidden" name="lng" id="lng" value="46.738586" readonly />
                    <div class="col-sm-12" id="add_map"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--end edit modal-->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#orderMenu2').trigger('click');
        });

        function editData(item){
            $("input[name='order_id']").val(item.id);
            $("#name").val(item.name);
            $("#phone").val(item.phone);
            $("#whatsapp").val(item.whatsapp);
            $("#city_id").val(item.city_id);
            $("#address").val(item.address);
            $("#comment").val(item.comment);
            $("#lat").val(item.lat);
            $("#lng").val(item.lng);
            initialize();

            $('#edit').modal('show');
        }
        
        function sortedBy(){
            let sorted_by   = $('#sortedBy').val();
            let url         = window.location.href;
            let separator   = (url.indexOf("?") === -1) ? "?" : "&";
            let querystring = separator == '&' ? url.split('?')[1] : '';
            let href        = '{{route('marketer_show_orders')}}' + '?' + querystring;
            // console.log(sorted_by);
            // console.log(url);
            // console.log(separator);
            // console.log(querystring);
            // console.log(href);
            // console.log(href + '&filter=' + sorted_by);
            window.location.assign(href + '&filter=' + sorted_by);
        }
    </script>
@endsection
