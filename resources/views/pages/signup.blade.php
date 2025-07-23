@extends('layouts.default')
@section('content')
<style>
    .signup-wrapper {
        padding: 20px;

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
            gap: 40px;

            .__inner-container {
                max-width: 600px;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                gap: 20px;

                h2 {
                    font-size: 36px;
                    font-weight: 400;
                }

                .intro {
                    font-size: 20px;
                }

                .input-field {
                    margin: 0 0 16px 0;
                }

                label {
                    font-size: 16px;
                    display: unset;
                    position: unset;
                    font-weight: 500;
                }

                input {
                    background-color: #F7FBFF;
                    border-radius: 8px;
                    margin-top: 5px;
                    border: solid 1px #D4D7E3;
                }

                .submit-btn {
                    background-color: #005EB5;
                    color: white;
                    cursor: pointer;
                    font-weight: 500;
                }
            }
        }

        .right-container {
            width: 100%;
            background-image: url("{{ asset('assets/images/signup-image.png') }}");
            background-size: cover;
            background-position: center;
            border-radius: 12px;
        }


        @media screen and (max-width:1024px) {
            .left-container {
                align-items: center;

                h2,
                .intro {
                    text-align: center;
                }
            }

            .right-container {
                display: none;
            }
        }
    }

</style>
<div class="signup-wrapper">
    <div class="main-container">
        <div class="left-container">
            <div class="logo">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" width="150">
            </div>
            <div class="__inner-container">
                <h2>Sign up</h2>
                <p class="intro">Today is a new day. It's your day. You shape it. Sign up and start managing your books.
                </p>
                <form method="POST" id="registerForm" enctype="multipart/form-data">
                    <div class="input-field">
                        <label for="fname">First Name</label>
                        <input type="text" name="f_name" id="fname" placeholder="First Name">
                    </div>
                    <div class="input-field">
                        <label for="lname">Last Name</label>
                        <input type="text" name="l_name" id="lname" placeholder="Last Name">
                    </div>
                    <div class="input-field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Your Email">
                    </div>
                    <div class="input-field">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" placeholder="Phone">
                    </div>
                    <div class="input-field">
                        <label for="pass">Password</label>
                        <input type="password" name="password" id="pass" placeholder="Password">
                    </div>
                    <div class="input-field">
                        <label for="re_pass">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="re_pass" placeholder="Repeat your password">
                    </div>
                    <div class="d-grid">
                        <input class="submit-btn" type="submit" name="signup" id="signup" value="Sign up" />
                    </div>
                </form>
                <p class="text-center mt-3">Already have an account? <a href="{{ url('/') }}">Sign in</a></p>
            </div>
        </div>
        <div class="right-container">
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    $("#imageUpload").change(function() {
        let input = this;
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    });



    const form = $('#registerForm');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let url = `{{ route('register') }}`;

    form.on('submit', function(event) {
        event.preventDefault();

        if (validateForm()) {
            let formData = new FormData(this);
            formData.append('_token', csrfToken);

            $.ajax({
                url: url
                , type: 'POST'
                , data: formData
                , processData: false
                , contentType: false
                , success: function(data) {
                    console.log("success : ",data);
                    if (data.success) {
                        Swal.fire({
                            icon: "success"
                            , text: "Registration Successful!"
                            , showConfirmButton: false
                            , timer: 3000
                        });
                        window.location.href = `{{ route('home') }}`;
                    } else {
                        Swal.fire({
                            icon: "error"
                            , text: data.message[0][0]
                            , showConfirmButton: false
                            , timer: 3000
                        });
                    }
                }
                , error: function(xhr) {
                    let errorText = "An error occurred.";
                    console.log("error : ",xhr)
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorText = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: "error"
                        , text: errorText
                        , showConfirmButton: false
                        , timer: 3000
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning'
                , text: 'Please fill all fields.'
                , showConfirmButton: false
                , timer: 3000
            });
        }
    });

    function validateForm() {
        let errorCount = 0;
        $("form#registerForm :input").each(function() {
            let val = $(this).val();
            if (val === '' && $(this).attr('id') !== 'signup') {
                errorCount++;
                $(this).css('border', '1px solid red');
            } else {
                $(this).css('border', '1px solid #999');
            }
        });
        return errorCount === 0;
    }

</script>
@endsection
