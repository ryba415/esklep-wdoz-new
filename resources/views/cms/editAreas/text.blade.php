<div class='edit-area-container'>
    <label>
        <span>{{ $area['name'] }}</span>
        @if(isset($area['info']) && $area['info'] != '' && $area['info'] != null)
            <span class="area-info">{{$area['info']}}</span>
        @endif
    </label>

    <input
        @if(!empty($area['readonly']))style="filter: grayscale(60%); opacity: 0.60; cursor: not-allowed;"@endif
        class="cms-edit-area"
        type="text"
        value="@if ($editItem != null){{ $editItem[0]->{$area['field']} }}@endif"
        name="{{ $area['field'] }}"
        @if(!empty($area['readonly'])) readonly @endif
    >
</div>
