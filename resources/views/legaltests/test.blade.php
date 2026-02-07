@extends('user.layouts')

@section('content')


    
<div class="one-test">

        @if(is_null($answers))
            <p>zadanie nie istnieje</p>
        @else
            @if($isPro OR $answers[0]->is_free==1)
            <input type="hidden" id="this-task-id" value="{{ $taskid }}">
                
            <div class="one-test-info">    
                <p class="one-test-info-item">
                    <strong>Kategoria:</strong> {!! $answers[0]->category_name !!}
                </p>
                <p class="one-test-info-item" title="Trudność: {!! $answers[0]->difficulty_scale !!}/6">
                    Trudność: 
                    @for($i=1;$i<=$answers[0]->difficulty_scale;$i++)
                    <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" fill="#000"><path d="M8 13.2h7.5c.3 0 .5.2.5.4v2c0 .2-.2.4-.5.4H8a.5.5 0 0 1-.5-.5v-1.9c0-.2.2-.4.5-.4Z"/><path d="m.4 12.1 5-5 2 2-5 5a1.4 1.4 0 0 1-2 0c-.5-.5-.5-1.4 0-2Z"/><path d="m5.4 5.8 3.3-3.3 3.4 3.3-3.4 3.3-3.3-3.3Z"/><path d="m13.7 6.1.7.7c.2.2.2.5 0 .7l-4 4a.5.5 0 0 1-.7 0l-.6-.7a.5.5 0 0 1 0-.7l4-4c.1-.2.4-.2.6 0Z"/><path d="M4.4 5.5h-.7l-.6-.7A.5.5 0 0 1 3 4l4-4h.6l.7.7c.2.2.2.5 0 .7l-4 4Z"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h16v16H0z"/></clipPath></defs></svg>
                    @endfor
                    @for($i=$answers[0]->difficulty_scale+1;$i<=3;$i++)
                    <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" fill="#9C9C9C"><path d="M8 13.2h7.5c.3 0 .5.2.5.4v2c0 .2-.2.4-.5.4H8a.5.5 0 0 1-.5-.5v-1.9c0-.2.2-.4.5-.4Z"/><path d="m.4 12.1 5-5 2 2-5 5a1.4 1.4 0 0 1-2 0c-.5-.5-.5-1.4 0-2Z"/><path d="m5.4 5.8 3.3-3.3 3.4 3.3-3.4 3.3-3.3-3.3Z"/><path d="m13.7 6.1.7.7c.2.2.2.5 0 .7l-4 4a.5.5 0 0 1-.7 0l-.6-.7a.5.5 0 0 1 0-.7l4-4c.1-.2.4-.2.6 0Z"/><path d="M4.4 5.5h-.7l-.6-.7A.5.5 0 0 1 3 4l4-4h.6l.7.7c.2.2.2.5 0 .7l-4 4Z"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h16v16H0z"/></clipPath></defs></svg>
                    @endfor
                </p>
            </div>
                
            <div class="one-test-question">
            {!!  $answers[0]->question !!}
            </div>
                
            <div id="inputs-container" class=" @if($answers[0]->question_type === "radio" or $answers[0]->question_type === "checbox") @endif ">  
                @foreach ($answers as $answer)
                    @if($answers[0]->question_type === "radio")
                    <div class="answer-container one-test-radio-answer">
                    <input autocomplete="off" id="answer-{{ $answer->anser_id }}" type="radio" name="radio-input" data-is-correct="{{ $answer->is_correctness}}"> 
                    <label for="answer-{{ $answer->anser_id }}">{!!  $answer->anser_text !!}</label>
                    </div>
                    <br>
                    @elseif($answers[0]->question_type === "checkbox")
                    <div class="answer-container one-test-radio-answer">
                    <input autocomplete="off" id="answer-{{ $answer->anser_id }}" type="checkbox" name="radio-input" data-is-correct="{{ $answer->is_correctness}}"> 
                    <label for="answer-{{ $answer->anser_id }}">{!!  $answer->anser_text !!}</label>
                    </div><br>
                    @else
                    <div class="one-test-textarea-answer">
                        <p class="one-test-textarea-title">Wpisz odpowiedź</p>
                        <textarea class="form-control" aria-label="Wpisz odpowiedź"></textarea>
                    </div>
                    @endif
                @endforeach
            </div>
            <div id="show-answer-contaioner" class="show-answer-contaioner">
                <div class="answer-contaioner">
                    <strong>Odpowiedź:</strong><br>
                    @foreach ($answers as $answer)
                        @if ($answer->is_correctness == 1)
                        {!!  $answer->anser_text !!}<br>
                        @endif    
                    @endforeach
                </div>
                @if(!empty($answers[0]->answer_explanation))
                <div class="answer-explanation-contaioner">
                    <strong>Wyjaśnienie:</strong>
                    {!!  $answers[0]->answer_explanation !!}
                </div>
                @endif
                
                @if($answers[0]->question_type === "open")
                <div class="is-answer-correct-container">
                    <p class="is-correct-title">Czy odpowiedziałeś poprawnie?
                    <p class="is-correct-desc">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                            Zaznaczanie czy odpowiedziałeś prawidłowo może liczeniu statystyk i pozwoli lepiej podpowiadać jaki materiał musisz powtórzyć.
                    </p>
                    <div id="answer-correctness-buttons-container">
                        <button id="send-answer-correct" class="standard-button standard-big-button-green">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"></path>
                                <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"></path>
                            </svg>
                          Odpowiedziałem poprawnie
                        </button>
                        <button  id="send-answer-incorrect" class="standard-button standard-big-button-red">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-octagon" viewBox="0 0 16 16">
                                <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"></path>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                            </svg>
                            Odpowiedziałem błędnie
                        </button>
                    </div>
                    <div id="answer-correctness-sended" class="d-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-send-check" viewBox="0 0 16 16">
                            <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855a.75.75 0 0 0-.124 1.329l4.995 3.178 1.531 2.406a.5.5 0 0 0 .844-.536L6.637 10.07l7.494-7.494-1.895 4.738a.5.5 0 1 0 .928.372l2.8-7Zm-2.54 1.183L5.93 9.363 1.591 6.602l11.833-4.733Z"></path>
                            <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686Z"></path>
                          </svg>
                        <span>Poprawność odpowiedzi została zapiana w statystykach</span>
                    </div>
                </div>
                @endif
            
            </div>
            <div id="show-explanation-contaioner" class="d-none px-2"></div>
            
            
            
            <div class="show-correct-answer-container">
                <button id="show-correct-answer" class="standard-big-button standard-big-button-green" data-test-type="{{$answers[0]->question_type}}">
                    @if($answers[0]->question_type === "radio")
                        Sprawdź odpowiedź
                    @elseif($answers[0]->question_type === "checbox")
                        Sprawdź odpowiedź
                    @else
                        Sprawdź odpowiedź
                    @endif
                </button>
            </div>
            
            @else
            <p class="acess-danied-task">Zawartość niedostępna w wersji darmowej!</p>
            @endif
            
        @endif
