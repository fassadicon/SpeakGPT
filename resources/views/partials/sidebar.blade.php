<div class="col-2 border border-secondary border-3 bg-secondary pb-2">
    @auth

        @if (Request::is('/'))
            <p class="text-warning m-0 fs-5 mb-2 border-bottom">Chats</p>
            <div id="chatHistory">
                <a href="/" class="btn btn-light d-inline-block text-nowrap overflow-hidden mb-2" id="newChatBtn">New
                    Chat</a>
                @foreach ($chats as $chat)
                    <a href="#" class="btn btn-dark d-inline-block text-nowrap overflow-hidden mb-2 chatHistoryBtn"
                        data-response="{{ $chat->response }}">{{ $chat->prompt }}</a>
                @endforeach
            </div>
        @else
            <p class="text-warning m-0 fs-5 mb-2 border-bottom">Images</p>
            <div id="imageHistory">
                <a href="/image" class="btn btn-light d-inline-block text-nowrap overflow-hidden mb-2" id="newChatBtn">New
                    Image</a>
                @foreach ($images as $image)
                    <form action="/getImage" method="post">
                        @csrf
                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                        <input type="submit"
                            class='btn btn-{{ $selected == $image->id ? 'primary' : 'dark' }} d-inline-block text-nowrap overflow-hidden mb-2 chatHistoryBtn'
                            value="{{ $image->prompt }}">
                    </form>
                @endforeach
            </div>
        @endif


    @endauth
    <div class="mt-auto">
        <div class="border-top py-2 text-center">
            <a href="/image" class="btn btn-warning mb-2 w-100">Generate Image</a>
            <a href="{{ Request::is('/') ? '/voice' : '/' }}"
                class="btn btn-warning w-100">{{ Request::is('/') ? 'Voice Mode' : 'Voice and Chat Mode' }}</a>
        </div>
        <div class="border-top pt-2">
            <a href="#" class="d-block text-light text-decoration-none">Clear Chats</a>
            <a href="#" class="d-block text-light text-decoration-none">Settings</a>
            <a href="#" class="d-block text-light text-decoration-none">Help</a>
        </div>
    </div>
</div>
