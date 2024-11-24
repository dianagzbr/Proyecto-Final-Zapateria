<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Calzado Pacheco</title>
    <link href="{{ asset('css/template.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body style="background-color:#db2373">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <!-- Name -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input class="form-control" id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your name" />
                                                    <label for="name">Name</label>
                                                </div>
                                                @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
                                            <label for="email">Email address</label>
                                            @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" />
                                                    <label for="password">Password</label>
                                                </div>
                                                @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password" />
                                                    <label for="password_confirmation">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>

                                        <select name="role" class="form-control">
                                            <option value="vendedor">Vendedor</option>
                                            <option value="comprador" selected>Comprador</option>
                                        </select>

                                        <!-- Terms and Conditions -->
                                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                        <div class="mt-3">
                                            <label for="terms" class="form-check-label">
                                                <input type="checkbox" name="terms" id="terms" class="form-check-input" required />
                                                <span>I agree to the <a href="{{ route('terms.show') }}">Terms of Service</a> and <a href="{{ route('policy.show') }}">Privacy Policy</a>.</span>
                                            </label>
                                        </div>
                                        @endif

                                        <!-- Submit Button -->
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-block" style="background-color:#db2373">Create Account</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">
                                        <a href="{{ route('login') }}">Have an account? Go to login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>