@extends('site.master')
@section('title') {{Translate('تحويلات مالية')}} @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <div class="col-12">
                    <div class="btns header-buttons">
                        {{-- <button class="btn bg-teal" title="{{Translate('اضافة')}}" data-toggle="modal" data-target="#add-user">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteAllUser('more')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{Translate('حذف المحدد')}}
                        </button> --}}
                        {{-- <button class="btn btn-danger" onclick="deleteAllUser('all')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{Translate('حذف الكل')}}
                        </button> --}}
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center">
                                <th>#</th>
                                <th>{{Translate('الأسم')}}</th>
                                <th>{{Translate('البريد الإلكتروني')}}</th>
                                <th>{{Translate('الجوال')}}</th>
                                <th>{{Translate('الواتس اب')}}</th>
                                <th>{{Translate('المبالغ المستحقة')}}</th>
                                <th>{{Translate('ارسال مبالغ')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i=>$item)
                                <tr style="text-align: center">
                                    <td>{{ ++$i }}</td>
                                    <td>{{$item->first_name}}  {{$item->last_name}}</td>
                                    <td><a href="mailto:{{$item->email}}" target="_blanck">{{$item->email}}</a></td>
                                    <td><a href="tel:{{convert_phone_to_international_format($item->phone_code , $item->phone)}}" target="_blanck">{{convert_phone_to_international_format($item->phone_code , $item->phone)}}</a></td>
                                    <td><a href="https://wa.me/{{convert_phone_to_international_format($item->whatsapp_code , $item->whatsapp)}}" target="_blanck">{{convert_phone_to_international_format($item->whatsapp_code , $item->whatsapp)}}</a></td>
                                    <td>{{$item->commission}}</td>
                                    <td>
                                        <div class="btn-action">
                                            <form action="{{route('marketer_send_money_transfer')}}" id="addServiceForm" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="to_id" value="{{$item->id}}">
                                                <div class="form-group">
                                                    <input type="number" name="message" min="1" max="{{$item->commission}}" id="message" class="form-control inputs" placeholder="{{Translate('المبلغ المطلوب')}}" required>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" style="width:100%" class="btn btn-sm btn-success">{{Translate('إرسال')}}</button>
                                                </div>
                                            </form>
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

@section('script')
    <script>
        
    </script>
@endsection
