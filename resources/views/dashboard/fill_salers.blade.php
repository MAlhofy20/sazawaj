@foreach($salers as $saler)
    <option value="{{$saler->id}}">{{$saler->name}}</option>
@endforeach