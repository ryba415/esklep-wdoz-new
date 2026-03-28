@extends('layouts.admin')

@section('content')

<div class="all-content-big">
    <h1>nazwa</h1>
    <div id="sucess-info-area"></div>
    <div id="fail-info-area">
        <ul></ul>
    </div>
    <div id="cms-edit-container">
        <input type="hidden" value="{{$id}}" name="id" id="edit-elem-id" class="cms-edit-area">
    @foreach ($areas as $area)
    @if($area['editable'])
    @include('cms.editAreas.' . $area['type'] ,['area' => $area, 'editItem' => $editItem])
    @endif
    @endforeach
    
    {!! $extraView !!}
    <div class="cms-save-areas-container save-all-areas-container-fixed">
        <button id="save-all-areas" class="standard-button standard-big-button-green">Zapisz</button>
    </div>
    </div>
    
    
</div>
    
<script>
document.getElementById('save-all-areas').addEventListener("click", (event) => {
    saveDate();
});

async function saveDate(){
    let jsonData = await preparedataJson();
    sendSave(jsonData);
    //console.log(jsonData);
}

async function preparedataJson(){
    let inputs = document.getElementById('cms-edit-container').querySelectorAll('.cms-edit-area');
    let dataArray = {};
    for (let i=0;i<inputs.length;i++){
        dataArray[inputs[i].getAttribute('name')] = {'area' : inputs[i].getAttribute('name'), 'value' : inputs[i].value};
    }
    
    if (typeof ownSaveFunction === 'function') {
        const result = ownSaveFunction();
        
        //console.log(result);
        //console.log(dataArray);
        dataArray = { ...dataArray, ...result };
        //console.log(dataArray);
    }
    
    return JSON.stringify(dataArray);
}

async function sendSave(jsonData){
    fetch("/cms-universal-save/{{$objectName}}",{
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        method: 'POST',
        body: jsonData
    })
    .then((response) => response.json())
    .then(res => {
        let sucessArea =  document.getElementById('sucess-info-area');
        let failArea =  document.getElementById('fail-info-area');
        if(res.status){
            document.getElementById('edit-elem-id').value = res.editElemId;
            failArea.style.display = 'none';
            sucessArea.style.display = 'block';
            sucessArea.innerHTML = res.sucessSaveInfoText;
            sucessArea.scrollIntoView({
                behavior: 'smooth', 
                block: 'center', 
                inline: 'center'     
            });
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
            failArea.scrollIntoView({
                behavior: 'smooth', 
                block: 'center', 
                inline: 'center'   
            });
            if (res.userUnloged){
                window.location.replace("/login");
            }
        }
    })
    .catch(error => {
        console.error(error);
    });
}
</script>
@endsection