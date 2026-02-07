@extends('user.layouts')

@section('content')



<div class="one-test">


    @if(is_null($task))
        <p>zadanie nie istnieje</p>
    @else
        @if($isPro OR $task->is_free==1)
            <input type="hidden" id="this-task-id" value="{{ $task->id }}">
            <h1 class="fs-3 mx-2">{{ $task->name }}</h1>

            <div class="one-test-info">    
                <p class="one-test-info-item">
                    <strong>Kategoria:</strong> {!! $task->category_name !!}
                </p>
                <p class="one-test-info-item" title="Trudność: {!! $task->correctness_consultation !!}/6">
                    Trudność: 
                    @for($i=1;$i<=$task->difficulty_scale;$i++)
                    <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" fill="#000"><path d="M8 13.2h7.5c.3 0 .5.2.5.4v2c0 .2-.2.4-.5.4H8a.5.5 0 0 1-.5-.5v-1.9c0-.2.2-.4.5-.4Z"/><path d="m.4 12.1 5-5 2 2-5 5a1.4 1.4 0 0 1-2 0c-.5-.5-.5-1.4 0-2Z"/><path d="m5.4 5.8 3.3-3.3 3.4 3.3-3.4 3.3-3.3-3.3Z"/><path d="m13.7 6.1.7.7c.2.2.2.5 0 .7l-4 4a.5.5 0 0 1-.7 0l-.6-.7a.5.5 0 0 1 0-.7l4-4c.1-.2.4-.2.6 0Z"/><path d="M4.4 5.5h-.7l-.6-.7A.5.5 0 0 1 3 4l4-4h.6l.7.7c.2.2.2.5 0 .7l-4 4Z"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h16v16H0z"/></clipPath></defs></svg>
                    @endfor
                    @for($i=$task->difficulty_scale+1;$i<=6;$i++)
                    <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" fill="#9C9C9C"><path d="M8 13.2h7.5c.3 0 .5.2.5.4v2c0 .2-.2.4-.5.4H8a.5.5 0 0 1-.5-.5v-1.9c0-.2.2-.4.5-.4Z"/><path d="m.4 12.1 5-5 2 2-5 5a1.4 1.4 0 0 1-2 0c-.5-.5-.5-1.4 0-2Z"/><path d="m5.4 5.8 3.3-3.3 3.4 3.3-3.4 3.3-3.3-3.3Z"/><path d="m13.7 6.1.7.7c.2.2.2.5 0 .7l-4 4a.5.5 0 0 1-.7 0l-.6-.7a.5.5 0 0 1 0-.7l4-4c.1-.2.4-.2.6 0Z"/><path d="M4.4 5.5h-.7l-.6-.7A.5.5 0 0 1 3 4l4-4h.6l.7.7c.2.2.2.5 0 .7l-4 4Z"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h16v16H0z"/></clipPath></defs></svg>
                    @endfor
                </p>
                @if(!empty($task->correctness_consultation))
                 <p class="one-test-info-item">
                    <strong>Konsultacja:</strong> {!! $task->correctness_consultation !!}
                </p>   
                @endif
            </div>


            <div class="one-test-question">
                {!! str_replace('</ul>','</ol>',str_replace('<ul>','<ol>',$task->content)) !!}
                <br>
            </div>
            <div class="one-test-question-rules">
                <p class="rules-title">Polecenie:</p>
                {!! $task->command  !!}
            </div>

            <div class="one-test-set-answer">
                <p class="answer-title">Wpisz odpowiedź:</p>
                <textarea class="form-control" aria-label="Wpisz odpowiedź"></textarea>
            </div>

            @if(!empty($task->question_small_hint))
            <div class="show-hint-container">
                <button id="show-hint" class="standard-big-button standard-big-button-blue">Pokaż podpowiedź</button>
                <div id="hint-container" class="d-none">    
                    {!! $task->question_small_hint !!}
                </div>
            </div>
            @endif

            <div class="show-correct-answer-container">
                <button id="show-correct-answer" class="standard-big-button standard-big-button-green">Pokaż prawidłową odpowiedź</button>
                <div id="answer-container" class="answer-contaioner-task d-none">
                    <div class="answer-contaioner">
                        <strong class="answer-title">Odpowiedź:</strong><br>
                        {!! $task->text_answer !!}
                        <br>
                    </div> 

                    @if(!empty($task->answer_explanation))
                    <div id="explanation-container" class="answer-explanation-contaioner">    
                        <strong class="answer-title">Wyjaśnienie:</strong><br>
                        {!! $task->answer_explanation !!}
                        <br>
                    </div>
                    @endif

                    @if(!empty($task->jurisprudence_theses))
                    <div class="explanation-jurisprudence-container">
                        <p class="jurisprudence-title">Orzecznictwo 1</p>
                        {!! $task->jurisprudence_theses !!}
                    </div>
                    @endif

                    @if(!empty($task->jurisprudence_theses1))
                    <div class="explanation-jurisprudence-container">
                        <p class="jurisprudence-title">Orzecznictwo 2</p>
                        {!! $task->jurisprudence_theses1 !!}
                    </div>
                    @endif

                    @if(!empty($task->jurisprudence_theses2))
                    <div class="explanation-jurisprudence-container">
                        <p class="jurisprudence-title">Orzecznictwo 3</p>
                        {!! $task->jurisprudence_theses2 !!}
                    </div>
                    @endif

                    @if(!empty($task->jurisprudence_theses3))
                    <div class="explanation-jurisprudence-container">
                        <p class="jurisprudence-title">Orzecznictwo 4</p>
                        {!! $task->jurisprudence_theses3 !!}
                    </div>
                    @endif

                    @if(!empty($task->jurisprudence_theses4))
                    <div class="explanation-jurisprudence-container">
                        <p class="jurisprudence-title">Orzecznictwo 5</p>
                        {!! $task->jurisprudence_theses4 !!}
                    </div>
                    @endif

                    @if(!empty($task->jurisprudence_theses5))
                    <div class="explanation-jurisprudence-container">
                        <p class="jurisprudence-title">Orzecznictwo 6</p>
                        {!! $task->jurisprudence_theses5 !!}
                    </div>
                    @endif

                    <div class="is-answer-correct-container">
                        <p class="is-correct-title">Czy odpowiedziałeś poprawnie?</p>
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
                            <span>Statystyki zostały zaktualizowane</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
        <p class="acess-danied-task">Zawartość niedostępna w wersji darmowej!</p>
        @endif
    
    
 
    @endif

