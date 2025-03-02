@extends('dashboard.master')
@section('title') مراحعة الملف الشخصي @endsection
@section('style')

@endsection
@section('content')
<div class="container">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-header text-center">
        <h3>تحديث صورة الملف الشخصي </h3>
        </div>

        <!-- User Details (Name & Email) -->
        <div class="card-body text-center">
            <h4>{{ $user->first_name }}</h4>
            <p class="text-muted">{{ $user->email }}</p>

            <!-- Images Row -->
            <div class="row justify-content-center align-items-center">
                <!-- Old Image -->
                <div class="col-md-6">
                    <h5>الصورة الحالية</h5>
                    <img src="{{ url('' . $user->avatar) }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="width: 150px; height: 150px; object-fit: cover;" 
                         alt="Old User Photo">
                </div>

                <!-- New Image -->
                <div class="col-md-6">
                    <h5>الصورة الجديدة</h5>
                    <img src="{{ url('' . $user->avatar_edit) }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="width: 150px; height: 150px; object-fit: cover;" 
                         alt="New User Photo">
                </div>
            </div>
        </div>

        <!-- Accept & Reject Buttons -->
        <div class="card-footer text-center">
            <form action="{{ route('user.accept', $user->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success px-4">قبول</button>
            </form>

            <form action="{{ route('user.reject', $user->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger px-4">رفض</button>
            </form>
        </div>
    </div>
</div>
@endsection