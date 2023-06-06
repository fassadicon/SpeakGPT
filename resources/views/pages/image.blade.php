<x-layout>
    <div class="row">
        @include('partials.sidebar')
        <div class="col-10">
            {{-- <img src="{{ $src }}" alt=""> --}}
            <div class="text-center">
                <p class="text-dark m-0 fs-4 my-2">Image Generated: </p>
                <img src="{{ $src ? $src : asset('admin/assets/images/logo.png') }}" alt="" height="512px"
                    width="512px" class="rounded" id="imageResponse">
            </div>

            <div class="d-flex justify-content-center">
                <div class="rounded-circle text-center w-25 h-100 bg-secondary mt-3 mb-3" id="userAudioIcon">
                    <i class="fa-solid fa-microphone mt-4" style="font-size: 100px;"></i>
                </div>
            </div>
            <form action="/generateImage" method="post" id="promptImageForm" class="form mt-4">
                @csrf
                <input type="text" name="prompt" id="prompt" class="form-control mt-1">
                <div class="text-end">
                    <input type="submit" class="btn btn-primary mt-2" value="Generate">
                </div>
            </form>
        </div>
    </div>
   
    <script src="{{ asset('admin/assets/js/image.js') }}"></script>
</x-layout>
