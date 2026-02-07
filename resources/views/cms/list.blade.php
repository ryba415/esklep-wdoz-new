@extends('layouts.admin')

@section('content')

<div class="all-content-big cms-list-container">
    <div class="cms-add-new-container">
        <a href="/{{$editItemUrl}}-new" class="standard-button standard-big-button-green" id="add-nawe-list-item">{{$addNewItemButtonName}}</a>
    </div>
    <h1>{{$listName}}</h1>
    @if (is_countable($listItems) and count($listItems) > 0)
    <table class="cms-list-table">
        <thead>
            <tr>
               @foreach ($headers as $header)
               <td>{{$header}}</td>
               @endforeach
               <td>Akcje</td>
            </tr>
        </thead>
        @foreach ($listItems as $item)
        <tr>
            @foreach ($item as $area => $value)
                @if ($area != 'id')
                <td>{{$value}}</td>
                @endif
            @endforeach
            <td class="cms-list-actions">
                <a class="standard-button standard-big-button-green" href="/{{$editItemUrl}}-{{$item->id}}">Edytuj</a>
                <a class="standard-button standard-big-button-red" href="">Usuń</a>
            </td>
        </tr>
        @endforeach
    </table>
    @else
    <p>brak elementów listy</p>
    @endif
    
    
</div>
    
@endsection