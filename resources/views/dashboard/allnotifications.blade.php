@extends('dashboard.master')
@section('title') الإشعارات @endsection

@section('content')
<div class="container">
    <div class="card mx-auto" style="max-width: 800px;">
        <div class="card-header text-center">
            <h3>الإشعارات</h3>
        </div>

        <!-- Notifications Details -->
        <div class="card-body text-center">
            @forelse($notifications as $notification)
                <div class="alert {{$notification->seen ? 'alert-secondary' : 'alert-info' }}" role="alert">
                    <a href="{{ $notification->url ?? '#' }}" style="text-decoration: none; color: inherit;">
                        <i class="fas {{$notification->seen ? 'fa-envelope-open' : 'fa-envelope' }} "></i> 
                        {{ $notification->message_ar ?? 'إشعار جديد' }}
                        <span class="float-right text-light text-sm">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </a>
                </div>
            @empty
                <h4 style="color: red"> لا يوجد إشعارات </h4>
            @endforelse

            <!-- Pagination Links -->
            <div class="mt-3">
                {{ $notifications->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>

    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $.ajax({
            type: 'POST',
            url: '{{ route('admin_notificationsRead') }}',
            datatype: 'json',
            async: true,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(msg) {
                if (msg.value != '1') {
                    alert('something error happened');
                }else{
                    document.getElementById("notificationCounter").classList.remove('badge-warning');
                    document.getElementById("notificationCounter").innerText='';
                }
            }
        });
    });
</script>
