@extends('layouts.default')
@section('content')
<style>
    form input {
        display: inline-block;
        text-align: center;
        width: 50px;
        /*height: 50px;
        color: black; */
    }
</style>
<div class="main" style="padding-top:30px !important;padding-bottom:30px !important; min-height:100vh;">

    <!-- Sign up form -->
    <section class="signup m-0">
        <div class="container" style="max-width: 700px; width:100%">
            <div class="signup-content d-block">
                <div class="text-center mx-auto">
                    <h2>Verify OTP Code</h2>
                </div>
                <p class="text-center mt-3">Enter OTP Code you received in your registered email.</p>
                <form action="{{route('verifyOTPpost')}}" class="mt-5 mx-auto" method="POST" id="otpForm">
                    @csrf
                    <div class="w-50 mx-auto d-flex justify-content-center align-items-center">
                        <input class="otp otp1 p-0 mx-1 text-center" type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1>
                        <input class="otp otp2 p-0 mx-1 text-center" type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1>
                        <input class="otp otp3 p-0 mx-1 text-center" type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1>
                        <input class="otp otp4 p-0 mx-1 text-center" type="text" oninput='digitValidate(this)' onkeyup='tabChange(4)' maxlength=1>
                        <input type="hidden" id="otp_code" name="otp_code">
                    </div>
                    <div class="form-group form-button text-center">
                        <input type="submit" name="signup" id="signup" class="form-submit" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </section>

</div>
<script>
    let digitValidate = function(ele) {
        console.log(ele.value);
        ele.value = ele.value.replace(/[^0-9]/g, '');
    }

    let tabChange = function(val) {
        let ele = document.querySelectorAll('input');
        if (ele[val - 1].value != '') {
            ele[val].focus()
        } else if (ele[val - 1].value == '') {
            ele[val - 2].focus()
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    // Contact Us Form Submission Function
    $("#otpForm").submit(function(e) {
        e.preventDefault();
        var value = "" + $(".otp1").val() + $(".otp2").val() + $(".otp3").val() + $(".otp4").val();
        $("#otp_code").val(value);
        validation = validateForm();
        if (validation) {
            $("#otpForm")[0].submit();
        } else {
            swal({
                title: "Some Fields Missing",
                text: "Please fill all fields.",
                icon: "error",
            });
        }
    });

    function validateForm() {
        let errorCount = 0;
        $("form#otpForm :input").each(function() {
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
@endsection
