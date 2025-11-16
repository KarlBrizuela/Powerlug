<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root {
            --sidebar-bg: #ffffff;
            --sidebar-color: #6c757d;
            --sidebar-active-bg: #e9ecef;
            --sidebar-active-color: #495057;
            --sidebar-hover-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .vertical-menu {
            width: 250px;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }
        
        #layout-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .main-content {
            flex: 1;
            margin-left: 250px;
            overflow-x: hidden;
            position: relative;
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        
        .sidebar-logo {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        
        .sidebar-logo img {
            max-width: 200px;
            height: auto;
        }
        
        #sidebar-menu {
            padding: 15px 0;
        }
        
        .menu-title {
            padding: 10px 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .metismenu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .metismenu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--sidebar-color);
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            gap: 12px;
        }
        
        .metismenu a i,
        .metismenu a svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }
        
        .metismenu a:hover {
            background-color: var(--sidebar-hover-bg);
            color: var(--sidebar-active-color);
        }
        
        .metismenu a.active {
            background-color: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            border-left-color: #3498db;
        }
        
        .metismenu a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .has-arrow::after {
            content: "";
            width: 16px;
            height: 16px;
            display: inline-block;
            margin-left: auto;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236c757d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M9 18l6-6-6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            transition: transform 0.3s ease;
        }
        
        .has-arrow[aria-expanded="true"]::after {
            transform: rotate(90deg);
        }
        
        .metismenu .active > .has-arrow::after,
        .metismenu a:hover .has-arrow::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23495057' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M9 18l6-6-6-6'/%3E%3C/svg%3E");
        }
        
        .sub-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: rgba(0, 0, 0, 0.02);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .sub-menu.show {
            max-height: 500px;
            transition: max-height 0.3s ease-in;
        }
        
        .sub-menu a {
            padding-left: 50px;
            font-size: 0.9rem;
        }
        
        /* Mobile styles */
        @media (max-width: 768px) {
            .vertical-menu {
                width: 70px;
                transform: translateX(0);
                overflow: visible;
            }
            
            .vertical-menu.collapsed {
                transform: translateX(-100%);
            }
            
            .vertical-menu .menu-title,
            .vertical-menu span {
                display: none;
                gap:3px;
            }
            
            .sidebar-logo img {
                max-width: 40px;
            }
            
            .vertical-menu a {
                justify-content: center;
                padding: 15px 0;
            }
            
            .vertical-menu a i {
                margin-right: 0;
            }
            
            #layout-wrapper .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
                transition: all 0.3s;
            }
            
            .vertical-menu.collapsed ~ .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .vertical-menu .has-arrow::after {
                display: none;
            }
            
            .vertical-menu .sub-menu {
                position: absolute;
                left: 70px;
                top: 0;
                width: 200px;
                background-color: var(--sidebar-bg);
                box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
                display: none;
            }
            
            .vertical-menu .sub-menu.show {
                display: block;
            }
            
            .vertical-menu .sub-menu a {
                padding-left: 20px;
            }
        }
        
        /* Toggle button for mobile */
        .sidebar-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            display: none;
        }
        
        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }
            
            .vertical-menu.collapsed {
                transform: translateX(-100%);
            }
        }
    </style>
</head>
<body>
    <!-- Toggle Button for Mobile -->
    <button class="btn btn-primary sidebar-toggle d-md-none">
        <i data-feather="menu"></i>
    </button>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">
        <div class="sidebar-logo">
            <img src="public/images/logs.jpg" alt="logo" class="img-fluid">
        </div>
        <div data-simplebar class="h-100">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" data-key="t-menu">Menu</li>

                    @if(auth()->user()->position === 'superadmin')
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i data-feather="home"></i>
                            <span data-key="t-dashboard">Dashboard</span>
                        </a>
                    </li>
                    @endif

                   <li>
    <a href="{{ route('policy') }}" class="@if(request()->url() === route('policy')) active @endif">
        <i data-feather="file-text"></i>
        <span data-key="t-pages">Policy Form</span>
    </a>
