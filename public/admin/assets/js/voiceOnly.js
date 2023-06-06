$(document).ready(function () {
    // Voice Bot
    let synth = speechSynthesis,
        isSpeaking = true;

    // Initialize voices
    const voices = () => {
        for (let voice of synth.getVoices()) {
            let selected = voice.name === "Google US English" ? "selected" : "";
            let option = `<option value="${voice.name}" ${selected}>${voice.name} (${voice.lang})</option>`;
            $("#voice_list").append(option);
        }
    };
    synth.addEventListener("voiceschanged", voices);
    voices();

    // User Voice Recognition
    window.SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition =
        new SpeechRecognition() || new webkitSpeechRecognition();
    recognition.interimResults = true;
    recognition.continuous = false;
    let currentPrompt = "";

    const textToSpeech = async (text) => {
        let utterance = new SpeechSynthesisUtterance(text);
        for (let voice of synth.getVoices()) {
            if (voice.name === $("#voice_list").val()) {
                utterance.voice = voice;
            }
        }
        $("#botAudioIcon").removeClass("bg-secondary").addClass("bg-warning");
        await synth.speak(utterance);
        utterance.onend = () => {
            $("#botAudioIcon")
                .removeClass("bg-warning")
                .addClass("bg-secondary");
        };
    };
    let count = 0;
    // ChatGPT Speak
    const botSpeak = (answer) => {
        recognition.abort();
        let answerLength = answer.length;
        if (answer !== "") {
            if (!synth.speaking) {
                textToSpeech(answer);
            }
            if (answerLength > 1) {
                setInterval(() => {
                    if (!synth.speaking && !isSpeaking) {
                        isSpeaking = true;
                    }
                }, 500);
                if (isSpeaking) {
                    synth.resume();
                    isSpeaking = false;
                    $("#speechControlBtn").text("Pause");
                } else {
                    synth.pause();
                    isSpeaking = true;
                    $("#speechControlBtn").text("Resume");
                }
    
            }
        }
    };

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
    let responses;
  
    recognition.onend = () => {
        console.log("Speech end");
        $("#userAudioIcon").removeClass("bg-danger").addClass("bg-secondary");
        if (
            currentPrompt == "Play." ||
            currentPrompt == "Pause." ||
            currentPrompt == "Resume."
        ) {
            botSpeak(responses[count].text);
        } else if (currentPrompt == "Regenerate.") {
            synth.cancel();
            count++;
            botSpeak(responses[count].text);
        } else {
            if (currentPrompt != "" && previousPrompt != currentPrompt) {
                $.ajax({
                    type: "POST",
                    url: "/speak",
                    data: { prompt: currentPrompt },
                    success: function (response) {
                        count = 0;
                        responses = response.answer;
                        console.log(responses);
                        botSpeak(response.answer[0]['text']);
                    },
                });
                console.log(`Prev: ${previousPrompt} Curr: ${currentPrompt}`);
                previousPrompt = currentPrompt;
            }
        }
        // if (currentPrompt != "" && previousPrompt != currentPrompt) {
        //     $.ajax({
        //         type: "POST",
        //         url: "/speak",
        //         data: { prompt: currentPrompt },
        //         success: function (response) {
        //             count = 0;
        //             responses = response.answer;
        //             botSpeak(response.answer[0]['text']);
        //         },
        //     });
        //     console.log(`Prev: ${previousPrompt} Curr: ${currentPrompt}`);
        //     previousPrompt = currentPrompt;
        // }
        recognition.start();
    };

    // $("#speechControlBtn").on("click", function (e) {
    //     e.preventDefault();
    //     synth.cancel();
    //     count++;
    //     botSpeak(responses[count].text);
    // });

    $('#regenerateBtn').on('click', function(e) {
        e.preventDefault();
        synth.cancel();
        count++;
        $("#answerText").text(responses[count].text);
        botSpeak(responses[count].text);
    });

    $('.chatHistoryBtn').each(function() {
        $(this).on('click', function(e) {
            e.preventDefault();
            synth.cancel();
            botSpeak($(this).attr('data-response'));
            $(this).siblings('.chatHistoryBtn').removeClass('btn-primary');
            $(this).siblings('.chatHistoryBtn').addClass('btn-dark');
            $(this).removeClass('btn-dark');
            $(this).addClass('btn-primary');
            $("#speechControlBtn").text("Play");
        });
    });

    // END $(document).ready
});
