@extends('user.layouts')

@section('content')

<div class="all-content-big">
        <h1>Zadania testowe
        @if($currentCategoryId != NULL)
        <br><span>z kategorii: {{ $currentCategory[0]->name }}</span>
        @endif
        </h1>
        
        @include('legaltasks/categories')
        @if (is_countable($randomTask) AND count($randomTask))
        <div class="start-tests">
            <a class="standard-big-button standard-big-button-blue" href="/legal-test/{{ $randomTask[0]->id }}?order=random"><strong>ROZPOCZNIJ TEST</strong><br>
                <span><strong>kolejność:</strong> losowa</span><br>  
                @if($currentCategoryId != NULL)
                <span><strong>kategoria:</strong> {{ $currentCategory[0]->name }}
                @endif</span>
            </a>
        </div>
        <div class="start-tests">
            <a class="standard-big-button standard-big-button-green" href="/legal-test/{{ $tasks[0]->id }}?order=const"><strong>ROZPOCZNIJ TEST</strong><br>
                <span><strong>kolejność:</strong> stała</span><br>
                @if($currentCategoryId != NULL)
                <span><strong>kategoria:</strong> {{ $currentCategory[0]->name }}
                @endif</span>
            </a>
        </div>
        @endif
</div>
    
@endsection