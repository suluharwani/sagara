<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2>Changelog</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                    <li class="breadcrumb-item active">Changelog</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-admin btn-admin-primary" data-bs-toggle="modal" data-bs-target="#addChangelogModal">
            <i class="fas fa-plus me-1"></i> Tambah Log
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Aktivitas</th>
                                <th>User</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($changelogs)): ?>
                                <?php $no = 1; foreach ($changelogs as $log): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= date('d M Y H:i', strtotime($log['created_at'] ?? 'now')) ?></td>
                                        <td><?= esc($log['riwayat'] ?? $log['aktivitas'] ?? '-') ?></td>
                                        <td><?= esc($log['user'] ?? $log['id_admin'] ?? '-') ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-history fa-2x mb-2 d-block"></i>
                                        Belum ada changelog
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Changelog -->
<div class="modal fade" id="addChangelogModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/changelog/add') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Changelog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Aktivitas</label>
                        <textarea name="aktivitas" class="form-control" rows="3" required></textarea>
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
