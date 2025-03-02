@extends('dashboard.master')
@section('title') تواجدنا @endsection
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
                        <button class="btn bg-teal" title="اضافة" data-toggle="modal" data-target="#add-our_location">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteAllOur_location('more')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف المحدد
                        </button>
                        {{--<button class="btn btn-danger" onclick="deleteAllOur_location('all')" data-toggle="modal" data-target="#confirm-all-del">
                            <i class="fas fa-trash"></i>
                            حذف الكل
                        </button>--}}
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
                                <th>العنوان</th>
                                <th>وقت التسجيل</th>
                                <th>التحكم</th>
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
                                    <td>{{$item->title}}</td>
                                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-action">
                                            <a href="#" class="btn btn-sm bg-teal" title="تعديل" onclick="editOur_location({{ $item }})"  data-toggle="modal" data-target="#edit-our_location">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm btn-danger" title="حذف" onclick="deleteOur_location('{{ $item->id }}')"  data-toggle="modal" data-target="#confirm-del">
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
    <!-- add-our_location modal-->
    <div class="modal fade" id="add-our_location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">إضافة عنصر</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{route('addour_location')}}" id="addOur_locationForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>العنوان</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="form-group" style="position: relative;">
                    {{-- <input class="controls" id="pac-input" name="pac-input" value="" placeholder="اكتب موقعك"/> --}}
                    <input type="hidden" name="lat" id="lat" value="24.774265" readonly />
                    <input type="hidden" name="lng" id="lng" value="46.738586" readonly />
                    <div class="col-sm-12" id="add_map"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" onclick="addOur_location()" class="btn btn-sm btn-success save">حفظ</button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--end add-our_location modal-->
    <!-- edit-our_location modal-->
    <div class="modal fade" id="edit-our_location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">تعديل عنصر</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{route('updateour_location')}}" id="updateOur_locationForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label>العنوان</label>
                    <input type="text" name="title" id="edit_title" class="form-control">
                </div>
                <div class="form-group" style="position: relative;">
                    {{-- <input class="controls" id="edit_pac-input" name="pac-input" value="" placeholder="اكتب موقعك"/> --}}
                    <input type="hidden" name="lat" id="edit_lat" value="24.774265" readonly />
                    <input type="hidden" name="lng" id="edit_lng" value="46.738586" readonly />
                    <div class="col-sm-12" id="edit_add_map"></div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" onclick="updateOur_location()" class="btn btn-sm btn-success save">حفظ</button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--end edit-our_location modal-->
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
            <form action="{{route('deleteour_location')}}" method="post" class="d-flex align-items-center">
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
            <form action="{{route('deleteour_locations')}}" method="post" class="d-flex align-items-center">
                @csrf
                <input type="hidden" name="our_location_ids" id="delete_ids">
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

        function addOur_location() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('addour_location') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#addOur_locationForm")[0]),
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

        function editOur_location(our_location){
            $('#edit_id').val(our_location.id);
            $('#edit_title').val(our_location.title);
            $('#edit_lat').val(our_location.lat > 0 ? our_location.lat : 24.774265);
            $('#edit_lng').val(our_location.lng > 0 ? our_location.lng : 46.738586);
            edit_initialize();
        }

        function updateOur_location() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('updateour_location') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#updateOur_locationForm")[0]),
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

        function deleteOur_location(id){
          $('#delete_id').val(id);
        }

        function deleteAllOur_location(type){
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
            let our_locationsIds = '';
			$('.checkSingle:checked').each(function () {
				let id = $(this).attr('id');
				our_locationsIds += id + ' ';
			});
			let requestData = our_locationsIds.split(' ');
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
    </script>
@endsection