</div>

<div class="test-navigation-container">
    <div class="test-navigation-content">
        @if($isPro OR $task->is_free==1)
            @if(!is_null($prevTask))
            <a class="standard-button standard-button-beige this-button-prev" href="/legal-task/{{ $prevTask->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
                </svg>
                Poprzedni kazus

            </a>
            @else
            <a class="standard-button standard-button-beige this-button-prev button-empty" >
            </a>
            @endif

            @if(!is_null($nextTask))
            <a class="standard-button standard-button-beige this-button-next" href="/legal-task/{{ $nextTask->id }}">
                Następny kazus
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                </svg>
            </a>
            @else
            <a class="standard-button standard-button-beige this-button-next button-empty" >
            </a>
            @endif
        @endif
    </div>
</div>

<script>
    @if($isPro OR $task->is_free==1)
    let hintButton =  document.getElementById('show-hint');
    if (hintButton != null){
        hintButton.addEventListener("click", function(){
            this.style.display = "none";
            document.getElementById('hint-container').classList.remove('d-none');
        });
    }
    
    let anserButton =  document.getElementById('show-correct-answer');
    anserButton.addEventListener("click", function(){
        this.style.display = "none";
        document.getElementById('answer-container').classList.remove('d-none');
    });
    
    let correctAnswer = document.getElementById('send-answer-correct');
    correctAnswer.addEventListener("click", function(){
        addAnswerToHistory('1');
    });
    
    let incorrectAnswer = document.getElementById('send-answer-incorrect');
    incorrectAnswer.addEventListener("click", function(){
        addAnswerToHistory('0');
    });
    
    
    function addAnswerToHistory(correctness){
        let xhr = new XMLHttpRequest();
 
        let taskId = document.getElementById('this-task-id').value;
        let url = '/set-legal-task-answer/' + taskId + '/' + correctness + '/1';
        xhr.open("GET", url, true);
        
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status){
                    document.getElementById('answer-correctness-buttons-container').innerHTML = '';
                    document.getElementById('answer-correctness-sended').classList.remove('d-none');
                    document.getElementById('answer-correctness-sended').style.display = "flex";
                } else {
                    if (response.unloged){
                        window.location.replace("/login");
                    }
                }
            }
        }
        xhr.send();
    }
    @endif
</script>
    
@endsection