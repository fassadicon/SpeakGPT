<x-layout>
    <div class="row">
        @include('partials.loginBrand')
        <div class="col-6 d-flex justify-content-center">
            <div class="border border-3 rounded-3 me-5 p-3">
                <form action="/store" method="post">
                    @csrf
                    <label for="first_name" class="form-label fw-bold">First name:</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" value="Michael">
                    <label for="last_name" class="form-label fw-bold mt-2">Last name:</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" value="Choi">
                    <label for="email" class="form-label fw-bold mt-2">Email:</label>
                    <input type="text" class="form-control" name="email" id="email" value="super@admin.com">
                    <label for="password" class="form-label fw-bold mt-2">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" value="qweqwe123">
                    <input type="submit" value="Signup" class="btn btn-primary w-100 mt-3">
                </form>
                <div class="text-center mt-2">
                    <a href="/login">Already have an account?</a>
                </div>
                <hr>
                <div class="text-center">
                    <a href="/guestLogin" class="btn btn-secondary w-100">Continue as guest</a>
                </div>
               
            </div>
        </div>
    </div>
</x-layout>