</div>
                
<div class="test-navigation-container">
    <div class="test-navigation-content">
    @if($isPro OR $answers[0]->is_free==1)
        @if(!is_null($prevTask))
        <a class="standard-button standard-button-beige this-button-prev" href="/legal-test/{{ $prevTask->id }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M-5.24537e-07 12C-3.8443e-07 8.79474 1.24823 5.78119 3.51471 3.51471C5.78119 1.24823 8.79474 -6.64643e-07 12 -5.24537e-07C15.2053 -3.8443e-07 18.2188 1.24823 20.4853 3.51471C22.7518 5.78119 24 8.79474 24 12C24 15.2053 22.7518 18.2188 20.4853 20.4853C18.2188 22.7518 15.2053 24 12 24C8.79474 24 5.78119 22.7518 3.51471 20.4853C1.24823 18.2188 -6.64643e-07 15.2053 -5.24537e-07 12ZM22.125 12C22.125 6.41711 17.5829 1.875 12 1.875C6.41711 1.875 1.875 6.41711 1.875 12C1.875 17.5829 6.41711 22.125 12 22.125C17.5829 22.125 22.125 17.5829 22.125 12ZM13.5937 18.4821L14.9196 17.1562L9.76337 12L14.9196 6.84375L13.5937 5.51788L7.11163 12L13.5937 18.4821Z" fill="black"/>
            </svg>

            Poprzednie

        </a>
        @else
        <a class="standard-button standard-button-beige this-button-prev button-empty" ></a>
        @endif

        @if(!is_null($nextTask))
        <a class="standard-button standard-button-beige this-button-next" href="/legal-test/{{ $nextTask->id }}">
            Następne
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_2358_1352)">
            <path d="M24 12C24 15.2053 22.7518 18.2188 20.4853 20.4853C18.2188 22.7518 15.2053 24 12 24C8.79474 24 5.78119 22.7518 3.51471 20.4853C1.24823 18.2188 -3.8443e-07 15.2053 -5.24537e-07 12C-6.64643e-07 8.79474 1.24823 5.78119 3.51471 3.51471C5.78119 1.24823 8.79474 -3.8443e-07 12 -5.24537e-07C15.2053 -6.64643e-07 18.2188 1.24823 20.4853 3.51471C22.7518 5.78119 24 8.79474 24 12ZM1.875 12C1.875 17.5829 6.41711 22.125 12 22.125C17.5829 22.125 22.125 17.5829 22.125 12C22.125 6.41711 17.5829 1.875 12 1.875C6.41711 1.875 1.875 6.41711 1.875 12ZM10.4062 5.51788L9.08038 6.84375L14.2366 12L9.08038 17.1562L10.4062 18.4821L16.8884 12L10.4062 5.51788Z" fill="black"/>
            </g>
            <defs>
            <clipPath id="clip0_2358_1352">
            <rect width="24" height="24" fill="white" transform="translate(0 24) rotate(-90)"/>
            </clipPath>
            </defs>
            </svg>

        </a>
        @else
        <a class="standard-button standard-button-beige this-button-next button-empty" ></a>
        @endif
    @endif
    </div>
