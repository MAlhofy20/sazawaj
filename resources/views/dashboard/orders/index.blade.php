@extends('dashboard.master')
@section('title') الحجوزات @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <input type="hidden" id="page_number" value="1">
        <input type="hidden" id="booking_method" value="{{$booking_method}}">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <div class="col-12">
                    <div class="btns header-buttons">
                        <a href="{{url('orders/new')}}?booking_method={{$booking_method}}" class="btn waves-effect btn-lg waves-light" style="width: 220px;margin: 2px;color:white;background: #daa21c !important">قيد الانتظار</a>
                        <a href="{{url('orders/current')}}?booking_method={{$booking_method}}" class="btn waves-effect btn-lg waves-light" style="width: 220px;margin: 2px;color:white;background: #35b8e0 !important">الحالية</a>

                        <a href="{{url('orders/finish')}}?booking_method={{$booking_method}}" class="btn waves-effect btn-lg waves-light" style="width: 220px;margin: 2px;color:white;background: #10c469 !important">تم الانتهاء</a>
                        <a href="{{url('orders/refused')}}?booking_method={{$booking_method}}" class="btn waves-effect btn-lg waves-light" style="width: 220px;margin: 2px;color:white;background: #ed683d !important">الحجوزات الملغية</a>
                    </div>
                </div>
                <div class="col-12">
                    <h3>
                        @if($status == 'new') الحجوزات قيد الانتظار @endif
                        @if($status == 'current') الحجوزات الحالية @endif
                        @if($status == 'finish') الحجوزات المنتهية @endif
                        @if($status == 'refused') الحجوزات الملغية @endif
                    </h3>
                </div>
                {{--<div class="col-12">
                    <div class="btns header-buttons">
                        <label for="">عرض حسب}}</label>
                        <select name="" id="sortedBy" onchange="sortedBy()" class="form-control" style="width: 25%">
                        <option value="" {{$filter == '' ? 'selected' : ''}}>الكل</option>
                        <option value="day" {{$filter == 'day' ? 'selected' : ''}}>هذا اليوم</option>
                        <option value="month" {{$filter == 'month' ? 'selected' : ''}}>هذا الشهر</option>
                        <option value="year" {{$filter == 'year' ? 'selected' : ''}}>هذه السنة</option>
                        </select>
                    </div>
                </div>--}}
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
                            <th>رقم الحجز</th>
                            <th>الصورة</th>
                            <th>الفرع</th>
                            <th>الاسم</th>
                            <th>رقم الجوال</th>
                            <th>رقم الهوية</th>
                            <th>تاريخ الميلاد</th>
                            <th>طريقة الحجز</th>
                            <th>نوع الحجز</th>
                            {{--<th>طريقة الدفع</th>
                            <th>الاجمالي قبل الخصم</th>
                            <th>الاجمالي بعد الخصم</th>
                            <th>حالة الحجز</th>--}}
                            <th>تاريخ الحجز</th>
                            <th>
                                الملفات المرفقة
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $payment  = ["cash" => "كاش", "transfer" => "تحويل بنكي", "online" => "اون لاين" , "not_now" => "الدفع اجلا" , "point" => "نقاط بيع"]; ?>
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
                                <td>
                                    @if(!empty($item->file))
                                        <a href="{{url(''.$item->file)}}" target="_blank">عرض</a>
                                    @endif
                                </td>
                                <td>
                                    @if(is_null($item->provider))
                                        لا يوجد
                                    @else
                                        <div>
                                            <p>{{is_null($item->provider) ? '' : $item->provider->full_name}}</p>
                                            <a href="tel:{{convert_phone_to_international_format(is_null($item->provider) ? 0 : $item->provider->phone, '966')}}" target="_blanck">{{is_null($item->provider) ? 0 : $item->provider->phone}}</a>
                                        </div>
                                    @endif
                                </td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->id_number}}</td>
                                <td>{{$item->birthdate}}</td>
                                @php
                                    $payment  = [
                                        "now" => 'حجز الآن',
                                        "later" => 'حجز في وقت لاحق',
                                        "online" => 'الدفع اونلاين',
                                        "cash" => 'الدفع كاش',
                                        "point" => 'نقاط بيع',
                                    ];
                                    $type  = [
                                        "issuance" => 'إصدار',
                                        "renewal" => 'تجديد'
                                    ];
                                @endphp
                                <td>
                                    <p>{{isset($payment[$item->booking_method]) ? $payment[$item->booking_method] : 'حجز الآن'}}</p>
                                    @if($item->booking_method == 'later' && !empty($item->booking_later_date)) <p>{{date('Y-m-d', strtotime($item->booking_later_date))}}</p> @endif
                                    @if($item->booking_method == 'later' && !empty($item->booking_later_time)) <p>{{date('H:i', strtotime($item->booking_later_time))}}</p> @endif
                                </td>
                                <td>{{isset($type[$item->type]) ? $type[$item->type] : 'إصدار'}}</td>
                                {{--<td>{{isset($payment[$item->payment_method]) ? $payment[$item->payment_method] : 'كاش'}}</td>
                                <td>{{$item->total_before_promo}}</td>
                                <td>{{$item->total_after_promo}}</td>
                                <td>{{order_status($item->status)}}</td>--}}

                                <td>
                                    <p>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
                                    <p>{{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</p>
                                </td>
                                <td>
                                    @foreach($item->files as $file)
                                        <p>
                                            <span>{{$file->title}}</span>
                                            <a href="{{url('show-order/' . $file->id)}}" target="_blank">(عرض)</a>
                                        </p>
                                        <hr>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-action">
                                        <p style="display: none">{{$item->data_upload}}</p>
                                        <div class="custom-control custom-switch custom-switch-off-success custom-switch-on-danger">
                                            <input type="checkbox" onchange="changeUserStatus('{{ $item->id }}')"
                                                   {{ $item->data_upload ? '' : 'checked' }} class="custom-control-input"
                                                   id="customSwitch{{ $item->id }}">
                                            <label class="custom-control-label" id="status_label{{ $item->id }}"
                                                   for="customSwitch{{ $item->id }}">{{ $item->data_upload ? 'تم الرفع بنجاح' : 'في انتظار الرفع' }}</label>
                                        </div>

                                        <hr>

                                        <div class="btn-action">
                                            <a href="#" class="btn btn-sm bg-teal" title="تعديل" onclick="updateData({{$item}})" data-toggle="modal" data-target="#edit-order{{$item->id}}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </div>

                                        <!-- edit-order modal-->
                                        <div class="modal fade" id="edit-order{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تعديل الطلب</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('updateorder')}}" id="updateOrderForm" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$item->id}}">
                                                            <div class="form-group">
                                                                <label>نوع الطلب</label>
                                                                <select name="type" id="edit_type" class="form-control">
                                                                    <option value="issuance" {{$item->type == 'issuance' ? 'selected' : ''}}>اصدار</option>
                                                                    <option value="renewal" {{$item->type == 'renewal' ? 'selected' : ''}}>تجديد</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>اجمالي الطلب</label>
                                                                <input type="text" name="total_after_promo" id="update_total_after_promo" value="{{$item->total_after_promo}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>الاسم</label>
                                                                <input type="text" name="name" id="edit_name" value="{{$item->name}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>رقم الجوال</label>
                                                                <input type="text" name="phone" id="edit_phone" value="{{$item->phone}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>رقم الهوية</label>
                                                                <input type="text" name="id_number" id="edit_id_number" value="{{$item->id_number}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>تاريخ الميلاد</label>
                                                                <input type="text" name="birthdate" id="edit_birthdate" value="{{$item->birthdate}}" class="form-control old_datepicker">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>تاريخ الحجز</label>
                                                                <input type="text" name="created_at_date" id="" value="{{Carbon\Carbon::parse($item->created_at)->format('Y-m-d')}}" class="form-control old_datepicker">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>وقت الحجز</label>
                                                                <input type="time" dir="ltr" name="created_at_time" id="" value="{{Carbon\Carbon::parse($item->created_at)->format('H:i:s')}}" class="form-control">
                                                            </div>
                                                            {{-- <div class="form-group">
                                                                <label>الصورة</label>
                                                                <input type="file" name="photo" id="photo" class="form-control">
                                                            </div> --}}
                                                            <div class="d-flex justify-content-center">
                                                                <button type="submit" class="btn btn-sm btn-success save">حفظ</button>
                                                                <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end edit-admin modal-->

                                        <hr>

                                        <a href="#" class="btn btn-sm btn-danger" title="حذف" onclick="deleteCountry('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                                {{--<td>
                                    <div class="btn-action">
                                        <a href="{{route('showorder' , $item->id)}}" class="btn btn-info btn-sm" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($status == 'new')
                                            <a href="{{route('changeorder' , ['id' => $item->id, 'status' => 'current'])}}" class="btn btn-success btn-sm" style="width: 100%" title="تم التجهيز">
                                                تأكيد الحجز
                                            </a>

                                            <a href="{{route('changeorder' , ['id' => $item->id, 'status' => 'refused'])}}" class="btn btn-danger btn-sm" style="width: 100%" title="الغاء الحجز">
                                                الغاء الحجز
                                            </a>

                                        --}}{{-- @elseif($status == 'current')
                                            <a href="{{route('changeorder' , ['id' => $item->id, 'status' => 'finish'])}}" class="btn btn-success btn-sm" style="width: 100%;margin-top: 5px" title="تم الانتهاء">
                                                تم الانتهاء
                                            </a> --}}{{--
                                        @endif

                                        --}}{{-- <a href="#" class="btn btn-sm btn-danger" title="حذف" onclick="deleteCountry('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
                                            <i class="fas fa-trash"></i>
                                        </a> --}}{{--
                                    </div>
                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="allDepartmentsLinks">{{$data->links()}}</div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('modal')
    <!-- confirm-del modal-->
    <div class="modal fade" id="confirm-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        هل تريد الاستمرار في عملية الحذف ؟
                    </h3>
                    <form action="{{route('deleteorder')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="id" id="delete_id">
                        <button type="submit" class="btn btn-sm btn-success">تأكيد</button>
                        <button class="btn btn-sm btn-danger" data-dismiss="modal">إلغاء</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end confirm-del modal-->
    <!-- confirm-del-all modal-->
    <div class="modal fade" id="confirm-all-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">
                        هل تريد الاستمرار في عملية الحذف ؟
                    </h3>
                    <form action="{{route('deletecountrys')}}" method="post" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="country_ids" id="delete_ids">
                        <input type="hidden" name="type" id="delete_type">
                        <button type="submit" onclick="checkDataIds()" class="btn btn-sm btn-success">تأكيد</button>
                        <button class="btn btn-sm btn-danger" id="delete-all-modal" data-dismiss="modal">إلغاء</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end confirm-del-all modal-->
@endsection

@section('script')
    <script>
        function getUrlVars(url_with_query)
        {
            var vars = [], hash;
            var hashes = url_with_query.slice(url_with_query.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }

        $(document).on('click', '#allDepartmentsLinks a', function(e) {
            e.preventDefault();
            /*let sortedByName  = $('#sortedByName').val();
            let sortedByPhone = $('#sortedByPhone').val();
            let sortedByEmail = $('#sortedByEmail').val();
            let city          = $('#city').val();
            let section       = $('#section').val();
            let queries       = $(this).attr('href') + '&name=' + sortedByName + '&phone=' + sortedByPhone + '&email=' + sortedByEmail + '&city=' + city + '&section=' + section;
            console.log(queries);
            $('.allDepartmentsDiv').load(queries + ' .allDepartmentsDiv');
            $(window).scrollTop(0);*/

            let query_string = getUrlVars($(this).attr('href'));
            $('#page_number').val(query_string['page']);
            let page = query_string['page'];
            let booking_method = $('#booking_method').val();
            window.location.assign(`?page=${page}&booking_method=${booking_method}`);
        });

        function changeUserStatus(id) {
            var tokenv = "{{ csrf_token() }}";
            $.ajax({
                type: 'POST',
                url: '{{ route('changestatusorder') }}',
                datatype: 'json',
                data: {
                    'id': id,
                    '_token': tokenv
                },
                success: function(msg) {
                    //success here
                    if (msg == 0)
                        return false;
                    else
                        $('#status_label' + id).html(msg);
                }
            });
        }

        function deleteCountry(id){
            $('#delete_id').val(id);
        }

        function deleteAllCountry(type){
            $('#delete_type').val(type);
        }

        function checkDataIds(){
            let ids  = $('#delete_ids').val();
            let type = $('#delete_type').val();
            if(type != 'all' && ids == ''){
                event.preventDefault();
                $('#delete-all-modal').trigger('click');
            }
        }

        function checkIds(){
            let countrysIds = '';
            $('.checkSingle:checked').each(function () {
                let id = $(this).attr('id');
                countrysIds += id + ' ';
            });
            let requestData = countrysIds.split(' ');
            $('#delete_ids').val(requestData);
        }

        $("#checkedAll").change(function(){
            if(this.checked){
                $(".checkSingle").each(function(){
                    this.checked=true;
                });
            }else{
                $(".checkSingle").each(function(){
                    this.checked=false;
                });
            }
            checkIds();
        });

        $(".checkSingle").click(function () {
            if ($(this).is(":checked")){
                var isAllChecked = 0;
                $(".checkSingle").each(function(){
                    if(!this.checked)
                        isAllChecked = 1;
                })
                if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }
            }else {
                $("#checkedAll").prop("checked", false);
            }
            checkIds();
        });

        function sortedBy(){
            let sorted_by = $('#sortedBy').val();
            window.location.assign('?filter=' + sorted_by);
        }
    </script>
@endsection
