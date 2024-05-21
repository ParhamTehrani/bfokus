@extends('layout')
@section('content')

    <div class="container-fluid d-grid justify-content-center align-self-center align-items-center py-5 px-5" tabindex="-1">
        <div class="d-flex justify-content-start" tabindex="0">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="33" viewBox="0 0 40 33" fill="none">
                <path d="M40 13.75H8.51111L16.4667 3.8775L13.3333 0L0 16.5L13.3333 33L16.4667 29.1225L8.51111 19.25H40V13.75Z" fill="#D9D9D9"/>
            </svg>
            <a class="mx-3" style="color: white;font-size: 1.5rem;text-decoration: none" tabindex="-1" href="/result/{{  Session::get('last_search_' . $providerName) }}?index={{ $index }}">
                Back to List
            </a>
        </div>

        @if($product_list)
            <div tabindex="0" class="my-2 product-data" id="product-data">
            <span style="color: white;font-size: 1.4rem">
                This page include info of product {{ $index ?? 1 }} of {{ count($product_list) }}, at the end of page can access result list.
            </span>
            </div>
        @endif
        <div tabindex="0" class="my-2">
            <span style="color: white;font-size: 1.4rem">
               {{ $product['title'] }}
            </span>
        </div>
        @if($product['description'])
            <div tabindex="0" class="my-2">
            <span style="color: white;font-size: 1.4rem">
               {{ $product['description'] }}
            </span>
            </div>
        @endif
        <div tabindex="0" class="my-2">
            <span style="color: white;font-size: 1.4rem">
                It’s Amazan’s choice with {{ $product['rating'] }} of 5 stars by {{ $product['ratings_total'] }} review
            </span>
        </div>
        <div tabindex="0" class="my-2">
            <span style="color: white;font-size: 1.4rem">
                Price with {{ $product['price']['raw'] }}
            </span>
        </div>

{{--        <div class="collapse-part my-2" >--}}
{{--            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed p-0" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" tabindex="0">--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="8" viewBox="0 0 15 8" fill="none" class="to-right">--}}
{{--                    <path d="M5.96356 7.15627C6.76315 8.11578 8.23685 8.11578 9.03644 7.15627L15 0H0L5.96356 7.15627Z" fill="white"/>--}}
{{--                </svg>--}}
{{--                <span style="color: white">Black and white color exits. W-tap to choose color</span>--}}
{{--            </button>--}}
{{--            <div class="collapse collapse-body p-2" id="collapseExample">--}}
{{--                <p tabindex="0" class="toggle-item" style="color:#fff;">White, w-tap to select</p>--}}
{{--                <p tabindex="0" class="toggle-item" style="color:#fff;">Black, w-tap to select</p>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div tabindex="-1" class="d-grid product-actions my-2">
            <a class="btn" tabindex="0" href="https://www.amazon.com/dp/{{ @$product['asin'] }}" target="_blank">open this product on amazon</a>
            <a class="btn" tabindex="0" href="?next">next product</a>
            <a class="btn" tabindex="0" href="?previous">previous product</a>
            <a class="btn" tabindex="0" href="/result/{{  Session::get('last_search_' . $providerName) }}?index={{ $index }}">back to search list</a>
            <a class="btn" tabindex="0" href="/?search">search another product</a>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#product-data').focus();

        $(document).on('click','.btn-toggle',function () {
            if($(this).parent().hasClass('selected')){
                $(this).parent().removeClass('selected')
                $(this).focus()
            }else{
                $(this).parent().addClass('selected')
                $('.toggle-item')[0].focus()
            }
        })
    </script>
@endsection
