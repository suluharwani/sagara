<body>
	<div class="body">

		<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 120, 'stickySetTop': 0}">
			<div class="header-body">
				<div class="header-top" style="background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);">
					<div class="header-top-container container">
						<div class="header-row">
							<div class="header-column justify-content-start">
								<span class="d-none d-sm-flex align-items-center">
									<i class="fas fa-map-marker-alt text-warning me-1"></i>
									&nbsp;
									<a href="#" class="text-white">
										Penganten, Kec. Klambu, Kab. Grobogan, Jawa Tengah
									</a>
								</span>
								<span class="d-none d-sm-flex align-items-center ms-4">
									<i class="fas fa-phone text-warning me-1"></i>
									&nbsp;
									<a href="tel:+6281327341834" class="text-white">+62 813-2734-1834</a>
								</span>
							</div>
							<div class="header-column justify-content-end">
								<ul class="nav">
									<li class="nav-item">
										<a class="nav-link text-white" href="<?= base_url('contact') ?>">Contact Us</a>
									</li>
								</ul>
								<ul class="header-top-social-icons social-icons social-icons-transparent d-none d-md-block">
									<li class="social-icons-facebook">
										<a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
									</li>
									<li class="social-icons-instagram">
										<a href="http://www.instagram.com/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
									</li>
									<li class="social-icons-whatsapp">
										<a href="https://wa.me/6281327341834" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="header-container container" style="background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);">
					<div class="header-row">
						<div class="header-column justify-content-start">
							<div class="header-logo">
								<a href="<?= base_url() ?>">
									Sagara Jersey
								</a>
							</div>
						</div>
						<div class="header-column justify-content-end">
							<div class="header-nav">
								<div class="header-nav-main header-nav-main-uppercase header-nav-main-effect-1 header-nav-main-sub-effect-1">
									<nav class="collapse">
										<ul class="nav flex-column flex-lg-row" id="mainNav">
											<li class="nav-item">
												<a class="nav-link" href="<?= base_url() ?>">Home</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="<?= base_url('product') ?>">Produk</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="<?= base_url('blog') ?>">Blog</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="<?= base_url('informations') ?>">Informasi</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="<?= base_url('contact') ?>">Kontak</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="<?= base_url('tracking') ?>">Tracking</a>
											</li>
										</ul>
									</nav>
								</div>

								<div class="header-button d-none d-sm-flex ms-3">
									<a href="<?= base_url('dashboard') ?>" class="btn btn-outline btn-rounded btn-success btn-4 btn-icon-effect-1">
										<span class="wrap">
											<span>Dashboard</span>
											<i class="fas fa-user"></i>
										</span>
									</a>
								</div>
								<button class="header-btn-collapse-nav ms-3" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
									<span class="hamburguer">
										<span></span>
										<span></span>
										<span></span>
									</span>
									<span class="close">
										<span></span>
										<span></span>
									</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<script type="text/javascript" src="<?= base_url() ?>/assets/js/menu.js"></script>