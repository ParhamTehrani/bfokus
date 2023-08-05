if ("webkitSpeechRecognition" in window) {
    // Initialize webkitSpeechRecognition
    let speechRecognition = new webkitSpeechRecognition();

    speechRecognition.lang = "de-DE";

    // String for the Final Transcript
    let final_transcript = "";

    // Set the properties for the Speech Recognition object
    speechRecognition.continuous = true;
    speechRecognition.interimResults = true;

    // Callback Function for the onStart Event
    speechRecognition.onstart = () => {
        console.log('aa')
        $('.accept').attr("disabled", true);

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
    };

    speechRecognition.onresult = (event) => {
        // Create the interim transcript string locally because we don't want it to persist like final transcript

        // Loop through the results from the speech recognition object.
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            final_transcript = event.results[i][0].transcript;

        }
        document.querySelector("#output").innerHTML = final_transcript;
        $('.accept').attr("disabled", false);
    };

    // Set the onClick property of the start button
    document.querySelector("#start").onclick = () => {
        document.getElementById("output").innerHTML = "Loading text...";
        // Start the Speech Recognition
        speechRecognition.start();
    };


} else {
    console.log("Speech Recognition Not Available");
}
