if ("webkitSpeechRecognition" in window) {
    // Initialize webkitSpeechRecognition
    let speechRecognition = new webkitSpeechRecognition();

    speechRecognition.lang = "de-DE";

    // String for the Final Transcript
    let final_transcript = "";

    // Set the properties for the Speech Recognition object
    speechRecognition.continuous = true;

    // Callback Function for the onStart Event
    speechRecognition.onstart = () => {
        $('.accept').attr("disabled", true);
        $('.mic-disactive').hide();
        $('.mic-active').show();
        $('.output').focus();
        $('.container-fluid').attr('tabindex','-1');

        // Show the Status Element
        // document.querySelector("#status").style.display = "block";
    };
    speechRecognition.onerror = () => {
        // Hide the Status Element
        // document.querySelector("#status").style.display = "none";
    };
    speechRecognition.onend = () => {
        // Hide the Status Element
        // document.querySelector("#status").style.display = "none";
        window.location = '/search/' + document.querySelector("#output").innerHTML
    };
    speechRecognition.onspeechend = function() {
        console.log('Speech recognition has stopped.');
    }

    speechRecognition.onresult = (event) => {
        // Create the interim transcript string locally because we don't want it to persist like final transcript

        // Loop through the results from the speech recognition object.
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            final_transcript = event.results[i][0].transcript;

        }

        if (final_transcript.length > 2 && final_transcript != 'Say what you looking for?'){
            document.querySelector("#output").innerHTML = final_transcript;
            $('.accept').attr("disabled", false);
            speechRecognition.stop()
            window.location = '/search/' + document.querySelector("#output").innerHTML

        }
    };

    // Set the onClick property of the start button
    document.querySelector("#start").onclick = () => {
        document.getElementById("output").innerHTML = "Say what you looking for?";
        // Start the Speech Recognition
        speechRecognition.start();
    };


} else {
    console.log("Speech Recognition Not Available");
}
