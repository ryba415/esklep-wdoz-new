<div class='edit-area-container'>
    <label>
        <span>{{ $area['name'] }}</span>
        @if(isset($area['info']) && $area['info'] != '' && $area['info'] != null)
        <span class="area-info">{{$area['info']}}</span>
        @endif
    </label>
    <input class="cms-edit-area  set-calendar" type="text" value="@if ($editItem != null){{ $editItem[0]->{$area['field']} }}@endif" name="{{ $area['field'] }}">
</div>