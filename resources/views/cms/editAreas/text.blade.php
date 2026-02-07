<div class='edit-area-container'>
    <label>{{$area['name']}}</label>
    <textarea class="cms-edit-area" name="{{ $area['field'] }}" >@if ($editItem != null){{ $editItem[0]->{$area['field']} }}@endif</textarea>
</div>