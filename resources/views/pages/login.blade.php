@extends('layouts.default')

@section('content')

<style>
    .login-wrapper {
        padding: 20px;
    }

    .main-container {
        display: flex;
        justify-content: space-between;
        gap: 60px;
        max-width: 1440px;
        margin: 0 auto;
        min-height: 94vh;
    }

    .main-container>div {
        width: 100%;
    }

    .left-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 40px;
        position: relative;
    }

    .logo {
        position: absolute;
        top: 0;
        left: 0;
    }

    .__inner-container {
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .__inner-container label {
        font-size: 16px;
        font-weight: 500;
    }

    .__inner-container input {
        background-color: #F7FBFF;
        border-radius: 8px;
        margin-top: 5px;
        border: solid 1px #D4D7E3;
        padding: 10px;
        width: 100%;
    }

    .__inner-container input:focus {
        border: 1px solid #313957;
        background: #F7FBFF;
        outline: none;
    }

    .submit-btn {
        background-color: #005EB5;
        color: white;
        cursor: pointer;
        font-weight: 500;
        padding: 12px;
        border: none;
        border-radius: 6px;
    }

    .right-container {
        background-image: url("{{ asset('assets/images/login_img.png') }}");
        background-size: cover;
        background-position: center;
        border-radius: 12px;
        display: block;
    }

    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
    }

    @media screen and (max-width: 1024px) {
        .right-container {
            display: none;
        }

        .left-container {
            align-items: center;
            text-align: center;
        }
    }
</style>

<div class="login-wrapper">
    <div class="main-container">
        <div class="left-container">
            <div class="logo">
                <img src="{{ asset('assets/images/book-builder-logo.svg') }}" alt="Book Builder Logo">
            </div>
            <div class="__inner-container">
                <h2>Welcome Back 👋</h2>
                <p class="intro">Today is a new day. It's your day. You shape it. Sign in to start managing your
                    projects.</p>

                <form method="POST" action="{{ route('loginpost') }}" id="loginForm" novalidate>
                    @csrf
                    {{-- Email --}}
                    <div class="mb-3">
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="example@example.com"
                            value="{{ old('email') }}">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Password + Toggle --}}
                    <div class="mb-3">
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="At least 8 characters">
                            <span class="toggle-password">
                                <i class="fas fa-eye" id="togglePasswordIcon"></i>
                            </span>
                        </div>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('forgetpassword') }}" class="text-decoration-none"
                            style="color: #005EB5;">Forgot Password?</a>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="submit-btn">Sign in</button>
                    </div>
                </form>

                <p class="text-center mt-3">
                    Don’t have an account?
                    <a href="{{ route('signup') }}" class="text-decoration-none"
                        style="color: #005EB5; font-weight: 600;">Sign up</a>
                </p>
            </div>
        </div>

        <div class="right-container"></div>
    </div>
</div>

{{-- jQuery & SweetAlert --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Toggle Password Visibility
        $(document).ready(function () {
            $('.toggle-password').on('click', function () {
                const input = $('#password');
                const icon = $('#togglePasswordIcon');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Validation before submit
            $("#loginForm").submit(function (e) {
                let hasError = false;

                $('#loginForm input[type="email"], #loginForm input[type="password"]').each(function () {
                    if (!$(this).val()) {
                        $(this).css('border', '1px solid red');
                        hasError = true;
                    } else {
                        $(this).css('border', '1px solid #D4D7E3');
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        text: 'Please fill in all required fields.',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            });
        });
</script>
@endsection