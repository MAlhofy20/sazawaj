@extends('dashboard.master')
@section('title') {{ Translate('الحسابات') }} @endsection
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
                        <span>حسابات : </span>
                        {{ $user->name }}
                    </h3>
                </div>
                <div class="col-12">
                    <div class="btns header-buttons text-center">
                        <a class="btn btn-success waves-effect btn-lg waves-light viewData"
                           style="width: 350px;margin: 2px;">عدد الطلبات المسلمة : <span>{{ count($data) }}</span></a>
                        <a class="btn btn-success waves-effect btn-lg waves-light viewData"
                           style="width: 350px;margin: 2px;">
                             اجمالي قيمة بضاعة العميل :
                            <span>{{ (float) $user->total_user_benfit }}</span>
                        </a>
                        <a class="btn btn-success waves-effect btn-lg waves-light viewData"
                           style="width: 350px;margin: 2px;">المتبقي للعميل : <span
                                    id="pay">{{ (float) $user->total_user_debt }}</span></a>
                    </div>
                </div>
                {{--<div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <h3>
                        سداد حساب التطبيق :
                    </h3>
                </div>
                <div class="col-12">
                    <div class="btns header-buttons">
                        <form action="{{ route('userpaid') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <input type="hidden" name="type" value="admin">
                            <input type="number" min="0" name="debt" id="debt" required class="form-control"
                                   placeholder="المبلغ المسدد">
                            <button class="btn-success form-control" style="margin: 2px">سداد</button>
                        </form>
                    </div>
                </div>--}}
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <h3>
                        سداد حساب العميل :
                    </h3>
                </div>
                <div class="col-12">
                    <div class="btns header-buttons">
                        <form action="{{ route('userpaid') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <input type="hidden" name="type" value="user">
                            <input type="number" min="0" name="debt" id="debt" required class="form-control"
                                   placeholder="المبلغ المسدد">
                            <button class="btn-success form-control" style="margin: 2px">سداد</button>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12">
                    <h3>
                        الطلبات تم التسليم :
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-button" class="table table-bordered table-striped">
                        <thead>
                        <tr style="text-align: center">
                            {{-- <th>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input" id="checkedAll">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </th> --}}
                            <th>#</th>
                            <th>{{ Translate('رقم الطلب') }}</th>
                            <th>{{ Translate('كود الطلب') }}</th>
                            <th>{{ Translate('العميل') }}</th>
                            <th>{{ Translate('المندوب') }}</th>
                            <th>{{ Translate('موقع المندوب') }}</th>
                            <th>{{ Translate('نوع الشحنة') }}</th>
                            <th>{{ Translate('حالة الشحنة') }}</th>
                            <th>{{ Translate('قيمة البضاعة') }}</th>
                            <th>{{ Translate('المرسل') }}</th>
                            <th>{{ Translate('مدينة المرسل') }}</th>
                            <th>{{ Translate('عنوان المرسل') }}</th>
                            <th>{{ Translate('عنوان المرسل بالتفصيل') }}</th>
                            <th>{{ Translate('المرسل اليه') }}</th>
                            <th>{{ Translate('مدينة المرسل اليه') }}</th>
                            <th>{{ Translate('عنوان المرسل اليه') }}</th>
                            <th>{{ Translate('عنوان المرسل اليه بالتفصيل') }}</th>
                            {{-- <th>{{ Translate('قيمة التوصيل') }}</th> --}}
                            <th>{{ Translate('اجمالي الطلب') }}</th>
                            <th>{{ Translate('طريقة الدفع') }}</th>
                            <th>{{ Translate('حالة الطلب') }}</th>
                            {{-- <th>{{ Translate('مكسب التطبيق من التاجر') }}</th> --}}

                            <th>{{ Translate('وقت التسجيل') }}</th>
                            <th>{{ Translate('التحكم') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $payment = [
                            'cash' => 'كاش',
                            'transfer' => 'تحويل بنكي',
                            'online' => 'اونلاين',
                            'not_now' => 'الدفع اجلا',
                        ]; ?>
                        @foreach ($data as $i => $item)
                            <tr style="text-align: center">
                                {{-- <td>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input checkSingle" id="{{$item->id}}">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </td> --}}
                                <td>{{ ++$i }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->api_token }}</td>

                                <td>
                                    {{ $item->user_name }}
                                    <a href="tel:{{ convert_phone_to_international_format($item->user_phone, '966') }}"
                                       target="_blanck">{{ $item->user_phone }}</a>
                                </td>

                                <td>
                                    @if (is_null($item->provider))
                                        لا يوجد
                                    @else
                                        <div>
                                            <p>{{ is_null($item->provider) ? '' : $item->provider->name }}</p>
                                            <a href="tel:{{ convert_phone_to_international_format(is_null($item->provider) ? 0 : $item->provider->phone, '966') }}"
                                               target="_blanck">{{ is_null($item->provider) ? 0 : $item->provider->phone }}</a>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if (is_null($item->provider) || empty($item->provider->lat))
                                        لا يوجد
                                    @else
                                        <a href="https://www.google.com/maps/?q={{ is_null($item->provider) ? 0 : $item->provider->lat }},{{ is_null($item->provider) ? 0 : $item->provider->lng }}"
                                           class="btn btn-info" target="_blanck">{{ Translate('عرض') }}</a>
                                    @endif
                                </td>

                                <td>
                                    <p>{{ is_null($item->section) ? '' : $item->section->title }}</p>
                                </td>
                                <td>
                                    <p>{{ (bool) $item->is_coverd ? 'مغلف' : 'غير مغلف'}}</p>
                                </td>
                                <td>{{number_format($item->package_total, 2)}}</td>
                                <td>
                                    {{ $item->start_name }}
                                    <a href="tel:{{ convert_phone_to_international_format($item->start_phone, '966') }}"
                                       target="_blanck">{{ $item->start_phone }}</a>
                                </td>
                                <td>
                                    <p>{{ is_null($item->start_city) ? '' : $item->start_city->title }}</p>
                                </td>
                                <td>
                                    <a href="https://www.google.com/maps/?q={{ $item->start_lat }},{{ $item->start_lng }}"
                                       target="_blanck">{{ $item->start_address }}</a>
                                </td>
                                <td>
                                    {{ $item->start_address_desc }}
                                </td>
                                <td>
                                    {{ $item->end_name }}
                                    <a href="tel:{{ convert_phone_to_international_format($item->end_phone, '966') }}"
                                       target="_blanck">{{ $item->end_phone }}</a>
                                </td>
                                <td>
                                    <p>{{ is_null($item->end_city) ? '' : $item->end_city->title }}</p>
                                </td>
                                <td>
                                    <a href="https://www.google.com/maps/?q={{ $item->end_lat }},{{ $item->end_lng }}"
                                       target="_blanck">{{ $item->end_address }}</a>
                                </td>
                                <td>
                                    {{ $item->end_address_desc }}
                                </td>

                                {{-- <td>{{ (float) $item->delivery }}</td> --}}
                                <td>{{number_format($item->total_after_promo, 2)}} </td>
                                <td>{{ isset($payment[$item->payment_method]) ? $payment[$item->payment_method] : 'كاش' }}
                                <td>{{ order_status($item->status) }}</td>
                                {{-- <td>{{ (float) $item->delgate_debt }}</td> --}}

                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-action">
                                        <a href="{{ route('showorder', $item->id) }}" class="btn btn-info btn-sm"
                                           title="{{ Translate('عرض') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- <a href="#" class="btn btn-sm btn-danger" title="{{Translate('حذف')}}" onclick="deleteCountry('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
                                                <i class="fas fa-trash"></i>
                                            </a> --}}
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

        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <div class="col-12">
                    <h3>
                        تقارير السداد :
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-button" class="table table-bordered table-striped">
                        <thead>
                        <tr style="text-align: center">
                            <th>#</th>
                            <th>{{ Translate('المبلغ') }}</th>
                            <th>{{ Translate('تاريخ السداد') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (App\Models\User_transction::whereUserId($user->id)->orderBy('id', 'desc')->get()
    as $i => $item)
                            <tr style="text-align: center">
                                <td>{{ ++$i }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
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

@section('script')
    <script>
        function deleteCountry(id) {
            $('#delete_id').val(id);
        }

        function deleteAllCountry(type) {
            $('#delete_type').val(type);
        }

        function checkDataIds() {
            let ids = $('#delete_ids').val();
            let type = $('#delete_type').val();
            if (type != 'all' && ids == '') {
                event.preventDefault();
                $('#delete-all-modal').trigger('click');
            }
        }

        function checkIds() {
            let countrysIds = '';
            $('.checkSingle:checked').each(function() {
                let id = $(this).attr('id');
                countrysIds += id + ' ';
            });
            let requestData = countrysIds.split(' ');
            $('#delete_ids').val(requestData);
        }

        $("#checkedAll").change(function() {
            if (this.checked) {
                $(".checkSingle").each(function() {
                    this.checked = true;
                });
            } else {
                $(".checkSingle").each(function() {
                    this.checked = false;
                });
            }
            checkIds();
        });

        $(".checkSingle").click(function() {
            if ($(this).is(":checked")) {
                var isAllChecked = 0;
                $(".checkSingle").each(function() {
                    if (!this.checked)
                        isAllChecked = 1;
                })
                if (isAllChecked == 0) {
                    $("#checkedAll").prop("checked", true);
                }
            } else {
                $("#checkedAll").prop("checked", false);
            }
            checkIds();
        });

        function sortedBy() {
            let sorted_by = $('#sortedBy').val();
            window.location.assign('?filter=' + sorted_by);
        }

    </script>
@endsection
