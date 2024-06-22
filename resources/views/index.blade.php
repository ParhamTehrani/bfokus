@extends('layout')
@section('title')
    | Be Focus on Your Shopping
@endsection
@section('header')
    <meta name="description" content="a free app, that connects blind and low-vision users to the Amazon store and makes online shopping simple">
@endsection
@section('content')
    <div class="container-fluid d-grid justify-content-center align-self-center align-items-center py-5" tabindex="-1" >
        <div class="d-flex justify-content-between">
            <select class="form-control" name="provider" id="providerSelector">
                <option value="">Select Provider</option>
                <option value="rainforest" @if(request()->get('provider') == 'rainforest' || request()->cookie('provider') == 'rainforest') selected @endif>Rainforest</option>
                <option value="amazon-native" @if(request()->get('provider') == 'amazon-native' || request()->cookie('provider') == 'amazon-native') selected @endif>Amazon</option>
            </select>
{{--            <select class="form-control" name="language" id="languageSelector">--}}
{{--                <option value="">Select Language</option>--}}
{{--                <option value="en-US" @if(request()->get('lang') == 'en-US') selected @endif>English</option>--}}
{{--                <option value="de-DE" @if(request()->get('lang') == 'de-DE') selected @endif>Germany</option>--}}
{{--            </select>--}}
        </div>
        <div aria-label="Tap on the screen and voice search on Amazon" id="start" tabindex="1">
            <p style="color: white;text-align: center;font-size: 2rem;margin-bottom: 200px" tabindex="-1">Tap on the screen and voice search on Amazon</p>

            <div class="d-flex justify-content-center" tabindex="-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="150" viewBox="0 0 52 79" fill="none" class="mic-disactive" style="cursor: pointer">
                    <path d="M25.9587 1.92896C23.24 1.92896 20.6327 3.00894 18.7103 4.93133C16.7879 6.85372 15.7079 9.46103 15.7079 12.1797V39.515C15.7079 42.2337 16.7879 44.841 18.7103 46.7634C20.6327 48.6858 23.24 49.7658 25.9587 49.7658C28.6774 49.7658 31.2847 48.6858 33.2071 46.7634C35.1294 44.841 36.2094 42.2337 36.2094 39.515V12.1797C36.2094 9.46103 35.1294 6.85372 33.2071 4.93133C31.2847 3.00894 28.6774 1.92896 25.9587 1.92896Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M49.8772 32.6812V39.515C49.8772 45.8586 47.3572 51.9423 42.8717 56.4279C38.3861 60.9135 32.3024 63.4334 25.9588 63.4334C19.6153 63.4334 13.5315 60.9135 9.04594 56.4279C4.56037 51.9423 2.04041 45.8586 2.04041 39.515V32.6812" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M25.9588 63.4335V77.1011" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.2912 77.1004H39.6265" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="150" viewBox="0 0 52 79" fill="none" class="mic-active">
                    <path d="M25.9587 1.92896C23.24 1.92896 20.6327 3.00894 18.7103 4.93133C16.7879 6.85371 15.7079 9.46103 15.7079 12.1797V39.515C15.7079 42.2337 16.7879 44.841 18.7103 46.7634C20.6327 48.6858 23.24 49.7658 25.9587 49.7658C28.6774 49.7658 31.2847 48.6858 33.2071 46.7634C35.1294 44.841 36.2094 42.2337 36.2094 39.515V12.1797C36.2094 9.46103 35.1294 6.85371 33.2071 4.93133C31.2847 3.00894 28.6774 1.92896 25.9587 1.92896Z" fill="url(#paint0_linear_1_51)" stroke="#FFD5A4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M49.8772 32.6812V39.515C49.8772 45.8586 47.3572 51.9423 42.8717 56.4279C38.3861 60.9135 32.3024 63.4334 25.9588 63.4334C19.6153 63.4334 13.5315 60.9135 9.04594 56.4279C4.56037 51.9423 2.04041 45.8586 2.04041 39.515V32.6812" fill="url(#paint1_linear_1_51)"/>
                    <path d="M49.8772 32.6812V39.515C49.8772 45.8586 47.3572 51.9423 42.8717 56.4279C38.3861 60.9135 32.3024 63.4334 25.9588 63.4334C19.6153 63.4334 13.5315 60.9135 9.04594 56.4279C4.56037 51.9423 2.04041 45.8586 2.04041 39.515V32.6812" stroke="#FFD5A4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M25.9588 63.4335V77.1011" stroke="#FFD5A4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.2912 77.1004H39.6265" stroke="#FFD5A4" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="paint0_linear_1_51" x1="25.9587" y1="1.92896" x2="25.9587" y2="49.7658" gradientUnits="userSpaceOnUse">
                            <stop stop-color="white" stop-opacity="0"/>
                            <stop offset="1" stop-color="#FF8A00"/>
                        </linearGradient>
                        <linearGradient id="paint1_linear_1_51" x1="25.9588" y1="32.6812" x2="25.9588" y2="63.4334" gradientUnits="userSpaceOnUse">
                            <stop stop-color="white" stop-opacity="0"/>
                            <stop offset="1" stop-color="#FF8A00"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>

        <div class="d-grid justify-content-center" tabindex="-1">
            <p id="action" style="color: white;font-weight: 800; padding: 0; padding-left: 2rem;" tabindex="-1"></p>
            <h3 id="output" class="hide" style="color: white" tabindex="-1"></h3>
        </div>

        {{--        <button class="btn btn-success accept" disabled onclick="search()" tabindex="-1">Accept</button>--}}
    </div>



@endsection
@if(request()->has('search'))
    @section('script')
        <script>
            setTimeout(()=>{
                $('#start').click()
            },500)
        </script>
    @endsection
@endif
