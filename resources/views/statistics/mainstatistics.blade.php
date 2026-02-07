@extends('user.layouts')

@section('content')


    
<div class="row">
    <div class="col-md-12">
        <h2>Statystyki postępów w nauce</h2>
        
    </div>
</div>

<div class="row">
    <div class="col-md-6 pt-4 pb-4">
        <h3 class="fs-5">Procentowa ilość poprawnych odpowiedzi</h3>
        Kazusy:
        @foreach ($tasksCategories as $key=>$category)
        <div>
            <span class="text-secondary">{{$category['category']->name}}:</span>
            @if (isset($mainCategoriesTasksStatistics[$category['category']->category_id]))
                {{ round($mainCategoriesTasksStatistics[$category['category']->category_id]['correct'] / ( $mainCategoriesTasksStatistics[$category['category']->category_id]['correct'] + $mainCategoriesTasksStatistics[$category['category']->category_id]['fail'] ) * 100) }} %
            @else
                brak danych
            @endif
        </div>
        @endforeach
        
        <br>
        Testy:
        @foreach ($testsCategories as $key=>$category)
        <div>
            <span class="text-secondary">{{$category['category']->name}}:</span>
            @if (isset($mainCategoriesTestsStatistics[$category['category']->category_id]))
                {{ round($mainCategoriesTestsStatistics[$category['category']->category_id]['correct'] / ( $mainCategoriesTestsStatistics[$category['category']->category_id]['correct'] + $mainCategoriesTestsStatistics[$category['category']->category_id]['fail'] ) * 100) }} %
            @else
                brak danych
            @endif
        </div>
        @endforeach
    </div>
</div>
                
@endsection
