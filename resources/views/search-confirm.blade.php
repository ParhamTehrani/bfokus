@extends('layout')
@section('content')
    <div class="container-fluid d-grid justify-content-center align-self-center align-items-center "  tabindex="-1">

        <div id="result" tabindex="0" aria-label="Get results for “serge” with w-tap" onclick="search()" style="cursor:pointer;">
            <span id="output" style="display:none;" tabindex="-1">{{ $search }}</span>
            <p style="color: white;text-align: center;font-size: 2rem" tabindex="-1">Get results for “{{ $search }}” with w-tap</p>
        </div>

        <a href="/?search" tabindex="0" aria-label="Tap to voice search again"  style="cursor:pointer;display: flex;text-decoration: none"  >
            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="63" viewBox="0 0 42 63" fill="none" tabindex="-1">
                <path d="M20.8048 2C18.6673 2 16.6174 2.8491 15.106 4.3605C13.5946 5.8719 12.7455 7.92179 12.7455 10.0592V31.5505C12.7455 33.688 13.5946 35.7379 15.106 37.2493C16.6174 38.7607 18.6673 39.6098 20.8048 39.6098C22.9422 39.6098 24.9921 38.7607 26.5035 37.2493C28.0149 35.7379 28.864 33.688 28.864 31.5505V10.0592C28.864 7.92179 28.0149 5.8719 26.5035 4.3605C24.9921 2.8491 22.9422 2 20.8048 2Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M39.6098 26.1777V31.5506C39.6098 36.5379 37.6285 41.321 34.1019 44.8476C30.5753 48.3742 25.7923 50.3554 20.8049 50.3554C15.8175 50.3554 11.0344 48.3742 7.50782 44.8476C3.98122 41.321 2 36.5379 2 31.5506V26.1777" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20.8049 50.3555V61.1011" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10.0593 61.1005H31.5506" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <p style="color: white;text-align: center;font-size: 2rem" tabindex="-1">Tap to voice search again</p>
        </a>
    </div>



@endsection
@section('script')
    <script>
        $('#result').focus()
    </script>
@endsection
