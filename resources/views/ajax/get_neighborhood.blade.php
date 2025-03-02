@foreach ($data as $item)
    <option value="{{$item->id}}">{{$item->title_ar}}</option>
@endforeach