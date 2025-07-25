{{-- new code - Beautiful Admin Layout --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Gratitude Builder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Safari-specific meta tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <style>
        /* Clean, modern admin design */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
            overflow: hidden;
        }

        .admin-layout {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-section img {
            height: 32px;
            width: auto;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
        }

        .admin-badge {
            background: linear-gradient(135deg, #902042 0%, #7a1c36 100%);
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 8px;
            display: inline-block;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto;
        }

        .nav-section {
            margin-bottom: 32px;
        }

        .nav-section-title {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 24px 12px;
        }

        .nav-item {
            margin-bottom: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-link:hover {
            background: #f1f5f9;
            color: #902042;
            text-decoration: none;
        }

        .nav-link.active {
            background: #fdf2f2;
            color: #902042;
            border-right: 3px solid #902042;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Header */
        .content-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* User dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #1e293b;
        }

        .user-trigger:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            text-decoration: none;
            color: #1e293b;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #902042 0%, #7a1c36 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 500;
            font-size: 14px;
            line-height: 1.2;
        }

        .user-role {
            font-size: 12px;
            color: #64748b;
        }

        .dropdown-icon {
            font-size: 12px;
            transition: transform 0.2s ease;
        }

        .user-dropdown.open .dropdown-icon {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 1000;
            margin-top: 8px;
        }

        .user-dropdown.open .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f8fafc;
            color: #1e293b;
            text-decoration: none;
        }

        .dropdown-item.danger {
            color: #dc2626;
        }

        .dropdown-item.danger:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        /* Content Area */
        .content-body {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
            background: #f8fafc;
        }

        /* Cards */
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body {
            padding: 24px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .stat-title {
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .stat-icon.blue {
            background: #dbeafe;
            color: #3b82f6;
        }

        .stat-icon.green {
            background: #dcfce7;
            color: #22c55e;
        }

        .stat-icon.purple {
            background: #f3e8ff;
            color: #a855f7;
        }

        .stat-icon.orange {
            background: #fed7aa;
            color: #f97316;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .stat-change {
            font-size: 12px;
            font-weight: 500;
        }

        .stat-change.positive {
            color: #22c55e;
        }

        .stat-change.negative {
            color: #ef4444;
        }

        /* Tables */
        .table-container {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f8fafc;
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .table tr:hover {
            background: #f8fafc;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #902042;
            color: white;
        }

        .btn-primary:hover {
            background: #7a1c36;
            color: white;
            text-decoration: none;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: #64748b;
        }

        .btn-outline:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #1e293b;
            text-decoration: none;
        }

        /* Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            opacity: 0.7;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #902042;
            box-shadow: 0 0 0 3px rgba(144, 32, 66, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        .form-help {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }

        .form-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 500;
            border-radius: 4px;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-green {
            background: #dcfce7;
            color: #166534;
        }

        /* Mobile Navigation Toggle */
        .mobile-nav-toggle {
            display: none;
            background: none;
            border: none;
            color: #64748b;
            font-size: 24px;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .mobile-nav-toggle:hover {
            background: #f1f5f9;
            color: #902042;
        }

        .mobile-nav-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .mobile-nav-overlay.active {
            display: block;
        }

        /* Form styling */
        .form-input, .form-select, .form-textarea {
            -webkit-appearance: none;
            font-size: 16px; /* Prevents zoom on iOS Safari */
        }

        /* Touch improvements */
        .btn, .nav-link, .user-trigger {
            min-height: 44px;
        }

        .btn-sm {
            min-height: 32px;
            min-width: 32px;
        }

        /* Better scroll behavior on Safari */
        .content-body,
        .table-container {
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }


        /* Responsive Design */
        @media (max-width: 1024px) {
            .content-header {
                padding: 12px 24px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 16px;
            }
            
            .stat-card {
                padding: 16px;
            }
            
            .stat-number {
                font-size: 24px;
            }
        }

        @media (max-width: 768px) {
            .admin-layout {
                flex-direction: column;
                height: 100vh;
                overflow: hidden;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: -280px;
                width: 280px;
                height: 100vh;
                z-index: 1000;
                transition: left 0.3s ease;
                border-right: 1px solid #e2e8f0;
                border-bottom: none;
            }

            .sidebar.mobile-open {
                left: 0;
            }

            .main-content {
                width: 100%;
                height: 100vh;
            }

            .content-header {
                padding: 12px 16px;
                flex-wrap: wrap;
                gap: 12px;
            }

            .mobile-nav-toggle {
                display: block;
                order: -1;
            }

            .page-title {
                font-size: 18px;
                flex: 1;
                min-width: 0;
                text-align: center;
            }

            .header-actions {
                gap: 12px;
            }

            .content-body {
                padding: 16px;
                height: calc(100vh - 70px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 24px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-header {
                margin-bottom: 12px;
            }

            .stat-number {
                font-size: 20px;
                margin-bottom: 8px;
            }

            .stat-change, .stat-title {
                font-size: 12px;
            }

            .card {
                margin-bottom: 16px;
                border-radius: 8px;
            }

            .card-header {
                padding: 16px;
            }

            .card-body {
                padding: 16px;
            }

            .card-title {
                font-size: 16px;
            }

            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 600px;
            }

            .table th, .table td {
                padding: 12px 8px;
                font-size: 12px;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-input, .form-select, .form-textarea {
                padding: 10px 12px;
                font-size: 16px; /* Prevents zoom on iOS Safari */
            }

            .btn {
                padding: 8px 12px;
                font-size: 13px;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 11px;
            }

            .user-trigger {
                padding: 6px 8px;
            }

            .user-avatar {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }

            .user-name {
                font-size: 13px;
            }

            .user-role {
                font-size: 11px;
            }

            .dropdown-menu {
                min-width: 160px;
                right: -8px;
            }

            /* Mobile: all grids become single column */
            .admin-grid-2, .admin-grid-3, .admin-grid-actions {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }
        }

        @media (max-width: 480px) {
            .content-header {
                padding: 8px 12px;
            }

            .page-title {
                font-size: 16px;
            }

            .mobile-nav-toggle {
                font-size: 20px;
            }

            .content-body {
                padding: 12px;
                height: calc(100vh - 60px);
            }

            .stats-grid {
                gap: 8px;
                margin-bottom: 16px;
            }

            .stat-card {
                padding: 12px;
            }

            .stat-icon {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .stat-number {
                font-size: 18px;
            }

            .card {
                margin-bottom: 12px;
                border-radius: 6px;
            }

            .card-header {
                padding: 12px;
            }

            .card-body {
                padding: 12px;
            }

            .card-title {
                font-size: 14px;
            }

            .table th, .table td {
                padding: 8px 4px;
                font-size: 11px;
            }

            .form-group {
                margin-bottom: 12px;
            }

            .form-input, .form-select, .form-textarea {
                padding: 8px 10px;
                font-size: 16px;
            }

            .form-label {
                font-size: 13px;
                margin-bottom: 6px;
            }

            .btn {
                padding: 6px 10px;
                font-size: 12px;
            }

            .user-trigger {
                padding: 4px 6px;
            }

            .user-avatar {
                width: 24px;
                height: 24px;
                font-size: 10px;
            }

            .user-name {
                font-size: 12px;
            }

            .user-role {
                font-size: 10px;
            }

            .dropdown-menu {
                min-width: 140px;
                right: -12px;
            }

            .dropdown-item {
                padding: 8px 12px;
                font-size: 12px;
            }


            .nav-link {
                padding: 10px 16px;
                font-size: 14px;
            }

            .nav-section-title {
                padding: 0 16px 8px;
                font-size: 11px;
            }
        }

        @media (max-width: 360px) {
            .content-header {
                padding: 6px 8px;
            }

            .content-body {
                padding: 8px;
                height: calc(100vh - 50px);
            }

            .page-title {
                font-size: 14px;
            }

            .stat-card {
                padding: 8px;
            }

            .card-header, .card-body {
                padding: 8px;
            }

            .form-input, .form-select, .form-textarea {
                padding: 6px 8px;
            }
        }

        /* Landscape: use 2 columns for stats */
        @media (max-width: 768px) and (orientation: landscape) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

    </style>
</head>
<body>
    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" onclick="closeMobileNav()"></div>
    
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <div class="logo-section">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="Gratitude Builder">
                    <div>
                        <div class="logo-text">Admin</div>
                        <div class="admin-badge">Administrator</div>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Overview</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Management</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.stories') }}" class="nav-link {{ request()->routeIs('admin.stories') ? 'active' : '' }}">
                            <i class="fas fa-book-open"></i>
                            <span>Stories</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Configuration</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                            <i class="fas fa-robot"></i>
                            <span>AI Settings</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Export</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.stories.export-pdf') }}" class="nav-link">
                            <i class="fas fa-file-pdf"></i>
                            <span>Export PDF</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to App</span>
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="content-header">
                <button class="mobile-nav-toggle" onclick="toggleMobileNav()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Admin Panel')</h1>
                
                <div class="header-actions">
                    <div class="user-dropdown" id="userDropdown">
                        <div class="user-trigger" onclick="toggleUserDropdown(event)">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ Auth::user()->name ?? 'Administrator' }}</div>
                                <div class="user-role">Admin</div>
                            </div>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </div>

                        <div class="dropdown-menu">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="content-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="alert-close" onclick="this.parentElement.remove()">×</button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleUserDropdown(event) {
            event.preventDefault();
            event.stopPropagation();
            
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('open');
        }

        function toggleMobileNav() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.querySelector('.mobile-nav-overlay');
            
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
            
            // Prevent body scroll when mobile nav is open
            if (sidebar.classList.contains('mobile-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        function closeMobileNav() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.querySelector('.mobile-nav-overlay');
            
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close mobile nav when clicking on nav links
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        closeMobileNav();
                    }
                });
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeMobileNav();
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });

    </script>
    @yield('scripts')
</body>
</html>