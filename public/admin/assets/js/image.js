$(document).ready(function () {
    // User Voice Recognition
    window.SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition =
        new SpeechRecognition() || new webkitSpeechRecognition();
    recognition.interimResults = true;
    recognition.continuous = false;
    let currentPrompt = "";

    // User Speech Start
    recognition.start();
    recognition.onspeechstart = () => {
        console.log("Speech start");
        $("#userAudioIcon").removeClass("bg-secondary").addClass("bg-danger");
        currentPrompt = "";
        recognition.addEventListener("result", (e) => {
            const transcript = Array.from(e.results)
                .map((result) => result[0])
                .map((result) => result.transcript)
                .join("");
            currentPrompt = transcript;
        });
    };

    // AJAX CSRF setup
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // User Speech End
    let previousPrompt = "";
    recognition.onend = () => {
        console.log("Speech end");
        $("#userAudioIcon").removeClass("bg-danger").addClass("bg-secondary");
        if (currentPrompt != "" && previousPrompt != currentPrompt) {
            $('#prompt').val(currentPrompt);
            $('#promptImageForm').submit();
            console.log(`Prev: ${previousPrompt} Curr: ${currentPrompt}`);
            previousPrompt = currentPrompt;
        }
        recognition.start();
    };

    // END $(document).ready
});
