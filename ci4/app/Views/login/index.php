<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Sagara Jersey</title>
    <meta name="description" content="Portal masuk admin Sagara Jersey.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/auth-sagara.css') ?>" rel="stylesheet">
</head>
<body class="auth-standalone">
    <main class="sagara-auth">
        <div class="auth-frame">
            <section class="auth-form-panel" aria-labelledby="admin-login-title">
                <div class="auth-topline">
                    <a class="auth-brand" href="<?= base_url() ?>" aria-label="Sagara Jersey, kembali ke beranda">
                        <span class="auth-mark">S</span>
                        <span>Sagara Jersey</span>
                    </a>
                    <a class="auth-back" href="<?= base_url() ?>">
                        <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Beranda
                    </a>
                </div>

                <span class="auth-eyebrow">Portal operasional</span>
                <h1 class="auth-title" id="admin-login-title">Masuk sebagai admin.</h1>
                <p class="auth-intro">Kelola order, progres produksi, dan laporan Sagara dari satu ruang kerja.</p>

                <?php $loginErrors = session()->getFlashdata('login_error'); ?>
                <?php if ($loginErrors): ?>
                    <div class="auth-alert auth-alert-danger" role="alert">
                        <i class="fas fa-circle-exclamation mt-1" aria-hidden="true"></i>
                        <div>
                            <?php foreach ((array) $loginErrors as $error): ?>
                                <p><?= esc($error) ?></p>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($successMessage = session()->getFlashdata('success')): ?>
                    <div class="auth-alert auth-alert-success" role="status">
                        <i class="fas fa-circle-check mt-1" aria-hidden="true"></i>
                        <p><?= esc($successMessage) ?></p>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/login') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token_generate" id="token_generate">

                    <div class="auth-field">
                        <label class="auth-label" for="admin-email">
                            <i class="fas fa-envelope" aria-hidden="true"></i> Email
                        </label>
                        <input class="auth-input" id="admin-email" type="email" name="email" autocomplete="username" placeholder="admin@sagara.id" value="<?= esc(old('email')) ?>" required autofocus>
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="admin-password">
                            <i class="fas fa-lock" aria-hidden="true"></i> Password
                        </label>
                        <div class="auth-input-wrap">
                            <input class="auth-input" id="admin-password" type="password" name="password" autocomplete="current-password" placeholder="Masukkan password" required>
                            <button class="auth-password-toggle" type="button" data-password-toggle data-target="admin-password" aria-label="Tampilkan password" aria-pressed="false">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <button class="auth-submit" type="submit" name="submit" value="login">
                        Masuk ke Dashboard <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>

                <?php if (!empty($login_link)): ?>
                    <div class="auth-divider"><span>atau</span></div>
                    <a href="<?= esc($login_link, 'attr') ?>" class="auth-google">
                        <img src="<?= base_url('assets/logo/google.png') ?>" alt="" aria-hidden="true">
                        Masuk dengan Google
                    </a>
                <?php endif; ?>
            </section>

            <aside class="auth-panel" aria-label="Informasi portal admin">
                <span class="auth-panel-badge">Sagara Control Center</span>
                <div class="auth-panel-content">
                    <p class="auth-panel-kicker">Kerja rapi, progres pasti</p>
                    <h2 class="auth-panel-title">Kendalikan alur produksi tanpa kehilangan detail.</h2>
                    <p class="auth-panel-copy">Akses khusus tim internal untuk memantau aktivitas bisnis dan menjaga setiap order tetap bergerak.</p>
                    <div class="auth-panel-points">
                        <span class="auth-panel-point"><i class="fas fa-box" aria-hidden="true"></i> Order dan status terpusat</span>
                        <span class="auth-panel-point"><i class="fas fa-chart-line" aria-hidden="true"></i> Ringkasan operasional cepat</span>
                        <span class="auth-panel-point"><i class="fas fa-shield-halved" aria-hidden="true"></i> Akses khusus administrator</span>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <script src="<?= base_url('assets/js/auth-sagara.js') ?>"></script>
    <?php $recaptchaSiteKey = $_ENV['recaptchaSiteKey'] ?? ''; ?>
    <?php if ($recaptchaSiteKey !== ''): ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?= esc($recaptchaSiteKey, 'attr') ?>"></script>
        <script>
            window.grecaptcha.ready(function () {
                window.grecaptcha.execute('<?= esc($recaptchaSiteKey, 'js') ?>', { action: 'login' }).then(function (token) {
                    document.getElementById('token_generate').value = token;
                });
            });
        </script>
    <?php endif; ?>
</body>
</html>
