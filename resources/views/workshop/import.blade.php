@extends('layouts.admin')

@section('content')

<div class="all-content-big">
    <h1>Importuj dane zabudowy warsztatowej</h1>
    <div id="sucess-info-area"></div>
    <div id="fail-info-area">
        <ul></ul>
    </div>
    <div id="cms-edit-container">
        <div class='edit-area-container'>
            <label>Identyfikator zabudowy</label>
            <input class="cms-edit-area" type="text" value="" name="workshop-identity">
        </div>
        <div class='edit-area-container'>
            <label>Opis zabudowy</label>
            <input class="cms-edit-area" type="text" value="" name="description">
        </div>
        <div class='edit-area-container'>
            <label>Plik csv</label>
            <input id="input-file" type="file" id="file" name="workshop-file" >
        </div>
        <div class="cms-save-areas-container">
            <button id="save-all-areas" class="standard-button standard-big-button-green">Importuj zabudowę</button>
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
}

async function preparedataJson(){
    let inputs = document.getElementById('cms-edit-container').querySelectorAll('.cms-edit-area');
    let dataArray= new FormData();;
    for (let i=0;i<inputs.length;i++){
        dataArray.append(inputs[i].getAttribute('name'),inputs[i].value);
    }
    
    dataArray.append('csvfile',document.getElementById('input-file').files[0]);
    console.log(dataArray);
    return dataArray;

}

async function sendSave(jsonData){
    fetch("/save-imported-workshop-12",{
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            //'Content-Type': 'application/CSV',
            //'Content-Type': 'application/json',
            //'Accept': 'application/json',
        },
        method: 'POST',
        body: jsonData
    })
    .then((response) => response.json())
    .then(res => {
        console.log(res);
        let sucessArea =  document.getElementById('sucess-info-area');
        let failArea =  document.getElementById('fail-info-area');
        if(res.status){

            failArea.style.display = 'none';
            sucessArea.style.display = 'block';
            sucessArea.innerHTML = res.sucessSaveInfoText;
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
    })
    .catch(error => {
        console.error(error);
    });
}
</script>
@endsection