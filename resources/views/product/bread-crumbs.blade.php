

    <a href="/"><span class="font-normal">Home</span></a><span class="font-normal text-[#7d7d7d]"> &gt; </span>
    @foreach ($breadCrumbsCategories as $i => $breadCrumb)
    <a href="{{$breadCrumb->slug}}"><span class="font-normal">{{$breadCrumb->name}}</span></a>
    @if ($i < count($breadCrumbsCategories) - 1)
    <span class="font-normal text-[#7d7d7d]"> &gt; </span>
    @endif
    @endforeach

    @if (isset($isProductPage) && $isProductPage)
    <span class="font-normal text-[#7d7d7d]"> &gt; </span>
    <span class="text-[#7d7d7d]">{{$product->name}}</span>
    @endif
</nav>
         