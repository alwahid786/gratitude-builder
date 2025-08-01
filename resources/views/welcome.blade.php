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
        position: relative;
    }

    /* Header Progress Bar Styles */
    .header-progress-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        max-width: 500px;
        margin: 0 40px;
    }

    .progress-title-section {
        text-align: center;
        margin-bottom: 10px;
    }

    .progress-title-section h3 {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin: 0 0 5px 0;
    }

    .progress-title-section p {
        font-size: 14px;
        color: #666;
        margin: 0;
    }

    .header-progress-bar {
        width: 100%;
        position: relative;
        display: flex;
        align-items: center;
    }

    .progress-bar-track {
        width: 100%;
        height: 8px;
        background: #e9ecef;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #830F35 0%, #6B0D2B 100%);
        border-radius: 20px;
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        width: 33.33%;
    }

    .progress-indicator {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 20px;
        background: #830F35;
        border-radius: 2px;
        transition: right 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .logo {
        font-size: 1.2rem;
        font-weight: 600;
        color: #902042;
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
        background: #902042;
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
    body,
    html {
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
        background: #902042;
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
        background: #902042;
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
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }

    .recording-controls {
        display: flex;
        align-items: center;
        gap:15px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #e0e0e0;
    }

    /* Real-time Speech Display */
    .realtime-speech-display {
        background: #fff;
        border: 2px solid #902042;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        background: #902042;
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
        background: #7a1c36;
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
        gap: 20px;
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

    /* Multi-step Navigation Styles */
    .step-content {
        display: none;
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .step-content.active {
        display: block;
        opacity: 1;
        transform: translateX(0);
    }

    .step-content.slide-out-left {
        transform: translateX(-30px);
        opacity: 0;
    }

    .step-content.slide-in-right {
        transform: translateX(30px);
        opacity: 0;
    }



    /* Welcome Page Styles */
    .welcome-intro {
        text-align: center;
        /* max-width: 800px; */
        margin: 0 auto;
        padding: 40px 20px;
    }

    .intro-content p {
        font-size: 18px;
        color: #666;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    .journey-steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .step-item {
        background: #f8f9fa;
        padding: 30px 20px;
        border-radius: 12px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .step-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: #830F35;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 600;
        margin: 0 auto 15px;
    }

    .step-item h4 {
        color: #333;
        margin-bottom: 10px;
        font-size: 18px;
    }

    .step-item p {
        color: #666;
        font-size: 14px;
        margin: 0;
        line-height: 1.5;
    }

    /* Goals Page Styles */
    .goals-section {
        max-width: 700px;
        margin: 0 auto;
        padding: 20px;
    }

    .goals-content p {
        font-size: 16px;
        color: #666;
        text-align: center;
        margin-bottom: 40px;
    }

    .goal-group {
        margin-bottom: 40px;
    }

    .goal-group h4 {
        color: #333;
        margin-bottom: 20px;
        font-size: 18px;
    }

    .gratitude-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .option-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .option-card:hover {
        border-color: #830F35;
        background: #fdf2f2;
    }

    .option-card input[type="checkbox"] {
        display: none;
    }

    .option-card input[type="checkbox"]:checked + .checkmark {
        transform: scale(1.2);
    }

    .option-card input[type="checkbox"]:checked ~ .option-text {
        color: #830F35;
        font-weight: 600;
    }

    .option-card:has(input:checked) {
        border-color: #830F35;
        background: #fdf2f2;
    }

    .checkmark {
        font-size: 30px;
        margin-bottom: 10px;
        transition: transform 0.3s ease;
    }

    .option-text {
        font-size: 14px;
        color: #333;
        transition: all 0.3s ease;
    }

    .frequency-options {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .radio-option:hover {
        border-color: #830F35;
        background: #fdf2f2;
    }

    .radio-option input[type="radio"] {
        display: none;
    }

    .radio-custom {
        width: 16px;
        height: 16px;
        border: 2px solid #ccc;
        border-radius: 50%;
        position: relative;
        transition: all 0.3s ease;
    }

    .radio-option input[type="radio"]:checked + .radio-custom {
        border-color: #830F35;
        background: #830F35;
    }

    .radio-option input[type="radio"]:checked + .radio-custom::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 6px;
        height: 6px;
        background: white;
        border-radius: 50%;
    }

    .radio-option:has(input:checked) {
        border-color: #830F35;
        background: #fdf2f2;
        color: #830F35;
        font-weight: 500;
    }

    /* Button Styles */
    .step-actions {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 40px;
    }

    .btn-secondary {
        background: #6c757d;
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
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    /* Story Telling Section Styles */
    .story-telling-section {
        /* max-width: 900px; */
        margin: 0 auto;
        padding: 20px;
    }

    .story-telling-section h2 {
        color: #333;
        margin-bottom: 10px;
        font-size: 2rem;
    }

    .story-telling-section h5 {
        color: #830F35;
        margin-bottom: 30px;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .boxes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .inner-box {
        display: flex;
        align-items: center;
        border: 1px solid rgba(184, 201, 206, 0.5);
        box-shadow: 0px 0px 12px rgba(152, 177, 201, 0.12);
        border-radius: 12px;
        padding: 20px 15px;
        gap: 15px;
        background: #fff;
        transition: all 0.3s ease;
    }

    .inner-box:hover {
        transform: translateY(-3px);
        box-shadow: 0px 5px 20px rgba(131, 15, 53, 0.15);
        border-color: #830F35;
    }

    .inner-box img {
        width: 98px;
        height: 98px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .inner-box h5 {
        font-size: 18px;
        color: #333;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .inner-box p {
        font-size: 14px;
        color: #666;
        margin: 0;
        line-height: 1.5;
    }

    .story-example {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        border-left: 4px solid #830F35;
    }

    .story-example h5 {
        color: #830F35;
        margin-bottom: 15px;
        font-size: 1.3rem;
        font-weight: 600;
    }

    .story-example p {
        color: #555;
        line-height: 1.7;
        font-size: 15px;
        margin: 0;
    }

    .heros-journey {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0px 0px 12px rgba(152, 177, 201, 0.12);
        border: 1px solid #e9ecef;
    }

    .heros-journey h5 {
        color: #830F35;
        margin-bottom: 20px;
        font-size: 1.3rem;
        font-weight: 600;
    }

    .journey-section {
        margin-top: 20px;
        display: flex;
        gap: 20px;
        align-items: stretch;
    }

    .journey-section div:first-child {
        width: 60%;
        background: url("{{ asset('assets/images/story-tell-journey.png') }}") no-repeat center center;
        /* background: linear-gradient(135deg, #830F35 0%, #6B0D2B 100%); */
        border-radius: 8px;
        background-size: cover;
        min-height: 200px;
    }

    .journey-section p {
        color: #555;
        line-height: 1.6;
        font-size: 14px;
        margin: 0;
    }

    .journey-section b {
        color: #830F35;
        font-weight: 600;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .journey-steps {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .gratitude-options {
            grid-template-columns: 1fr;
        }
        
        .frequency-options {
            flex-direction: column;
            align-items: stretch;
        }
        
        .step-progress {
            bottom: 20px;
            padding: 12px 20px;
            gap: 15px;
        }
        
        .step-circle {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }
        
        .progress-step span {
            font-size: 11px;
        }

        .boxes {
            grid-template-columns: 1fr;
        }

        .inner-box {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .inner-box img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        .journey-section {
            flex-direction: column;
            gap: 15px;
        }

        .journey-section div:first-child {
            width: 100%;
            min-height: 150px;
        }

        .story-telling-section {
            padding: 15px;
        }

        .story-example {
            padding: 20px;
        }

        .heros-journey {
            padding: 20px;
        }
    }

    @media (max-width: 600px) {
        .journey-section div:first-child {
            display: none;
        }
    }

    /* Header Progress Responsive */
    @media (max-width: 768px) {
        .header-progress-section {
            margin: 0 20px;
            max-width: 400px;
        }
        
        .progress-title-section h3 {
            font-size: 18px;
        }
        
        .progress-title-section p {
            font-size: 12px;
        }
        
        .user-header {
            flex-direction: column;
            gap: 15px;
            padding: 15px;
        }
    }

    @media (max-width: 480px) {
        .header-progress-section {
            margin: 0 10px;
            max-width: 300px;
        }
        
        .progress-title-section h3 {
            font-size: 16px;
        }
        
        .progress-title-section p {
            font-size: 11px;
        }
    }
</style>

<section class="main-container">
    <div class="container-wrapper">
        <div class="content-area">
            <!-- User Header with Dropdown -->
            <div class="user-header">
                <span class="logo">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="Gratitude Builder Logo"
                        style="vertical-align: middle;">
                </span>

                <!-- Progress Bar Section -->
                <div class="header-progress-section">
                    <div class="progress-title-section">
                        <h3 id="progress-title">Story Telling</h3>
                        <p id="progress-subtitle">Tips of Powerful Storytelling</p>
                    </div>
                    <div class="header-progress-bar">
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill" id="headerProgressFill"></div>
                        </div>
                        <div class="progress-indicator" id="progressIndicator"></div>
                    </div>
                </div>

                <div class="user-dropdown" id="userDropdown">
                    <a href="#" class="user-dropdown-toggle" onclick="toggleUserDropdown(event)">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span>{{ Auth::user()->name ?? 'User' }}</span>
                        <span class="dropdown-arrow">▼</span>
                    </a>

                    <div class="user-dropdown-menu">
                        @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item" o>
                            <i class="fa fa-user"></i> Admin Dashboard
                        </a>
                        @endif
                            {{-- <a href="#" class="dropdown-item" onclick="toggleUserDropdown(event)">
                                <i class="fa fa-lock"></i> Change Password
                                </a> --}}
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item logout-item"
                                style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Body -->
            <div class="content-body">
                <!-- Step 1: Welcome Page -->
                <div class="step-content active" id="step1">
                    <div class="welcome-intro">
                        <div class="col-12">
                            <img src="{{asset('assets/images/story-telling.png')}}" alt="" style="height: 50%; width: 100%; border-radius: 12px; margin-bottom: 20px;" />
                        </div>
                        <div class="col-12">
                            <div class="text-center mt-2">
                                <h2>Welcome to 3X Author &amp; Your Book Builder tool</h2>
                                <p class="my-2">
                                    Your Book Builder simplifies and speeds up the process of
                                    writing your book. In addition to making it easy to get your
                                    book to paper (or screen – LOL). The tool will help you track
                                    your progress toward the finish line.
                                </p>
                                <p>
                                    The biggest challenge about getting a book out of your head or
                                    heart and on to paper is your own brain. Most people overthink
                                    the process. Some overthinkers suffer from paralysis of
                                    analysis. Somewhere between starting and finishing their book,
                                    they reach a point where they just freeze. It took me a year to
                                    write my first book and it's a 60-page book. I'll write a
                                    brand-new book alongside you and share my progress during the
                                    project.
                                </p>
                                <p>
                                    Remember, getting to the finish line is as easy as you think it
                                    is. Henry Ford said "Whether you think you can, or you think you
                                    can't – you're right." That quote is certainly true about
                                    writing a book. You'll probably be amazed at the changes in your
                                    attitude, business, and life you'll see as an Author.
                                </p>
                                <p>Nothing builds Authority like being an Author.</p>
                                <p>
                                    Thank you for allowing me to help you on this journey, I'm
                                    grateful.
                                </p>
                            </div>
                        </div>
                        
                        <div class="step-actions">
                            <button class="btn-primary" onclick="nextStep()">
                                Get Started ✨
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Story Telling -->
                <div class="step-content" id="step2">
                    <div class="story-telling-section">
                        <div>
                            <h2 class="text-center">Story Telling</h2>
                            <h5>Tips of Powerful Storytelling</h5>
                        </div>
                        <div class="boxes">
                            <div class="inner-box">
                                <img src="{{asset('assets/images/story-tell-1.png')}}" alt="" />
                                <div>
                                    <h5>Speak to One Person</h5>
                                    <p>
                                        Imagine you're sharing your story with a close friend. This makes it
                                        personal and relatable.
                                    </p>
                                </div>
                            </div>
                            <div class="inner-box">
                                <img src="{{asset('assets/images/story-tell-2.png')}}" alt="" />
                                <div>
                                    <h5>Keep It Chronological</h5>
                                    <p>
                                        A clear beginning, middle, and end help your audience follow along
                                        effortlessly.
                                    </p>
                                </div>
                            </div>
                            <div class="inner-box">
                                <img src="{{asset('assets/images/story-tell-3.png')}}" alt="" />
                                <div>
                                    <h5>Speak from the Heart</h5>
                                    <p>
                                        Authenticity connects deeply. Share your emotions and experiences
                                        genuinely.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="story-example">
                            <h5>Cinderella</h5>
                            <p>
                                Cinderella was a beautiful and kind-hearted girl who lived with her
                                wicked stepmother and stepsisters. They made her do all the household
                                chores and treated her poorly. <br />
                                <br />
                                One day, the prince of the kingdom announced a grand ball, and all the
                                eligible maidens were invited. Cinderella wanted to go, but her
                                stepmother forbade her from attending.
                                <br />
                                <br />
                                With the help of her fairy godmother, Cinderella got a beautiful dress,
                                glass slippers, and a carriage. She went to the ball and danced with the
                                prince, but had to leave before midnight, leaving behind one glass
                                slipper.
                                <br />
                                <br />
                                The prince searched the kingdom for the owner of the slipper and finally
                                found Cinderella. He recognized her beauty and kindness, and they lived
                                happily ever after.
                                <br />
                                <br />
                                The original Cinderella Story was titled "Cendrillon ou La petite
                                pantoufle de verre" and written by Charles Perrault in the late 17th
                                century.
                            </p>
                        </div>
                        
                        <div class="heros-journey">
                            <h5>Tell Your Story like the Hero's Journey</h5>
                            <div class="journey-section">
                                <div></div>
                                <p>
                                    <b>The Call to Adventure</b> - The hero receives a call to action or
                                    adventure, which sets them on a journey.<br /><br />
                                    <b>Refusal of the Call</b> - The hero may initially refuse the call,
                                    often due to fear or self-doubt.<br /><br />
                                    <b>Acceptance of the Call</b> - The hero eventually accepts the call
                                    to adventure and begins their journey.<br /><br />
                                    <b>Meeting the Mentor</b> - The hero meets a mentor who provides
                                    guidance and assistance on their journey.<br /><br />
                                    <b>Crossing the Threshold</b> - The hero crosses a threshold into the
                                    unknown or unfamiliar world of their adventure.<br /><br />
                                    <b>Trials and Challenges</b> - The hero faces various trials and
                                    challenges that test their skills, abilities, and resolve.<br /><br />
                                    <b>The Approach</b> - The hero approaches their ultimate goal, facing
                                    greater obstacles and challenges.<br /><br />
                                    <b>The Ordeal</b> - The hero faces their greatest challenge or ordeal,
                                    often a life or death situation.<br /><br />
                                    <b>The Reward</b> - The hero emerges from their ordeal with a reward,
                                    such as knowledge, a magical object, or a sense of self-discovery.<br /><br />
                                    <b>The Road Back</b> - The hero begins their journey back to their
                                    ordinary world, often facing new challenges.<br /><br />
                                    <b>The Resurrection</b> - The hero faces a final challenge, often a
                                    battle or confrontation, that tests their growth and
                                    transformation.<br /><br />
                                    <b>The Return</b> - The hero returns to their ordinary world, using
                                    their new knowledge and abilities to help others or make positive
                                    changes in their world.<br /><br />
                                </p>
                            </div>
                        </div>
                        
                        <div class="step-actions">
                            <button class="btn-secondary" onclick="prevStep()">
                                ← Back
                            </button>
                            <button class="btn-primary" onclick="nextStep()">
                                Continue →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Create Gratitude Story -->
                <div class="step-content" id="step3">
                    <div class="gratitude-section">
                        <h2>Create Your Gratitude Story</h2>

                    <!-- Story Container -->
                    <div class="story-container" id="mainStoryContainer">
                        <div class="story-header">
                            <h3 class="story-title" id="storyTitle">{{ $gratitudeStory['title'] }}</h3>
                            <div class="story-badge" id="storyBadge">Default Story</div>
                        </div>
                        <div class="story-content" id="storyContent">
                            {!! $gratitudeStory['content'] !!}
                        </div>
                    </div>

               

                    <!-- Recording Interface -->
                    <div class="recording-interface">
                        <div class="recording-header">
                            <div>
                                <h4 style="margin: 0 0 5px 0;">Record Audio</h4>
                                <p style="margin: 0; color: #666; font-size: 14px;">Record your voice or type your
                                    gratitude prompt below</p>
                            </div>
                            <div class="recording-timer">
                                <div class="recording-indicator" id="recordingIndicator"></div>
                                <span id="timer2">00:00:00</span>
                            </div>
                        </div>

                        <!-- Real-time Speech Display -->

                        <div class="mt-2" id="realtimeDisplay style=" padding: 8px; background-color: aliceblue;
                            min-height: 16px">
                            <span id="realTimeTranscription" style="display: inline-block"></span>
                        </div>
                        <div class="editor-container">
                            <div id="editor2">
                               
                            </div>
                        </div>

                        <!-- Recording Controls at Bottom -->
                        <div class="recording-controls">
                            <button id="startBtn2" data-sr_no="2" data-editor_name="editor2"
                                class="btn-success startBtn">
                                🎤 Start Recording
                            </button>
                            <button id="stopBtn2" data-sr_no="2" class="btn-danger stopBtn" style="display: none">
                                ⏹️ Stop Recording
                            </button>
                            <button id="resetBtn2" data-sr_no="2" class="btn-danger resetBtn" style="display: none">
                                🗑️ Reset Text
                            </button>
                            <button id="reviewWithAi" type="button" style="background-color: #830F35" class="btn-primary">
                                🤖 Review with AI
                            </button>
                        </div>
                    </div>

                    <!-- Generate Story Button -->
                    <div class="generate-button-container">
                        <button id="generateStoryBtn" class="btn-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="btn-text">Generate Your Story</span>
                        </button>
                        @if(Auth::user()->role == 'admin')

                            <a href="{{route('admin.stories.export-pdf')}}" class="btn-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="btn-text">Generate Your PDF</span>
                        </a>
                    @endif
                            </div>
                            
                            <div class="step-actions">
                                <button class="btn-secondary" onclick="prevStep()">
                                    ← Back
                                </button>
                            </div>
                        </div>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
        // SweetAlert notification system
        window.showNotification = function(message, type = 'info', duration = 5000) {
            let icon = 'info';
            let confirmButtonColor = '#902042';
            
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
                    confirmButtonColor = '#902042';
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
            
            // Get current content
            const currentContent = editor.getData();
            
            // Append new text with a space if there's existing content
            const newContent = currentContent ? currentContent + ' ' + realtimeTranscript : realtimeTranscript;
            
            // Set the data instead of using model.change for better editing capability
            editor.setData(newContent);
            
            // Focus the editor to enable editing
            setTimeout(() => {
                editor.editing.view.focus();
                // Move cursor to end
                const viewDocument = editor.editing.view.document;
                const root = viewDocument.getRoot();
                const range = editor.editing.view.createRangeIn(root);
                const walker = range.getWalker({ ignoreElementEnd: true });
                let lastPosition;
                for (const item of walker) {
                    lastPosition = item.nextPosition;
                }
                if (lastPosition) {
                    editor.editing.view.document.selection.setTo(lastPosition);
                }
            }, 100);
            
            // Clear the real-time display and reset transcript
            realtimeTranscript = '';
            const realtimeDisplay = document.getElementById('realTimeTranscription');
            if (realtimeDisplay) {
                realtimeDisplay.textContent = '';
            }
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

    // Multi-step Navigation Functions
    let currentStep = 1;
    const totalSteps = 3;

    function nextStep() {
        if (currentStep < totalSteps) {
            // Validate current step before proceeding
            if (validateCurrentStep()) {
                transitionToStep(currentStep + 1);
            }
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            transitionToStep(currentStep - 1);
        }
    }

    function goToStep(step) {
        if (step >= 1 && step <= totalSteps && step !== currentStep) {
            transitionToStep(step);
        }
    }

    function transitionToStep(targetStep) {
        const currentStepElement = document.getElementById(`step${currentStep}`);
        const targetStepElement = document.getElementById(`step${targetStep}`);

        // Animate transition
        currentStepElement.style.opacity = '0';
        currentStepElement.style.transform = targetStep > currentStep ? 'translateX(-30px)' : 'translateX(30px)';
        
        setTimeout(() => {
            currentStepElement.classList.remove('active');
            targetStepElement.classList.add('active');
            
            // Reset and animate in new step
            targetStepElement.style.transform = targetStep > currentStep ? 'translateX(30px)' : 'translateX(-30px)';
            targetStepElement.style.opacity = '0';
            
            setTimeout(() => {
                targetStepElement.style.opacity = '1';
                targetStepElement.style.transform = 'translateX(0)';
            }, 50);
        }, 200);

        currentStep = targetStep;

        // Scroll to top
        $('.content-area').scrollTop(0);

        // Update header progress bar
        updateHeaderProgress();
    }

    function validateCurrentStep() {
        switch (currentStep) {
            case 1:
                // No validation needed for welcome step
                return true;
            case 2:
                // No validation needed for story tips step
                return true;
            case 3:
                // No validation needed - user can create story at their own pace
                return true;
            default:
                return true;
        }
    }

    // Update header progress bar
    function updateHeaderProgress() {
        const progressFill = document.getElementById('headerProgressFill');
        const progressIndicator = document.getElementById('progressIndicator');
        const progressTitle = document.getElementById('progress-title');
        const progressSubtitle = document.getElementById('progress-subtitle');
        
        const stepInfo = {
            1: {
                title: "Welcome",
                subtitle: "3X Author & Your Book Builder tool",
                progress: 33.33
            },
            2: {
                title: "Story Telling",
                subtitle: "Tips of Powerful Storytelling",
                progress: 66.66
            },
            3: {
                title: "Create Story",
                subtitle: "Record or write your gratitude story",
                progress: 100
            }
        };
        
        const info = stepInfo[currentStep];
        if (info) {
            progressTitle.textContent = info.title;
            progressSubtitle.textContent = info.subtitle;
            progressFill.style.width = info.progress + '%';
            
            // Update indicator position
            const trackWidth = progressFill.parentElement.offsetWidth;
            const indicatorPosition = (trackWidth * info.progress / 100) - 2; // -2 for half indicator width
            progressIndicator.style.right = `${trackWidth - indicatorPosition}px`;
        }
    }

    // Initialize the multi-step functionality
    $(document).ready(function() {
        // Make sure the first step is visible on page load
        $('#step1').addClass('active');
        
        // Initialize progress bar
        updateHeaderProgress();
        
        console.log('Multi-step navigation initialized');
    });
</script>
<script>
    // Review With AI button handler
        $('#reviewWithAi').click(function() {
            // Get content from CKEditor
            let editorMessage = window.editor2.getData().trim();
            editorMessage = editorMessage.replace(/<\/?[^>]+(>|$)/g, '');

            // Word count check
            const wordCount = editorMessage.split(/\s+/).length;
            const maxWords = {{ $input_limit }};

            if (editorMessage === "" || wordCount > maxWords) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: `Please select max ${@json($input_limit)} words to AI Wizard .`,
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true
                });
                return;
            }

            // Show loading alert
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while AI reviews your content.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Post to chatgpt-response route
            axios.post(`{{ route('chatgpt-response') }}`, {
                    message: editorMessage,
                    page: "Content",
                    rule: "review"
                })
                .then(response => {
                    Swal.close();
                    console.log('AI Response:', response.data.response);
                    
                    // Show response in SweetAlert modal instead of Bootstrap modal
                    Swal.fire({
                        title: 'AI Review Results',
                        html: `
                            <div style="text-align: left; margin-bottom: 20px;">
                                <div id="modalResponse" style="min-height: 200px; max-height: 400px; overflow-y: auto; padding: 15px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; font-family: inherit; line-height: 1.6; white-space: pre-wrap;">${response.data.response}</div>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: '✅ Replace Content',
                        cancelButtonText: '❌ Cancel',
                        confirmButtonColor: '#830F35',
                        cancelButtonColor: '#6c757d',
                        width: '600px',
                        customClass: {
                            popup: 'swal-wide'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const newText = response.data.response;
                            replaceSelectedText(newText);
                            showNotification('✅ Content has been replaced successfully!', 'success', 3000);
                        }
                    });
                })
                .catch(error => {
                    Swal.close();
                        let message = 'Something went wrong. Please try again.';
                        if (error.response && error.response.status === 400 && error.response.data.error) {
                            message = error.response.data.error;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message,
                            confirmButtonText: 'OK',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    });
        });

        function replaceSelectedText(newHtml) {
            if (window.editor2) {
                const editor = window.editor2;
                const selection = editor.model.document.selection;
                
                // If there's a selection, replace only the selected content
                if (!selection.isCollapsed) {
                    editor.model.change(writer => {
                        const range = selection.getFirstRange();
                        writer.remove(range);
                        
                        // Insert HTML content at the current position
                        const viewFragment = editor.data.processor.toView(newHtml);
                        const modelFragment = editor.data.toModel(viewFragment);
                        writer.insert(modelFragment, range.start);
                    });
                } else {
                    // If no selection, replace all content with the new HTML
                    editor.setData(newHtml);
                }
                
                // Focus the editor after replacing content
                editor.editing.view.focus();
            } else {
                console.error('CKEditor instance not initialized.');
            }
        }
</script>
@endsection