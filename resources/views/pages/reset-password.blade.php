@extends('layouts.default')
@section('content')
<div class="main" style="padding-top:30px !important;padding-bottom:30px !important; min-height:100vh;">

    <!-- Sign up form -->
    <section class="signup m-0">
        <div class="container" style="max-width: 700px; width:100%">
            <div class="signup-content d-block">
                <div class="text-center mx-auto">
                    <h2>Reset Password</h2>
                </div>
                <p class="text-center mt-3">Enter your new Password.</p>
                <form action="{{route('resetpasswordpost')}}" class="mt-5" method="post" id="resetForm">
                    @csrf
                    <div class="form-group w-50 mx-auto">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input type="password" name="password" id="email" placeholder="New Password" />
                    </div>
                    <div class="form-group w-50 mx-auto">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input type="password" name="password_confirmation" id="" placeholder="Confirm New Password" />
                    </div>
                    <div class="form-group form-button text-center">
                        <input type="submit" name="signup" id="signup" class="form-submit" value="Reset" />
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    // Contact Us Form Submission Function
    $("#resetForm").submit(function(e) {
        e.preventDefault();
        validation = validateForm();
        if (validation) {
            $("#resetForm")[0].submit();
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
        $("form#resetForm :input").each(function() {
            let val = $(this).val();
            if (val == '' && $(this).attr('id') !== 'signup') {
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

</script>
@endsection
