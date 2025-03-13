@extends('dashboard.master')
@section('title') الإشعارات @endsection

@section('content')
<style>
    /* role="button" */
    p[role="button"] {
        cursor: pointer;
        color: inherit;
    }
    /* onhover */
    p[role="button"]:hover {
        text-decoration: underline;
    }
</style>
<div class="container">
    <div class="card mx-auto" style="max-width: 800px;">
        <div class="card-header text-center">
            <h3>الإشعارات</h3>
        </div>
        <p onclick="markAllNotificationsRead()" role="button" style="color: inherit; margin-right: 10px; margin-top: 10px;">
            تحديد الكل كمقروء
        </p>

        <!-- Notifications Details -->
        <div class="card-body text-center">
            @forelse($notifications as $notification)
                <div onclick="markNotificationAsRead(`{{$notification->id}}`, `{{ $notification->url ?? '#' }}`)"  id="alert_{{ $notification->id }}" class="alert  {{$notification->seen ? 'alert-secondary' : 'alert-info' }}" role="alert" style="cursor: pointer;">
                    <p style="text-decoration: none; color: inherit;">
                        <i class="fas {{$notification->seen ? 'fa-envelope-open' : 'fa-envelope' }} float-right"></i>
                        {{ $notification->message_ar ?? 'إشعار جديد' }}
                        <span class="float-left text-light text-sm">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </p>
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


    function markAllNotificationsRead() {
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
    }

    function markNotificationAsRead(id, url) {
        const alertElement = document.getElementById(`alert_${id}`);
        alertElement.classList.remove('alert-info');
        alertElement.classList.add('alert-secondary');
        alertElement.querySelector('i').classList.remove('fa-envelope');
        alertElement.querySelector('i').classList.add('fa-envelope-open');
        $.ajax({
            type: 'POST',
            url: `{{ route('admin_notificationsRead') }}`,
            datatype: 'json',
            async: true,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                'id': id,
            },
            success: function(msg) {
                if (msg.value != '1') {
                    alert('something error happened');
                }else{
                    if(url != '#'){
                        window.location.href = url;
                    }else{
                        location.reload();
                    }
                }
            }
        });
    }
</script>
