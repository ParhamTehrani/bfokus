<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BFokus</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
        <link rel="stylesheet" href="/style.css">
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

        <script src="/script.js"></script>
        <script src="/speechRecognition.js"></script>

        @yield('script')
        <script>
            $(document).keypress(function (event) {
                if (event.keyCode === 13) {
                    var focused = $(':focus');
                    focused.click()
                }
            });
        </script>
    </body>
</html>
