<x-layout>
    <div class="row">
        @include('partials.loginBrand')
        <div class="col-6 d-flex justify-content-center">
            <div class="border border-secondary border-3 p-3 rounded-3 me-5">
                <form action="/authenticate" method="post">
                    @csrf
                    <label for="email" class="form-label fw-bold">Email:</label>
                    <input type="text" class="form-control" name="email" id="email" value="super@admin.com">
                    <label for="password" class="form-label mt-2 fw-bold">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" value="qweqwe123">
                    <input type="submit" value="Login" class="btn btn-primary mt-3 w-100">
                </form>
                <div class="text-center mt-2">
                    <a href="#">Forgot password?</a>
                </div>
                <hr>
                <div class="text-center"> <a href="/guestLogin" class="btn btn-secondary w-100">Continue as guest</a></div>
                <div class="text-center mt-2"> <a href="/create">Create a new account</a></div>


            </div>
        </div>
    </div>
</x-layout>
