<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BFokus @yield('title')</title>
    @yield('header')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <link rel="stylesheet" href="/style.css?v=1.0.1">
    <link rel="manifest" href="/manifest.json">
    {{--        <style>--}}
    {{--            /* *:focus-visible, */--}}
    {{--            *:focus {--}}
    {{--                outline: 4px dashed darkorange !important;--}}
    {{--            }--}}
    {{--        </style>--}}
</head>
<body>

@yield('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="/script.js?v=1.0.1"></script>
<script src="/speechRecognition.js?v=1.0.1"></script>

@yield('script')
<script>
    $(document).keypress(function (event) {
        if (event.keyCode === 13) {
            var focused = $(':focus');
            focused.click()
        }
    });
</script>



@if(request()->has('provider'))
    <script>
        var expires = "";
        var date = new Date();
        date.setTime(date.getTime() + (1*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
        document.cookie = 'provider' + "=" + ('{{ request()->get('provider') }}' || "")  + expires + "; path=/";
    </script>
@endif
</body>
</html>
