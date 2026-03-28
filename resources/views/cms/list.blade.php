@extends('layouts.admin')

@section('content')

<div class="all-content-big cms-list-container">
    <h1>{{$listName}}</h1>
    @if ($filtersExist)
    <div class="cms-filters-container">
        <span class="filters-name">Filtrowanie</span>
        <form>
            @foreach ($areas as $area => $value)
            @if (isset($value['onFilter']) && $value['onFilter'])
            <div class="filter-row">
                <label>{{$value['name']}}:</label> 
                <input type="text" name="{{$value['field']}}" @if(isset($filtersValues[$value['field']])) value="{{$filtersValues[$value['field']]}}" @endif>
            </div>           
            @endif    
            @endforeach
            <input type="submit" value="Filtruj" class="standard-button standard-big-button-green submit-filters">
        </form>
    </div>
    @endif
    <div class="cms-add-new-container">
        <a href="/{{$editItemUrl}}-new" class="standard-button standard-big-button-green" id="add-nawe-list-item">{{$addNewItemButtonName}}</a>
    </div>
    {!! $extraView !!}
    
    @if (is_countable($listItems) and count($listItems) > 0)
    <table class="cms-list-table">
        <thead>
            <tr>
               <!--<td class="workshop-action-checbox-all"><input type="checkbox" id="select-all-items" autocomplete="off"></td>-->
               @foreach ($headers as $header)
               <td>{{$header}}</td>
               @endforeach
               <td>Akcje</td>
            </tr>
        </thead>
        @foreach ($listItems as $item)
        <tr>
            <!--<td class="workshop-action-checbox"><input type="checkbox" autocomplete="off" data-row-id="{{$item->id}}"></td>-->
            @foreach ($item as $area => $value)
                @if ($area != 'id')
                <td>{{$value}} @if($area == 'progress')%@endif</td>
                @endif
            @endforeach
            <td class="cms-list-actions" data-item-id="{{$item->id}}">
                <a class="standard-button standard-big-button-green" href="/{{$editItemUrl}}-{{$item->id}}">Edytuj</a>
                <a class="standard-button standard-big-button-red delete-on-list-button" data-id="{{$item->id}}" data-list-type="{{$objectName}}">Usuń</a>
            </td>
        </tr>
        @endforeach
    </table>
    <!--<div class="table-mass-actions">
        masowe działania na zaznaczonych pozycjach: 
        <select id="mass-actions-action" autocomplete="off">
            <option value=""></option>
            <option value="print">Drukuj</option>
        </select>
        <button class="standard-big-button-green" id="save-mass-actions">zatwierdź</button>
        <div id="mass-actions-sucess-info"></div>
        <div id="mass-actions-fail-info">
            <ul></ul>
        </div>
    </div>-->
    @else
    <p>brak elementów listy</p>
    @endif
    
    <?=$extraView?>
</div>

<script>
let deleteButtons = document.querySelectorAll('.delete-on-list-button');
for (let i=0;i<deleteButtons.length;i++){
    deleteButtons[i].addEventListener("click", (event) => {
        if (confirm('Czy na pewno chcesz usunąć tą pozycję?')) {
            let itemId = event.target.getAttribute('data-id');
            let itemType = event.target.getAttribute('data-list-type');
            fetch("/cms-universal-delete-list/" + itemId + '/' + itemType,{
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                method: 'POST',
            })
            .then((response) => response.json())
            .then(res => {
                if(res.status){
                    location.reload();
                }


            })
            .catch(error => {
                console.error(error);
            });
        }

    });
}
/*
document.getElementById('select-all-items').addEventListener("click", (event) => {
    let select = false;
    if (event.target.checked){
        select = true;
    }
    let allChcecboxes = document.querySelectorAll('.workshop-action-checbox input[type="checkbox"]');
    for (let i=0;i<allChcecboxes.length;i++){
        if (select){
            allChcecboxes[i].checked = true;
        } else {
            allChcecboxes[i].checked = false;
        }
    }
});


document.getElementById('mass-actions-action').addEventListener("change", (event) => {
    let massActionSelect = document.getElementById('mass-actions-action');
    
    let allChcecboxes = document.querySelectorAll('.workshop-action-checbox input[type="checkbox"]');
    
    let checkedIds = [];
    for (let i=0;i<allChcecboxes.length;i++){
        if (allChcecboxes[i].checked){
            checkedIds.push(allChcecboxes[i].getAttribute('data-row-id'));
        }
    }
    if (massActionSelect.value == 'print'){
        let idsString = '';
        for (let i=0;i<checkedIds.length;i++){
            if (idsString != ''){
                idsString = idsString + '-';
            }
            idsString = idsString + checkedIds[i];
        }
        if (idsString != ''){
            window.open("/import-workshop-0?workshop-ids=" + idsString + '&isPrint=true&history=0', '_blank');
            //window.location.href = "/import-workshop" + idsString + '?isPrint=true&history=0';
        }
    }
});*/
</script>  
@endsection