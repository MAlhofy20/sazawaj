@extends('site.master')
@section('title') 
    {{$type == 'package' ? 'الباقات' : 'التمارين'}}
@endsection
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
                        <button class="btn bg-teal" title="{{Translate('اضافة')}}" data-toggle="modal" data-target="#add-package">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteAllPackage('more')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            {{Translate('حذف المحدد')}}
                        </button>
                        {{-- <button class="btn btn-danger" onclick="deleteAllPackage('all')" data-toggle="modal" data-target="#confirm-all-del">
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
                                <th>
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input" id="checkedAll">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                </th>
                                <th>#</th>
                                <th>{{Translate('الصورة')}}</th>
                                <th>{{Translate('العنوان')}}</th>
                                <th>{{Translate('وقت التسجيل')}}</th>
                                <th>{{Translate('التحكم')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i=>$item)
                                <tr style="text-align: center">
                                    <td>
                                        <label class="custom-control material-checkbox" style="margin: auto">
                                            <input type="checkbox" class="material-control-input checkSingle" id="{{$item->id}}">
                                            <span class="material-control-indicator"></span>
                                        </label>
                                    </td>
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        <a data-fancybox data-caption="{{$item->title_ar}}" href="{{ is_null($item->image) ? url(''.settings('logo')) : url(''.$item->image) }}">
                                            <img src="{{ is_null($item->image) ? url(''.settings('logo')) : url(''.$item->image) }}" height="40px" width="35px" alt="" class="img-circle">
                                        </a>
                                    </td>
                                    <td>{{$item->title}}</td>
                                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                    <div class="btn-action">
                                        <a href="#" class="btn btn-sm bg-teal" title="{{Translate('تعديل')}}" onclick="editPackage({{ $item }})"  data-toggle="modal" data-target="#edit-package">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-danger" title="{{Translate('حذف')}}" onclick="deletePackage('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
                                            <i class="fas fa-trash"></i>
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
    <!-- add-package modal-->
    <div class="modal fade" id="add-package" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{Translate('إضافة عنصر')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{route('site_addpackage')}}" id="addPackageForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{isset($id) ? $id : Auth::id()}}">
                <input type="hidden" name="type" value="{{$type}}">
                <div class="form-group">
                    <label>{{Translate('الصورة')}}</label>
                    <div class="main-input">
                    <input class="file-input" type="file" name="photo" accept="image/*"/>
                    <i class="fas fa-camera gray"></i>
                    <span class="file-name text-right gray">

                    </span>
                    <div class="uploaded-image"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label>عدد الدقائق</label>
                    <input type="number" name="amount" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{Translate('السعر')}}</label>
                    <input type="number" name="price" class="form-control">
                </div>

                @if($type == 'exercise')
                    <div class="form-group">
                        <label>{{Translate('التاريخ')}}</label>
                        <input type="text" name="date" class="form-control datepicker">
                    </div>

                    <div class="form-group">
                        <label>{{Translate('بداية الوقت')}}</label>
                        <input type="time" name="start_time" dir="ltr" class="form-control">
                    </div>
                @endif

                <div class="form-group">
                    <label>{{Translate('العنوان بالعربية')}}</label>
                    <input type="text" name="title_ar" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{Translate('العنوان بالإنجليزية')}}</label>
                    <input type="text" name="title_en" dir="ltr" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>{{Translate('التفاصيل بالعربية')}}</label>
                    <textarea name="desc_ar" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>{{Translate('التفاصيل بالإنجليزية')}}</label>
                    <textarea name="desc_en" dir="ltr" class="form-control" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" onclick="addPackage()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--end add-package modal-->
    <!-- edit-package modal-->
    <div class="modal fade" id="edit-package" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{Translate('تعديل عنصر')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{route('site_updatepackage')}}" id="updatePackageForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label>{{Translate('الصورة')}}</label>
                    <div class="main-input">
                        <input class="file-input" type="file" name="photo" accept="image/*"/>
                        <i class="fas fa-camera gray"></i>
                        <span class="file-name text-right gray">

                        </span>
                        <div class="uploaded-image">
                            <img src="" id="edit_image" alt="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>عدد الدقائق</label>
                    <input type="number" name="amount" id="edit_amount" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{Translate('السعر')}}</label>
                    <input type="number" name="price" id="edit_price" class="form-control">
                </div>

                @if($type == 'exercise')
                    <div class="form-group">
                        <label>{{Translate('التاريخ')}}</label>
                        <input type="text" name="date" id="edit_date" class="form-control datepicker">
                    </div>

                    <div class="form-group">
                        <label>{{Translate('بداية الوقت')}}</label>
                        <input type="time" name="start_time" id="edit_start_time" dir="ltr" class="form-control">
                    </div>
                @endif

                <div class="form-group">
                    <label>{{Translate('العنوان بالعربية')}}</label>
                    <input type="text" name="title_ar" id="edit_title_ar" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{Translate('العنوان بالإنجليزية')}}</label>
                    <input type="text" name="title_en" dir="ltr" id="edit_title_en" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>{{Translate('التفاصيل بالعربية')}}</label>
                    <textarea name="desc_ar" id="edit_desc_ar" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>{{Translate('التفاصيل بالإنجليزية')}}</label>
                    <textarea name="desc_en" dir="ltr" id="edit_desc_en" class="form-control" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" onclick="updatePackage()" class="btn btn-sm btn-success save">{{Translate('حفظ')}}</button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إغلاق')}}</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--end edit-package modal-->
    <!-- confirm-del modal-->
    <div class="modal fade" id="confirm-del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{Translate('تأكيد الحذف')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3 class="text-center">
              {{Translate('هل تريد الاستمرار في عملية الحذف ؟')}}
            </h3>
            <form action="{{route('site_deletepackage')}}" method="post" class="d-flex align-items-center">
                @csrf
                <input type="hidden" name="id" id="delete_id">
                <button type="submit" class="btn btn-sm btn-success">{{Translate('تأكيد')}}</button>
                <button class="btn btn-sm btn-danger" data-dismiss="modal">{{Translate('إلغاء')}}</button>
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
            <h5 class="modal-title" id="exampleModalLabel">{{Translate('تأكيد الحذف')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3 class="text-center">
              {{Translate('هل تريد الاستمرار في عملية الحذف ؟')}}
            </h3>
            <form action="{{route('site_deletepackages')}}" method="post" class="d-flex align-items-center">
                @csrf
                <input type="hidden" name="package_ids" id="delete_ids">
                <input type="hidden" name="type" id="delete_type">
                <button type="submit" onclick="checkDataIds()" class="btn btn-sm btn-success">{{Translate('تأكيد')}}</button>
                <button class="btn btn-sm btn-danger" id="delete-all-modal" data-dismiss="modal">{{Translate('إلغاء')}}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--end confirm-del-all modal-->
@endsection

@section('script')
    <script>
        $(function () {
            $(document).on("change", ".file-input", function () {
                let input = $(this),
                uploadedImage = input.siblings(".uploaded-image"),
                placeHolder = input.siblings(".placeholder"),
                fileName = input.parent().find(".file-name"),
                plus = input.siblings("i.fas.fa-camera");
                if (input.val() === "") {
                fileName.empty();
                uploadedImage.empty();
                placeHolder.removeClass("active");
                plus.fadeIn(100);
                } else {
                plus.fadeOut(100);
                fileName.text(input.val().replace("C:\\fakepath\\", ""));
                uploadedImage.empty();
                uploadedImage.append('<img src="' + URL.createObjectURL(event.target.files[0]) + '">');
                }
            });

            $(document).on("click", ".file-name", function () {
                $(this).siblings(".file-input").click();
            });

            $(document).on("click", ".uploaded-image", function () {
                $(this).addClass("active");
            });

            $("body").on("click", function () {
                $('.uploaded-image').removeClass("active");
            });

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
                $('#label-switch').bootstrapSwitch('onText', 'I');
                $('#label-switch').bootstrapSwitch('offText', 'O');
            });

        });

        function back() {
            // window.location.assign("{{route('site_sections')}}");
        }

        function addPackage() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('site_addpackage') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addPackageForm")[0]),
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

        function editPackage(package){
            $('#edit_id').val(package.id);
            $('#edit_amount').val(package.amount);
            $('#edit_price').val(package.price);
            $('#edit_date').val(package.date);
            $('#edit_start_time').val(package.start_time);
            $('#edit_title_ar').val(package.title_ar);
            $('#edit_title_en').val(package.title_en);
            $('#edit_desc_ar').val(package.desc_ar);
            $('#edit_desc_en').val(package.desc_en);
            $('#edit_image').removeAttr('src');
            $('#edit_image').attr('src' , "{{url('')}}"+package.image);
        }

        function updatePackage() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('site_updatepackage') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updatePackageForm")[0]),
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

        function deletePackage(id){
          $('#delete_id').val(id);
        }

        function deleteAllPackage(type){
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
            let packagesIds = '';
			$('.checkSingle:checked').each(function () {
				let id = $(this).attr('id');
				packagesIds += id + ' ';
			});
			let requestData = packagesIds.split(' ');
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

        $(document).on("click", ".uploaded-image", function () {
            $(this).addClass("active");
        });

        $("body").on("click", function () {
            $('.uploaded-image').removeClass("active");
        });
    </script>
@endsection
