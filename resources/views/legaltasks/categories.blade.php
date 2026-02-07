
@if($categoriesType==1)
<p class="tests-categories-description">Wybierz dział z którego chcesz rozwiązywać kazusy: </p>
@else
<p class="tests-categories-description">Wybierz dział z którego chcesz rozwiązywać zadania testowe: </p>
@endif
<div class="tests-categories-list">
    <div class="category-main-item"> 
        <svg class="show-child-categories-icon" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" fill="#000"><path d="M10 0C4.473 0 0 4.473 0 10s4.473 10 10 10 10-4.473 10-10S15.527 0 10 0Zm0 18.667c-4.779 0-8.667-3.888-8.667-8.667S5.221 1.333 10 1.333 18.667 5.221 18.667 10 14.779 18.667 10 18.667Z"/><path d="M14.506 9.333h-3.84V5.494a.667.667 0 0 0-1.333 0v3.84H5.494a.667.667 0 0 0 0 1.333h3.84v3.839a.667.667 0 1 0 1.333 0v-3.84h3.839a.667.667 0 0 0 0-1.333Z"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h20v20H0z"/></clipPath></defs></svg>
        <svg class="hide-child-categories-icon" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" fill="#000"><path d="M19.2 6.1A10 10 0 0 0 6.2.8a10 10 0 0 0-5.4 13 10 10 0 0 0 13 5.4 10 10 0 0 0 5.4-13ZM18 13.4A8.7 8.7 0 0 1 6.6 18 8.7 8.7 0 0 1 2 6.6 8.7 8.7 0 0 1 13.4 2 8.7 8.7 0 0 1 18 13.4Z"/><path d="M15.2 9.3H4.8a.7.7 0 0 0 0 1.4h10.4a.7.7 0 0 0 0-1.4Z"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h20v20H0z"/></clipPath></defs></svg>
        @if($categoriesType==1)
        <a class="category-main-item-link  " href="/legal-tasks">
            <span class=" @if ($currentCategoryId == null) category-main-item-selected @endif ">Wszystkie kazusy</span>
        </a>
        @else
        <a class="category-main-item-link " href="/legal-tests">
            <span class=" @if ($currentCategoryId == null) category-main-item-selected @endif ">Wszystkie zadania testowe</span>
        </a>
        @endif
    </div>
    @foreach ($categories as $key=>$category)
    <div class="category-main-item @if ($category['opened']) category-main-item-opened @endif " >
        <div class="d-inline-block">
            <svg class="show-child-categories-icon" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" fill="#000"><path d="M10 0C4.473 0 0 4.473 0 10s4.473 10 10 10 10-4.473 10-10S15.527 0 10 0Zm0 18.667c-4.779 0-8.667-3.888-8.667-8.667S5.221 1.333 10 1.333 18.667 5.221 18.667 10 14.779 18.667 10 18.667Z"/><path d="M14.506 9.333h-3.84V5.494a.667.667 0 0 0-1.333 0v3.84H5.494a.667.667 0 0 0 0 1.333h3.84v3.839a.667.667 0 1 0 1.333 0v-3.84h3.839a.667.667 0 0 0 0-1.333Z"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h20v20H0z"/></clipPath></defs></svg>
            <svg class="hide-child-categories-icon" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" fill="#000"><path d="M19.2 6.1A10 10 0 0 0 6.2.8a10 10 0 0 0-5.4 13 10 10 0 0 0 13 5.4 10 10 0 0 0 5.4-13ZM18 13.4A8.7 8.7 0 0 1 6.6 18 8.7 8.7 0 0 1 2 6.6 8.7 8.7 0 0 1 13.4 2 8.7 8.7 0 0 1 18 13.4Z"/><path d="M15.2 9.3H4.8a.7.7 0 0 0 0 1.4h10.4a.7.7 0 0 0 0-1.4Z"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h20v20H0z"/></clipPath></defs></svg>
            <a class="category-main-item-link @if ($category['category']->category_id == $currentCategoryId) category-main-item-selected @endif "
                href="
                @if($category['category']->destination_type==1)
                /legal-tasks/category-{{ $category["category"]->category_id }}
                @else
                /legal-tests/category-{{ $category["category"]->category_id }}
                @endif">
                {{ $category["category"]->name }}
            </a>
            <div class="category-main-item-slide">
                <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)"><path d="M12.6 8c0 .3-.1.6-.4.8l-6.8 6.9A1.1 1.1 0 1 1 3.8 14l6-6.1-6-6A1.1 1.1 0 0 1 5.4.2l6.8 7c.3.1.4.4.4.7Z" fill="#948F82"/></g><defs><clipPath id="a"><path fill="#fff" transform="rotate(-90 8 8)" d="M0 0h16v16H0z"/></clipPath></defs></svg>
            </div>
        </div>
        <div class="category-child-items-container">
            @foreach ($category["childCategories"] as $subKey=>$subCategory)
            <div class="category-child-item">
                <a class="d-inline-block @if ($subCategory->category_id == $currentCategoryId) category-main-item-selected @endif "
                    href="
                    @if($category['category']->destination_type==1)
                    /legal-tasks/category-{{ $subCategory->category_id }}
                    @else
                    /legal-tests/category-{{ $subCategory->category_id }}
                    @endif">
                {{ $subCategory->name }}
                <br><span class="tasks-count">
                        {{ $subCategory->taskscount}}
                        @if($categoriesType==1) 
                            @if ($subCategory->taskscount == 1)
                                kazus
                            @elseif ($subCategory->taskscount > 1 AND $subCategory->taskscount < 5)
                                kazusy
                            @else
                                kazusów
                            @endif
                        @else 
                            @if ($subCategory->taskscount == 1)
                                pytanie
                            @elseif ($subCategory->taskscount > 1 AND $subCategory->taskscount < 5)
                                paytania
                            @else
                                pytań
                            @endif
                        @endif</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<script>
    let mainCategoriesItems = document.querySelectorAll('.category-main-item-slide');
    for (let i=0;i<mainCategoriesItems.length;i++){
        mainCategoriesItems[i].addEventListener("click", function(e){
            let container = e.target.closest('.category-main-item');
            if (container.classList.contains('category-main-item-opened')){
                container.classList.remove('category-main-item-opened');
            } else {
                container.classList.add('category-main-item-opened');
            }
        });
    }
</script>
