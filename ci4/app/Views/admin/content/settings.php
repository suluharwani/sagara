<div class="content-header">
    <h2>Pengaturan Libur</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
            <li class="breadcrumb-item active">Pengaturan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-calendar-week me-2"></i> Pengaturan Hari Libur
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('admin/settings') ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Sabtu Libur</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="saturday_off" id="saturdayOff" value="1" <?= (($settings['saturday_off'] ?? '0') == '1') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="saturdayOff">
                                <?= (($settings['saturday_off'] ?? '0') == '1') ? '<span class="text-danger">Libur</span>' : '<span class="text-success">Masuk</span>' ?>
                            </label>
                        </div>
                        <small class="text-muted">Aktifkan untuk menjadikan Sabtu sebagai hari libur</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Minggu Libur</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="sunday_off" id="sundayOff" value="1" <?= (($settings['sunday_off'] ?? '0') == '1') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="sundayOff">
                                <?= (($settings['sunday_off'] ?? '0') == '1') ? '<span class="text-danger">Libur</span>' : '<span class="text-success">Masuk</span>' ?>
                            </label>
                        </div>
                        <small class="text-muted">Aktifkan untuk menjadikan Minggu sebagai hari libur</small>
                    </div>
                    
                    <button type="submit" class="btn btn-admin btn-admin-primary">
                        <i class="fas fa-save me-1"></i> Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i> Keterangan
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-toggle-on text-primary me-2"></i>
                        <strong>Aktif:</strong> Hari tersebut akan ditandai sebagai libur di kalender
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-toggle-off text-secondary me-2"></i>
                        <strong>Nonaktif:</strong> Hari tersebut akan ditandai sebagai hari kerja
                    </li>
                </ul>
                <hr>
                <h6>Preview:</h6>
                <div class="d-flex gap-2">
                    <span class="badge bg-danger">Sabtu Libur</span>
                    <span class="badge bg-danger">Minggu Libur</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-switch .form-check-input {
    width: 3em;
    height: 1.5em;
}
.form-switch .form-check-label {
    margin-left: 0.5rem;
    font-size: 1rem;
}
</style>