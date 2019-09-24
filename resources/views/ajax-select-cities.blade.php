 @foreach($cities as $key => $value)
        <option value="{{ $value->ter_id }}">{{ $value->ter_name }}</option>
    @endforeach
