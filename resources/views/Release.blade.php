@extends('layouts.default')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<style>
    /* Release Page Specific Styles */
    body, html {
        margin: 0;
        padding: 0;
        height: 100vh;
        background: #F8F9FA;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .release-container {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .release-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 1200px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }

    .release-header {
        background: #ccc;
        color: white;
        padding: 30px;
        border-radius: 20px 20px 0 0;
        text-align: center;
        position: relative;
    }

    .release-header::after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 20px solid transparent;
        border-right: 20px solid transparent;
        border-top: 20px solid #6B0D2B;
    }

    .logo-section {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .logo-section img {
        height: 40px;
    }

    .release-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: #830F35;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .release-subtitle {
        font-size: 1.1rem;
        margin: 10px 0 0 0;
        opacity: 0.9;
        font-weight: 300;
    }

    .release-body {
        padding: 50px 40px 40px;
    }

    .welcome-section {
        text-align: center;
        margin-bottom: 40px;
    }

    .welcome-section h3 {
        color: #333;
        font-size: 1.5rem;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .welcome-section p {
        color: #666;
        font-size: 1.1rem;
        line-height: 1.6;
        margin: 0;
    }

    .user-info {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        text-align: center;
        border-left: 4px solid #830F35;
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #830F35 0%, #6B0D2B 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 auto 15px;
        box-shadow: 0 4px 15px rgba(131, 15, 53, 0.3);
    }

    .user-name {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .content-section {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .content-header {
        background: #f8f9fa;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .content-header h4 {
        color: #830F35;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
    }

    .content-body {
        padding: 25px;
    }

    .legal-text {
        color: #555;
        line-height: 1.7;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .legal-text p {
        margin-bottom: 15px;
    }

    .legal-text b {
        color: #830F35;
        font-weight: 600;
    }

    .signature-recaptcha-section {
        margin: 30px 0;
    }

    .section-title {
        color: #830F35;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 20px;
        text-align: center;
    }

    .signature-recaptcha-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: start;
    }

    .signature-section {
        background: #f8f9fa;
        border: 2px dashed #830F35;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        position: relative;
    }

    .signature-section h6 {
        color: #830F35;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 15px;
        margin-top: 0;
    }

    #signature-pad {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background: white;
        cursor: crosshair;
        width: 100%;
        height: 200px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .signature-controls {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 15px;
    }

    .signature-btn {
        background: #6c757d;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .signature-btn:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    .signature-btn.clear {
        background: #dc3545;
    }

    .signature-btn.clear:hover {
        background: #c82333;
    }

    .recaptcha-section {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 200px;
    }

    .recaptcha-section h6 {
        color: #830F35;
        font-size: 1rem;
        margin-bottom: 15px;
        margin-top: 0;
        font-weight: 600;
    }

    .g-recaptcha {
        transform: scale(0.9);
        transform-origin: center;
    }

    .submit-section {
        text-align: center;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #e9ecef;
    }

    .submit-btn {
        background: linear-gradient(135deg, #830F35 0%, #6B0D2B 100%);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(131, 15, 53, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(131, 15, 53, 0.4);
    }

    .submit-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .release-container {
            padding: 10px;
        }

        .release-card {
            max-height: 95vh;
        }

        .release-header {
            padding: 25px 20px;
        }

        .release-title {
            font-size: 1.6rem;
        }

        .release-body {
            padding: 30px 25px;
        }

        .signature-recaptcha-container {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .signature-controls {
            flex-direction: column;
            align-items: center;
        }

        .g-recaptcha {
            transform: scale(0.8);
        }
    }

    @media (max-width: 480px) {
        .release-header {
            padding: 20px 15px;
        }

        .release-title {
            font-size: 1.4rem;
        }

        .release-body {
            padding: 25px 20px;
        }

        .content-body {
            padding: 20px;
        }

        #signature-pad {
            height: 150px;
        }

        .signature-recaptcha-container {
            gap: 15px;
        }

        .g-recaptcha {
            transform: scale(0.75);
        }
    }
</style>

<div class="release-container">
    <div class="release-card">
        <!-- Header Section -->
        <div class="release-header">
            <div class="logo-section">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Gratitude Builder Logo">
            </div>
            <h1 class="release-title">Media Release Agreement</h1>
            <p class="release-subtitle">Please review and sign the consent agreement to continue</p>
        </div>

        <!-- Body Section -->
        <div class="release-body">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h3>Welcome to Your Journey!</h3>
                <p>Before we begin, please review and sign our media release agreement.</p>
            </div>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-avatar-large">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <h4 class="user-name">{{ Auth::user()->name ?? 'User' }}</h4>
            </div>

            <!-- Form -->
            <form id="releaseForm" action="{{ route('release.store') }}" method="POST">
                @csrf
                
                <!-- Legal Content Section -->
                <div class="content-section">
                    <div class="content-header">
                        <h4>📄 Media Release and Consent Agreement</h4>
                    </div>
                    <div class="content-body">
                        <div class="legal-text">
                            <p>
                                The above-named <b>USER</b> does hereby irrevocably consent to the
                                recording and distribution of reproduction(s) of the <b>USER</b>'s
                                image, voice and performance as part of the program titled Book
                                Builder, 3X Author Boot Camp, &/or One Day Author, etc. (herein
                                referred to as the "<b>Program</b>").
                            </p>
                            <p>
                                <b>USER</b> does hereby acknowledge that Don Williams, Don Williams
                                Global, Alliance PDMS, LLC and all other Don Williams Companies is
                                the sole owner of all rights in and to the <b>Program</b>, and the
                                recording(s) thereof, as "works made for hire" pursuant to 17 USC
                                §101, et.seq., for all purposes; and that Don Williams, Don Williams
                                Global, Alliance PDMS, LLC and all other Don Williams Companies has
                                the unfettered right, among other things, to use, exploit and
                                distribute the <b>Program</b>, and <b>USER</b> performance as
                                embodied therein in any and all media or formats, throughout the
                                world, in perpetuity. Any materials relating to the production and
                                distribution of the Program ("Materials") become the property of Don
                                Williams, Don Williams Global, Alliance PDMS, LLC and all other Don
                                Williams Companies, and Don Williams, Don Williams Global, Alliance
                                PDMS, LLC and all other Don Williams Companies shall have the sole
                                and exclusive right to use, exploit and distribute such Materials,
                                throughout the world, in perpetuity.
                            </p>
                            <p>
                                Nothing contained in this <b>USER</b> Release shall be construed to
                                obligate Don Williams, Don Williams Global, Alliance PDMS, LLC and
                                all other Don Williams Companies to use or exploit any of the rights
                                granted or acquired by Don Williams, Don Williams Global, Alliance
                                PDMS, LLC and all other Don Williams Companies, or to make, sell,
                                license, distribute or otherwise exploit the <b>Program</b> or
                                Materials whatsoever.
                            </p>
                            <p>
                                <b>USER</b> understands and agrees that he/she shall receive no
                                compensation for appearances on and participation in the
                                <b>Program</b>.
                            </p>
                            <p>
                                <b>USER</b>'s name and likeness may be used in advertising and
                                promotional material for the <b>Program</b>, but not as an
                                endorsement of any product or service.
                            </p>
                            <p>
                                <b>USER</b> hereby releases and discharges Don Williams, Don
                                Williams Global, Alliance PDMS, LLC and all other Don Williams
                                Companies from any and all liability arising out of or in connection
                                with the making, producing, reproducing, processing, exhibiting,
                                distributing, publishing, transmitting by any means or otherwise
                                using the above-mentioned production.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Signature and reCAPTCHA Section -->
                <div class="signature-recaptcha-section">
                    <h5 class="section-title">✍️ Complete to Continue</h5>
                    <div class="signature-recaptcha-container">
                        <!-- Signature Section -->
                        <div class="signature-section">
                            <h6>Digital Signature Required</h6>
                            <canvas id="signature-pad" width="700" height="200"></canvas>
                            <div class="signature-controls">
                                <button type="button" class="signature-btn" id="undo-button">
                                    <i class="mdi mdi-undo"></i> Undo
                                </button>
                                <button type="button" class="signature-btn clear" id="clear-button">
                                    <i class="mdi mdi-eraser"></i> Clear
                                </button>
                            </div>
                        </div>

                        <!-- reCAPTCHA Section -->
                        <div class="recaptcha-section">
                            <h6>🛡️ Security Verification</h6>
                            <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.site_key') }}"
                                 data-callback="recaptchaCallback"></div>
                        </div>
                    </div>
                    <input type="hidden" name="signature" id="signature-input" />
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                </div>

                <!-- Submit Section -->
                <div class="submit-section" id="saveBtn" style="display: none;">
                    <button type="submit" class="submit-btn">
                        🚀 Continue to Journey
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
    function recaptchaCallback(response) {
        $("#saveBtn").show();
    }

    // reCAPTCHA expiration check
    setInterval(function() {
        if (typeof grecaptcha !== 'undefined') {
            const response = grecaptcha.getResponse();
            if (!response) {
                $("#saveBtn").hide();
            }
        }
    }, 1000);

    $(document).ready(function() {
        // Initialize signature pad
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });
        
        var signatureInput = document.getElementById('signature-input');
        var clearButton = document.getElementById('clear-button');
        var undoButton = document.getElementById('undo-button');

        // Resize canvas
        function resizeCanvas() {
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        // Update signature input
        function updateSignatureInput() {
            if (!signaturePad.isEmpty()) {
                signatureInput.value = signaturePad.toDataURL();
            } else {
                signatureInput.value = "";
            }
        }

        // Signature events
        signaturePad.addEventListener('endStroke', updateSignatureInput);

        // Clear button
        clearButton.addEventListener('click', function() {
            signaturePad.clear();
            updateSignatureInput();
        });

        // Undo button
        undoButton.addEventListener('click', function() {
            var data = signaturePad.toData();
            if (data.length > 0) {
                data.pop();
                signaturePad.fromData(data);
                updateSignatureInput();
            }
        });

        // Form submission
        $("#releaseForm").submit(function(e) {
            e.preventDefault();
            
            // Check reCAPTCHA
            if (typeof grecaptcha === 'undefined' || !grecaptcha.getResponse()) {
                Swal.fire({
                    title: "Security Check Required",
                    text: "Please complete the reCAPTCHA verification.",
                    icon: "warning",
                    confirmButtonColor: "#830F35"
                });
                return;
            }

            // Check signature
            if (signaturePad.isEmpty()) {
                Swal.fire({
                    title: "Signature Required",
                    text: "Please provide your digital signature to continue.",
                    icon: "error",
                    confirmButtonColor: "#830F35"
                });
                return;
            }

            updateSignatureInput();
            
            // Submit form via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Agreement Signed!",
                            text: "Thank you for signing the release agreement. Redirecting to your journey...",
                            icon: "success",
                            confirmButtonColor: "#830F35",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Redirect to gratitude page to start the journey
                            window.location.href = "{{ url('/gratitude') }}";
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response.message || "Something went wrong. Please try again.",
                            icon: "error",
                            confirmButtonColor: "#830F35"
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong. Please try again.",
                        icon: "error",
                        confirmButtonColor: "#830F35"
                    });
                }
            });
        });
    });
</script>
@endsection