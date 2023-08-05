/* Check whether the SpeechRecognition or the webkitSpeechRecognition API is available on window and reference it */
const recognitionSvc = window.SpeechRecognition || window.webkitSpeechRecognition;

// Instantiate it
const recognition = new recognitionSvc();

/* Set the speech recognition to continuous so it keeps listening to whatever you say. This way you can record long texts, conversations and so on. */
recognition.continuous = true;


/* Sets the language for speech recognition. It uses IETF tags, ISO 639-1 like en-GB, en-US, es-ES and so on */
recognition.lang = 'en-GB';

// Start the speech recognition
recognition.start();

// Event triggered when it gets a match
recognition.onresult = (event) => {
    // iterate through speech recognition results
    for (const result of event.results) {
        // Print the transcription to the console
        console.log(`${result[0].transcript}`);
    }
}

// Stop the speech recognition
recognition.stop();
