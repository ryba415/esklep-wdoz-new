@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
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

                                @if(isset($value['type']) && $value['type'] === 'select' && isset($value['options']))
                                    <select name="{{$value['field']}}">
                                        <option value="">Wszystkie</option>
                                        @foreach ($value['options'] as $key => $option)
                                            <option value="{{$key}}" @if(isset($filtersValues[$value['field']]) && (string)$filtersValues[$value['field']] === (string)$key) selected @endif>
                                                {{$option}}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" name="{{$value['field']}}" @if(isset($filtersValues[$value['field']])) value="{{$filtersValues[$value['field']]}}" @endif>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    <input type="submit" value="Filtruj" class="standard-button standard-big-button-green submit-filters">
                </form>
            </div>
        @endif

        @if(!empty($allowAddNewItem))
            <div class="cms-add-new-container">
                <a href="/{{$editItemUrl}}-new" class="standard-button standard-big-button-green" id="add-nawe-list-item">{{$addNewItemButtonName}}</a>
            </div>
        @endif

        @if (!empty($exportEnabled) && !empty($exportFormats))
            @php
                $exportQueryString = http_build_query(request()->query());
            @endphp
            <div class="cms-export-container" style="margin: 20px 0;">
                <span class="filters-name">Eksport danych</span>
                <div style="margin-top: 10px;">
                    @foreach ($exportFormats as $format)
                        <a
                            href="{{ route('cms-universal-export', ['objectName' => $objectName, 'format' => $format]) }}@if($exportQueryString !== '')?{{ $exportQueryString }}@endif"
                            class="standard-button standard-big-button-green"
                        >
                            Eksport {{ strtoupper($format) }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {!! $extraView !!}

        @php
            $hasActions = !empty($allowEditOnList) || !empty($allowDeleteOnList);
        @endphp

        @if (is_countable($listItems) and count($listItems) > 0)
            <table class="cms-list-table">
                <thead>
                <tr>
                    @foreach ($headers as $header)
                        <td>{{$header}}</td>
                    @endforeach
                    @if($hasActions)
                        <td>Akcje</td>
                    @endif
                </tr>
                </thead>
                @foreach ($listItems as $item)
                    <tr>
                        @foreach ($item as $field => $value)
                            @php
                                $fieldArea = $areasByField[$field] ?? null;
                                $showField = $field !== 'id' || $showIdOnList;
                                $isSingleImage = $fieldArea
                                    && isset($fieldArea['type'])
                                    && $fieldArea['type'] === 'image'
                                    && (!isset($fieldArea['multiple']) || !$fieldArea['multiple']);

                                $isSelect = $fieldArea
                                    && isset($fieldArea['type'])
                                    && $fieldArea['type'] === 'select'
                                    && isset($fieldArea['options']);

                                $displayValue = $value;

                                if ($isSelect) {
                                    $displayValue = $fieldArea['options'][(string)$value] ?? $fieldArea['options'][$value] ?? $value;
                                }
                            @endphp

                            @if ($showField)
                                <td>
                                    @if($isSingleImage)
                                        @if($value)
                                            <img src="{{ $value }}" alt="" class="h-[70px] w-[120px] rounded-md border border-gray-200 object-cover">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    @else
                                        {{ $displayValue }} @if($field == 'progress')%@endif
                                    @endif
                                </td>
                            @endif
                        @endforeach

                        @if($hasActions)
                            <td class="cms-list-actions" data-item-id="{{$item->id}}">
                                @if(!empty($allowEditOnList))
                                    <a class="standard-button standard-big-button-green" href="/{{$editItemUrl}}-{{$item->id}}">Edytuj</a>
                                @endif

                                @if(!empty($allowDeleteOnList))
                                    <a class="standard-button standard-big-button-red delete-on-list-button" data-id="{{$item->id}}" data-list-type="{{$objectName}}">Usuń</a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @else
            <p>brak elementów listy</p>
        @endif
    </div>

    @if(!empty($allowDeleteOnList))
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
                                } else if (typeof res.message !== 'undefined' && res.message !== '') {
                                    alert(res.message);
                                }
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
                });
            }
        </script>
    @endif
@endsection
