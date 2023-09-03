if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
    // Initialize webkitSpeechRecognition
    const speechRecognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    speechRecognition.interimResults = true; // Set to true if you want to get intermediate results

    speechRecognition.lang = "de-DE";

    // String for the Final Transcript
    let final_transcript = "";

    // Set the properties for the Speech Recognition object
    speechRecognition.continuous = true;

    // Callback Function for the onStart Event
    speechRecognition.onstart = () => {
        console.log('start')
        $('.accept').attr("disabled", true);
        $('.mic-disactive').hide();
        $('.mic-active').show();
        $('.output').focus();
        $('.container-fluid').attr('tabindex','-1');

        // Show the Status Element
        // document.querySelector("#status").style.display = "block";
    };
    speechRecognition.onerror = function(event) {
        console.log('error')
        console.log(event.error);
        speechRecognition.stop();

    };

    speechRecognition.onend = () => {
        console.log('end')
        // Hide the Status Element
        // document.querySelector("#status").style.display = "none";
        window.location = '/search/' + document.querySelector("#output").innerHTML
    };
    speechRecognition.onspeechend = function() {
        console.log('Speech recognition has stopped.');
    }

    speechRecognition.onresult = (event) => {
        // Create the interim transcript string locally because we don't want it to persist like final transcript

        let interim_transcript = "";

        // Loop through the results from the speech recognition object.
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            // If the result item is Final, add it to Final Transcript, Else add it to Interim transcript
            if (event.results[i].isFinal) {
                final_transcript += event.results[i][0].transcript;
            } else {
                interim_transcript += event.results[i][0].transcript;
            }
        }
        document.querySelector("#output").innerHTML = final_transcript;
        setTimeout(()=>{
                speechRecognition.stop()
        },2000)

        // // Loop through the results from the speech recognition object.
        // for (let i = event.resultIndex; i < event.results.length; ++i) {
        //     final_transcript = event.results[i][0].transcript;
        //
        // }
        // console.log(final_transcript)
        //
        // if (final_transcript.length > 2 && final_transcript != 'Say what you looking for?' && final_transcript != 'Say what you looking for'){
        //     document.querySelector("#output").innerHTML = final_transcript;
        //     $('.accept').attr("disabled", false);
        //     // window.location = '/search/' + document.querySelector("#output").innerHTML
        //     speechRecognition.stop()
        //
        // }

    };


    const startRecognition = () => {
        speechRecognition.start();
    };
    // Set the onClick property of the start button
    document.querySelector("#start").onclick = () => {
        document.getElementById("output").innerHTML = "Say what you looking for?";
        // Start the Speech Recognition
        startRecognition();
    };


} else {
    console.log("Speech Recognition Not Available");
}
