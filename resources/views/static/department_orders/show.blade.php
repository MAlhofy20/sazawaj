@extends('dashboard.master')
@section('title') {{Translate('عرض طلب')}} @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline item -->
              <div>
                <i class="fas fa-info bg-green"></i>
                <div class="timeline-item">
                  <h3 class="timeline-header">{{Translate('تفاصيل الطلب')}}</h3>

                  <div class="timeline-body">
                    <div class="bill-info">
                      <ul>
                        <li class="text-bold">
                            <span>{{Translate('رقم الطلب')}}</span>
                            <span>:</span>
                            <span>{{$order->id}}</span>
                        </li>
                        <li class="text-bold">
                            <span>{{Translate('حالة الطلب')}}</span>
                            <span>:</span>
                            <span>{{order_status($order->status)}}</span>
                        </li>
                        <li>
                            <span>{{Translate('أسم العميل')}}</span>
                            <span>:</span>
                            <span>{{$order->name}}</span>
                        </li>
                        <li>
                            <span>{{Translate('جوال العميل')}}</span>
                            <span>:</span>
                            <span>{{$order->phone}}</span>
                        </li>
                        <li>
                            <span>{{Translate('رقم الهوية')}}</span>
                            <span>:</span>
                            <span>{{$order->id_number}}</span>
                        </li>
                        <li>
                            <span>{{Translate('المدينة')}}</span>
                            <span>:</span>
                            <span>{{$order->city_title_ar}}</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-info bg-green"></i>
                <div class="timeline-item">
                  <h3 class="timeline-header">{{Translate('تفاصيل العقار')}}</h3>

                  <div class="timeline-body">
                    <div class="bill-info">

                        <p>
                            <span class="text-bold">{{Translate('صورة العقار')}}</span>
                            <span class="text-bold">:</span>
                            <span>
                                <a data-fancybox data-caption="{{$order->title_ar}}" href="{{ url(''.$order->image) }}">
                                    <img src="{{ url(''.$order->image) }}" height="75px" width="70px" alt="" class="img-circle">
                                </a>
                            </span>
                        </p>

                        <ul>
                            <li class="text-bold">
                                <span>{{Translate('اسم العقار بالعربية')}}</span>
                                <span>:</span>
                                <span>{{$order->title_ar}}</span>
                            </li>
                            <li>
                                <span>{{Translate('اسم العقار بالانجليزية')}}</span>
                                <span>:</span>
                                <span>{{$order->title_en}}</span>
                            </li>
                            <li class="text-bold">
                                <span>{{Translate('عنوان العقار بالعربية')}}</span>
                                <span>:</span>
                                <span>{{$order->address_ar}}</span>
                            </li>
                            <li>
                                <span>{{Translate('عنوان العقار بالانجليزية')}}</span>
                                <span>:</span>
                                <span>{{$order->address_en}}</span>
                            </li>
                        </ul>

                        <p>
                            <span class="text-bold">{{Translate('وصف العقار بالعربية')}}</span>
                            <span class="text-bold">:</span>
                            <span>{{$order->desc_ar}}</span>
                        </p>
                        <p>
                            <span class="text-bold">{{Translate('وصف العقار بالانجليزية')}}</span>
                            <span class="text-bold">:</span>
                            <span>{{$order->desc_en}}</span>
                        </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              {{-- <div>
                <i class="fas fa-list bg-yellow"></i>
                <div class="timeline-item">
                  <h3 class="timeline-header">{{Translate('الطلبات')}}</h3>
                  <div class="timeline-body">
                        @foreach ($order->order_items as $item)
                            <div class="order-item">
                                <div class="img">
                                    <div class="img-c">
                                        <a data-fancybox data-caption="{{!is_null($order->section) ? $order->section->title_ar : $order->section_title_ar}}"
                                            href="{{is_null($order->section) ? url('/public/none.png') : url('' . $order->section->image)}}">
                                            <img src="{{is_null($order->section) ? url('/public/none.png') : url('' . $order->section->image)}}" alt="...">
                                        </a>
                                        <span class="count">{{$item->amount}}</span>
                                    </div>
                                    <span class="order-name">{{!is_null($order->section) ? $order->section->title_ar : $order->section_title_ar}}</span>
                                </div>
                                <div class="item-price">
                                    <span> <a href="https://www.google.com/maps/?q={{$item->lat}},{{$item->lng}}" target="_blanck">{{$item->address}}</a> </span>
                                </div>
                                <div class="item-total">
                                    <span> {{$item->name}}</span>
                                </div>
                                <div class="item-total">
                                    <span> {{$item->phone}}</span>
                                </div>
                                <div class="item-total">
                                    <span>@if(!empty($item->gender)) {{$item->gender == 'female' ? 'مصلى السيدات' : 'مصلى الرجال'}} @endif</span>
                                </div>
                                <div class="item-total">
                                    <span> <a href="" onclick="showNotes('{{$item->notes}}')" data-toggle="modal" data-target="#notes-model">ملاحظات</a></span>
                                </div>
                                <div class="item-price">
                                    <span> {{$order->section_price}}  </span> {{$item->amount}}X
                                </div>
                                <div class="item-total">
                                    <span> {{$order->section_price * $item->amount}} ريال سعودي</span>
                                </div>
                            </div>
                        @endforeach
                  </div>
                </div>
              </div> --}}
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-info bg-blue"></i>
                <div class="timeline-item">
                  <h3 class="timeline-header">{{Translate('بيانات مضافة للطلب')}} </h3>
                  <div class="timeline-body">
                      <a href="#" id="dataBtn" class="btn btn-success" onclick="addData()" style="margin-bottom: 5px"><i class="fas fa-plus"></i> {{Translate('أضافة بيانات')}}</a>
                    <div class="bill-info">
                      <ul>
                            @if(is_null($order->data))
                                <li id="dataMsg" style="text-align: center">
                                    <span class="alert alert-danger" style="color: white">{{Translate('لم يتم أضافة بيانات لهذا الطلب')}}</span>
                                </li>
                            @else
                                @foreach (json_decode($order->data) as $item)
                                    <li>
                                        <span>{{$item->title}}</span>
                                        <span>:</span>
                                        <span>{{$item->desc}}</span>
                                    </li>
                                @endforeach
                            @endif

                            <li id="dataForm" style="display: none">
                                <form action="{{route('addData')}}" id="addDataForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="counter" value="0">
                                    <input type="hidden" name="id" value="{{$order->id}}">
                                    <div class=" dataDiv">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" name="title[0]" class="form-control" placeholder="اكتب العنوان مثال : الإيميل">
                                            </div>
                                            <div class="col-6">
                                                <textarea name="desc[0]" id="" cols="30" rows="2" class="form-control" placeholder="اكتب وصف البيانات مثال : ex@info.sa"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-sm btn-success save"><i class="fas fa-save"></i> {{Translate('حفظ')}}</button>
                                            <button class="btn btn-sm btn-info" onclick="addInputs()"><i class="fas fa-plus"></i> {{Translate('اضافة بيان')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-user bg-purple"></i>
                <div class="timeline-item">
                  <h3 class="timeline-header">{{Translate('بيانات الموظف')}}</h3>
                  <div class="timeline-body">
                        @if($order->status == 'new')
                            <a href="#" class="btn btn-success" id="employeeBtn" onclick="addEmployee()" style="margin-bottom: 5px"><i class="fas fa-user"></i> {{Translate('تعيين موظف')}}</a>
                            <a href="{{route('changedepartment_order',['id'=>$order->id , 'status'=>'refused'])}}" class="btn btn-danger" style="margin-bottom: 5px"><i class="fas fa-window-close"></i> {{Translate('رفض الطلب')}}</a>
                        @endif
                        @if($order->status == 'new' || $order->status == 'current')
                            <a href="{{route('changedepartment_order',['id'=>$order->id , 'status'=>'finish'])}}" class="btn btn-success" style="margin-bottom: 5px"><i class="fas fa-check"></i> {{Translate('انهاء الطلب')}}</a>
                        @endif
                    <div class="bill-info">
                      <ul>
                          @if($order->status == 'refused' || is_null($order->provider_id))
                            <li style="text-align: center" id="employeeMsg">
                                <span class="alert alert-danger" style="color: white">{{Translate('لم يتم تعيين موظف لهذا الطلب')}}</span>
                            </li>
                          @else
                            <li>
                                <span>{{Translate('أسم الموظف')}}</span>
                                <span>:</span>
                                <span>{{!is_null($order->provider) ? $order->provider->name : $order->provider_name}}</span>
                            </li>
                            <li>
                                <span>{{Translate('جوال الموظف')}}</span>
                                <span>:</span>
                                <span>{{!is_null($order->provider) ? $order->provider->phone : $order->provider_phone}}</span>
                            </li>
                        @endif

                            <li id="employeeForm" style="display: none">
                                <form action="{{route('agreedepartment_order')}}" id="addEmployeeForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$order->id}}">
                                    <div class="row">
                                        <div class="col-12">
                                            <label>{{Translate('الموظف')}}</label>
                                            <select name="provider_id" class="form-control">
                                                @foreach (get_active_users_by('provider') as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-sm btn-success save" style="width: 100%"><i class="fas fa-save"></i> {{Translate('إرسال')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
@endsection

@section('modal')
@endsection

@section('script')
    <script>
        function addEmployee() {
            event.preventDefault();
            // $('#employeeBtn').hide();
            $('#employeeMsg').hide();
            $('#employeeForm').show();
        }

        function addData() {
            event.preventDefault();
            $('#dataBtn').hide();
            $('#dataMsg').hide();
            $('#dataForm').show();
        }

        function addInputs() {
            event.preventDefault();
            let counter = parseInt($('#counter').val()) + 1;
            $('#counter').val(counter);
            $('.dataDiv').append('<div class="row" style="margin-top:5px"><div class="col-6"><input type="text" name="title['+ counter +']" class="form-control" placeholder="اكتب العنوان مثال : الإيميل"></div><div class="col-6"><textarea name="desc['+ counter +']" id="" cols="30" rows="2" class="form-control" placeholder="اكتب وصف البيانات مثال : ex@info.sa"></textarea></div></div>');
        }
    </script>
@endsection
