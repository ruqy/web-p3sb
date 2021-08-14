<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-laptop"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SISMA P3SB</div>
            </a>

            <!-- Query Menu -->
            <?php
            $menu = $this->menuModel->get_menu();

            ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- LOOPING MENU -->
            <?php foreach ($menu as $m) : ?>
            <!-- Heading -->
            <div class="sidebar-heading">
                <?= $m['menu']; ?>
            </div>

            <!-- QUERY SUB MENU -->
            <?php $submenu = $this->menuModel->get_sub_menu($m['id']); ?>

            <!-- LOOPING SUBMENU -->
            <?php foreach ($submenu as $sm) : ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= ($heading == $sm['submenu']) ? 'active' : ''; ?>">
                <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                    <i class="<?= $sm['icon']; ?>"></i>
                    <span><?= $sm['submenu']; ?></span></a>
            </li>
            <?php endforeach; ?>

            <!-- Divider -->
            <hr class="sidebar-divider mt-3">

            <?php endforeach; ?>


            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link pt-0" href="<?= base_url('auth/logout'); ?>">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->