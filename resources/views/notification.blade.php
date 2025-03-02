
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
    /* .toast{
        max-width:40% !important;
    } */
</style>


<script>




    @if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}");
    {{Session::forget('success')}}
    @endif


    @if(Session::has('info'))
    toastr.info("{{ Session::get('info') }}");
    {{Session::forget('info')}}
    @endif


    @if(Session::has('warning'))
    toastr.warning("{{ Session::get('warning') }}");
    {{Session::forget('warning')}}
    @endif


    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
    {{Session::forget('error')}}
    @endif

    // confirm send noti from provider to admin for add new service
    @if(Session::has('confirm'))
    toastr.info('<button><i class="icon-off" onclick="sendNoti()">@lang('site.send')</i></button>',"{{ Session::get('confirm') }}",{timeOut:0,extendedTimeOut:0,positionClass:"toast-top-center",closeButton : true});
    {{Session::forget('confirm')}}
    @endif

    toastr.options.preventDuplicates = true;
    toastr.options.progressBar = false;
    toastr.options.timeOut = 2000;
    toastr.options.onHidden = function() {
        toastr.clear()
        {{Session::forget('info')}}
        {{Session::forget('success')}}
        {{Session::forget('warning')}}
        {{Session::forget('error')}}
    }
    toastr.options.onCloseClick = function() { 
        toastr.clear()
        {{Session::forget('info')}}
        {{Session::forget('success')}}
        {{Session::forget('warning')}}
        {{Session::forget('error')}}
    }; 
    toastr.options.maxOpened =1;
    @if($lang == 'en')
        toastr.options.positionClass = "toast-top-left";
    @else
        toastr.options.positionClass = "toast-top-right";
        toastr.options.rtl = true;
    @endif


    // toastr.options.autoDismiss =true;
    //toastr.remove();




</script>