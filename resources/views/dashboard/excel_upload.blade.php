@extends('dashboard.master')
@section('title') رفع طلبات جماعية @endsection
@section('style')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card" style="width:100% !important;">
            <div class="card-header">
                <h3>رفع طلبات من خلال اكسيل شيت</h3>
                <form action="{{route('post_upload_excel_order')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12" style="margin-bottom: 3px">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class="col-sm-4 control-label">{{Translate('ملف الاكسيل')}}</label>
                                <input type="file" name="excel_sheet" class="dropify" data-max-file-size="3000M">
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 20px">
                        <button type="submit" class="btn btn-success waves-effect waves-light" style="width: 100%">حفظ</button>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
        </div>
    </section>

@endsection
