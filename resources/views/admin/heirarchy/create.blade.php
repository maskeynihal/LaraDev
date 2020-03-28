<form action="{{route('heirarchy.store')}}" method="post">
    @csrf
    <input type="title">
    <select name="parent_id">
        @foreach ($heirarchies as $item)
            <option value="{{$item->heirarcy_id}}">{{$item->title}}</option>
        @endforeach
    </select>
    <input type="radio" name="is_root">
    <button type="submit">Submit</button>
</form>