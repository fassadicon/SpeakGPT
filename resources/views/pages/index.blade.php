<x-layout>
    <div class="row d-flex">
        @include('partials.sidebar')
        <div class="col-7">
            <p class="h2 mt-2">SpeakGPT says:</p>
            {{-- ChatGPT Re --}}
            <textarea id="answerText" class="form-control h-75"></textarea>
            <div class="text-end">
                <select class="d-inline form-select mt-2 pt-2 w-50" id="voice_list"></select>
                <a href="#" class="btn btn-info" id="regenerateBtn">Regenerate</a>
                <a href="#" class="btn btn-secondary" id="speechControlBtn" disabled>Play</a>
            </div>
            {{-- Send a prompt --}}
            <form action="/speak" class="form mt-3" method="post" id="promptForm">
                @csrf
                <label for="prompt" class="form-label">Send a message:</label>
                <input name="prompt" id="prompt" class="form-control"></input>
                <div class="text-end">
                    <input type="submit" class="btn btn-success mt-2 mb-2" value="Submit">
                </div>
            </form>
        </div>
        <div class="col-3 d-flex justify-content-center">
            <div class="rounded-circle text-center w-100 h-25 w-100 bg-secondary mb-5 pt-3" id="botAudioIcon">
                <i class="fa-solid fa-robot mt-4" style="font-size: 120px;"></i>
            </div>
            <div class="rounded-circle text-center w-50 h-25 w-100 bg-secondary mt-5" id="userAudioIcon">
                <i class="fa-solid fa-microphone mt-4" style="font-size: 150px;"></i>
            </div>
        </div>
    </div>
  
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>
</x-layout>
