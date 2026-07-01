<div class='edit-area-container'>
    <label>
        <span>{{ $area['name'] }}</span>
        @if(isset($area['info']) && $area['info'] != '' && $area['info'] != null)
        <span class="area-info">{{$area['info']}}</span>
        @endif
    </label>

    <select class="cms-edit-area" 
            name="{{ $area['field'] }}" 
            @if(!empty($area['readonly']))style="filter: grayscale(60%); opacity: 0.60; cursor: not-allowed;"@endif
            @if(!empty($area['readonly'])) readonly @endif
            autocomplete="off">
        @foreach ($area['options'] as $key => $option)
        <option value="{{$key}}" @if ($editItem != null && $editItem[0]->{$area['field']} == $key ) selected @endif >{{$option}}</option>
        @endforeach
    </select>
</div>