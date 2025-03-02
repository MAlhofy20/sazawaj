<!-- alert data -->
@if(Session::has('success'))
    <!-- success alert -->
    <input type="hidden" id="alertType" value="1">
    <input type="hidden" id="alertTheme" value="success">
    <input type="hidden" id="alertMessage" value="{{Session::get('success')}}">
    @php
        Session::forget('success');
    @endphp
@elseif(Session::has('danger'))
    <!-- danger alert -->
    <input type="hidden" id="alertType" value="2">
    <input type="hidden" id="alertTheme" value="error">
    <input type="hidden" id="alertMessage" value="{{Session::get('danger')}}">
    @php
        Session::forget('danger');
    @endphp
@else
    <!-- no alert -->
    <input type="hidden" id="alertType" value="0">
@endif
