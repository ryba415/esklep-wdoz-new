@extends('layouts.admin')

@section('content')

<div class="all-content-big cms-list-container">
    <h1>Lista narzędzi z zabudowy: {{$workshop->name}}</h1>
    <p>{{$workshop->description}}</p>
    @if (is_countable($items) and count($items) > 0)
    <table class="cms-list-table worksop-details-table">
        <thead>
            <tr>
                <td class="workshop-action-checbox-all"><input type="checkbox" id="select-all-items" autocomplete="off"></td>
                <td>Symbol</td>
                <td>Opis</td>
                <td>Ilość sztuk</td>
                <td>Jednostka</td>
                <td class="text-vertical"><span>Gotowy</span></td>
                <td class="text-vertical"><span>Oznakowany</span></td>
                <td class="text-vertical"><span>Skopletowany</span></td>
                <td class="text-vertical"><span>Wysłany</span></td>
                <td class="text-vertical"><span>Ułożony w warsztacie</span></td>
            </tr>
        </thead>
        <tbody>
        @foreach ($items as $item)
            <tr>
                <td class="workshop-action-checbox"><input type="checkbox" autocomplete="off" data-row-id="{{$item->id}}"></td>
                <td>{{$item->symbol}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->count}}</td>
                <td>{{$item->unit}}</td>
                <td class="workshop-action-container" data-id="{{$item->id}}">
                    @if($item->delivered != null)
                    <span data-id="{{$item->id}}" class="positive-action-workshop delivered" 
                          title="@if (isset($history[$item->id]['delivered'])){{$history[$item->id]['delivered']}} @else brak historii @endif ">{{$item->delivered}}</span>
                    @else
                    <span data-id="{{$item->id}}" class="negative-action-workshop delivered">
                        <span class="click-to-change-status" data-action="delivered"
                              title="@if (isset($history[$item->id]['delivered'])){{$history[$item->id]['delivered']}} @else brak historii @endif ">Kliknij aby zmienić status</span>  
                    </span>
                    @endif
                    <span class="remove-status @if($item->delivered != null) active @endif" data-action="delivered">usuń</span>
                </td>
                <td class="workshop-action-container" data-id="{{$item->id}}">
                    @if($item->marked != null)
                    <span data-id="{{$item->id}}" class="positive-action-workshop marked"
                          title="@if (isset($history[$item->id]['marked'])){{$history[$item->id]['marked']}} @else brak historii @endif ">{{$item->marked}}</span>
                    @else
                    <span data-id="{{$item->id}}" class="negative-action-workshop marked">
                        <span class="click-to-change-status" data-action="marked"
                              title="@if (isset($history[$item->id]['marked'])){{$history[$item->id]['marked']}} @else brak historii @endif ">Kliknij aby zmienić status</span>
                    </span>
                    @endif
                    <span class="remove-status @if($item->marked != null) active @endif" data-action="marked">usuń</span>
                </td>
                <td class="workshop-action-container" data-id="{{$item->id}}">
                    @if($item->complete != null)
                    <span data-id="{{$item->id}}" class="positive-action-workshop complete"
                          title="@if (isset($history[$item->id]['complete'])){{$history[$item->id]['complete']}} @else brak historii @endif ">{{$item->complete}}</span>
                    @else
                    <span data-id="{{$item->id}}" class="negative-action-workshop complete">
                        <span class="click-to-change-status" data-action="complete"
                              title="@if (isset($history[$item->id]['complete'])){{$history[$item->id]['complete']}} @else brak historii @endif ">Kliknij aby zmienić status</span>
                    </span>
                    @endif
                    <span class="remove-status @if($item->complete != null) active @endif" data-action="complete">usuń</span>
                </td>
                <td class="workshop-action-container" data-id="{{$item->id}}">
                    @if($item->sent != null)
                    <span data-id="{{$item->id}}" class="positive-action-workshop sent"
                          title="@if (isset($history[$item->id]['sent'])){{$history[$item->id]['sent']}} @else brak historii @endif ">{{$item->sent}}</span>
                    @else
                    <span data-id="{{$item->id}}" class="negative-action-workshop sent">
                        <span class="click-to-change-status" data-action="sent"
                              title="@if (isset($history[$item->id]['sent'])){{$history[$item->id]['sent']}} @else brak historii @endif ">Kliknij aby zmienić status</span>
                    </span>
                    @endif
                    <span class="remove-status @if($item->sent != null) active @endif" data-action="sent">usuń</span>
                </td>
                <td class="workshop-action-container" data-id="{{$item->id}}">
                    @if($item->arranged != null)
                    <span data-id="{{$item->id}}" class="positive-action-workshop arranged"
                          title="@if (isset($history[$item->id]['arranged'])){{$history[$item->id]['arranged']}} @else brak historii @endif ">{{$item->arranged}}</span>
                    @else
                    <span data-id="{{$item->id}}" class="negative-action-workshop arranged">
                        <span class="click-to-change-status" data-action="arranged"
                              title="@if (isset($history[$item->id]['arranged'])){{$history[$item->id]['arranged']}} @else brak historii @endif ">Kliknij aby zmienić status</span>
                    </span>
                    @endif
                    <span class="remove-status @if($item->arranged != null) active @endif" data-action="arranged">usuń</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="table-mass-actions">
        ustaw status dla zaznczonych: 
        <select id="mass-actions-action" autocomplete="off">
            <option value=""></option>
            <option value="delivered">Gotowy</option>
            <option value="marked">Oznakowany</option>
            <option value="complete">Skopletowany</option>
            <option value="sent">Wysłany</option>
            <option value="arranged">Ułożony w warsztacie</option>
        </select>
        <button class="standard-big-button-green" id="save-mass-actions">Zmień status</button>
        <div id="mass-actions-sucess-info"></div>
        <div id="mass-actions-fail-info">
            <ul></ul>
        </div>
    </div>
    @else
    <p>brak elementów listy</p>
    @endif
    
    
