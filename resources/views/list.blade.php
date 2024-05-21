@extends('layout')
@section('content')
    <div class="container-fluid d-grid justify-content-center align-self-center align-items-center py-5 px-5" >
        <input type="hidden" name="page" value="2" id="page">
        <a href="/?search" tabindex="1" aria-label="Voice search"  style="cursor: pointer;display: flex;justify-content: center;text-decoration: none;align-items: end;position: relative;
}"  >
            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="63" viewBox="0 0 42 63" fill="none" tabindex="-1">
                <path d="M20.8048 2C18.6673 2 16.6174 2.8491 15.106 4.3605C13.5946 5.8719 12.7455 7.92179 12.7455 10.0592V31.5505C12.7455 33.688 13.5946 35.7379 15.106 37.2493C16.6174 38.7607 18.6673 39.6098 20.8048 39.6098C22.9422 39.6098 24.9921 38.7607 26.5035 37.2493C28.0149 35.7379 28.864 33.688 28.864 31.5505V10.0592C28.864 7.92179 28.0149 5.8719 26.5035 4.3605C24.9921 2.8491 22.9422 2 20.8048 2Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M39.6098 26.1777V31.5506C39.6098 36.5379 37.6285 41.321 34.1019 44.8476C30.5753 48.3742 25.7923 50.3554 20.8049 50.3554C15.8175 50.3554 11.0344 48.3742 7.50782 44.8476C3.98122 41.321 2 36.5379 2 31.5506V26.1777" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20.8049 50.3555V61.1011" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10.0593 61.1005H31.5506" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <p style="color: white;text-align: center;margin-bottom: 0;font-size: 2rem;padding: 0;display: flex;align-items: end;margin-left: 10px" tabindex="-1">Voice search</p>
        </a>



        <div class="d-flex justify-content-center py-2" tabindex="1" id="data-result">
            <p tabindex="-1" style="color: white">Below are the results for "{{ request()->route()->parameter('search') }}". Price range {{ $minPrice }} to {{ $maxPrice }} {{$symbol}} and {{ $minStar }} stars or more for the first
                {{ count($products) }} products.</p>
        </div>

        <div class="d-grid justify-content-center py-2 pro-list">
            @foreach($products as $key => $product)
                <a id="item-{{$key}}" class="items d-flex  @if($key == @$index-1) selected @endif" href="/product/{{ $product['asin'] }}" style="text-decoration: none" tabindex="0" aria-label="Item {{ $key+1 }} is {{ $product['title'] }} / Rate is {{ $product['rating'] }} of {{ $product['ratings_total']  }} reviews price is €{{ number_format(@$products['price']['value'] ?? 0) }}">
                    <div tabindex="-1" >
                        <p style="color:white;" tabindex="-1" >
                            {{ $key+1 }}. {{ $product['title'] }} / Rate is {{ $product['rating'] }} of {{ $product['ratings_total']  }} reviews price is
                            {{@$product['price']['raw'] ?? 0}}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

            <div style="display:grid;">
                @if($hasMore)
                    <button type="button" onclick="loadMore()" class="more-page btn ">Load 7 more products</button>
                @endif
                <a class="btn" href="/?search">Voice search another </a>
            </div>
    </div>
@endsection
@section('script')
    <script>
        $('#data-result').focus();
        @if(@$index)
        $(document).ready(function () {
            // Handler for .ready() called.
            $('html, body').animate({
                scrollTop: $('#item-{{$index-1}}').offset().top
            }, 'slow');
            document.getElementById('item-{{$index-1}}').focus();
        });

        @endif

        function loadMore(){
            let page = $('#page').val()
            $.ajax({
                url: "/result/{{ $search }}/page?page=" + page,
                type: "Get",

                success: function (data) {
                    let lastNo = $('.items').length;
                    lastNo = parseInt(lastNo)
                    data.products.forEach((product) => {
                        let html = `<a id="item-${lastNo }" class="items d-flex " href="/product/${product.asin}" style="text-decoration: none" tabindex="0" aria-label="Item ${lastNo} is ${product.title} / Rate is ${product.rating} of ${ product.ratings_total } reviews price is €${ product.price.value }">
                                    <div tabindex="-1" >
                                        <p style="color:white;" tabindex="-1" >
                                            ${lastNo + 1 }. ${product.title} / Rate is ${ product.rating } of ${ product.ratings_total } reviews price is ${ product.price.raw }
                                        </p>
                                    </div>
                                </a>`
                        $('.pro-list').append(html)
                        lastNo++
                    })
                    $('#page').val(parseInt($('#page').val()) + 1)
                    if(!data.more_page){
                        $('.more-page').hide()
                    }
                },
                error: function (data) {
                    console.log(data)
                }
            });
        }

    </script>
@endsection
