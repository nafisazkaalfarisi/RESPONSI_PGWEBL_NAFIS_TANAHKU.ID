<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Tanahku.id')); ?></title>

    <link rel="icon" href="<?php echo e(asset('images/tanahku.png')); ?>" type="image/png">


    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
        }

        body.bg-dark .sidebar {
            background-color: #1f1f1f;
        }


        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #0d6efd;
            /* Warna biru solid */
            transition: width 0.3s;
            overflow-x: hidden;
            color: white;
            z-index: 1000;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }


        .sidebar.collapsed {
            width: 70px;
        }


        .sidebar-header {
            font-size: 1.4rem;
            padding: 1.2rem;
            text-align: center;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-header i {
            font-size: 1.6rem;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar ul.nav {
            list-style: none;
            padding: 0;
        }

        .sidebar ul.nav li {
            padding: 0.8rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .sidebar ul.nav li:hover,
        .sidebar ul.nav li.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar ul.nav li i {
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }


        .sidebar.collapsed li span {
            display: none;
        }

        .content {
            margin-left: 250px;
            padding: 1.5rem;
            transition: margin-left 0.3s;
        }

        .content.full {
            margin-left: 70px;
        }

        .toggle-btn {
            position: absolute;
            top: 1rem;
            left: 260px;
            z-index: 1100;
            transition: left 0.3s;
        }

        .sidebar.collapsed+.toggle-btn {
            left: 80px;
        }

        .sidebar.collapsed .nav .text-uppercase {
            display: none;
        }


        .toggle-btn .btn {
            background-color: #0d6efd;
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1050;
            }

            .toggle-btn {
                left: 70px;
            }

            .sidebar.collapsed+.toggle-btn {
                left: 80px;
            }

            .content {
                margin-left: 70px;
            }

            .content.full {
                margin-left: 70px;
            }
        }
    </style>

    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body class="<?php echo e(session('theme', 'light') === 'dark' ? 'bg-dark text-light' : ''); ?>">

    
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header d-flex align-items-center justify-content-center">
    <img src="<?php echo e(asset('images/tanahku.png')); ?>" alt="Tanahku.id Logo"
         style="height: 48px; width: auto;" class="me-2">
    <span class="logo-text">Tanahku.id</span>
</div>

        <ul class="nav flex-column mt-3">

            
            <li class="text-uppercase fw-bold small px-3 mt-2">Navigasi</li>

            <li class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" onclick="location.href='<?php echo e(route('home')); ?>'">
                <i class="fas fa-home"></i> <span>Home</span>
            </li>
            <li class="<?php echo e(request()->routeIs('map') ? 'active' : ''); ?>" onclick="location.href='<?php echo e(route('map')); ?>'">
                <i class="fas fa-map-marked-alt"></i> <span>Peta</span>
            </li>
            <li class="<?php echo e(request()->routeIs('table') ? 'active' : ''); ?>"
                onclick="location.href='<?php echo e(route('table')); ?>'">
                <i class="fas fa-table"></i> <span>Tabel</span>
            </li>
            <li class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"
                onclick="location.href='<?php echo e(route('dashboard')); ?>'">
                <i class="fas fa-chart-line"></i> <span>Dashboard</span>
            </li>

            <?php if(auth()->guard()->check()): ?>
                
                <li class="text-uppercase fw-bold small px-3 mt-4">Pengguna</li>

                <li class="<?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>"
                    onclick="location.href='<?php echo e(route('profile.edit')); ?>'">
                    <i class="fas fa-user-circle"></i> <span>Profil</span>
                </li>
                <?php
                    $unread = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;
                ?>

                <li class="<?php echo e(request()->routeIs('notifications') ? 'active' : ''); ?>"
                    onclick="location.href='<?php echo e(route('notifications')); ?>'">
                    <i class="fas fa-bell"></i>
                    <span>
                        Notifikasi
                        <?php if($unread > 0): ?>
                            <span class="badge bg-danger ms-1"><?php echo e($unread); ?></span>
                        <?php endif; ?>
                    </span>
                </li>


                
                <li class="text-uppercase fw-bold small px-3 mt-4">Lainnya</li>

                <li class="<?php echo e(request()->routeIs('settings') ? 'active' : ''); ?>"
                    onclick="location.href='<?php echo e(route('settings')); ?>'">
                    <i class="fas fa-cog"></i> <span>Settings</span>
                </li>
                <li class="<?php echo e(request()->routeIs('help') ? 'active' : ''); ?>"
                    onclick="location.href='<?php echo e(route('help')); ?>'">
                    <i class="fas fa-question-circle"></i> <span>Bantuan</span>
                </li>

                
                <li class="text-uppercase fw-bold small px-3 mt-4">Keluar</li>

                <li onclick="confirmLogout()" style="cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>

            <?php endif; ?>

        </ul>

    </div>


    
    <div class="toggle-btn" id="toggleBtn">
        <button class="btn btn-sm" onclick="toggleSidebar()" id="toggleIconBtn">
            <span id="toggleIcon">«</span>
        </button>
    </div>




    
    <div class="content" id="mainContent">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('toggleBtn');
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('full');

            // Ubah ikon panah
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.textContent = '»'; // tampilkan panah kanan
            } else {
                toggleIcon.textContent = '«'; // tampilkan panah kiri
            }
        }
    </script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('toggleBtn');
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('full');

            // Ubah ikon panah
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.textContent = '»'; // tampilkan panah kanan
            } else {
                toggleIcon.textContent = '«'; // tampilkan panah kiri
            }
        }

        function confirmLogout() {
            if (confirm("Apakah kamu yakin ingin logout?")) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/layouts/app.blade.php ENDPATH**/ ?>