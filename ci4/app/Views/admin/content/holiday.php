<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2>Kelola Hari Libur</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                    <li class="breadcrumb-item active">Hari Libur</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-admin btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addHolidayModal">
            <i class="fas fa-plus me-1"></i> Tambah Libur
        </button>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i> Daftar Hari Libur
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($holidays)): ?>
                                <?php foreach ($holidays as $i => $holiday): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= date('d M Y', strtotime($holiday['holiday_date'])) ?></td>
                                        <td><?= esc($holiday['title']) ?></td>
                                        <td>
                                            <?php if ($holiday['type'] === 'national'): ?>
                                                <span class="badge bg-danger">Nasional</span>
                                            <?php elseif ($holiday['type'] === 'custom'): ?>
                                                <span class="badge bg-success">Custom</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary">Pengganti</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($holiday['is_active'] == 1): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/holiday/delete/' . $holiday['id']) ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Hapus hari libur ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada hari libur</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i> Keterangan
            </div>
            <div class="card-body">
                <h6>Jenis Libur:</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><span class="badge bg-danger">Nasional</span> - Hari libur nasional resmi</li>
                    <li class="mb-2"><span class="badge bg-success">Custom</span> - Hari libur custom perusahaan</li>
                    <li class="mb-2"><span class="badge bg-primary">Pengganti</span> - Hari pengganti masuk kerja</li>
                </ul>
                <hr>
                <h6>Tips:</h6>
                <ul class="text-muted small">
                    <li>Libur nasional: Warna merah</li>
                    <li>Libur custom: Warna hijau</li>
                    <li>Hari pengganti: Warna biru</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Holiday -->
<div class="modal fade" id="addHolidayModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/holiday/add') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Hari Libur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="holiday_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-select" id="holidayType" onchange="updateHolidayColor()">
                            <option value="national" selected>Libur Nasional</option>
                            <option value="custom">Libur Custom</option>
                            <option value="replacement">Hari Pengganti</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna</label>
                        <input type="color" name="color" id="holidayColor" class="form-control form-control-color" value="#dc3545">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-control-color {
    width: 100%;
    height: 38px;
    padding: 0.375rem;
}
</style>

<script>
function updateHolidayColor() {
    const type = document.getElementById('holidayType').value;
    const colorMap = {
        'national': '#dc3545',
        'custom': '#28a745',
        'replacement': '#1976d2'
    };
    document.getElementById('holidayColor').value = colorMap[type] || '#dc3545';
}
</script>