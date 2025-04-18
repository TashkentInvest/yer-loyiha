<!DOCTYPE html>
<html lang="en">

<head>
    <title>Toshkent Invest Projects | Official Government Investment Portal</title>

    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Official Toshkent Investment Portal - Explore prime investment opportunities in Tashkent" />
    <meta name="keywords"
        content="Invest, Toshkent, Tashkent Invest, Investitsiya, Aksiyadorlik jamiyati, Investment, Real Estate, Government" />
    <meta name="author" content="Tashkent Invest Administration" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.toshkentinvest.uz" />
    <meta property="og:title" content="Toshkent Invest - Official Government Investment Portal" />
    <meta property="og:description" content="Explore official investment opportunities in Tashkent city" />
    <meta property="og:image" content="{{ asset('assets/projects-map/images/og-image.png') }}" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Toshkent Invest - Official Government Portal" />
    <meta name="twitter:description" content="Explore official investment opportunities in Tashkent city" />
    <meta name="twitter:image" content="{{ asset('assets/projects-map/images/twitter-image.png') }}" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/projects-map/images/logo.png') }}" type="image/x-icon" />

    <!-- Include SimpleBar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.css">

    <!-- Google Fonts - Official Government Style -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/projects-map/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/projects-map/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/projects-map/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/projects-map/css/custom.style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/projects-map/css/icon.css') }}" />

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Load scripts asynchronously -->
    <script defer src="https://cdn.jsdelivr.net/npm/whatwg-fetch@3.6.2/dist/fetch.umd.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Enhanced Government-Style CSS -->
    <style>
        /* Global font settings for government style */
        body {
            font-family: 'Montserrat', 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .datatable-table td,
        .datatable-table th,
        .table td,
        .table th {
            border-top: 1px solid #e7eaee;
            border-bottom: none;
            white-space: unset !important;
            padding: .7rem .75rem;
            vertical-align: middle
        }

        /* Government color scheme */
        :root {
            --primary-color: #10316b;
            --secondary-color: #1a4a9e;
            --accent-color: #f0f6ff;
            --text-color: #333333;
            --light-text: #666666;
            --success-color: #2e7d32;
            --warning-color: #ed6c02;
            --danger-color: #d32f2f;
            --info-color: #0288d1;
            --dark-overlay: rgba(0, 0, 0, 0.75);
            --light-overlay: rgba(255, 255, 255, 0.85);
        }

        /* Header styling - Improved Government Style */
        .pc-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
            border-bottom: 2px solid #fff;
            height: 64px;
        }

        .pc-header .header-wrapper {
            padding: 0px 20px;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .pc-header .pc-head-link,
        .pc-header .dropdown-toggle {
            color: white !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pc-header .pc-head-link:hover,
        .pc-header .dropdown-toggle:hover {
            color: rgba(255, 255, 255, 0.85) !important;
            transform: translateY(-2px);
        }

        .header-title-text {
            color: white;
            font-weight: 600;
            font-size: 1.15rem;
            margin-left: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            padding: 5px 15px;
            border-left: 2px solid rgba(255, 255, 255, 0.5);
        }

        #xml-selector {
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            font-weight: 500;
            padding: 6px 32px 6px 12px;
            transition: all 0.3s ease;
        }

        #xml-selector:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
            background-color: rgba(255, 255, 255, 0.25);
        }

        #xml-selector option {
            background-color: white;
            color: var(--primary-color);
        }

        .user-welcome {
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .user-welcome i {
            margin-right: 5px;
            font-size: 1.1rem;
        }

        .btn-outline-light {
            border-radius: 20px;
            font-weight: 500;
            border-width: 2px;
            padding: 5px 15px;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: none;
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 5px;
            padding: 8px 15px;
            transition: all 0.2s ease;
        }

        .dropdown-item i {
            margin-right: 8px;
        }



        .official-badge {
            background-color: #fff;
            color: var(--primary-color);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            margin-left: 8px;
            vertical-align: middle;
            letter-spacing: 0.5px;
        }

        /* Sidebar styling - Enhanced Government Look */
        .pc-sidebar {
            background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
            border-right: 1px solid #e0e0e0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
        }

        .navbar-content .pc-navbar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            padding: 10px;
            border-left: 3px solid var(--primary-color);
        }

        .pc-navbar .pc-item {
            margin-bottom: 5px;
        }

        .pc-navbar .pc-link {
            padding: 8px 10px;
            transition: all 0.2s ease;
        }

        .pc-navbar .pc-link:hover {
            background-color: var(--accent-color);
            border-radius: 4px;
        }

        .pc-navbar .pc-caption {
            margin-top: 15px;
            font-weight: 600;
            color: var(--primary-color);
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
        }

        /* Selector styling - More Professional */
        #xml-selector {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            color: var(--text-color);
            font-weight: 500;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            max-width: 220px;
            cursor: pointer;
            transition: all 0.2s;
        }

        #xml-selector:hover {
            border-color: var(--secondary-color);
        }

        #xml-selector:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(16, 49, 107, 0.25);
        }

        /* District info styling - Enhanced Governmental Card */
        #district-info {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            padding: 18px;
            margin-bottom: 20px;
            border-top: 4px solid var(--primary-color);
        }

        #district-name {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            text-align: center;
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 8px;
            letter-spacing: 0.5px;
        }

        #info-table {
            width: 100%;
            border-collapse: collapse;
        }

        #info-table th {
            background-color: #f5f5f5;
            padding: 8px;
            text-align: center;
            font-weight: 600;
            color: var(--primary-color);
        }

        #info-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        #info-table tr:last-child td {
            border-bottom: none;
        }

        /* Map Container - Full Screen Map Experience */
        #map {
            width: 100%;
            height: 100vh;
            /* height: calc(100vh - 64px); */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Map Type Controls - Custom Container */
        .map-type-controls {
            position: absolute;
            top: 80px;
            right: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            padding: 6px;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .map-type-btn {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-color);
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .map-type-btn:hover {
            background: #f5f5f5;
        }

        .map-type-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .map-type-btn i {
            font-size: 14px;
        }

        /* Search Box - Enhanced Professional Design */
        .search-box-container {
            margin: 10px;
            width: 360px;
            max-width: 90vw;
        }

        .search-wrapper {
            position: relative;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            height: 42px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }

        .search-wrapper:focus-within {
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
            border-color: var(--primary-color);
        }

        .search-icon {
            padding: 0 12px;
            color: var(--primary-color);
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 0;
            height: 100%;
            font-size: 14px;
            outline: none;
        }

        .clear-button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0 12px;
            color: #777;
            transition: color 0.2s;
        }

        .clear-button:hover {
            color: var(--danger-color);
        }

        /* Government Emblem - Official Branded Badge */
        .gov-emblem {
            margin: 10px;
            background-color: white;
            border-radius: 8px;
            padding: 10px 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            text-align: center;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid var(--primary-color);
        }

        .gov-emblem .emblem-logo {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .gov-emblem .emblem-text {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        /* Legend Control - Improved Styling */
        .legend-control {
            position: absolute;
            bottom: 30px;
            right: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            padding: 12px;
            z-index: 1;
            max-width: 220px;
            border-left: 4px solid var(--primary-color);
        }

        .legend-title {
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 6px;
            color: var(--primary-color);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .legend-item:last-child {
            margin-bottom: 0;
        }

        .legend-item .legend-marker {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid white;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
        }

        .legend-item .legend-marker.red {
            background-color: #FF0000;
        }

        .legend-item .legend-marker.yellow {
            background-color: #FFFF00;
        }

        .legend-item .legend-marker.blue {
            background-color: #1a81bd;
        }

        .legend-item span {
            font-size: 13px;
            color: #333;
            font-weight: 500;
        }

        /* Info Window - Enhanced Design */
        .map-info-window {
            font-family: 'Montserrat', 'Roboto', sans-serif;
            min-width: 250px;
        }

        .map-info-window .info-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 8px;
        }

        .map-info-window h4 {
            margin: 0;
            color: var(--primary-color);
            font-size: 16px;
            font-weight: 600;
        }

        .map-info-window .info-badge {
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .map-info-window .info-body {
            margin-bottom: 10px;
        }

        .map-info-window .info-body p {
            margin: 6px 0;
            font-size: 13px;
            display: flex;
            align-items: center;
        }

        .map-info-window .info-body p i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
            color: var(--primary-color);
        }

        .map-info-window .info-footer {
            font-size: 12px;
            color: var(--primary-color);
            text-align: center;
            font-weight: 500;
            border-top: 1px dashed #eee;
            padding-top: 8px;
        }

        /* Sidebar Enhancements - Luxury Government Style */
        #info-sidebar {
            position: fixed;
            top: 0;
            right: -500px;
            width: 500px;
            height: 100%;
            background-color: #fff;
            overflow-y: auto;
            transition: right 0.3s ease;
            z-index: 1000;
            padding: 0;
            box-shadow: -5px 0 20px rgba(0, 0, 0, 0.2);
            border-left: 4px solid var(--primary-color);
        }

        #info-sidebar.open {
            right: 0;
        }

        #info-sidebar .sidebar-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 15px 20px;
            position: relative;
        }

        #info-sidebar .sidebar-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            padding-right: 30px;
        }

        #info-sidebar .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: rgb(255, 255, 255);
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(4, 4, 12, 0.731);
            transition: background-color 0.2s;
        }

        #info-sidebar .close-btn:hover {
            background-color: rgba(0, 0, 0, 0.55);
        }

        #info-sidebar .sidebar-content {
            padding: 20px;
        }

        #info-sidebar .info-content img.custom_sidebar_image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        #info-sidebar .custom_sidebar_title {
            font-size: 1.6rem;
            margin-bottom: 15px;
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 8px;
            font-weight: 600;
        }

        #info-sidebar table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid #eee;
        }

        #info-sidebar table th {
            padding: 10px;
            text-align: left;
            background-color: #f5f7fa;
            border-bottom: 1px solid #ddd;
            color: var(--primary-color);
            font-weight: 600;
        }

        #info-sidebar table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        #info-sidebar .btn-link {
            display: inline-block;
            padding: 10px 15px;
            background-color: var(--primary-color);
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            margin: 8px 5px;
            transition: background-color 0.3s;
            font-weight: 500;
            border: none;
            cursor: pointer;
        }

        #info-sidebar .btn-link:hover {
            background-color: var(--secondary-color);
        }

        #toggle-currency-btn {
            background-color: var(--primary-color);
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        #toggle-currency-btn:hover {
            background-color: var(--secondary-color);
        }

        /* QR Code Container - Enhanced Styling */
        #qr-code-container {
            text-align: center;
            margin: 25px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px dashed #ddd;
        }

        #qr-code-container img {
            width: 180px;
            height: 180px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: white;
            padding: 10px;
            border-radius: 8px;
        }

        #qr-code-container a {
            display: inline-block;
            padding: 8px 16px;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        #qr-code-container a:hover {
            background-color: var(--secondary-color);
        }

        /* Badge Styles - Enhanced Look */
        .badge {
            display: inline-block;
            padding: 0.25em 0.6em;
            font-size: 75%;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            color: #fff;
        }

        .badge-primary {
            background-color: var(--primary-color);
        }

        .badge-success {
            background-color: var(--success-color);
        }

        .badge-danger {
            background-color: var(--danger-color);
        }

        .badge-warning {
            background-color: var(--warning-color);
            color: #fff;
        }

        .badge-info {
            background-color: var(--info-color);
        }

        /* Tabs in sidebar */
        .sidebar-tabs {
            display: flex;
            margin: 20px 0 15px;
            border-bottom: 1px solid #dee2e6;
            padding: 0;
            background-color: #f8f9fa;
            border-radius: 8px 8px 0 0;
            overflow: hidden;
        }

        .sidebar-tab {
            padding: 12px 15px;
            cursor: pointer;
            border: none;
            background: transparent;
            margin: 0;
            flex-grow: 1;
            text-align: center;
            font-weight: 500;
            color: var(--text-color);
            transition: all 0.2s;
            position: relative;
        }

        .sidebar-tab:not(:last-child) {
            border-right: 1px solid #dee2e6;
        }

        .sidebar-tab:hover {
            background-color: #eceff1;
        }

        .sidebar-tab.active {
            background-color: #fff;
            color: var(--primary-color);
            font-weight: 600;
        }

        .sidebar-tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background-color: var(--primary-color);
        }

        .tab-content {
            display: none;
            background-color: #fff;
            border-radius: 0 0 8px 8px;
            padding: 20px 0;
        }

        .tab-content.active {
            display: block;
        }

        /* Loading animation */
        .loading-spinner {
            display: inline-block;
            width: 50px;
            height: 50px;
            border: 4px solid rgba(16, 49, 107, 0.2);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -25px;
            margin-left: -25px;
            z-index: 9999;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .map-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--light-overlay);
            z-index: 9998;
            backdrop-filter: blur(3px);
        }

        /* Modal Styles - Luxurious Government Style */
        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: var(--dark-overlay);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            position: relative;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
            border-top: 5px solid var(--primary-color);
        }

        .modal .close {
            color: var(--light-text);
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            right: 20px;
            top: 15px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .modal .close:hover,
        .modal .close:focus {
            color: var(--primary-color);
        }

        .modal .modal-text {
            font-size: 18px;
            margin-bottom: 25px;
            color: var(--text-color);
            line-height: 1.5;
        }

        .modal .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .modal .social-icons a {
            color: inherit;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .modal .social-icons a:hover {
            transform: scale(1.1);
        }

        .modal .social-icons i {
            font-size: 35px;
            transition: color 0.3s;
        }

        .modal .social-icons i:hover {
            color: var(--primary-color);
        }

        .telegram {
            color: #0088cc;
        }

        .facebook {
            color: #3b5998;
        }

        .instagram {
            color: #e4405f;
        }

        /* Responsive Adjustments */
        @media (max-width: 767px) {
            #info-sidebar {
                width: 100%;
                right: -100%;
            }

            .sidebar-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .sidebar-tab {
                font-size: 14px;
                padding: 10px;
                white-space: nowrap;
            }

            .search-box-container {
                width: 80%;
            }

            .legend-control {
                bottom: 20px;
                right: 20px;
                max-width: 150px;
            }

            .map-type-controls {
                top: 80px;
                right: 10px;
            }

            .gov-emblem {
                padding: 8px 10px;
            }

            .gov-emblem .emblem-logo {
                width: 24px;
                height: 24px;
            }

            .gov-emblem .emblem-text {
                font-size: 14px;
            }

            #district-info {
                padding: 15px;
            }

            #district-name {
                font-size: 18px;
            }
        }

        /* Custom date display */
        .current-date {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background-color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--primary-color);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1;
            border-left: 3px solid var(--primary-color);
        }

        /* User welcome message */
        .user-welcome {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            margin-right: 10px;
            font-size: 14px;
            font-weight: 500;
        }

        .user-welcome i {
            margin-right: 5px;
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme="light">

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p class="modal-text">Добро пожаловать на официальный инвестиционный портал Ташкента. Следите за нами в
                социальных сетях для получения актуальной информации.</p>
            <div class="social-icons">
                <a href="https://t.me/toshkentinvestuz" target="_blank" title="Telegram">
                    <i class="fab fa-telegram telegram"></i>
                </a>
                <a href="https://www.facebook.com/profile.php?id=61567396581686" target="_blank" title="Facebook">
                    <i class="fab fa-facebook facebook"></i>
                </a>
                <a href="https://www.instagram.com/toshkentinvest" target="_blank" title="Instagram">
                    <i class="fab fa-instagram instagram"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="map-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Page Loader -->
    <div class="page-loader">
        <div class="bar"></div>
    </div>


    <!-- Sidebar -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('aktivs.index') }}" class="b-brand text-primary">
                    <img src="{{ asset('assets/projects-map/images/logo.png') }}" class="img-fluid logo-lg custom_logo"
                        alt="Тошкент Инвест логотипи" />
                    <span class="official-badge">Расмий</span>
                </a>
            </div>
            <div class="navbar-content px-3" data-simplebar>
                <!-- District Information -->
                <div id="district-info" class="district-info-card">
                    <div id="district-name" class="district-title">Тошкент</div>
                    <table id="info-table" class="table info-table">
                        <thead>
                            <tr>
                                <th colspan="2" class="info-header">Асосий маълумот</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="info-row">
                                <td class="info-label"><i class="fas fa-map-marked"></i> Майдони</td>
                                <td id="maydoni" class="info-value">43.5 км²</td>
                            </tr>
                            <tr class="info-row">
                                <td class="info-label"><i class="fas fa-users"></i> Аҳолиси</td>
                                <td id="aholiSoni" class="info-value">3 млн</td>
                            </tr>
                            <tr class="info-row">
                                <td class="info-label"><i class="fas fa-city"></i> Туманлар</td>
                                <td id="TumanlarSoni" class="info-value">12</td>
                            </tr>
                            <tr class="info-row">
                                <td class="info-label"><i class="fas fa-home"></i> Маҳаллалар</td>
                                <td id="MahallaSoni" class="info-value">585</td>
                            </tr>
                            <tr class="info-row">
                                <td class="info-label"><i class="fas fa-building"></i> Объектлар</td>
                                <td id="savdodaTurganJamiSoni" class="info-value badge-highlight">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if (Auth::check())
                    <ul class="pc-navbar admin-menu">
                        <li class="pc-item pc-caption"><label class="menu-category">Бошқарув</label></li>
                        <li class="pc-item">
                            <a href="{{ route('aktivs.create') }}" class="pc-link menu-item">
                                <i class="fas fa-plus-circle menu-icon"></i>
                                <span>Объект қўшиш</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="#" id="importExcelBtn" class="pc-link menu-item">
                                <i class="fas fa-file-excel menu-icon"></i>
                                <span>Excel дан импорт</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a href="/dashboard" class="pc-link menu-item">
                                <i class="fas fa-tachometer-alt menu-icon"></i>
                                <span>Бошқарув панели</span>
                            </a>
                        </li>
                    </ul>
                @endif

                <div class="ms-auto admin-controls">

                    <ul class="list-unstyled admin-actions">
                        @if (session('success'))
                            <div class="alert alert-success fade-in">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger fade-in">
                                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.cache.action') }}" class="cache-form">
                            @csrf
                            <button type="submit" name="action" value="clear"
                                class="btn btn-danger cache-clear-btn">
                                <i class="fas fa-trash-alt"></i> Кешни тозалаш
                            </button>
                        </form>
                    </ul>
                </div>

                <div class="footer-content">
                    <div class="copyright">
                        <span class="copyright-icon">©</span> {{ date('Y') }} <span
                            class="brand-name">TeamDev.uz</span>
                    </div>
                    <div class="update-info">
                        <i class="fas fa-history"></i> Охирги янгиланиш: 2025-04-18 06:25:30
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <style>
        /* Light Theme Sidebar Styling */
        :root {
            --primary-rgb: 0, 123, 255;
            --primary-color: #007bff;
            --secondary-color: #6610f2;
            --text-dark: #333;
            --text-medium: #555;
            --text-light: #777;
            --border-color: #e0e0e0;
            --hover-bg: #f0f7ff;
        }

        .pc-sidebar {
            background: #ffffff;
            box-shadow: 1px 0 10px rgba(0, 0, 0, 0.05);
            border-right: 1px solid var(--border-color);
        }

        .navbar-wrapper {
            padding: 10px 0;
        }

        .m-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            position: relative;
        }

        .custom_logo {
            /* max-height: 52px; */
            transition: transform 0.3s ease;
        }

        .custom_logo:hover {
            transform: scale(1.05);
        }

        .official-badge {
            position: absolute;
            top: 8px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            font-size: 0.65rem;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* District Info Card */
        .district-info-card {
            background: #f8faff;
            border-radius: 12px;
            margin: 10px 0 20px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .district-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
        }

        .info-table {
            margin-bottom: 0;
        }

        .info-table thead {
            background: rgba(var(--primary-rgb), 0.1);
        }

        .info-header {
            font-size: 0.9rem;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            padding: 8px;
            font-weight: 600;
        }

        .info-row {
            border-bottom: 1px dashed var(--border-color);
            transition: background-color 0.2s ease;
        }

        .info-row:hover {
            background-color: var(--hover-bg);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--text-medium);
            font-size: 0.85rem;
            padding: 8px 10px;
            vertical-align: middle;
        }

        .info-label i {
            margin-right: 8px;
            color: var(--primary-color);
            width: 16px;
            text-align: center;
        }

        .info-value {
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 10px;
            text-align: right;
            vertical-align: middle;
        }

        .badge-highlight {
            background: rgba(var(--primary-rgb), 0.1);
            border-radius: 4px;
            padding: 3px 8px;
            font-weight: 600;
        }

        /* Admin Menu */
        .admin-menu {
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .menu-category {
            color: var(--primary-color);
            font-size: 0.85rem;
            letter-spacing: 1px;
            font-weight: 600;
            text-transform: uppercase;
            padding: 10px 0;
            margin-bottom: 5px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-bottom: 5px;
            color: var(--text-medium) !important;
        }

        .menu-item:hover {
            background: var(--hover-bg);
            color: var(--primary-color) !important;
            transform: translateX(3px);
        }

        .menu-icon {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            color: var(--primary-color);
            font-size: 1rem;
        }

        /* Admin Controls - Light Theme */
        .admin-controls {
            display: flex;
            flex-direction: column;
            padding: 10px 15px;
            background-color: #f0f7ff;
            border-radius: 10px;
            margin: 8px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(var(--primary-rgb), 0.2);
        }

        .admin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(var(--primary-rgb), 0.1);
        }

        .date-time,
        .user-info {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 4px 8px;
            background-color: rgba(var(--primary-rgb), 0.1);
            border-radius: 6px;
            color: var(--text-dark);
        }

        .date-time i,
        .user-info i {
            margin-right: 6px;
            color: var(--primary-color);
        }

        .date {
            margin-right: 5px;
        }

        .time {
            font-family: monospace;
            background-color: rgba(var(--primary-rgb), 0.2);
            padding: 2px 4px;
            border-radius: 4px;
        }

        .user-info {
            margin-left: 10px;
            background-color: rgba(var(--primary-rgb), 0.15);
        }

        .admin-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 100%;
        }

        .alert {
            padding: 8px 12px;
            border-radius: 6px;
            margin: 0;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
        }

        .alert i {
            margin-right: 8px;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cache-form {
            display: flex;
            justify-content: center;
        }

        .cache-clear-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            border-radius: 6px;
            padding: 8px 15px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(220, 53, 69, 0.3);
            transition: all 0.3s ease;
            width: 100%;
            color: white;
        }

        .cache-clear-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.4);
            background: linear-gradient(135deg, #e04b59, #d32f2f);
        }

        .cache-clear-btn:active {
            transform: translateY(1px);
            box-shadow: 0 1px 3px rgba(220, 53, 69, 0.4);
        }

        .cache-clear-btn i {
            margin-right: 6px;
        }

        /* Footer Content */
        .footer-content {
            margin-top: 20px;
            padding: 15px 0;
            border-top: 1px solid var(--border-color);
            text-align: center;
        }

        .copyright {
            color: var(--text-light);
            font-size: 0.85rem;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .copyright-icon {
            font-size: 1rem;
            margin-right: 4px;
            margin-top: -2px;
        }

        .brand-name {
            font-weight: 700;
            color: var(--primary-color);
            margin-left: 3px;
        }

        .update-info {
            color: var(--text-light);
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .update-info i {
            margin-right: 4px;
            font-size: 0.7rem;
        }

        /* Scrollbar Styling */
        [data-simplebar]::-webkit-scrollbar {
            width: 6px;
            background-color: #f5f5f5;
        }

        [data-simplebar]::-webkit-scrollbar-thumb {
            background-color: rgba(var(--primary-rgb), 0.5);
            border-radius: 10px;
        }

        [data-simplebar]::-webkit-scrollbar-thumb:hover {
            background-color: rgba(var(--primary-rgb), 0.7);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .district-title {
                font-size: 1.2rem;
            }

            .info-label,
            .info-value {
                font-size: 0.8rem;
                padding: 6px 8px;
            }
        }

        .pc-header .pc-head-link,
        .pc-header .dropdown-toggle {
            background: #fff !important;

        }
    </style>
    <!-- Header -->

    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup" id="hide_in_mobile">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item">
                        <select id="xml-selector" class="form-select form-control">
                            <option id="testTashkent" value="tashkent">Тошкент шаҳри</option>
                            <option value="bektemir.xml">Бектемир</option>
                            <option value="chilonzor.xml">Чилонзор</option>
                            <option value="mirabod.xml">Миробод</option>
                            <option value="mirzo_ulugbek.xml">Мирзо Улуғбек</option>
                            <option value="olmazor.xml">Олмазор</option>
                            <option value="sergeli.xml">Сергели</option>
                            <option value="shayhontaxur.xml">Шайхонтоҳур</option>
                            <option value="uchtepa.xml">Учтепа</option>
                            <option value="yakkasaroy.xml">Яккасарой</option>
                            <option value="yashnabod.xml">Яшнобод</option>
                            <option value="yunusabod.xml">Юнусобод</option>
                            <option value="yangihayot.xml">Янгиҳаёт</option>
                        </select>
                    </li>
                    <li class="pc-h-item">
                        <span class="header-title-text">Сотилган ерлар рўйхати</span>
                    </li>
                </ul>
            </div>

            <!-- Жорий сана ва вақт (UTC - YYYY-MM-DD HH:MM:SS форматида): 2025-04-18 06:10:36 -->
            <!-- Жорий фойдаланувчи логини: InvestUz -->

        </div>
    </header>

    <!-- Map Container -->
    <div id="map"></div>

    <!-- Map Type Controls -->
    <div class="map-type-controls">
        <button class="map-type-btn active" data-type="roadmap"><i class="fas fa-map"></i> Карта</button>
        <button class="map-type-btn" data-type="satellite"><i class="fas fa-satellite"></i> Спутник</button>
        <button class="map-type-btn" data-type="hybrid"><i class="fas fa-globe"></i> Гибрид</button>
        <button class="map-type-btn" data-type="terrain"><i class="fas fa-mountain"></i> Рельеф</button>
    </div>

    <!-- Current Date Display -->
    <div class="current-date">
        <i class="far fa-calendar-alt"></i> 2025-04-16 13:07:11
    </div>

    <!-- Info Sidebar -->
    <div id="info-sidebar" style="padding:5px" data-currency="UZS" data-simplebar>
        <div class="sidebar-header">
            <h3 class="sidebar-title">Информация об объекте</h3>
            <span class="close-btn">&times;</span>
        </div>
        <div class="sidebar-content">
            <!-- Content will be injected here -->
        </div>
    </div>

    <!-- Import Excel Modal -->
    @if (Auth::check())
        <div class="modal" id="importExcelModal">
            <div class="modal-content" style="max-width: 600px;">
                <span class="close" data-dismiss="modal">&times;</span>
                <h4>Импорт данных из Excel</h4>
                <form id="importExcelForm" action="#!" method="POST" enctype="multipart/form-data"
                    class="mt-4">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="excel_file" class="form-label">Выберите файл Excel</label>
                        <input type="file" name="excel_file" id="excel_file" class="form-control" required
                            accept=".xlsx,.xls">
                    </div>
                    <button type="submit" class="btn-link mt-3">
                        <i class="fas fa-upload"></i> Загрузить и импортировать
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
    <script src="{{ asset('assets/projects-map/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/projects-map/js/plugins/feather.min.js') }}"></script>

    <!-- Initialize Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById("myModal");
            const closeButton = document.querySelector(".modal .close");
            const modalShown = localStorage.getItem('modalShown');

            // Check if modal was shown in the last 7 days
            const lastShown = localStorage.getItem('modalLastShown');
            const sevenDaysAgo = new Date();
            sevenDaysAgo.setDate(sevenDaysAgo.getDate() - 7);

            const shouldShowModal = !lastShown || new Date(lastShown) < sevenDaysAgo;

            if (shouldShowModal) {
                modal.style.display = "flex";
                localStorage.setItem('modalShown', 'true');
                localStorage.setItem('modalLastShown', new Date().toISOString());
            }

            closeButton.onclick = function() {
                modal.style.display = "none";
            };

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // Import Excel modal
            const importExcelBtn = document.getElementById('importExcelBtn');
            const importExcelModal = document.getElementById('importExcelModal');

            if (importExcelBtn && importExcelModal) {
                importExcelBtn.addEventListener('click', function() {
                    importExcelModal.style.display = 'flex';
                });

                const closeImportModal = document.querySelectorAll('[data-dismiss="modal"]');
                closeImportModal.forEach(btn => {
                    btn.addEventListener('click', function() {
                        importExcelModal.style.display = 'none';
                    });
                });
            }

            // Form submission with loading indicator
            const importExcelForm = document.getElementById('importExcelForm');
            if (importExcelForm) {
                importExcelForm.addEventListener('submit', function() {
                    document.getElementById('loadingOverlay').style.display = 'block';
                });
            }
        });
    </script>

    <!-- Main JavaScript - Enhanced with Map Type Controls -->
    <script>
        const baseUrl = "{{ url('') }}";
        let usdRate = null;
        let map;
        let markers = [];
        const TASHKENT_CENTER = {
            lat: 41.311081,
            lng: 69.279251
        };
        const ZOOM_LEVEL = 12;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Google Maps
            loadGoogleMaps();
        });

        function loadGoogleMaps() {
            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key=AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY&libraries=places&callback=initMap`;
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        }

        function initMap() {
            // Show loading
            document.getElementById('loadingOverlay').style.display = 'block';

            const urlParams = new URLSearchParams(window.location.search);
            const urlLat = parseFloat(urlParams.get('lat'));
            const urlLng = parseFloat(urlParams.get('lng'));

            // Enhanced Government Map Styling
            const mapStyles = [{
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "white"
                    }]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "geometry.stroke",
                    "stylers": [{
                        "color": "#dcd2be"
                    }]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#10316b"
                    }]
                },
                {
                    "featureType": "administrative.neighborhood",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#10316b"
                    }]
                },
                {
                    "featureType": "administrative.province",
                    "elementType": "geometry.stroke",
                    "stylers": [{
                        "color": "#10316b"
                    }, {
                        "weight": 1
                    }]
                },
                {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#f5f5f5"
                    }]
                },
                {
                    "featureType": "landscape.man_made",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#eeeeee"
                    }]
                },
                {
                    "featureType": "landscape.natural",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#e8f0f9"
                    }]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#dfd2ae"
                    }]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#10316b"
                    }]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#c7e6bd"
                    }]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#336633"
                    }]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#ffffff"
                    }]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#696969"
                    }]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#ffffff"
                    }]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#ffffff"
                    }]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [{
                        "color": "#e9bc62"
                    }]
                },
                {
                    "featureType": "transit.line",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#e5e5e5"
                    }]
                },
                {
                    "featureType": "transit.station",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#eeeeee"
                    }]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#b3d3f9"
                    }]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#10316b"
                    }]
                }
            ];

            // Create map with enhanced styling
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: urlLat && urlLng ? 17 : ZOOM_LEVEL,
                center: urlLat && urlLng ? {
                    lat: urlLat,
                    lng: urlLng
                } : TASHKENT_CENTER,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: mapStyles,
                mapTypeControl: false, // We'll use our custom controls
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                fullscreenControl: true,
                fullscreenControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_CENTER
                },
                scaleControl: true,
                rotateControl: false,
                gestureHandling: 'greedy'
            });

            // Set up custom map type controls
            setupMapTypeControls(map);

            // Add enhanced government emblem
            addGovernmentEmblem(map);

            // Add search box with enhanced design
            addSearchBox(map);

            // Add legend to map
            addMapLegend(map);

            // Fetch USD exchange rate and then fetch markers
            fetchUsdRate()
                .then(rate => {
                    usdRate = rate;
                    fetchMarkers(map, usdRate, urlLat, urlLng);
                    setupEventListeners();
                })
                .catch(error => {
                    console.error('Error fetching USD rate:', error);
                    fetchMarkers(map, usdRate, urlLat, urlLng);
                    setupEventListeners();
                });

            // Handle district selection and KML processing
            handleDistrict(map);
        }

        // Set up custom map type controls
        function setupMapTypeControls(map) {
            const mapTypeButtons = document.querySelectorAll('.map-type-btn');

            mapTypeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const mapType = this.getAttribute('data-type');

                    // Update active state
                    mapTypeButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Set map type
                    map.setMapTypeId(mapType);
                });
            });
        }

        // Add custom government emblem
        function addGovernmentEmblem(map) {
            const emblemDiv = document.createElement('div');
            emblemDiv.className = 'gov-emblem';
            emblemDiv.innerHTML = `
                <img src="{{ asset('assets/projects-map/images/logo.png') }}" class="emblem-logo" alt="Emblem">
                <span class="emblem-text">TOSHKENT INVEST</span>
            `;
            map.controls[google.maps.ControlPosition.LEFT_TOP].push(emblemDiv);
        }

        // Add a legend to the map
        function addMapLegend(map) {
            const legendDiv = document.createElement('div');
            legendDiv.className = 'legend-control';
            legendDiv.innerHTML = `
        <div class="legend-title">ОБЪЕКТ ТУРЛАРИ</div>
        <div class="legend-item">
            <span class="legend-marker red"></span>
            <span>Ер участкалари</span>
        </div>
        <div class="legend-item">
            <span class="legend-marker yellow"></span>
            <span>Турар-жой бинолари</span>
        </div>
        <div class="legend-item">
            <span class="legend-marker blue"></span>
            <span>Тижорат объектлари</span>
        </div>
    `;
            // map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legendDiv);
        }

        // Add enhanced search box
        function addSearchBox(map) {
            const searchBoxDiv = document.createElement('div');
            searchBoxDiv.className = 'search-box-container';
            searchBoxDiv.innerHTML = `
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="pac-input" class="search-input" placeholder="Поиск мест в Ташкенте...">
                    <button id="clear-search" class="clear-button"><i class="fas fa-times"></i></button>
                </div>
            `;
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchBoxDiv);

            // Initialize the search box after the div is added to the map
            setTimeout(() => {
                const input = document.getElementById('pac-input');
                const clearButton = document.getElementById('clear-search');
                const searchBox = new google.maps.places.SearchBox(input);

                // Bias the SearchBox results towards current map's viewport
                map.addListener('bounds_changed', function() {
                    searchBox.setBounds(map.getBounds());
                });

                // Listen for the event fired when the user selects a prediction
                searchBox.addListener('places_changed', function() {
                    const places = searchBox.getPlaces();
                    if (places.length === 0) {
                        return;
                    }

                    // Get the first place
                    const place = places[0];
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    // Center the map on the search result
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                });

                // Clear search
                clearButton.addEventListener('click', function() {
                    input.value = '';
                    map.setCenter(TASHKENT_CENTER);
                    map.setZoom(ZOOM_LEVEL);
                });
            }, 300);
        }

        async function fetchUsdRate() {
            try {
                const cachedRate = localStorage.getItem('usdRate');
                const cacheTime = localStorage.getItem('usdRateCacheTime');

                // Check if we have a cached rate less than 24 hours old
                if (cachedRate && cacheTime) {
                    const cacheAge = Date.now() - parseInt(cacheTime);
                    if (cacheAge < 24 * 60 * 60 * 1000) { // 24 hours in milliseconds
                        return parseFloat(cachedRate);
                    }
                }

                // If no valid cache, fetch from API
                const response = await fetch('https://cbu.uz/uz/arkhiv-kursov-valyut/json/');
                const rates = await response.json();
                const usdRateObj = rates.find(rate => rate.Ccy === 'USD');

                if (usdRateObj && usdRateObj.Rate) {
                    const rate = parseFloat(usdRateObj.Rate);
                    // Cache the rate
                    localStorage.setItem('usdRate', rate);
                    localStorage.setItem('usdRateCacheTime', Date.now());
                    return rate;
                } else {
                    throw new Error('USD rate not found in API response');
                }
            } catch (error) {
                console.error('Error fetching USD rate:', error);
                return null; // Return null if fetching failed
            }
        }

        function fetchMarkers(map, usdRate, urlLat, urlLng) {
            document.getElementById('loadingOverlay').style.display = 'block';

            fetch('/api/aktivs')
                .then(response => response.json())
                .then(data => {
                    const markersData = data.lots;
                    window.markers = markersData;

                    // Clear existing markers
                    markers.forEach(marker => marker.setMap(null));
                    markers = [];

                    let targetMarkerData = null;
                    const bounds = new google.maps.LatLngBounds();

                    markersData.forEach(markerData => {
                        const lat = parseFloat(markerData.lat);
                        const lng = parseFloat(markerData.lng);

                        if (!isNaN(lat) && !isNaN(lng)) {
                            const position = {
                                lat,
                                lng
                            };
                            const title = markerData.property_name || 'No Title';

                            // Enhanced marker styling
                            let markerIcon;

                            if (markerData.building_type === 'yer') {
                                markerIcon = {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    fillColor: '#FF0000',
                                    fillOpacity: 0.9,
                                    strokeWeight: 2,
                                    strokeColor: '#FFFFFF',
                                    scale: 10
                                };
                            } else if (markerData.building_type === 'TurarBino') {
                                markerIcon = {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    fillColor: '#FFFF00',
                                    fillOpacity: 0.9,
                                    strokeWeight: 2,
                                    strokeColor: '#FFFFFF',
                                    scale: 10
                                };
                            } else if (markerData.building_type === 'NoturarBino') {
                                markerIcon = {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    fillColor: '#1a81bd',
                                    fillOpacity: 0.9,
                                    strokeWeight: 2,
                                    strokeColor: '#FFFFFF',
                                    scale: 10
                                };
                            } else {
                                markerIcon = {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    fillColor: '#00FF00',
                                    fillOpacity: 0.9,
                                    strokeWeight: 2,
                                    strokeColor: '#FFFFFF',
                                    scale: 10
                                };
                            }

                            // Create marker with animation
                            const marker = new google.maps.Marker({
                                position: position,
                                map: map,
                                title: title,
                                icon: markerIcon,
                                animation: google.maps.Animation.DROP,
                                optimized: true
                            });

                            // Add to markers array
                            markers.push(marker);

                            // Extend bounds for autofit but only for Tashkent
                            if (lat >= 41.2 && lat <= 41.4 && lng >= 69.1 && lng <= 69.4) {
                                bounds.extend(position);
                            }

                            // Create info window with basic info for hover
                            const infoContent = `
                                <div class="map-info-window">
                                    <div class="info-header">
                                        <h4>${title}</h4>
                                        <span class="info-badge ${markerData.building_type_comment}">${markerData.building_type_comment}</span>

                                    </div>
                                    <div class="info-body">
                                        <p><i class="fas fa-map-marker-alt"></i> ${markerData.address || 'N/A'}</p>
                                        <p><i class="fas fa-ruler-combined"></i> ${markerData.land_area || 'N/A'} m²</p>
                                        ${markerData.start_price ? `<p><i class="fas fa-tag"></i> ${formatCurrency(markerData.start_price, 'UZS')}</p>` : ''}
                                    </div>
                                    <div class="info-footer">
                                        <span>Нажмите для подробной информации</span>
                                    </div>
                                </div>
                            `;


                            const infoWindow = new google.maps.InfoWindow({
                                content: infoContent,
                                maxWidth: 300
                            });

                            // Show info window on hover (desktop only)
                            if (window.innerWidth > 768) {
                                marker.addListener('mouseover', function() {
                                    infoWindow.open(map, marker);
                                });

                                marker.addListener('mouseout', function() {
                                    infoWindow.close();
                                });
                            }

                            marker.addListener('click', function() {
                                if (window.innerWidth <= 768) {
                                    infoWindow.close();
                                }

                                const sidebar = document.getElementById('info-sidebar');
                                const isInUSD = sidebar.getAttribute('data-currency') === 'USD';
                                updateSidebarContent(markerData, isInUSD, usdRate);
                                sidebar.classList.add('open');

                                // Update URL with marker coordinates for sharing
                                const newUrl = new URL(window.location.href);
                                newUrl.searchParams.set('lat', lat);
                                newUrl.searchParams.set('lng', lng);
                                window.history.replaceState({}, '', newUrl);
                            });

                            // Check if URL parameters match this marker
                            if (urlLat && urlLng && Math.abs(lat - urlLat) < 0.0001 && Math.abs(lng - urlLng) <
                                0.0001) {
                                targetMarkerData = markerData;
                                map.setCenter({
                                    lat,
                                    lng
                                });
                                map.setZoom(17);
                            }
                        }
                    });

                    // Fit map to markers if no specific location requested
                    if (!urlLat && !urlLng && markers.length > 0) {
                        map.fitBounds(bounds);

                        // Don't zoom in too far on small datasets
                        const listener = google.maps.event.addListener(map, 'idle', function() {
                            if (map.getZoom() > 15) {
                                map.setZoom(15);
                            }
                            google.maps.event.removeListener(listener);
                        });
                    }

                    // Open sidebar if URL parameters match a marker
                    if (targetMarkerData) {
                        const sidebar = document.getElementById('info-sidebar');
                        const isInUSD = sidebar.getAttribute('data-currency') === 'USD';
                        updateSidebarContent(targetMarkerData, isInUSD, usdRate);
                        sidebar.classList.add('open');
                    }

                    // Hide loading overlay
                    document.getElementById('loadingOverlay').style.display = 'none';
                })
                .catch(error => {
                    console.error('Error fetching markers:', error);
                    document.getElementById('loadingOverlay').style.display = 'none';
                    alert('Error loading marker data. Please try refreshing the page.');
                });
        }

        // Get badge class based on building type
        function getBadgeClass(buildingType) {
            switch (buildingType) {
                case 'yer':
                    return 'badge-danger';
                case 'TurarBino':
                    return 'badge-warning';
                case 'NoturarBino':
                    return 'badge-info';
                default:
                    return 'badge-primary';
            }
        }

        // Format currency
        function formatCurrency(amount, currency) {
            try {
                if (currency === 'USD') {
                    return new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    }).format(amount);
                } else {
                    return new Intl.NumberFormat('uz-UZ', {
                        style: 'currency',
                        currency: 'UZS',
                        minimumFractionDigits: 0
                    }).format(amount);
                }
            } catch (error) {
                console.error('Error formatting currency:', error);
                return amount.toString();
            }
        }

        function updateSidebarContent(markerData, isInUSD, usdRate) {
            const sidebar = document.getElementById('info-sidebar');
            const area = parseFloat(markerData.land_area) || 0;
            const priceUZS = parseFloat(markerData.start_price) || 0;
            const soldPriceUZS = parseFloat(markerData.sold_price) || 0;

            // Calculate lot price per sotix
            const lotPricePerSotixUZS = area > 0 ? priceUZS / (area * 100) : 0;

            // Convert price and per-sotix based on currency
            let lotPriceFormatted = 'N/A';
            let lotPricePerSotixFormatted = 'N/A';
            let soldPriceFormatted = 'N/A';

            try {
                if (isInUSD && usdRate) {
                    if (priceUZS > 0) {
                        const priceUSD = priceUZS / usdRate;
                        const pricePerSotixUSD = lotPricePerSotixUZS / usdRate;

                        lotPriceFormatted = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD'
                        }).format(priceUSD);

                        lotPricePerSotixFormatted = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD'
                        }).format(pricePerSotixUSD);
                    }

                    if (soldPriceUZS > 0) {
                        const soldPriceUSD = soldPriceUZS / usdRate;

                        soldPriceFormatted = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD'
                        }).format(soldPriceUSD);
                    }
                } else {
                    if (priceUZS > 0) {
                        lotPriceFormatted = new Intl.NumberFormat('uz-UZ', {
                            style: 'currency',
                            currency: 'UZS',
                            minimumFractionDigits: 0
                        }).format(priceUZS);

                        lotPricePerSotixFormatted = new Intl.NumberFormat('uz-UZ', {
                            style: 'currency',
                            currency: 'UZS',
                            minimumFractionDigits: 0
                        }).format(lotPricePerSotixUZS);
                    }

                    if (soldPriceUZS > 0) {
                        soldPriceFormatted = new Intl.NumberFormat('uz-UZ', {
                            style: 'currency',
                            currency: 'UZS',
                            minimumFractionDigits: 0
                        }).format(soldPriceUZS);
                    }
                }
            } catch (error) {
                console.error('Error formatting currency:', error);
            }

            // Format building area
            const buildingArea = markerData.building_area ? `${markerData.building_area} m²` : 'N/A';

            // Format auction date
            let auctionDate = 'N/A';
            if (markerData.auction_date) {
                const dateObj = new Date(markerData.auction_date);
                if (!isNaN(dateObj)) {
                    auctionDate = dateObj.toLocaleDateString();
                }
            }

            // Format utilities
            const gas = markerData.gas === 'Yes' ?
                '<span class="badge badge-success">Yes</span>' :
                '<span class="badge badge-danger">No</span>';

            const water = markerData.water === 'Yes' ?
                '<span class="badge badge-success">Yes</span>' :
                '<span class="badge badge-danger">No</span>';

            const electricity = markerData.electricity === 'Yes' ?
                '<span class="badge badge-success">Yes</span>' :
                '<span class="badge badge-danger">No</span>';

            // Building type badge
            let buildingTypeBadge = '';
            switch (markerData.building_type) {
                case 'yer':
                    buildingTypeBadge = '<span class="badge badge-danger">Yer</span>';
                    break;
                case 'TurarBino':
                    buildingTypeBadge = '<span class="badge badge-warning">Turar Bino</span>';
                    break;
                case 'NoturarBino':
                    buildingTypeBadge = '<span class="badge badge-info">Noturar Bino</span>';
                    break;
                default:
                    buildingTypeBadge = '<span class="badge badge-primary">' + markerData.building_type + '</span>';
            }

            // Generate QR Code URL
            const qrCodeUrl = `${baseUrl}/api/lot/qr-code/${markerData.lat}/${markerData.lng}`;

            // Share URL
            const shareUrl =
                `${window.location.origin}${window.location.pathname}?lat=${markerData.lat}&lng=${markerData.lng}`;
            sidebar.innerHTML = `
                <span class="close-btn">&times;</span>
                <div class="info-content">
                    <img class="custom_sidebar_image" src="${markerData.main_image}" alt="Маркер расми" onerror="this.src='https://cdn.dribbble.com/users/1651691/screenshots/5336717/404_v2.png'"/>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <button id="toggle-currency-btn">${isInUSD ? 'Валютани таҳрирлаш UZS' : 'Валютани таҳрирлаш USD'}</button>
                        <div>
                            <button class="btn-link" onclick="window.open('https://www.google.com/maps/dir/?api=1&destination=${markerData.lat},${markerData.lng}', '_blank')" style="padding: 5px 10px; margin-left: 5px;">
                                <i class="fas fa-directions"></i> Йўналишлар
                            </button>
                            <button class="btn-link" onclick="copyToClipboard('${shareUrl}')" style="padding: 5px 10px; margin-left: 5px;">
                                <i class="fas fa-share-alt"></i> Улашиш
                            </button>
                        </div>
                    </div>

                    <h4 class="custom_sidebar_title"><b>${markerData.property_name || 'Сарлавҳа йўқ'}</b></h4>

                    <div class="sidebar-tabs">
                        <div class="sidebar-tab active" data-tab="basic-info">Асосий маълумот</div>
                        <div class="sidebar-tab" data-tab="details">Тафсилотлар</div>
                        <div class="sidebar-tab" data-tab="auction">Аукцион</div>
                        <div class="sidebar-tab" data-tab="additional">Лойиҳа</div>
                    </div>

                    <div id="basic-info" class="tab-content active">
                        <table>
     <tr>
                                <th class="sidebar_key">Уникал рақами</th>
                                <td>${markerData.kadastr_raqami || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Лот рақами</th>
                                <td>${markerData.lot_number || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Манзили</th>
                                <td>${markerData.address || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Бино тури</th>
                                <td>${buildingTypeBadge || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Фаолият Тури</th>
                                <td>${markerData.building_type_comment || 'Мавжуд эмас'}</td>
                            </tr>

                            <tr>
                                <th class="sidebar_key">Ер майдони</th>
                                <td>${markerData.land_area || 'Мавжуд эмас'} га</td>
                            </tr>

                            <tr>
                                <th class="sidebar_key">Фойдаланишга топшириш муддати</th>
                                <td>
                                    ${markerData.land_area_comment ? `<span class="land-area-timeframe">(Муддати: ${markerData.land_area_comment || 'Мавжуд эмас'})</span>` : ''}
                                </td>
                            </tr>


                        </table>
                    </div>

                    <div id="details" class="tab-content">
                        <table>
                            <tr>
                                <th class="sidebar_key">Ҳудуд</th>
                                <td>${markerData.address || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Коммунал хизматлар</th>
                                <td>
                                    <div>Газ: ${gas}</div>
                                    <div>Сув: ${water}</div>
                                    <div>Электр: ${electricity}</div>
                                </td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Зона</th>
                                <td>${markerData.zone || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Координаталар</th>
                                <td>${markerData.lat}, ${markerData.lng}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Яратувчи</th>
                                <td>${markerData.user_name || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Боғланиш учун электрон почта</th>
                                <td>${markerData.user_email || 'Мавжуд эмас'}</td>
                            </tr>
                        </table>
                    </div>

                    <div id="auction" class="tab-content">
                        <table>
                            <tr>
                                <th class="sidebar_key">Аукцион санаси</th>
                                <td>${auctionDate}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Аукцион ҳолати</th>
                                <td>Сотилган</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Ғолиб номи</th>
                                <td>${markerData.winner_name || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Ғолиб телефони</th>
                                <td>${markerData.winner_phone || 'Мавжуд эмас'}</td>
                            </tr>
                            ${soldPriceUZS > 0 ? `
                                                                                                                                                            <tr>
                                                                                                                                                                <th class="sidebar_key">Сотилган нархи</th>
                                                                                                                                                                <td>${soldPriceFormatted}</td>
                                                                                                                                                            </tr>` : ''}
                            <tr>
                                <th class="sidebar_key">Тўлов тури</th>
                                <td>${markerData.payment_type || 'Мавжуд эмас'}</td>
                            </tr>
                        </table>
                    </div>

                    <div id="additional" class="tab-content">
                        <table>
                            <tr>
                                <th class="sidebar_key">Инвестиция миқдори</th>
                                <td>${markerData.investment_amount || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Яратиладиган иш ўринлари</th>
                                <td>${markerData.job_creation_count || 'Мавжуд эмас'}</td>
                            </tr>
                            <tr>
                                <th class="sidebar_key">Қўшимча маълумот</th>
                                <td><pre style="white-space: pre-wrap; margin: 0;">${markerData.additional_info || 'Мавжуд эмас'}</pre></td>
                            </tr>
                        </table>


                    </div>

                    <div style="margin-top: 15px;">
                        ${markerData.lot_link ? `<a target="_blank" href="${markerData.lot_link}" class="btn-link"><i class="fas fa-external-link-alt"></i> Ташқи лотни кўриш</a>` : ''}
                        ${markerData.id ? `<a target="_blank" href="${baseUrl}/aktivs/${markerData.id}" class="btn-link"><i class="fas fa-info-circle"></i> Тўлиқ маълумотларни кўриш</a>` : ''}

                        @if (Auth::check())
                        ${markerData.id ? `<a target="_blank" href="${baseUrl}/aktivs/${markerData.id}/edit" class="btn-link"><i class="fas fa-edit"></i> Таҳрирлаш</a>` : ''}
                        @endif
                    </div>
                </div>
            `;
            // Add event listeners to tabs
            const tabButtons = sidebar.querySelectorAll('.sidebar-tab');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabButtons.forEach(btn => btn.classList.remove('active'));

                    // Hide all tab contents
                    const tabContents = sidebar.querySelectorAll('.tab-content');
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Show the corresponding tab content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        }

        function copyToClipboard(text) {
            // Create a temporary input element
            const input = document.createElement('input');
            input.value = text;
            document.body.appendChild(input);

            // Select and copy the text
            input.select();
            document.execCommand('copy');

            // Remove the temporary element
            document.body.removeChild(input);

            // Show feedback to user
            alert('Link copied to clipboard!');
        }

        function setupEventListeners() {
            document.addEventListener('click', function(event) {
                if (event.target.matches('.close-btn')) {
                    const sidebar = document.getElementById('info-sidebar');
                    sidebar.classList.remove('open');

                    // Remove URL parameters for sharing
                    const newUrl = new URL(window.location.href);
                    newUrl.searchParams.delete('lat');
                    newUrl.searchParams.delete('lng');
                    window.history.replaceState({}, '', newUrl);
                } else if (event.target.matches('#toggle-currency-btn')) {
                    const sidebar = document.getElementById('info-sidebar');
                    const isInUSD = sidebar.getAttribute('data-currency') === 'USD';
                    sidebar.setAttribute('data-currency', isInUSD ? 'UZS' : 'USD');
                    event.target.textContent = isInUSD ? 'Valyutani tahrirlash USD' :
                        'Valyutani tahrirlash UZS';

                    const currentTitle = sidebar.querySelector('.custom_sidebar_title b').textContent;
                    const markerData = window.markers.find(marker => marker.property_name === currentTitle);

                    if (markerData) {
                        if (usdRate !== null || !isInUSD) {
                            updateSidebarContent(markerData, !isInUSD, usdRate);
                        } else {
                            alert('USD rate is not available at the moment. Please try again later.');
                        }
                    }
                }
            });

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(event) {
                const urlParams = new URLSearchParams(window.location.search);
                const urlLat = parseFloat(urlParams.get('lat'));
                const urlLng = parseFloat(urlParams.get('lng'));

                if (urlLat && urlLng) {
                    // Find marker at these coordinates
                    const markerData = window.markers?.find(m =>
                        Math.abs(parseFloat(m.lat) - urlLat) < 0.0001 &&
                        Math.abs(parseFloat(m.lng) - urlLng) < 0.0001
                    );

                    if (markerData) {
                        const sidebar = document.getElementById('info-sidebar');
                        const isInUSD = sidebar.getAttribute('data-currency') === 'USD';
                        updateSidebarContent(markerData, isInUSD, usdRate);
                        sidebar.classList.add('open');

                        map.setCenter({
                            lat: urlLat,
                            lng: urlLng
                        });
                        map.setZoom(17);
                    }
                } else {
                    // Close sidebar when no coordinates in URL
                    const sidebar = document.getElementById('info-sidebar');
                    sidebar.classList.remove('open');
                }
            });
        }

        // Handle District Selection and KML Files
        function handleDistrict(map) {
            let polygons = {};
            let currentHighlight = null;

            const defaultColor = 'lightgreen';
            const highlightColor = '#ee6b6e';

            const kmlFileNames = [
                'bektemir.xml', 'chilonzor.xml', 'mirabod.xml', 'mirzo_ulugbek.xml', 'olmazor.xml',
                'sergeli.xml', 'shayhontaxur.xml', 'uchtepa.xml', 'yakkasaroy.xml', 'yashnabod.xml',
                'yunusabod.xml', 'yangihayot.xml'
            ];

            // Load KML files in sequence to avoid overwhelming the browser
            loadKmlFilesSequentially(kmlFileNames, defaultColor, map, polygons, 0);

            document.getElementById('xml-selector').addEventListener('change', function(event) {
                const selectedFile = event.target.value;
                if (selectedFile) {
                    if (currentHighlight && currentHighlight !== 'tashkent') {
                        setPolygonColor(currentHighlight, defaultColor, polygons);
                    }

                    if (selectedFile === 'tashkent') {
                        map.setCenter(TASHKENT_CENTER);
                        map.setZoom(ZOOM_LEVEL);
                        fetchDistrictInfo('tashkent');
                        currentHighlight = 'tashkent';
                    } else {
                        processKML(selectedFile, highlightColor, map, polygons);
                        currentHighlight = selectedFile;
                        fetchDistrictInfo(selectedFile);
                    }
                }
            });

            function loadKmlFilesSequentially(fileNames, color, map, polygons, index) {
                if (index >= fileNames.length) return;

                processKML(fileNames[index], color, map, polygons)
                    .then(() => {
                        // Process next file after a short delay
                        setTimeout(() => {
                            loadKmlFilesSequentially(fileNames, color, map, polygons, index + 1);
                        }, 50);
                    })
                    .catch(error => {
                        console.error(`Error loading ${fileNames[index]}:`, error);
                        // Continue with next file despite errors
                        setTimeout(() => {
                            loadKmlFilesSequentially(fileNames, color, map, polygons, index + 1);
                        }, 50);
                    });
            }

            function processKML(fileName, color, map, polygons) {
                return new Promise((resolve, reject) => {
                    fetch(`{{ asset('xml-map') }}/${fileName}`)
                        .then(response => response.text())
                        .then(kmlText => {
                            const paths = parseKML(kmlText);
                            if (paths.length > 0) {
                                addPolygon(fileName, [paths], color, map, polygons);

                                // Only fit bounds when explicitly selecting a district
                                if (color === highlightColor) {
                                    const bounds = new google.maps.LatLngBounds();
                                    paths.forEach(coord => bounds.extend(new google.maps.LatLng(coord.lat,
                                        coord.lng)));
                                    map.fitBounds(bounds);
                                }
                            }
                            resolve();
                        })
                        .catch(error => {
                            console.error(`Error fetching ${fileName}:`, error);
                            reject(error);
                        });
                });
            }

            function addPolygon(fileName, paths, fillColor, map, polygons) {
                if (polygons[fileName]) {
                    polygons[fileName].forEach(polygon => polygon.setMap(null));
                }

                const polygonArray = paths.map(path => {
                    const polygon = new google.maps.Polygon({
                        paths: path,
                        strokeColor: 'red',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: fillColor,
                        fillOpacity: 0.35,
                        map: map
                    });
                    return polygon;
                });

                polygons[fileName] = polygonArray;
            }

            function setPolygonColor(fileName, color, polygons) {
                if (polygons[fileName]) {
                    polygons[fileName].forEach(polygon => polygon.setOptions({
                        fillColor: color
                    }));
                }
            }

            function parseKML(kmlText) {
                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(kmlText, "application/xml");
                const coordinates = xmlDoc.getElementsByTagName('coordinates')[0]?.textContent.trim();
                return coordinates ? coordinates.split(' ').map(coord => {
                    const [lng, lat] = coord.split(',').map(Number);
                    return {
                        lat,
                        lng
                    };
                }) : [];
            }

            // Жорий сана ва вақт (UTC - YYYY-MM-DD HH:MM:SS форматида): 2025-04-18 05:52:10
            // Жорий фойдаланувчи логини: InvestUz

            function fetchDistrictInfo(districtFile) {
                const districtInfo = {
                    'bektemir.xml': {
                        name: 'Бектемир',
                        maydoni: '32.0 (км²)',
                        aholiSoni: '60,5 минг',
                        TumanlarSoni: '20',
                        MahallaSoni: '18',
                        savdodaTurganJamiSoni: '-'
                    },
                    'chilonzor.xml': {
                        name: 'Чилонзор',
                        maydoni: '30,0 (км²)',
                        aholiSoni: '275,1 минг',
                        TumanlarSoni: '45',
                        MahallaSoni: '45',
                        savdodaTurganJamiSoni: '-'
                    },
                    'mirabod.xml': {
                        name: 'Миробод',
                        maydoni: '17,0 (км²)',
                        aholiSoni: '152,2 минг',
                        TumanlarSoni: '30',
                        MahallaSoni: '39',
                        savdodaTurganJamiSoni: '-'
                    },
                    'mirzo_ulugbek.xml': {
                        name: 'Мирзо Улуғбек',
                        maydoni: '59,06 (км²)',
                        aholiSoni: '331,2 минг',
                        TumanlarSoni: '35',
                        MahallaSoni: '70',
                        savdodaTurganJamiSoni: '-'
                    },
                    'olmazor.xml': {
                        name: 'Олмазор',
                        maydoni: '34,0 (км²)',
                        aholiSoni: '404,4 минг',
                        TumanlarSoni: '50',
                        MahallaSoni: '64',
                        savdodaTurganJamiSoni: '-'
                    },
                    'sergeli.xml': {
                        name: 'Сергели',
                        maydoni: '54,75 (км²)',
                        aholiSoni: '168,2 минг',
                        TumanlarSoni: '55',
                        MahallaSoni: '46',
                        savdodaTurganJamiSoni: '-'
                    },
                    'shayhontaxur.xml': {
                        name: 'Шайхонтоҳур',
                        maydoni: '27,0 (км²)',
                        aholiSoni: '365,4 минг',
                        TumanlarSoni: '15',
                        MahallaSoni: '51',
                        savdodaTurganJamiSoni: '-'
                    },
                    'uchtepa.xml': {
                        name: 'Учтепа',
                        maydoni: '28,0 (км²)',
                        aholiSoni: '299,4 минг',
                        TumanlarSoni: '60',
                        MahallaSoni: '60',
                        savdodaTurganJamiSoni: '-'
                    },
                    'yakkasaroy.xml': {
                        name: 'Яккасарой',
                        maydoni: '14,0 (км²)',
                        aholiSoni: '133,4 минг',
                        TumanlarSoni: '40',
                        MahallaSoni: '21',
                        savdodaTurganJamiSoni: '-'
                    },
                    'yashnabod.xml': {
                        name: 'Яшнобод',
                        maydoni: '67,42 (км²)',
                        aholiSoni: '300,1 минг',
                        TumanlarSoni: '25',
                        MahallaSoni: '67',
                        savdodaTurganJamiSoni: '-'
                    },
                    'yunusabod.xml': {
                        name: 'Юнусобод',
                        maydoni: '41,0 (км²)',
                        aholiSoni: '376,1 минг',
                        TumanlarSoni: '30',
                        MahallaSoni: '64',
                        savdodaTurganJamiSoni: '-'
                    },
                    'yangihayot.xml': {
                        name: 'Янгиҳаёт',
                        maydoni: '44,2 (км²)',
                        aholiSoni: '174,7 минг',
                        TumanlarSoni: '52',
                        MahallaSoni: '30',
                        savdodaTurganJamiSoni: '-'
                    },
                    'tashkent': {
                        name: 'Тошкент',
                        maydoni: '43,5 (км²)',
                        aholiSoni: '3 млн',
                        TumanlarSoni: '12',
                        MahallaSoni: '585',
                        savdodaTurganJamiSoni: '-'
                    } // Тошкент учун статик маълумот
                };

                // Танланган туман учун маълумотни олиш
                const info = districtInfo[districtFile] || {
                    name: '',
                    maydoni: 'Мавжуд эмас',
                    aholiSoni: 'Мавжуд эмас',
                    TumanlarSoni: 'Мавжуд эмас',
                    MahallaSoni: 'Мавжуд эмас',
                    savdodaTurganJamiSoni: '-'
                };

                updateInfoTable(info);
            }

            function updateInfoTable(data) {
                // Маълумотлар массивини шартли равишда яратиш
                const info = [{
                        metric: 'Майдони',
                        value: data.maydoni
                    },
                    {
                        metric: 'Аҳоли сони',
                        value: data.aholiSoni
                    },
                    // 'Туманлар сони'ни фақат исм 'Тошкент' бўлганда қўшиш
                    ...(data.name === 'Тошкент' ? [{
                        metric: 'Туманлар сони',
                        value: data.TumanlarSoni
                    }] : []),
                    {
                        metric: 'Маҳалла сони',
                        value: data.MahallaSoni
                    },
                    {
                        metric: 'Объектлар',
                        value: data.savdodaTurganJamiSoni
                    }
                ];

                // Туман номини янгилаш
                document.getElementById('district-name').textContent = data.name || 'Мавжуд эмас';

                // Жадвални берилган маълумотлар билан янгилаш
                updateTable(info);
            }

            function updateTable(info) {
                // Жадвал танасини олиш
                const tableBody = document.getElementById('info-table').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // Мавжуд қаторларни тозалаш

                // Жадвалга қаторлар қўшиш
                info.forEach(item => {
                    const row = document.createElement('tr');
                    const metricCell = document.createElement('td');
                    metricCell.textContent = item.metric;
                    const valueCell = document.createElement('td');
                    valueCell.textContent = item.value;
                    row.appendChild(metricCell);
                    row.appendChild(valueCell);
                    tableBody.appendChild(row);
                });
            }
        }
    </script>

    <!-- Additional information for page footer -->
    <footer class="footer-info" style="display: none;">
        <div class="container">
            <p>Page generated for InvestUz on 2025-04-16 12:57:47</p>
            <p>© 2025 Toshkent Invest. All Rights Reserved.</p>
        </div>
    </footer>
</body>

</html>
