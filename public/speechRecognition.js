if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
    let speechRecognition;
    const languageSelector = document.getElementById('languageSelector');
    const providerSelector = document.getElementById('providerSelector');

    function initializeRecognition(lang = 'en-US',provider = 'rainforest') {
        console.log(lang)
        speechRecognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        speechRecognition.interimResults = true;
        speechRecognition.continuous = true;
        speechRecognition.lang = lang;

        speechRecognition.onstart = () => {
            console.log('start')
            $('.accept').attr("disabled", true);
            $('.mic-disactive').hide();
            $('.mic-active').show();
            $('#output').attr("tabindex", 1);
            $('#output').focus();
            $('.container-fluid').attr('tabindex','-1');

            console.log('Recognition started');
        };

        speechRecognition.onerror = (event) => {
            console.log('Recognition error:', event.error);
        };

        speechRecognition.onend = () => {
            console.log('Recognition ended');
            window.location = '/search/' + document.querySelector("#output").innerHTML + '?provider=' + provider + '&lang=' + lang

        };

        speechRecognition.onresult = (event) => {
            let final_transcript = '';
            let interim_transcript = '';

            for (let i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    final_transcript += event.results[i][0].transcript;
                } else {
                    interim_transcript += event.results[i][0].transcript;
                }
            }
            document.getElementById('output').innerHTML = final_transcript;

            setTimeout(()=>{
                speechRecognition.stop()
            },2000)
        };
    }

    document.addEventListener("DOMContentLoaded", function() {
        initializeRecognition(languageSelector.value , providerSelector.value);
    });

    // Event listener for language and manual stop
    languageSelector.addEventListener('change', function() {
        if (speechRecognition) {
            speechRecognition.stop();
        }
        initializeRecognition(this.value,providerSelector.value);
    });

    // Event listener for language and manual stop
    providerSelector.addEventListener('change', function() {
        if (speechRecognition) {
            speechRecognition.stop();
        }
        initializeRecognition(languageSelector.value,this.value);
    });

    document.getElementById('start').onclick = () => {
        document.getElementById('output').innerHTML = "Say what you're looking for?";
        speechRecognition.start();
    };

    document.getElementById('stop').onclick = () => {
        if (speechRecognition) {
            speechRecognition.stop();
        }
    };




} else {
    console.log("Speech Recognition Not Available");
}
