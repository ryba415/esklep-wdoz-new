<div class='edit-area-container'>
    <label>
        <span>{{ $area['name'] }}</span>
        @if(isset($area['info']) && $area['info'] != '' && $area['info'] != null)
            <span class="area-info">{{$area['info']}}</span>
        @endif
    </label>

    <input
        class="cms-edit-area"
        type="password"
        value=""
        name="{{ $area['field'] }}"
        autocomplete="new-password"
    >
</div>
