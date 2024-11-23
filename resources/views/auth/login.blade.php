<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="{{ asset('css/template.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body style="background-color:#db2373">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Login</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Formulario de Jetstream -->
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <!-- Email -->
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="name@example.com" />
                                                <label for="email">Email address</label>
                                            </div>

                                            <!-- Password -->
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                                                <label for="password">Password</label>
                                            </div>

                                            <!-- Remember me -->
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="remember_me" type="checkbox" name="remember" />
                                                <label class="form-check-label" for="remember_me">Remember Password</label>
                                            </div>

                                            <!-- Botones -->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                @if (Route::has('password.request'))
                                                    <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                                                @endif
                                                <button class="btn" style="background-color:#db2373" type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">
                                            <a href="{{ route('register') }}">Need an account? Sign up!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <x-footer/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
</html>