</div>


<script>
    let answers = document.querySelectorAll('.one-test-radio-answer');
    for (let i=0;i<answers.length;i++){
        answers[i].addEventListener("click", function(e){
            let radio = e.target.querySelector('[name="radio-input"]');
            let allAnswers = document.querySelectorAll('.one-test-radio-answer-selected');
            let anserType = document.getElementById('show-correct-answer').getAttribute('data-test-type');
            
            if (anserType == 'radio'){
                for (let j=0;j<allAnswers.length;j++){
                    allAnswers[j].classList.remove('one-test-radio-answer-selected');
                }
                
                radio.checked = true;
                this.classList.add('one-test-radio-answer-selected');
            } else if (anserType == 'checkbox'){
                if (radio.checked){
                    radio.checked = false
                    this.classList.remove('one-test-radio-answer-selected');
                } else {
                    radio.checked = true;
                    this.classList.add('one-test-radio-answer-selected');
                }
            }
            //if (radio.checked) {
                //radio.checked = false;
            //} else {
               
            //}
        });
    }
    
    
    let anserButton = document.getElementById('show-correct-answer');
    anserButton.addEventListener("click", function(){
        let anserType=anserButton.getAttribute('data-test-type');
        let isCorrect = true;
        if (anserType == 'radio' || anserType == 'checkbox'){
            let answers = document.querySelectorAll('input[name="radio-input"]');
            
            for(let i=0;i<answers.length;i++){
                answers[i].closest('.answer-container').classList.remove('one-test-radio-answer-correct');
                answers[i].closest('.answer-container').classList.remove('one-test-radio-answer-wrong');
            }
            let correctAnswers = document.querySelectorAll('input[name="radio-input"][data-is-correct="1"]');
            for(let i=0;i<correctAnswers.length;i++){
                correctAnswers[i].closest('.answer-container').classList.add('one-test-radio-answer-correct');
            }
            let allSelected = document.querySelectorAll('input[name="radio-input"]:checked');
            for (let i=0;i<allSelected.length;i++){
                let selected = allSelected[i];
                if (selected != null && selected.getAttribute('data-is-correct') == 1){
                } else {
                    isCorrect = false;
                    selected.closest('.answer-container').classList.add('one-test-radio-answer-wrong');
                }
            }
            if (isCorrect){
                addAnswerToHistory('1');
            } else {
                addAnswerToHistory('0');
            }
            
        } else if(anserType == 'open'){
            //document.getElementById('show-answer-contaioner').classList.add('show-answer-contaioner-active');
        }
        document.getElementById('show-answer-contaioner').classList.add('show-answer-contaioner-active');
        //document.getElementById('show-explanation-contaioner').classList.remove('d-none');
        

        document.getElementById('show-correct-answer').classList.add('show-correct-answer-hidden');

        
    });
    
    let correctAnswer = document.getElementById('send-answer-correct');
    if (correctAnswer != null){
        correctAnswer.addEventListener("click", function(){
            addAnswerToHistory('1');
        });

        let incorrectAnswer = document.getElementById('send-answer-incorrect');
        incorrectAnswer.addEventListener("click", function(){
            addAnswerToHistory('0');
        });
    }
    
    
    function addAnswerToHistory(correctness){
        let xhr = new XMLHttpRequest();
 
        let taskId = document.getElementById('this-task-id').value;
        let url = '/set-legal-task-answer/' + taskId + '/' + correctness + '/2';
        xhr.open("GET", url, true);
        
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status){
                    document.getElementById('answer-correctness-buttons-container').innerHTML = '';
                    document.getElementById('answer-correctness-sended').classList.remove('d-none');
                } else {
                    if (response.unloged){
                        window.location.replace("/login");
                    }
                }
            }
        }
        xhr.send();
    }

</script>
@endsection