</div>

<script>
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

let removeButtons = document.querySelectorAll('.remove-status');
for (let i=0;i<removeButtons.length;i++){
    removeButtons[i].addEventListener("click", (event) => {
        let id = event.target.closest('.workshop-action-container').getAttribute('data-id');
        let checkedIds = [id];
        let dataArray = new FormData();
        dataArray.append('checkedIds',JSON.stringify(checkedIds));
        let action = event.target.getAttribute('data-action');
        dataArray.append('action',action);
        console.log(action);
        sendSave(dataArray,action,0);
    });
}

let changeStatusButtons = document.querySelectorAll('.click-to-change-status');
for (let i=0;i<changeStatusButtons.length;i++){
    changeStatusButtons[i].addEventListener("click", (event) => {
        let id = event.target.closest('.negative-action-workshop').getAttribute('data-id');
        let checkedIds = [id];
        let dataArray = new FormData();
        dataArray.append('checkedIds',JSON.stringify(checkedIds));
        let action = event.target.getAttribute('data-action');
        dataArray.append('action',action);
        console.log(action);
        sendSave(dataArray,action);
    });
}

document.getElementById('save-mass-actions').addEventListener("click", (event) => {
    saveDate();
});

async function saveDate(){
    let jsonData = await preparedataJson();
    if (confirm('Czy na pewno chcesz zmienić status wszytskich zaznaczonych pozycji?')) {
        sendSave(jsonData,document.getElementById('mass-actions-action').value);
    } else {

    }
    
}

async function preparedataJson(){
    let dataArray= new FormData();
    let allChcecboxes = document.querySelectorAll('.workshop-action-checbox input[type="checkbox"]');
    
    let checkedIds = [];
    for (let i=0;i<allChcecboxes.length;i++){
        if (allChcecboxes[i].checked){
            checkedIds.push(allChcecboxes[i].getAttribute('data-row-id'));
        }
    }
    dataArray.append('checkedIds',JSON.stringify(checkedIds));
    
    dataArray.append('action',document.getElementById('mass-actions-action').value);

    return dataArray;

}

async function sendSave(jsonData,area,type=1){
    fetch("/change-worshop-item-status/"+type,{
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        method: 'POST',
        body: jsonData
    })
    .then((response) => response.json())
    .then(res => {
        let sucessArea =  document.getElementById('mass-actions-sucess-info');
        let failArea =  document.getElementById('mass-actions-fail-info');
        if(res.status){

            failArea.style.display = 'none';
            sucessArea.style.display = 'block';
            sucessArea.innerHTML = res.sucessSaveInfoText;
            for (let i=0; i<res.ids.length;i++){
                if (type == 1){
                    let span = document.querySelector('.negative-action-workshop.'+area+'[data-id="'+res.ids[i]+'"]');
                    if (span != null){
                        span.classList.remove('negative-action-workshop');
                        span.classList.add('positive-action-workshop');
                        span.innerHTML = res.date;

                        span.closest('.workshop-action-container').querySelector('.remove-status').classList.add('active');
                    }
                } else {
                    let span = document.querySelector('.positive-action-workshop.'+area+'[data-id="'+res.ids[i]+'"]');
                    if (span != null){
                        span.classList.add('negative-action-workshop');
                        span.classList.remove('positive-action-workshop');
                        span.innerHTML = '';

                        span.closest('.workshop-action-container').querySelector('.remove-status').classList.remove('active');
                    }
                    location.reload(); 
                }
            }
        } else {
            
            let failAreaUl = failArea.querySelector('ul');
            sucessArea.innerHTML = '';
            failAreaUl.innerHTML = '';
            failArea.style.display = 'block';
            sucessArea.style.display = 'none';
            
            if (typeof res.errors != 'undefined'){
                for (let i=0; i<res.errors.length; i++){
                    let li = document.createElement('li');
                    li.innerHTML = res.errors[i];
                    failAreaUl.append(li);
                }
            } else {
                let li = document.createElement('li');
                li.innerHTML = 'Wystąpił nieoczekiwany błąd podczas próby zapisu';
                failAreaUl.append(li);
            }
            if (res.userUnloged){
                window.location.replace("/login");
            }
        }
        
        
        setTimeout(function(){ 
            failArea.style.display = 'none';
            sucessArea.style.display = 'none';
        }, 2500);
    })
    .catch(error => {
        console.error(error);
    });
}
</script>    
    
@endsection