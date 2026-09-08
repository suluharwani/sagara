<footer id="footer" class="footer-dark" style="background: linear-gradient(135deg, #1565c0 0%, #1976d2 100%);">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="text-white">Sagara Jersey</h5>
                <p class="mt-3 text-white" style="opacity: 0.9;">Percetakan jersey dan kaos custom berkualitas tinggi. Desain bebas, bahan premium, pengiriman ke seluruh Indonesia.</p>
                <ul class="social-icons">
                    <li class="social-icons-facebook"><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="social-icons-instagram"><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li class="social-icons-whatsapp"><a href="https://wa.me/6282137300307" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h5 class="text-white">Menu</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><a href="<?= base_url('product') ?>">Produk</a></li>
                    <li><a href="<?= base_url('blog') ?>">Blog</a></li>
                    <li><a href="<?= base_url('contact') ?>">Kontak</a></li>
                    <li><a href="<?= base_url('tracking') ?>">Tracking</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5 class="text-white">Layanan</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Jersey Custom</a></li>
                    <li><a href="#">Kaos Custom</a></li>
                    <li><a href="#">Seragam Kerja</a></li>
                    <li><a href="#">Jacket Custom</a></li>
                    <li><a href="#">Hoodie Custom</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5 class="text-white">Kontak</h5>
                <ul class="list-unstyled footer-links">
                    <li><i class="fas fa-map-marker-alt me-2"></i> Penganten, Klambu, Grobogan</li>
                    <li><i class="fas fa-phone me-2"></i> +62 821-3730-0307</li>
                    <li><i class="fas fa-envelope me-2"></i> info@sagarajersey.com</li>
                </ul>
            </div>
        </div>
        <hr style="border-color: rgba(255,255,255,0.3);">
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-white mb-0">&copy; 2026 Sagara Jersey. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>
		</div>

		<!-- Vendor -->
		<script src="<?=base_url('assets/HTML')?>/vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/jquery.cookie/jquery.cookie.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/common/common.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/jquery.validation/jquery.validate.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/isotope/jquery.isotope.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/vide/jquery.vide.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/vivus/vivus.min.js"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="<?=base_url('assets/HTML')?>/js/theme.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="<?=base_url('assets/HTML')?>/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script src="<?=base_url('assets/HTML')?>/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

		<!-- Theme Custom -->
		<script src="<?=base_url('assets/HTML')?>/js/custom.js"></script>

		<!-- Theme Initialization Files -->
		<script async src="<?=base_url('assets/HTML')?>/js/theme.init.js"></script>

	</body>
</html>

<style>
.footer-dark {
    padding: 60px 0 30px;
    color: #fff;
}
.footer-dark h5 {
    color: #fff;
    margin-bottom: 20px;
}
.footer-links li {
    margin-bottom: 10px;
}
.footer-links a {
    color: rgba(255,255,255,0.85);
    text-decoration: none;
    transition: color 0.3s ease;
}
.footer-links a:hover {
    color: #ffc107;
}
.footer-dark .social-icons {
    padding: 0;
    list-style: none;
    display: flex;
    gap: 10px;
}
.footer-dark .social-icons a {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    transition: all 0.3s ease;
}
.footer-dark .social-icons a:hover {
    background: #ffc107;
    color: #1a1a2e;
}
</style>
