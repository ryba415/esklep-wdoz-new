@extends('user.layouts')

@section('content')

<div class="all-content-big">
        <h1>Kazusy prawnicze
            <br><span>
            @if($currentCategoryId != NULL)
                z kategorii: {{ $currentCategory[0]->name }}
            @endif
            </span>
        </h1>
        @include('legaltasks/categories')
        @if(count($tasks) > 0)
        <div class="all-test-list-container">
            @foreach ($tasks as $key=>$task)
            <a @if($isPro OR $task->is_free==1) href="/legal-task/{{ $task->id }}"@endif  class="test-on-list-link">
                <div class="test-on-list-container @if($isPro OR $task->is_free==1) test-avariable @else test-unavariable @endif">
                    <p class="task-number">{{ $key +1 }}</p>
                    <div class="test-content">
                    <p class="test-category">{{ strip_tags($task->categoryName) }}</p>
                    <p class="test-name">@if($isPro OR $task->is_free==1){{ strip_tags($task->name) }} @else kazus niedostepny w wersji darmowej @endif</p>
                    </div>
                    <svg class="arrow-icon" width="10" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 8c0 .3-.1.6-.3.8l-7 6.9A1.1 1.1 0 1 1 1.3 14l6-6-6-6A1.1 1.1 0 0 1 2.7.2l6.9 7c.2.1.3.4.3.7Z" fill="#000"/>
                    </svg>

                </div>
            </a>
            @endforeach
        </div>

        @else
        <p>Brak kazusuów z tej kategorii</p>
        @endif
</div>
    
@endsection