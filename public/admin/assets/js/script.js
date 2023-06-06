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

// TTS-STT Configuration

// let speech = true;
window.SpeechRecognition =
    window.SpeechRecognition || window.webkitSpeechRecognition;

const recognition = new SpeechRecognition() || new webkitSpeechRecognition();
recognition.interimResults = true;
recognition.continuous = false;

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
        $("#botAudioIcon").removeClass("bg-warning").addClass("bg-secondary");
        $("#speechControlBtn").text("Play");
    };
};

// ChatGPT Speak
const botSpeak = (answer) => {
    console.log("fire");
    recognition.abort();
    let answerText = $("#answerText").val();
    let answerLength = answerText.length;
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
    $("#prompt").val("");
    recognition.addEventListener("result", (e) => {
        const transcript = Array.from(e.results)
            .map((result) => result[0])
            .map((result) => result.transcript)
            .join("");
        $("#prompt").val(transcript);
        console.log(transcript);
    });
};

// User Speech End
let previousPrompt = "";
recognition.onend = () => {
    console.log("Speech end");
    $("#userAudioIcon").removeClass("bg-daFnger").addClass("bg-secondary");
    let currentPrompt = $("#prompt").val();
    if (
        currentPrompt == "Play." ||
        currentPrompt == "Pause." ||
        currentPrompt == "Resume."
    ) {
        botSpeak($("#answerText").val());
    } else if (currentPrompt == "Regenerate.") {
        synth.cancel();
        count++;
        $("#answerText").text(responses[count].text);
        botSpeak(responses[count].text);
    } else {
        if (currentPrompt != "" && previousPrompt != currentPrompt) {
            $("#promptForm").submit();
            console.log(`Prev: ${previousPrompt} Curr: ${currentPrompt}`);
            previousPrompt = currentPrompt;
        }
    }
    recognition.start();
};

let responses;
let count = 0;

$(document).ready(function () {
    // Initialize voices available
    // recognition.start();
    voices();

    // AJAX CSRF setup
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Submit prompt

    $("#promptForm").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/speak",
            data: { prompt: $("#prompt").val() },
            success: function (response) {
                count = 0;
                $("#answerText").text(response.answer[0]["text"]);
                responses = response.answer;
                console.log(responses);
                botSpeak(response.answer[0]["text"]);
            },
        });
    });

    // Speech control
    $("#speechControlBtn").on("click", function (e) {
        e.preventDefault();
        botSpeak($("#answerText").text());
    });

    $(".chatHistoryBtn").each(function () {
        $(this).on("click", function (e) {
            e.preventDefault();
            // $('#prompt').val($(this).text());
            $("#answerText").text($(this).attr("data-response"));
            $("#prompt").val($(this).text());
            console.log($(this).text());
            synth.cancel();
            $(this).siblings(".chatHistoryBtn").removeClass("btn-primary");
            $(this).siblings(".chatHistoryBtn").addClass("btn-dark");
            $(this).removeClass("btn-dark");
            $(this).addClass("btn-primary");
            $("#speechControlBtn").text("Play");
        });
    });

    $("#regenerateBtn").on("click", function (e) {
        e.preventDefault();
        synth.cancel();
        count++;
        $("#answerText").text(responses[count].text);
        botSpeak(responses[count].text);
    });

    $("#newChatBtn").on("click", function (e) {
        synth.cancel();
    });
    // END $(document).ready
});
