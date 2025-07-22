@extends('layouts.default')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
<style>
    /* User Dropdown in Container */
    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #fff;
        border-bottom: 1px solid #e0e0e0;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
    
    .logo {
        font-size: 1.2rem;
        font-weight: 600;
        color: #007bff;
        margin: 0;
    }
    
    @media (max-width: 768px) {
        .user-header {
            padding: 12px 16px;
            margin-bottom: 15px;
        }
        
        .logo {
            font-size: 1.1rem;
        }
    }
    
    @media (max-width: 480px) {
        .user-header {
            padding: 10px 12px;
            margin-bottom: 10px;
        }
        
        .logo {
            font-size: 1rem;
        }
    }
    
    .user-dropdown {
        position: relative;
        display: inline-block;
    }
    
    .user-dropdown-toggle {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        color: #333;
        white-space: nowrap;
    }
    
    .user-dropdown-toggle:hover {
        background: #e9ecef;
        text-decoration: none;
        color: #333;
    }
    
    @media (max-width: 768px) {
        .user-dropdown-toggle {
            padding: 6px 10px;
            gap: 6px;
            font-size: 14px;
        }
    }
    
    @media (max-width: 480px) {
        .user-dropdown-toggle {
            padding: 5px 8px;
            gap: 4px;
            font-size: 13px;
        }
        
        .user-dropdown-toggle span:not(.dropdown-arrow) {
            display: none;
        }
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }
    
    @media (max-width: 768px) {
        .user-avatar {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }
    }
    
    @media (max-width: 480px) {
        .user-avatar {
            width: 26px;
            height: 26px;
            font-size: 11px;
        }
    }
    
    .dropdown-arrow {
        font-size: 12px;
        transition: transform 0.2s ease;
    }
    
    .user-dropdown.open .dropdown-arrow {
        transform: rotate(180deg);
    }
    
    .user-dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 180px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s ease;
        z-index: 1001;
    }
    
    @media (max-width: 768px) {
        .user-dropdown-menu {
            min-width: 150px;
            right: -5px;
        }
    }
    
    @media (max-width: 480px) {
        .user-dropdown-menu {
            min-width: 120px;
            right: -10px;
            font-size: 14px;
        }
    }
    
    .user-dropdown.open .user-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .dropdown-item {
        display: block;
        padding: 12px 16px;
        color: #333;
        text-decoration: none;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s ease;
        font-size: 14px;
    }
    
    .dropdown-item:last-child {
        border-bottom: none;
    }
    
    .dropdown-item:hover {
        background: #f8f9fa;
        text-decoration: none;
        color: #333;
    }
    
    @media (max-width: 768px) {
        .dropdown-item {
            padding: 10px 12px;
            font-size: 13px;
        }
    }
    
    @media (max-width: 480px) {
        .dropdown-item {
            padding: 8px 10px;
            font-size: 12px;
        }
    }
    
    .logout-item {
        color: #dc3545;
    }
    
    .logout-item:hover {
        background: #fdf2f2;
        color: #dc3545;
    }

    /* Full screen styles */
    body, html {
        margin: 0;
        padding: 0;
        height: 100vh;
        overflow: hidden;
    }
    
    .main-container {
        height: 100vh;
        width: 100vw;
        padding: 0;
        margin: 0;
        overflow: hidden;
    }
    
    .container-wrapper {
        height: 100vh;
        width: 100vw;
        padding: 20px;
        box-sizing: border-box;
        overflow: hidden;
    }
    
    @media (max-width: 768px) {
        .container-wrapper {
            padding: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .container-wrapper {
            padding: 10px;
        }
    }
    
    .content-area {
        height: 100%;
        width: 100%;
        overflow-y: auto;
        padding: 0;
        box-sizing: border-box;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }
    
    .content-body {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }
    
    @media (max-width: 768px) {
        .content-body {
            padding: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .content-body {
            padding: 12px;
        }
    }
    
    .gratitude-section {
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .gratitude-section h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-size: 1.8rem;
    }
    
    @media (max-width: 768px) {
        .gratitude-section {
            gap: 15px;
        }
        
        .gratitude-section h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
    }
    
    @media (max-width: 480px) {
        .gratitude-section {
            gap: 12px;
        }
        
        .gratitude-section h2 {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
    }
    
    .story-container {
        flex: 0 0 auto;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .story-container {
            padding: 15px;
            margin-bottom: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .story-container {
            padding: 12px;
            margin-bottom: 12px;
        }
    }
    
    .story-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    @media (max-width: 480px) {
        .story-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 12px;
        }
    }
    
    .story-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    
    @media (max-width: 768px) {
        .story-title {
            font-size: 1.3rem;
        }
    }
    
    @media (max-width: 480px) {
        .story-title {
            font-size: 1.2rem;
        }
    }
    
    .story-badge {
        background: #007bff;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .story-content {
        background: white;
        padding: 15px;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
        line-height: 1.6;
        color: #666;
    }
    
    .samples-section {
        flex: 1;
        min-height: 0;
        display: flex;
        flex-direction: column;
    }
    
    .sample-container {
        display: none;
        flex-direction: column;
        gap: 15px;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        max-height: 300px;
        overflow-y: auto;
    }
    
    .sample-container.active {
        display: flex;
    }
    
    .sample-container img {
        width: 100%;
        max-width: 300px;
        height: auto;
        border-radius: 6px;
        align-self: center;
    }
    
    .gratitude-change {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .gratitude-change a {
        width: 12px;
        height: 12px;
        background: #ccc;
        border-radius: 50%;
        display: block;
        text-decoration: none;
    }
    
    .gratitude-change a.active {
        background: #007bff;
    }
    
    .recording-interface {
        flex: 0 0 auto;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
    }
    
    .recording-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .recording-timer {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #e9ecef;
        padding: 8px 12px;
        border-radius: 6px;
        font-family: monospace;
    }
    
    .recording-indicator {
        width: 10px;
        height: 10px;
        background: #ccc;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .recording-indicator.active {
        background: #dc3545;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    .recording-controls {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #e0e0e0;
    }
    
    /* Real-time Speech Display */
    .realtime-speech-display {
        background: #fff;
        border: 2px solid #007bff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .realtime-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .realtime-text {
        min-height: 50px;
        max-height: 150px;
        overflow-y: auto;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 4px;
        border: 1px solid #e0e0e0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 16px;
        line-height: 1.5;
        color: #333;
    }
    
    .realtime-text.empty {
        color: #999;
        font-style: italic;
    }
    
    .realtime-text.empty:before {
        content: "Your speech will appear here as you speak...";
    }
    
    .auto-transfer-info {
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #e0e0e0;
        text-align: center;
    }
    
    .recording-controls button {
        padding: 8px 16px;
        margin-right: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    
    .btn-success {
        background: #28a745;
        color: white;
    }
    
    .btn-danger {
        background: #dc3545;
        color: white;
    }
    
    .btn-primary {
        background: #007bff;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary:hover {
        background: #0056b3;
    }
    
    .btn-primary:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    
    .generate-button-container {
        flex: 0 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 0;
    }
    
    .editor-container {
        margin-top: 15px;
    }
    
    #editor2 {
        min-height: 200px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .ck-editor__editable {
        min-height: 200px !important;
    }
    
    /* Removed interim text styling as we're now using final text only */
    
    /* SweetAlert custom styling */
    .swal-container {
        z-index: 10000 !important;
    }
    
    .swal-wide {
        width: 500px !important;
        max-width: 90vw !important;
    }
    
    .swal-title {
        font-size: 24px !important;
        font-weight: 600 !important;
    }
</style>

<section class="main-container">
    <div class="container-wrapper">
        <div class="content-area">
            <!-- User Header with Dropdown -->
            <div class="user-header">
                <span class="logo">
                    <img src="{{ asset('assets/images/book-builder-logo.svg') }}" alt="Gratitude Builder Logo" style="vertical-align: middle;">
                </span>
                
                <div class="user-dropdown" id="userDropdown">
                    <a href="#" class="user-dropdown-toggle" onclick="toggleUserDropdown(event)">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span>{{ Auth::user()->name ?? 'User' }}</span>
                        <span class="dropdown-arrow">▼</span>
                    </a>
                    
                    <div class="user-dropdown-menu">
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item logout-item" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Body -->
            <div class="content-body">
                <div class="gratitude-section">
                <h2>Gratitude Story</h2>
                
                <!-- Story Container -->
                <div class="story-container" id="mainStoryContainer">
                    <div class="story-header">
                        <h3 class="story-title" id="storyTitle">{{ $gratitudeStory['title'] ?? 'Your Gratitude Story' }}</h3>
                        <div class="story-badge" id="storyBadge">AI Generated</div>
                    </div>
                    <div class="story-content" id="storyContent">
                        @if(isset($gratitudeStory['content']))
                            {!! nl2br(e($gratitudeStory['content'])) !!}
                        @else
                            <p>Your generated gratitude story will appear here...</p>
                        @endif
                    </div>
                </div>
                
                <!-- Sample Stories Section -->
                <div class="samples-section">
                    <h4 style="text-align: center; margin-bottom: 20px; color: #333;">Sample Stories for Inspiration</h4>
                    
                    <div class="sample-container sample-1 active" data-target="1">
                        <div>
                            <h3>My name is Don Williams and I'm Grateful</h3>
                            <h6>- Sample 1 -</h6>
                        </div>
                        <img src="{{asset('assets/images/gratitude-1.png')}}" />
                        <p>
                            My gratitude journey started at the Entrepreneur's Organization Global
                            Leadership Conference in Bangkok, Thailand. A smart lady and now friend by
                            the name of Gina Mollicone- Long was speaking during a break-out session.
                            During her lecture, she proposed that humans perform at their highest
                            level when they express or experience gratitude, and at their lowest level
                            when they express or experience fear or shame. Little did I know that
                            thought would completely change my life.
                        </p>
                        <p>
                            When we returned to the United States, I drove myself to our local Home
                            Depot and bought a small, galvanized pail. I carried the pail everywhere with me. 
                            That pail became a physical reminder to me to be intentional about my gratitude practice.
                            The interesting thing about gratitude, is the more you practice gratitude the more grateful you become.
                        </p>
                    </div>
                    
                    <div class="sample-container sample-2" data-target="2">
                        <div>
                            <h3>Ripples to Waves</h3>
                            <h6>- Sample 2 -</h6>
                        </div>
                        <img src="{{asset('assets/images/gratitude-2.png')}}" />
                        <p>
                            We moved to London in the summer of 2016. Our new apartment was still
                            littered with boxes and half-unpacked luggage when my wife discovered a
                            lump in her breast. My wife was 32—young, healthy, and with no family history of
                            the disease—when she was diagnosed with breast cancer.
                        </p>
                        <p>
                            For Sue, cancer became her strength. She kept a journal the whole time she
                            was sick. Every morning, she would make a list of everything she was
                            grateful for. Every night, she would read through what she wrote. It
                            inspired her enough to write a book that will be published this year.
                        </p>
                        <p class="text-right">Gratefully <br />Raj Goodman Anand</p>
                    </div>
                    
                    <div class="gratitude-change">
                        <a href="#" data-sample="1" class="active"></a>
                        <a href="#" data-sample="2"></a>
                    </div>
                </div>
                
                <!-- Recording Interface -->
                <div class="recording-interface">
                    <div class="recording-header">
                        <div>
                            <h4 style="margin: 0 0 5px 0;">Record Audio</h4>
                            <p style="margin: 0; color: #666; font-size: 14px;">Record your voice or type your gratitude prompt below</p>
                        </div>
                        <div class="recording-timer">
                            <div class="recording-indicator" id="recordingIndicator"></div>
                            <span id="timer2">00:00:00</span>
                        </div>
                    </div>
                    
                    <!-- Real-time Speech Display -->
                  
                    <div class="mt-2" id="realtimeDisplay style="padding: 8px; background-color: aliceblue; min-height: 16px">
                        <span id="realTimeTranscription" style="display: inline-block"></span>
                    </div>
                    <div class="editor-container">
                        <div id="editor2">
                            <?php if (isset($user->gratitude) && $user->gratitude != null) { echo $user->gratitude; } ?>
                        </div>
                    </div>
                    
                    <!-- Recording Controls at Bottom -->
                    <div class="recording-controls">
                        <button id="startBtn2" data-sr_no="2" data-editor_name="editor2" class="btn-success startBtn">
                            🎤 Start Recording
                        </button>
                        <button id="stopBtn2" data-sr_no="2" class="btn-danger stopBtn" style="display: none">
                            ⏹️ Stop Recording
                        </button>
                        <button id="resetBtn2" data-sr_no="2" class="btn-danger resetBtn" style="display: none">
                            🗑️ Reset Text
                        </button>
                    </div>
                </div>
                
                <!-- Generate Story Button -->
                <div class="generate-button-container">
                    <button id="generateStoryBtn" class="btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="btn-text">Generate Your Story</span>
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize CKEditor 5
        ClassicEditor
            .create(document.querySelector('#editor2'), {
                height: '200px',
                removePlugins: ['ElementPath']
            })
            .then(editor => {
                window.editor2 = editor;
            })
            .catch(error => {
                console.error(error);
            });

        // Simple loader
        $('<div id="storyLoader" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);"><div>Generating your story...</div></div>').insertAfter('body');

        // SweetAlert notification system
        window.showNotification = function(message, type = 'info', duration = 5000) {
            let icon = 'info';
            let confirmButtonColor = '#007bff';
            
            switch(type) {
                case 'success':
                    icon = 'success';
                    confirmButtonColor = '#28a745';
                    break;
                case 'error':
                    icon = 'error';
                    confirmButtonColor = '#dc3545';
                    break;
                case 'warning':
                    icon = 'warning';
                    confirmButtonColor = '#ffc107';
                    break;
                case 'info':
                default:
                    icon = 'info';
                    confirmButtonColor = '#17a2b8';
                    break;
            }
            
            Swal.fire({
                title: message,
                icon: icon,
                confirmButtonColor: confirmButtonColor,
                confirmButtonText: 'OK',
                timer: duration,
                timerProgressBar: true,
                showConfirmButton: duration > 0 ? false : true,
                toast: true,
                position: 'top-end',
                showCloseButton: true,
                customClass: {
                    container: 'swal-container'
                }
            });
        }
        
        // Simple button loading state
        window.setButtonLoading = function(button, loading = true) {
            if (loading) {
                button.text('Loading...').prop('disabled', true);
            } else {
                button.text('Generate Your Story').prop('disabled', false);
            }
        }
        
        // Sample story switcher
        let gratBtns = document.querySelectorAll(".gratitude-change > a");
        let samples = document.querySelectorAll(".sample-container");
        gratBtns.forEach((btn) => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                gratBtns.forEach((btn) => {
                    btn.classList.remove("active");
                });
                btn.classList.add("active");
                samples.forEach((sample) => {
                    sample.classList.remove("active");
                    if (sample.getAttribute("data-target") === btn.getAttribute("data-sample")) {
                        sample.classList.add("active");
                    }
                })
            })
        });
        
        // Submit gratitude content
        $(document).on("click", "#generateStoryBtn", function() {
            var gratitudeContent = window.editor2.getData();
            var $btn = $(this);
            
            if (!gratitudeContent.trim()) {
                showNotification('⚠️ Please write or record your gratitude prompt first.', 'warning');
                return;
            }
            
            // Simple loading state
            setButtonLoading($btn, true);
            $('#storyLoader').show();
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ route('updateGratitude') }}`,
                type: "POST",
                data: {
                    gratitude: gratitudeContent
                },
                cache: false,
                success: function(dataResult) {
                    $('#storyLoader').hide();
                    setButtonLoading($btn, false);
                    
                    if (dataResult.success) {
                        // Update the story container
                        $('#storyTitle').text(dataResult.story.title);
                        $('#storyBadge').text('Personal Story');
                        $('#storyContent').html(dataResult.story.content);
                        
                        // Scroll to top to show the generated story
                        $('.content-area').scrollTop(0);
                        
                        // Show database success popup
                        Swal.fire({
                            title: '🎉 Success!',
                            html: `
                                <div style="text-align: center; padding: 20px;">
                                    <h3 style="color: #28a745; margin-bottom: 15px;">Your gratitude story has been created!</h3>
                                    <p style="margin-bottom: 15px;">✅ Story generated successfully</p>
                                    <p style="margin-bottom: 15px;">💾 Data saved to database</p>
                                    <p style="color: #666; font-size: 14px;">Your personalized gratitude story is now ready and has been securely stored.</p>
                                </div>
                            `,
                            icon: 'success',
                            confirmButtonText: 'Awesome! 🎉',
                            confirmButtonColor: '#28a745',
                            showCloseButton: true,
                            allowOutsideClick: false,
                            customClass: {
                                popup: 'swal-wide',
                                title: 'swal-title'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Optional: Additional actions after user acknowledges
                                showNotification('🎉 Your personalized gratitude story has been created successfully!', 'success', 3000);
                            }
                        });
                    } else {
                        showNotification('❌ ' + (dataResult.message || 'Failed to generate story. Please try again.'), 'error');
                    }
                },
                error: function(xhr, status, error) {
                    $('#storyLoader').hide();
                    setButtonLoading($btn, false);
                    showNotification('❌ An error occurred while generating your story. Please try again.', 'error');
                }
            });
        });
    });

    // Speech Recognition Setup
    let recognition;
    let editorName = 'editor2';
    let startBtn, stopBtn, resetBtn;

    // Create a new instance of SpeechRecognition
    if (window.SpeechRecognition || window.webkitSpeechRecognition) {
        recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
    } else {
        console.log('Speech recognition not supported');
    }

    // Set recognition properties
    recognition.continuous = true;
    recognition.interimResults = true;
    recognition.lang = 'en-US';

    let realtimeTranscript = '';
    let autoTransferTimeout;
    
    recognition.onresult = function(event) {
        let finalTranscript = '';
        let interimTranscript = '';

        for (let i = event.resultIndex; i < event.results.length; i++) {
            const result = event.results[i];
            if (result.isFinal) {
                finalTranscript += result[0].transcript.trim() + ' ';
            } else {
                interimTranscript += result[0].transcript;
            }
        }
        
        // Update real-time display with current transcript
        if (finalTranscript) {
            // Add final text to our accumulator
            realtimeTranscript += finalTranscript;
            
            // Auto-transfer after 2 seconds of silence
            clearTimeout(autoTransferTimeout);
            autoTransferTimeout = setTimeout(() => {
                if (realtimeTranscript.trim()) {
                    transferToEditor();
                }
            }, 2000);
        }
        
        // Display current text in real-time display (final + interim)
        const realtimeDisplay = document.getElementById('realTimeTranscription');
        if (realtimeDisplay) {
            const currentText = realtimeTranscript + interimTranscript;
            if (currentText.trim()) {
                realtimeDisplay.textContent = currentText;
                // Auto-scroll to bottom
                realtimeDisplay.scrollTop = realtimeDisplay.scrollHeight;
            } else {
                realtimeDisplay.textContent = '';
            }
        }
        
        // Reset auto-transfer timer if still speaking (interim results)
        if (interimTranscript.trim()) {
            clearTimeout(autoTransferTimeout);
        }
    };
    
    // Function to transfer text to editor and clear display
    function transferToEditor() {
        if (realtimeTranscript.trim()) {
            const editor = window.editor2;
            editor.model.change(writer => {
                const root = editor.model.document.getRoot();
                const endPosition = writer.createPositionAt(root, 'end');
                writer.insertText(realtimeTranscript, endPosition);
            });

            // Scroll to bottom after inserting
            setTimeout(() => {
                const view = editor.editing.view;
                view.scrollToTheSelection();
            }, 50);
            
            // Clear the real-time display and reset transcript
            realtimeTranscript = '';
            const realtimeDisplay = document.getElementById('realTimeTranscription');
            if (realtimeDisplay) {
                realtimeDisplay.textContent = '';
            }
            
            // Show notification
            // showNotification('📝 Text transferred to editor', 'success', 2000);
        }
    }

    let isRecognitionActive = false;
    let shouldRestart = false;

    // Handle error event
    recognition.onerror = function(event) {
        console.log('Error occurred in recognition: ' + event.error);
    };

    // Handle end event
    recognition.onend = function() {
        console.log('Recognition ended');
        if (isRecognitionActive && shouldRestart) {
            setTimeout(() => {
                try {
                    recognition.start();
                    console.log('Recognition restarted automatically');
                } catch (e) {
                    console.log('Could not restart recognition:', e);
                }
            }, 500);
        } else {
            startBtn.style.display = 'inline-block';
            resetBtn.style.display = 'inline-block';
            stopBtn.style.display = 'none';
            isRecognitionActive = false;
        }
    };

    // Start button
    $('.startBtn').click(function() {
        let sr_id = $(this).attr('data-sr_no');
        startBtn = document.getElementById('startBtn' + sr_id);
        stopBtn = document.getElementById('stopBtn' + sr_id);
        resetBtn = document.getElementById('resetBtn' + sr_id);
        
        isRecognitionActive = true;
        shouldRestart = true;
        
        // Reset real-time transcript and clear any pending auto-transfer
        realtimeTranscript = '';
        clearTimeout(autoTransferTimeout);
        
        // Clear real-time display
        document.getElementById('realTimeTranscription').textContent = '';
        
        startTimer(sr_id);
        $("#recordingIndicator").addClass('active');
        
        try {
            recognition.start();
            console.log('Recognition started');
            
            startBtn.style.display = 'none';
            stopBtn.style.display = 'inline-block';
            resetBtn.style.display = 'none';
            
            showNotification('🎤 Recording started. Speak clearly into your microphone.', 'info', 3000);
        } catch (e) {
            console.log('Error starting recognition:', e);
            isRecognitionActive = false;
            shouldRestart = false;
            $("#recordingIndicator").removeClass('active');
            // Clear real-time display on error
            document.getElementById('realTimeTranscription').textContent = '';
            showNotification('❌ Could not start recording. Please check your microphone permissions.', 'error');
        }
    });

    // Stop button
    $('.stopBtn').click(function() {
        let sr_id = $(this).attr('data-sr_no');
        startBtn = document.getElementById('startBtn' + sr_id);
        stopBtn = document.getElementById('stopBtn' + sr_id);
        resetBtn = document.getElementById('resetBtn' + sr_id);
        
        isRecognitionActive = false;
        shouldRestart = false;
        
        stopTimer();
        $("#recordingIndicator").removeClass('active');
        recognition.stop();
        console.log('Recognition stopped');
        
        // Clear any pending auto-transfer
        clearTimeout(autoTransferTimeout);
        
        // Transfer any remaining real-time text to editor
        if (realtimeTranscript.trim()) {
            transferToEditor();
        }
        
        // Clear real-time display
        document.getElementById('realTimeTranscription').textContent = '';
        
        stopBtn.style.display = 'none';
        startBtn.style.display = 'inline-block';
        resetBtn.style.display = 'inline-block';
        
        showNotification('✅ Recording stopped. Your speech has been converted to text.', 'success', 3000);
    });

    // Reset button
    $('.resetBtn').click(function() {
        let sr_id = $(this).attr('data-sr_no');
        startBtn = document.getElementById('startBtn' + sr_id);
        stopBtn = document.getElementById('stopBtn' + sr_id);
        resetBtn = document.getElementById('resetBtn' + sr_id);
        
        Swal.fire({
            title: 'Reset Text Content?',
            text: 'This will permanently delete all text in the editor. This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, reset it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                resetTimer(sr_id);
                const editor = window.editor2;
                editor.setData('');
                recognition.stop();
                console.log('Recognition stopped');
                
                resetBtn.style.display = 'none';
                
                showNotification('🗑️ Text content has been reset successfully.', 'success', 3000);
            }
        });
    });

    // Timer functions
    var startTime = 0;
    var elapsedTime = 0;
    var timerInterval;

    function startTimer(id) {
        if (elapsedTime === 0) {
            startTime = new Date().getTime();
        } else {
            startTime = new Date().getTime() - elapsedTime;
        }
        timerInterval = setInterval(function() {
            updateTimer(id);
        }, 1000);
    }

    function stopTimer() {
        clearInterval(timerInterval);
        elapsedTime = new Date().getTime() - startTime;
    }

    function resetTimer(id) {
        clearInterval(timerInterval);
        elapsedTime = 0;
        document.getElementById('timer' + id).innerHTML = '00:00:00';
    }

    function updateTimer(id) {
        var elapsedTime = new Date().getTime() - startTime;
        var seconds = Math.floor(elapsedTime / 1000) % 60;
        var minutes = Math.floor(elapsedTime / (1000 * 60)) % 60;
        var hours = Math.floor(elapsedTime / (1000 * 60 * 60)) % 24;
        document.getElementById('timer' + id).innerHTML = formatTime(hours) + ':' + formatTime(minutes) + ':' + formatTime(seconds);
    }

    function formatTime(time) {
        return (time < 10 ? '0' : '') + time;
    }

    // User Dropdown Toggle Function
    function toggleUserDropdown(event) {
        event.preventDefault();
        event.stopPropagation();
        
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('open');
    }

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });

    // Keyboard shortcuts
    $(document).keydown(function(e) {
        // Alt + R to start/stop recording
        if (e.altKey && e.which === 82) {
            e.preventDefault();
            if (isRecognitionActive) {
                $('.stopBtn:visible').click();
            } else {
                $('.startBtn:visible').click();
            }
        }
        
        // Alt + G to generate story
        if (e.altKey && e.which === 71) {
            e.preventDefault();
            $('#generateStoryBtn').click();
        }
    });
</script>
@endsection