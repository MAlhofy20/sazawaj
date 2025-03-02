@extends('site.master')
@section('title') الاشعارات @endsection
@section('style')
<style>
.notifications-list {
        max-width: 600px;
        margin: auto;
        padding: 20px;
    }

    .notification-item {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
    }

    .notification-item.unread {
        background: #ede2ab;
    }

    .notification-icon {
        font-size: 24px;
        color: #b72dd2;
        margin-left: 12px;
    }

    .notification-content {
        flex-grow: 1;
    }

    .notification-text {
        margin: 0;
        font-size: 16px;
        color: #333;
    }

    .notification-time {
        font-size: 14px;
        color: #777;
    }

    .no-notifications {
        text-align: center;
        padding: 20px;
        font-size: 18px;
        color: #b72dd2;
    }
    .page-title {
    position: relative;
    color: #b72dd2; /* Main color */
    font-size: 1.8rem;
    font-weight: bold;
    font-family: 'Tajawal', sans-serif;
    text-align: center;
    display: inline-block;
    padding: 10px 20px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(50, 142, 164, 0.19);
}

/* Icon Styling */
.icon {
    font-size: 1.8rem;
    color: #2492a8; /* Secondary color */
    margin-left: 12px; /* Space for RTL */
}

/* Super Stylish Underline */
.underline {
    width: 100px;
    height: 6px;
    background: linear-gradient(to right, #b72dd2, #2492a8);
    margin: 8px auto 0;
    border-radius: 30px;
    position: relative;
    overflow: hidden;
}

/* ✨ Stylish Animation Effect */
.underline::before {
    content: "";
    position: absolute;
    width: 50%;
    height: 100%;
    background: rgba(255, 255, 255, 0.4);
    left: -50%;
    border-radius: 30px;
    animation: underlineGlow 1.8s infinite ease-in-out;
}

@keyframes underlineGlow {
    0% { left: -50%; opacity: 0.6; }
    50% { left: 50%; opacity: 1; }
    100% { left: 150%; opacity: 0.6; }
}

</style>
@endsection

@section('content')
   
    <!--  //welcome  -->

    <section class="new-members">
        <div class="container">
            <div class="d-flex justify-content-center my-4">
                <div class="page-title">
                    <i class="fas fa-bell icon"></i>
                    <span class="title-text">الإشعارات</span>
                    <div class="underline"></div>
                </div>
            </div>

             <div class="notifications-list">
        @forelse($notifications as $item)
            <div class="notification-item {{ $item->read_at ? '' : 'unread' }}">
                <div class="notification-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="notification-content">
                    <p class="notification-text">
                        {{ isset($item->header) ? $item->header : '' }} {{ $item->message_ar }}
                    </p>
                    <span class="notification-time">
                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </span>
                </div>
            </div>
        @empty
            <div class="no-notifications">
                <h4>لا يوجد إشعارات</h4>
            </div>
        @endforelse
    </div>
        </div>
    </section>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $.ajax({
            type: 'POST',
            url: '{{ route('site_notificationsRead') }}',
            datatype: 'json',
            async: true,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(msg) {
                if (msg.value != '1') {
                    alert('حدث خطأ ما');
                } else {
                    document.querySelectorAll("#notification-icon").forEach(item => {
                        item.style.display = 'none';
                        item.classList.remove('has-unread');
                    });
                }
            }
        });
    });
</script>