</li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="layout"></i>
                            <span data-key="t-authentication">Claim Filing</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('claims.create') }}" class="{{ request()->routeIs('claims.create') ? 'active' : '' }}">
                                   Claim
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('walk-in.create') }}" class="{{ request()->routeIs('walk-in.create') ? 'active' : '' }}">
                                   walk-in
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-authentication">Client Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('clients.create') }}" class="{{ request()->routeIs('clients.create') ? 'active' : '' }}">
                                    New Client
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.index') ? 'active' : '' }}">
                                    Client List
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="briefcase"></i>
                            <span data-key="t-authentication">Insurance Provider</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('providers.create') }}" class="{{ request()->routeIs('providerd.create') ? 'active' : '' }}">
                                    New Insurance Provider
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('providers.index') }}" class="{{ request()->routeIs('providers.index') ? 'active' : '' }}">
                                    Insurance Provider List
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="database"></i>
                            <span data-key="t-authentication">Collection Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('collections.create') }}" class="{{ request()->routeIs('collections.create') ? 'active' : '' }}">
                                    New Collection
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('collections.index') }}" class="{{ request()->routeIs('collections.index') ? 'active' : '' }}">
                                    Collection List
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Freebies -->
                    <li>
                        <a href="{{ route('freebies.index') }}" class="{{ request()->routeIs('freebies.*') ? 'active' : '' }}">
                            <i data-feather="gift"></i>
                            <span data-key="t-pages">Freebies</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('audit-trail.index') }}" class="{{ request()->routeIs('audit-trail.index') ? 'active' : '' }}">
                            <i data-feather="settings"></i>
                            <span data-key="t-pages">Audit Trail</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('commission.index') }}" class="{{ request()->routeIs('commission.*') ? 'active' : '' }}">
                            <i data-feather="user"></i>
                            <span data-key="t-pages">Commission</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i data-feather="arrow-left"></i>
                            <span data-key="t-horizontal">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- Simplebar JS -->
    <script src="https://cdn.jsdelivr.net/npm/simplebar@5.3.9/dist/simplebar.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize Feather Icons with specific size
        feather.replace({ width: 16, height: 16 });
        
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.vertical-menu');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    if (mainContent) {
                        mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '0' : '70px';
                        mainContent.style.width = sidebar.classList.contains('collapsed') ? '100%' : 'calc(100% - 70px)';
                    }
                });
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    if (mainContent) {
                        mainContent.style.marginLeft = '250px';
                        mainContent.style.width = 'calc(100% - 250px)';
                    }
                    sidebar.classList.remove('collapsed');
                }
            });
            
            // Handle dropdown menus
            const dropdownLinks = document.querySelectorAll('.has-arrow');
            dropdownLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Toggle aria-expanded state
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                    
                    // Toggle submenu visibility
                    const submenu = this.nextElementSibling;
                    if (submenu && submenu.classList.contains('sub-menu')) {
                        submenu.classList.toggle('show');
                        
                        // Close other open submenus
                        const otherSubmenus = document.querySelectorAll('.sub-menu.show');
                        otherSubmenus.forEach(menu => {
                            if (menu !== submenu) {
                                menu.classList.remove('show');
                                menu.previousElementSibling.setAttribute('aria-expanded', 'false');
                            }
                        });
                    }
                });
            });
            
            // Dropdown functionality for mobile
            const hasArrowLinks = document.querySelectorAll('.has-arrow');
            
            hasArrowLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        const subMenu = this.nextElementSibling;
                        
                        // Close other open menus
                        document.querySelectorAll('.sub-menu.show').forEach(menu => {
                            if (menu !== subMenu) {
                                menu.classList.remove('show');
                            }
                        });
                        
                        // Toggle current menu
                        if (subMenu) {
                            subMenu.classList.toggle('show');
                        }
                    }
                });
            });
            
            // Close dropdowns when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!e.target.closest('.vertical-menu')) {
                        document.querySelectorAll('.sub-menu.show').forEach(menu => {
                            menu.classList.remove('show');
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>