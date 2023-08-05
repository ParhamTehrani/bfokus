<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BFokus</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
        <link rel="stylesheet" href="/style.css">
        <style>
            /* *:focus-visible, */
            *:focus {
                outline: 4px dashed darkorange !important;
            }
        </style>
    </head>
    <body>

        @yield('content')

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="/speechRecognition.js"></script>
        <script src="/script.js"></script>
        <script>

            runSpeechRecog = () => {
                document.getElementById("output").innerHTML = "Loading text...";
                var output = document.getElementById('output');
                var action = document.getElementById('action');
                let recognization = new webkitSpeechRecognition();
                recognization.lang = "de-DE";

                recognization.onstart = () => {
                    action.innerHTML = "Listening...";
                    $('.accept').attr("disabled", true);
                }
                recognization.onresult = (e) => {
                    var transcript = e.results[0][0].transcript;
                    output.innerHTML = transcript;
                    output.classList.remove("hide")
                    $('.accept').attr("disabled", false);
                    action.innerHTML = "";
                }
                recognization.start();
            }
        </script>
    </body>
</html>
