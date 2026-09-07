<section class="sagara-auth" aria-labelledby="client-login-title">
    <div class="auth-frame">
        <div class="auth-form-panel">
            <div class="auth-topline">
                <a class="auth-brand" href="<?= base_url() ?>" aria-label="Sagara Jersey, kembali ke beranda">
                    <span class="auth-mark">S</span>
                    <span>Member Area</span>
                </a>
                <a class="auth-back" href="<?= base_url() ?>">
                    <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Beranda
                </a>
            </div>

            <span class="auth-eyebrow">Area pelanggan</span>
            <h1 class="auth-title" id="client-login-title">Selamat datang kembali.</h1>
            <p class="auth-intro">Masuk untuk melanjutkan pesanan custom dan melihat informasi akun Anda.</p>

            <?php $validationErrors = session()->getFlashdata('errors'); ?>
            <?php if ($validationErrors): ?>
                <div class="auth-alert auth-alert-danger" role="alert">
                    <i class="fas fa-circle-exclamation mt-1" aria-hidden="true"></i>
                    <div>
                        <?php foreach ((array) $validationErrors as $error): ?>
                            <p><?= esc($error) ?></p>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($errorMessage = session()->getFlashdata('error')): ?>
                <div class="auth-alert auth-alert-danger" role="alert">
                    <i class="fas fa-circle-exclamation mt-1" aria-hidden="true"></i>
                    <p><?= esc($errorMessage) ?></p>
                </div>
            <?php endif; ?>

            <?php if ($successMessage = session()->getFlashdata('success')): ?>
                <div class="auth-alert auth-alert-success" role="status">
                    <i class="fas fa-circle-check mt-1" aria-hidden="true"></i>
                    <p><?= esc($successMessage) ?></p>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/process') ?>" method="post">
                <?= csrf_field() ?>

                <div class="auth-field">
                    <label class="auth-label" for="client-email">
                        <i class="fas fa-envelope" aria-hidden="true"></i> Email
                    </label>
                    <input class="auth-input" id="client-email" type="email" name="email" autocomplete="username" placeholder="nama@email.com" value="<?= esc(old('email')) ?>" required autofocus>
                </div>

                <div class="auth-field">
                    <label class="auth-label" for="client-password">
                        <i class="fas fa-lock" aria-hidden="true"></i> Password
                    </label>
                    <div class="auth-input-wrap">
                        <input class="auth-input" id="client-password" type="password" name="password" autocomplete="current-password" placeholder="Masukkan password" required>
                        <button class="auth-password-toggle" type="button" data-password-toggle data-target="client-password" aria-label="Tampilkan password" aria-pressed="false">
                            <i class="fas fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <div class="auth-actions">
                    <label class="auth-check" for="remember">
                        <input type="checkbox" name="remember" id="remember">
                        Ingat saya
                    </label>
                    <a class="auth-inline-link" href="<?= base_url('forgot-password') ?>">Lupa password?</a>
                </div>

                <button class="auth-submit" type="submit">
                    Masuk ke Akun <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </button>
            </form>

            <div class="auth-divider"><span>atau</span></div>
            <a href="<?= base_url('login/google') ?>" class="auth-google">
                <img src="<?= base_url('assets/logo/google.png') ?>" alt="" aria-hidden="true">
                Masuk dengan Google
            </a>

            <p class="auth-footer">Belum punya akun? <a href="<?= base_url('register') ?>">Daftar sekarang</a></p>
        </div>

        <aside class="auth-panel" aria-label="Keuntungan akun pelanggan">
            <span class="auth-panel-badge">Custom wear, your way</span>
            <div class="auth-panel-content">
                <p class="auth-panel-kicker">Satu akun, semua lebih mudah</p>
                <h2 class="auth-panel-title">Dari desain pertama sampai order tiba.</h2>
                <p class="auth-panel-copy">Simpan detail akun dan kembali ke proses pemesanan tanpa memulai semuanya dari awal.</p>
                <div class="auth-panel-points">
                    <span class="auth-panel-point"><i class="fas fa-location-crosshairs" aria-hidden="true"></i> Pantau progres pesanan</span>
                    <span class="auth-panel-point"><i class="fas fa-shirt" aria-hidden="true"></i> Lanjutkan kebutuhan apparel custom</span>
                    <span class="auth-panel-point"><i class="fas fa-user-check" aria-hidden="true"></i> Kelola informasi akun</span>
                </div>
            </div>
        </aside>
    </div>
</section>

<script src="<?= base_url('assets/js/auth-sagara.js') ?>"></script>
