<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Daftar Akun Baru</h3>
                    
                    <form action="<?= base_url('register/process') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" minlength="8" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" name="phone" class="form-control" value="<?= old('phone') ?>" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="terms" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">Saya menyetujui syarat dan ketentuan</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </form>
                    
                    <hr>
                    <p class="text-center mb-0">Sudah punya akun? <a href="<?= base_url('login') ?>">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>