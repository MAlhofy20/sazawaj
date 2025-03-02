@extends('marketer.master')
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
                                <th>{{Translate('المبلغ المرسل')}}</th>
                                <th>{{Translate('وقت الارسال')}}</th>
                                <th>{{Translate('الرد')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i=>$item)
                                <tr style="text-align: center">
                                    <td>{{ ++$i }}</td>
                                    <td>{{$item->message}}</td>
                                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-action">
                                            <a href="{{route('marketer_send_replay_transfer' , ['id' => $item->id ,'status' => 'agree'])}}" class="btn btn-sm btn-success" title="{{Translate('قبول')}}">
                                                {{Translate('قبول')}}
                                            </a>

                                            <a href="{{route('marketer_send_replay_transfer' , ['id' => $item->id ,'status' => 'refused'])}}" class="btn btn-sm bg-danger" title="{{Translate('رفض')}}">
                                                {{Translate('رفض')}}
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

@section('script')
    <script>
        
    </script>
@endsection
