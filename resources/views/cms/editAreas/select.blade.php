<div class='edit-area-container'>
    <label>{{ $area['name'] }}</label>

    <select class="cms-edit-area" name="{{ $area['field'] }}">
        @foreach ($area['options'] as $key => $option)
        <option value="{{$key}}">{{$option}}</option>
        @endforeach
    </select>
</div>