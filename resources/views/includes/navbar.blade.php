<nav class="navbar navbar-dark bg-dark p-0">
    <div class="container-fluid">
        <a class="navbar-brand"><img src="{{ asset('admin/assets/images/logo.png') }}" alt="SpeakGPT Logo"
                height="40"></a>
        <div class="d-flex">
            @auth
                <p class="text-light me-5 mt-2 mb-0">Welcome {{ auth()->user()->first_name }}! </p>
                <form action="/logout" method="post">
                    @csrf
                    <input type="submit" class="btn btn-secondary" value="Logout">
                </form>
            @endauth                                             
            @guest
                @if (!(Request::is('login') || Request::is('create')))
                    <a href="/login" class="btn btn-secondary" id="loginBtn">Login</a>
                @endif
            @endguest
        </div>
</nav>
