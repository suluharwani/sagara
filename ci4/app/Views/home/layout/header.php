<body>
	<div class="body">

		<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 120, 'stickySetTop': 0}">
			<div class="header-body">
				<div class="header-top header-top-dark">
					<div class="header-top-container container">
						<div class="header-row">
							<div class="header-column justify-content-start">
								<span class="d-none d-sm-flex align-items-center">
									<i class="fas fa-map-marker-alt text-warning me-1"></i>
									&nbsp;
									<a href="#">
										Penganten,
										Kec. Klambu, Kab. Grobogan, Provinsi
										Jawa Tengah, Indonesia.
									</a>
								</span>
								<span class="d-none d-sm-flex align-items-center ms-4">
									<i class="fas fa-phone text-warning me-1"></i>
									&nbsp;
									<a href="tel:+6281327341834">+62 813-2734-1834</a>
								</span>
							</div>
							<div class="header-column justify-content-end">
								<ul class="nav">
									<li class="nav-item">
										<a class="nav-link" href="<?= base_url('contact') ?>">Contact Us</a>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link dropdown-menu-toggle py-2" id="dropdownLanguage" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											English <i class="fas fa-angle-down fa-sm"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLanguage">
											<li><a href="#" class="no-skin"><img src="<?= base_url('assets/HTML') ?>/img/blank.gif" class="flag flag-us" alt="English" /> English</a></li>
											<!-- <li><a href="#" class="no-skin"><img src="<?= base_url('assets/HTML') ?>/img/blank.gif" class="flag flag-es" alt="Español" /> Español</a></li>
											<li><a href="#" class="no-skin"><img src="<?= base_url('assets/HTML') ?>/img/blank.gif" class="flag flag-fr" alt="Française" /> Française</a></li> -->
										</ul>
									</li>
								</ul>
								<ul class="header-top-social-icons social-icons social-icons-transparent d-none d-md-block">
									<li class="social-icons-facebook">
										<a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
									</li>
									<li class="social-icons-twitter">
										<a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
									</li>
									<li class="social-icons-instagram">
										<a href="http://www.instagram.com/" target="_blank" title="Instragram"><i class="fab fa-instagram"></i></a>
									</li>
								</ul>

							</div>
						</div>
					</div>
				</div>
				<div class="header-container container">
					<div class="header-row">
						<div class="header-column justify-content-start">
							<div class="header-logo">
								<a href="<?= base_url() ?>">
									<img alt="Logo" height="80" style="z-index:-1; margin-top:5%" src="<?= base_url('assets/logo/images.png') ?>">
									<!-- <label class="brand-text">PT. Cendrawasih Digikarya Pertama</label> -->
								</a>
							</div>
						</div>
						<div class="header-column justify-content-end">
							<div class="header-nav">
								<div class="header-nav-main header-nav-main-uppercase header-nav-main-effect-1 header-nav-main-sub-effect-1">
									<nav class="collapse">
										<ul class="nav flex-column flex-lg-row" id="mainNav">

										</ul>
									</nav>
								</div>

								<div class="header-button d-none d-sm-flex ms-3">

									<?php if (isset($_SESSION['logoutButton'])) {
										echo $_SESSION['logoutButton'];
									} else { ?>
										<a href="<?= base_url('client') ?>" class="btn btn-outline btn-rounded btn-success btn-4 btn-icon-effect-1">
											<span class="wrap">
												<span>CLIENT AREA</span>
												<i class="fas fa-user"></i>
											</span>
										</a>
									<?php }
									?>
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