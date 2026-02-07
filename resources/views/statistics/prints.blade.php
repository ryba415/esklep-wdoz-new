@extends('user.layouts')

@section('content')

<style>
    #user-left-menu{
        display: none;
    }
    .breadcrumb{
        display: none;
    }
</style>
    
<div class="row">
    <div class="col-md-12">
        <h2>Statystyki postępów w nauce</h2>
        @foreach ($tasks as $key=>$task)
        <div style="border-bottom: 2px solid black; padding-top: 90px; padding-bottom: 90px;">
                <h1 class="fs-3 mx-2">{{ $task->name }}</h1>
                <div class="mb-3 mx-2 text-secondary">    
                    <p>
                        Kategoria: {!! $task->categoryName !!}<br>
                        Trudność: {!! $task->difficulty_scale !!}/6
                    </p>
                </div>

                @if(!empty($task->correctness_consultation))
                <div class="bg-light mb-3 mx-2 text-secondary">
                    <p>Konsultacja: {!! $task->correctness_consultation !!}</p>
                </div>   
                @endif

                <div class="mt-2 p-2">
                    {!! $task->content !!}
                    <br>
                </div>
                <div class="fs-5 mx-2">
                    <p>Polecenie:</p>
                </div>
                <div class="border m-2 p-2">
                    {!! $task->command  !!}
                </div>

                @if(!empty($task->question_small_hint))
                <div class="fs-5 mx-2">
                    <p>Podpowiedź:</p>
                </div>
                <div class="m-2 mb-5">
                    <div id="hint-container" class="bg-light border mt-2 p-2">    
                        {!! $task->question_small_hint !!}
                        <br>
                    </div>
                </div>
                @endif

                <div class="m-2">
                    <div id="answer-container" >
                        <div class="bg-light border mt-2 p-2">
                            <p><strong>Odpowiedź</strong></p>
                            {!! $task->text_answer !!}
                            <br>
                        </div> 

                        @if(!empty($task->answer_explanation))
                        <!--<button id="show-explanation">Pokaż wyjaśnienie</button>-->
                        <div id="explanation-container" class="bg-light border mt-2 p-2">    
                            <p><strong>Wyjaśnienie</strong></p>
                            {!! $task->answer_explanation !!}
                            <br>
                        </div>
                        @endif

                        @if(!empty($task->jurisprudence_theses))
                        <div id="answer-container" class="bg-light border mt-2 p-2">
                        <p><strong>Orzecznictwo 1</strong></p>
                        {!! $task->jurisprudence_theses !!}
                        <br>
                        </div>
                        @endif

                        @if(!empty($task->jurisprudence_theses1))
                        <div id="answer-container" class="bg-light border mt-2 p-2">
                        <p><strong>Orzecznictwo 2</strong></p>
                        {!! $task->jurisprudence_theses !!}
                        <br>
                        </div>
                        @endif

                        @if(!empty($task->jurisprudence_theses2))
                        <div id="answer-container" class="bg-light border mt-2 p-2">
                        <p><strong>Orzecznictwo 3</strong></p>
                        {!! $task->jurisprudence_theses !!}
                        <br>
                        </div>
                        @endif

                        @if(!empty($task->jurisprudence_theses3))
                        <div id="answer-container" class="bg-light border mt-2 p-2">
                        <p><strong>Orzecznictwo 4</strong></p>
                        {!! $task->jurisprudence_theses !!}
                        <br>
                        </div>
                        @endif

                        @if(!empty($task->jurisprudence_theses4))
                        <div id="answer-container" class="bg-light border mt-2 p-2">
                        <p><strong>Orzecznictwo 5</strong></p>
                        {!! $task->jurisprudence_theses !!}
                        <br>
                        </div>
                        @endif

                        @if(!empty($task->jurisprudence_theses5))
                        <div id="answer-container" class="bg-light border mt-2 p-2">
                        <p><strong>Orzecznictwo 6</strong></p>
                        {!! $task->jurisprudence_theses !!}
                        <br>
                        </div>
                        @endif


                    </div>
                </div>
        </div>
        @endforeach
    </div>
</div>

                
@endsection
