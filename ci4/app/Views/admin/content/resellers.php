<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div><h2 class="mb-1">Manajemen Reseller</h2><p class="text-muted mb-0">Periksa pengajuan sebelum membuka harga dasar dan fitur nota.</p></div>
    <a href="<?= base_url('admin/reseller-products') ?>" class="btn btn-dark"><i class="fas fa-box-open me-2"></i>Produk Reseller</a>
</div>

<?php if ($success = session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc($success) ?></div><?php endif; ?>
<?php if ($error = session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc($error) ?></div><?php endif; ?>

<div class="row g-3 mb-4">
    <?php foreach (['pending' => ['Menunggu', 'clock', 'warning'], 'approved' => ['Disetujui', 'check-circle', 'success'], 'rejected' => ['Ditolak', 'times-circle', 'danger'], 'suspended' => ['Ditangguhkan', 'pause-circle', 'secondary']] as $key => [$label, $icon, $color]): ?>
        <div class="col-6 col-xl-3"><div class="admin-card h-100"><div class="card-body d-flex align-items-center gap-3"><span class="btn btn-<?= $color ?> rounded-circle"><i class="fas fa-<?= $icon ?>"></i></span><div><h3 class="mb-0"><?= (int) ($counts[$key] ?? 0) ?></h3><small class="text-muted"><?= $label ?></small></div></div></div></div>
    <?php endforeach; ?>
</div>

<div class="admin-card"><div class="card-header"><i class="fas fa-handshake me-2"></i>Daftar Pengajuan</div><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Kode</th><th>Usaha</th><th>Kontak</th><th>Kota/Kanal</th><th>Status</th><th style="min-width:280px">Tindakan</th></tr></thead><tbody>
<?php if ($resellers): foreach ($resellers as $reseller): ?>
<tr><td><strong><?= esc($reseller['code']) ?></strong><br><small class="text-muted"><?= date('d M Y', strtotime($reseller['created_at'])) ?></small></td><td><strong><?= esc($reseller['business_name']) ?></strong><br><small><?= esc($reseller['owner_name']) ?></small></td><td><a href="mailto:<?= esc($reseller['email'], 'attr') ?>"><?= esc($reseller['email']) ?></a><br><small><?= esc($reseller['whatsapp']) ?></small></td><td><?= esc($reseller['city'] ?: '-') ?><br><small><?= esc($reseller['sales_channel'] ?: '-') ?></small></td><td><span class="badge bg-<?= $reseller['status'] === 'approved' ? 'success' : ($reseller['status'] === 'pending' ? 'warning text-dark' : 'secondary') ?>"><?= esc(ucfirst($reseller['status'])) ?></span></td><td><form action="<?= base_url('admin/resellers/' . $reseller['id'] . '/status') ?>" method="post" class="d-flex gap-2"><?= csrf_field() ?><select name="status" class="form-select form-select-sm"><?php foreach (['pending' => 'Menunggu', 'approved' => 'Setujui', 'rejected' => 'Tolak', 'suspended' => 'Tangguhkan'] as $value => $label): ?><option value="<?= $value ?>" <?= $reseller['status'] === $value ? 'selected' : '' ?>><?= $label ?></option><?php endforeach; ?></select><input name="admin_note" class="form-control form-control-sm" value="<?= esc($reseller['admin_note']) ?>" placeholder="Catatan"><button class="btn btn-sm btn-primary">Simpan</button></form></td></tr>
<?php endforeach; else: ?><tr><td colspan="6" class="text-center py-5 text-muted">Belum ada pengajuan reseller.</td></tr><?php endif; ?>
</tbody></table></div></div></div>
