@extends('layouts.default')
@section('content')
<style>
input {
    width: 100%;
    height: 45px;
    border-radius: 8px;
    display: block;
    border: 1px solid black;
}
label{
    font-weight: 400;
    font-size: 16px;
    line-height: 16px;
    letter-spacing: 1px;
    position: relative;
}
</style>
<div class="main" style="padding-top:30px !important;padding-bottom:30px !important; min-height:100vh;">

    <!-- Sign up form -->
    <section class="signup m-0">
        <div class="container" style="max-width: 700px; width:100%">
            <div>
                <img src="{{asset('assets/images/book-builder-logo.svg')}}" alt="logo" class="mx-auto mt-3" width="150">
            </div>
            <div class="signup-content d-block">
                <div class="text-center mx-auto">
                    <h2>Forgot Password</h2>
                </div>
                <p class="text-center mt-3">Enter your email to let us verify that it is really you.</p>
                <form action="{{route('forgetpasswordpost')}}" class="mt-3" method="post" id="forgetForm">
                    @csrf
                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Your Email" />
                        <input type="submit" name="signup" id="forget" class="form-submit" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    // Contact Us Form Submission Function
    $("#forgetForm").submit(function(e) {
        e.preventDefault();
        validation = validateForm();
        if (validation) {
            $("#forgetForm")[0].submit();
        } else {
            swal({
                title: "Some Fields Missing",
                text: "Please fill all fields.",
                icon: "error",
            });
        }
    })

    function validateForm() {
        let errorCount = 0;
        $("form#forgetForm :input").each(function() {
            let val = $(this).val();
            if (val == '' && $(this).attr('id') !== 'forget') {
                errorCount++
                $(this).css('border-bottom', '1px solid red');
            } else {
                $(this).css('border-bottom', '1px solid #999');
            }
        });
        if (errorCount > 0) {
            return false;
        }
        return true;
    }
</script>
@endsection
