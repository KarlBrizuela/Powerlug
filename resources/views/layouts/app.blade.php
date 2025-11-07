<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Powerlug')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Powerlug" name="description" />
    <meta content="Powerlug" name="author" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Material Design Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
    <!-- MetisMenu CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.css">
    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"/>
    
    <style>
        :root {
            --primary: #2c80ff;
            --secondary: #6c757d;
            --success: #34c38f;
            --info: #50a5f1;
            --warning: #f1b44c;
            --danger: #f46a6a;
            --light: #f8f9fa;
            --dark: #343a40;
            --sidebar-bg: #ffffff;
            --sidebar-width: 250px;
            --header-height: 70px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #495057;
        }

        /* Sidebar Styles */
        .vertical-menu {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        #sidebar-menu {
            padding: 15px 0;
        }

        .menu-title {
            padding: 12px 20px;
            letter-spacing: .05em;
            pointer-events: none;
            cursor: default;
            font-size: 11px;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: 600;
        }

        .metismenu {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .metismenu li {
            display: block;
            width: 100%;
        }

        .metismenu a {
            display: block;
            padding: 12px 20px;
            color: #495057;
            position: relative;
            font-size: 14px;
            transition: all .4s;
            text-decoration: none;
        }

        .metismenu a i {
            display: inline-block;
            min-width: 1.75rem;
            padding-bottom: 3px;
            font-size: 15px;
            line-height: 1.40625rem;
            vertical-align: middle;
            color: #7c8a96;
            transition: all .4s;
        }

        .metismenu a:hover {
            color: var(--primary);
        }

        .metismenu a:hover i {
            color: var(--primary);
        }

        .metismenu a.active {
            color: var(--primary);
            background: rgba(44, 128, 255, 0.1);
        }

        .metismenu a.active i {
            color: var(--primary);
        }

        .metismenu .has-arrow:after {
            content: "\f107";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            display: block;
            float: right;
            transition: transform .2s;
            font-size: 1rem;
            margin-left: auto;
        }

        .metismenu .has-arrow[aria-expanded="true"]:after {
            transform: rotate(180deg);
        }

        .metismenu .sub-menu {
            list-style: none;
            padding-left: 0;
            display: none;
            background: rgba(0,0,0,0.02);
        }

        .metismenu .sub-menu a {
            padding-left: 45px;
        }

        .metismenu .sub-menu.show {
            display: block;
        }

        .metismenu .sub-menu a {
            padding: 8px 20px 8px 55px;
            font-size: 13px;
            color: #545a6d;
        }

        .metismenu .sub-menu a:hover {
            color: var(--primary);
        }

        .metismenu .sub-menu a.active {
            color: var(--primary);
            background: rgba(44, 128, 255, 0.1);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.3s;
            position: relative;
            z-index: 1;
            background-color: #f5f7fb;
        }

        .page-content {
            padding: 20px;
            position: relative;
        }

        @media (max-width: 991.98px) {
            .vertical-menu {
                display: none;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="layout-wrapper">
        <x-sidebar />
        
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            @yield('content')
        </div>
        <!-- end main content-->
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Feather icons
            feather.replace();
            
            // Initialize SimpleBar
            document.querySelectorAll('[data-simplebar]').forEach(el => new SimpleBar(el));
        });

        $(document).ready(function() {
            // Handle sidebar dropdowns
            $('.has-arrow').click(function(e) {
                e.preventDefault();
                $(this).toggleClass('active');
                $(this).attr('aria-expanded', $(this).attr('aria-expanded') === 'true' ? 'false' : 'true');
                $(this).next('.sub-menu').slideToggle(300);
            });
            
            // Auto-expand active menus on load
            $('.metismenu li a.active').parents('.sub-menu').show();
            $('.metismenu li a.active').parents('li').find('> a.has-arrow').addClass('active');
        });
    </script>
    @stack('scripts')
</body>
</html>