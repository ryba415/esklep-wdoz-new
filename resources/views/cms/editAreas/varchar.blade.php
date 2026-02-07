<div class='edit-area-container'>
    <label>{{ $area['name'] }}</label>
    <input class="cms-edit-area" type="text" value="@if ($editItem != null){{ $editItem[0]->{$area['field']} }}@endif" name="{{ $area['field'] }}">
</div>