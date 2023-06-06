<x-layout>
    <div class="row d-flex">
        <div class="col-2 border border-secondary border-3 bg-secondary pb-2" id="sidebarVoice">
            @auth
                <p class="text-warning m-0 fs-5 mb-2 border-bottom">Chats</p>
                <div id="chatHistoryVoice">
                    <a href="/voice" class="btn btn-light d-inline-block text-nowrap overflow-hidden mb-2"
                        id="newChatBtn">New
                        Chat</a>
                    @foreach ($chats as $chat)
                        <a href="#" class="btn btn-dark d-inline-block text-nowrap overflow-hidden mb-2 chatHistoryBtn"
                            data-response="{{ $chat->response }}">{{ $chat->prompt }}</a>
                    @endforeach
                </div>
            @endauth
            <div class="mt-auto">
                <div class="border-top py-2 text-center">
                    <a href="/image" class="btn btn-warning mb-2">Generate Image</a>
                    <a href="{{ Request::is('/') ? '/voice' : '/' }}"
                        class="btn btn-warning">{{ Request::is('/') ? 'Voice Mode' : 'Voice and Chat Mode' }}</a>
                </div>
                <div class="border-top pt-2">
                    <a href="#" class="d-block text-light text-decoration-none">Clear Chats</a>
                    <a href="#" class="d-block text-light text-decoration-none">Settings</a>
                    <a href="#" class="d-block text-light text-decoration-none">Help</a>
                </div>
            </div>
        </div>

        <div class="col-10">
            <div class="row">
                <div class="col-6 d-flex align-items-center justify-content-center">
                    <div class="rounded-circle text-center w-50 h-25 bg-secondary" id="botAudioIcon">
                        <i class="fa-solid fa-robot mt-4" style="font-size: 120px;"></i>
                    </div>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-center ">
                    <div class="rounded-circle text-center w-50 h-25 bg-secondary" id="userAudioIcon">
                        <i class="fa-solid fa-microphone mt-4" style="font-size: 150px;"></i>
                    </div>
                </div>
                <div id="voiceOnlyControl" class="text-center">
                    <a href="#" class="btn btn-info mt-2 w-50" id="speechControlBtn" disabled>Pause</a><br>
                    <select class="d-inline form-select mt-2 w-50" id="voice_list"></select><br>
                    <a href="#" class="btn btn-info mt-2 w-50" id="regenerateBtn" disabled>Regenerate</a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/assets/js/voiceOnly.js') }}"></script>
</x-layout>
