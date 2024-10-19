
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="<?=base_url('dashboard')?>" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i><?=$_ENV['name']?></h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="<?=base_url('assets/dashmin-1.0.0/')?>img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    
                    <div class="ms-3">
                        <h6 class="mb-0"><?=session()->get('username')?></h6>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="<?=base_url('admin/dashboard')?>" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-hashtag  me-2"></i>CMS</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="<?=base_url('admin/sejarah')?>" class="dropdown-item">Sejarah</a>
                            <a href="<?=base_url('admin/visimisi')?>" class="dropdown-item">Visi&misi</a>
                            <a href="<?=base_url('admin/informasi')?>" class="dropdown-item">Informasi</a>
                            <a href="<?=base_url('admin/kegiatan')?>" class="dropdown-item">Kegiatan</a>
                            <a href="<?=base_url('admin/content')?>" class="dropdown-item">Konten</a>
                        </div>
                    </div>
                   <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-credit-card me-2"></i>Management</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="<?=base_url('admin/struktur')?>" class="dropdown-item">struktur</a>
                            <a href="<?=base_url('admin/jadwalacara')?>" class="dropdown-item">Jadwal</a>
                            <a href="<?=base_url('admin/pengisiacara')?>" class="dropdown-item">Jadwal Pengisi Acara</a>
                            <a href="<?=base_url('admin/keuangan')?>" class="dropdown-item">Keuangan</a>
                            <a href="<?=base_url('admin/user')?>" class="dropdown-item">User</a>
                        </div>
                    </div>
                </div>

            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto h1" ><?php if (isset($title)){echo $title;}?></div>

                <div class="navbar-nav align-items-center ms-auto">
             
                 
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="<?=base_url('assets/dashmin-1.0.0/')?>img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?=session()->get('username')?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="<?=base_url('auth/logout')?>" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
