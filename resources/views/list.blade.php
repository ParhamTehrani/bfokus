@extends('layout')
@section('content')
    <div class="container-fluid d-grid justify-content-center align-self-center align-items-center py-5 px-5">
        <div class="d-flex justify-content-center p-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="36" viewBox="0 0 24 36" fill="none" onclick="runSpeechRecog()" style="cursor: pointer">
                <path d="M12.0816 2C10.9356 2 9.83665 2.45521 9.02636 3.2655C8.21608 4.07579 7.76086 5.17477 7.76086 6.32069V17.8425C7.76086 18.9884 8.21608 20.0874 9.02636 20.8977C9.83665 21.708 10.9356 22.1632 12.0816 22.1632C13.2275 22.1632 14.3265 21.708 15.1367 20.8977C15.947 20.0874 16.4022 18.9884 16.4022 17.8425V6.32069C16.4022 5.17477 15.947 4.07579 15.1367 3.2655C14.3265 2.45521 13.2275 2 12.0816 2Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22.1632 14.962V17.8425C22.1632 20.5163 21.101 23.0806 19.2104 24.9713C17.3197 26.8619 14.7554 27.9241 12.0816 27.9241C9.40779 27.9241 6.8435 26.8619 4.95283 24.9713C3.06217 23.0806 2 20.5163 2 17.8425V14.962" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12.0816 27.9242V33.6851" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6.32068 33.6847H17.8425" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span style="color:white;display: flex;align-items: end;padding-left: 5px">Voice Search</span>
        </div>

        <div>
            <div class="d-grid justify-content-center">
                <p id="action" style="color: white;font-weight: 800; padding: 0; padding-left: 2rem;"></p>
                <h3 id="output" class="hide" style="color: white"></h3>
                <button class="btn btn-success accept" onclick="search()" disabled>Accept</button>

            </div>

        </div>

        <div class="d-flex justify-content-center py-2">
            <p style="color: white">Below are the results for <span style="color:#14AE5C;">"{{ request()->route()->parameter('search') }}"</span>. Price range <span style="color:#14AE5C;">{{ $minPrice }} to {{ $maxPrice }} euros</span> and <span style="color:#14AE5C;">{{ $minStar }} stars or more</span> for the first
                {{ count($products) }} products.</p>
        </div>

        <div class="d-grid justify-content-center py-2">
            @foreach($products as $key => $product)
                <a class="d-flex" href="{{ $product['url'] }}" style="text-decoration: none" target="_blank">
                    <div>
                        <span style="color:white;border: 1px solid grey;padding: 3px 6px;margin-right: 5px">{{ $key+1 }}</span>
                    </div>
                    <div>
                        <p style="color:white;">
                            {{ $product['title'] }} / Rate is {{ $product['rating'] }} of {{ number_format($product['ratings_total']) }} reviews price is €64.99
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

    </div>



@endsection
