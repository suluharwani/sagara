<div class="reseller-shell reseller-form-page">
    <div class="container">
        <div class="reseller-form-layout">
            <aside class="reseller-form-aside">
                <span class="reseller-kicker">Pendaftaran reseller</span>
                <h1>Kenalkan usaha Anda.</h1>
                <p>Data ini digunakan admin untuk memeriksa pengajuan dan menghubungi Anda bila diperlukan.</p>
                <ol><li><span>01</span> Isi identitas usaha</li><li><span>02</span> Admin memeriksa pengajuan</li><li><span>03</span> Harga dasar dan nota terbuka</li></ol>
            </aside>
            <main class="reseller-form-card">
                <?php if ($errors = session()->getFlashdata('errors')): ?><div class="reseller-alert danger" role="alert"><?php foreach ((array) $errors as $error): ?><p><?= esc($error) ?></p><?php endforeach; ?></div><?php endif; ?>
                <?php if ($error = session()->getFlashdata('error')): ?><div class="reseller-alert danger" role="alert"><p><?= esc($error) ?></p></div><?php endif; ?>
                <form action="<?= base_url('reseller/register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="reseller-form-grid">
                        <div class="reseller-field"><label for="owner_name">Nama pemilik</label><input id="owner_name" name="owner_name" value="<?= esc(old('owner_name')) ?>" required></div>
                        <div class="reseller-field"><label for="business_name">Nama usaha</label><input id="business_name" name="business_name" value="<?= esc(old('business_name')) ?>" required></div>
                        <div class="reseller-field"><label for="reseller_email">Email</label><input id="reseller_email" type="email" name="email" value="<?= esc(old('email')) ?>" autocomplete="email" required></div>
                        <div class="reseller-field"><label for="whatsapp">Nomor WhatsApp</label><input id="whatsapp" name="whatsapp" value="<?= esc(old('whatsapp')) ?>" inputmode="tel" required></div>
                        <div class="reseller-field"><label for="city">Kota</label><input id="city" name="city" value="<?= esc(old('city')) ?>" required></div>
                        <div class="reseller-field"><label for="sales_channel">Kanal penjualan</label><input id="sales_channel" name="sales_channel" value="<?= esc(old('sales_channel')) ?>" placeholder="Instagram, toko, komunitas"></div>
                        <div class="reseller-field full"><label for="address">Alamat usaha</label><textarea id="address" name="address" rows="3"><?= esc(old('address')) ?></textarea></div>
                        <div class="reseller-field"><label for="reseller_password">Password</label><input id="reseller_password" type="password" name="password" autocomplete="new-password" minlength="8" required></div>
                        <div class="reseller-field"><label for="confirm_password">Ulangi password</label><input id="confirm_password" type="password" name="confirm_password" autocomplete="new-password" minlength="8" required></div>
                    </div>
                    <label class="reseller-consent"><input type="checkbox" name="terms" value="1" required> Saya menyetujui data ini digunakan untuk proses pendaftaran reseller.</label>
                    <button class="btn-reseller-primary reseller-submit" type="submit">Kirim Pengajuan <i class="fas fa-arrow-right"></i></button>
                    <p class="reseller-form-foot">Sudah terdaftar? <a href="<?= base_url('login') ?>">Masuk ke akun</a></p>
                </form>
            </main>
        </div>
    </div>
</div>
