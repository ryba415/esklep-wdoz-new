<div class='edit-area-container'>
    <label>
        <span>{{ $area['name'] }}</span>
        @if(isset($area['info']) && $area['info'] != '' && $area['info'] != null)
            <span class="area-info">{{$area['info']}}</span>
        @endif
    </label>
    <textarea class="cms-edit-area" name="{{ $area['field'] }}" @if(!empty($area['readonly'])) readonly @endif>@if ($editItem != null){{ $editItem[0]->{$area['field']} }}@endif</textarea>
</div>
