@extends('layouts.front')

@section('content')

@include('loader')
<div class="bg-white flex flex-col overflow-hidden items-center pt-7 pb-[46px] px-20 max-md:px-5">
    <div class="w-[1280px] max-w-full">
        <h1 class="m-auto text-center pt-1 pb-4 sm:pt-8 pl-1 pr-1 text-xl sm:text-2xl font-bold max-w-[250px] sm:max-w-[100%] text-[#008641]">{!!$title!!}</h1>
                    <p>Za zakupy dokonane w aptece internetowej wdoz.pl można zapłacić poprzez:</p>

<table class="payment-page-table">
	<tbody>
		<tr>
			<td style="border: none;"><img alt="paynow - logo" src="/images/paynow-payments.png" style="width: 1000px;"></td></tr><tr>
			<td style="border: none; padding: 0px;">Płatność online PayNow oferująca wszystkie najpopularniejsze płatności internetowe, jak: przelew elektroniczny z większości banków, karty płatnicze, portfele elektroniczne. Jest to bezpieczny i najszybszy sposób zapłaty za zamówienie.</td>
		</tr>
	</tbody>
</table>

<p>PayNow gwarantuje&nbsp;pełne bezpieczeństwo.</p>
    </div>
</div>
@endsection