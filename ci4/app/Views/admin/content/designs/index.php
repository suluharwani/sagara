<?php $isTemplate = $kind === 'template'; $path = $isTemplate ? 'admin/design-templates' : 'admin/custom-designs'; ?>
<div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-4">
    <div><h2><?= $isTemplate ? 'Template Desain' : 'Desain Custom' ?></h2><p class="text-muted mb-0"><?= $isTemplate ? 'Buat template yang bisa langsung digunakan pelanggan di Design Studio.' : 'Kelola kiriman pelanggan, revisi desain, dan catatan pengerjaan.' ?></p></div>
    <?php if ($ready): ?><a href="<?= base_url($path . '/new') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i><?= $isTemplate ? 'Tambah Template' : 'Tambah Desain' ?></a><?php endif ?>
</div>
<?php if (!$ready): ?>
    <div class="alert alert-warning">Penyimpanan desain belum diaktifkan. Jalankan <code>php spark design:setup</code> di direktori ci4.</div>
<?php else: ?>
    <div class="d-flex gap-2 flex-wrap mb-4"><?php foreach ($statuses as $key => $label): ?><a class="btn btn-sm <?= $status === $key ? 'btn-primary' : 'btn-outline-secondary' ?>" href="<?= base_url($path) . '?status=' . $key ?>"><?= esc($label) ?> <strong><?= (int) ($counts[$key] ?? 0) ?></strong></a><?php endforeach ?></div>
    <form class="row g-2 mb-4" method="get" action="<?= base_url($path) ?>">
        <div class="col-md-7"><label class="visually-hidden" for="design-search">Cari desain</label><input class="form-control" id="design-search" name="search" value="<?= esc($search, 'attr') ?>" placeholder="Cari nama, kode, kategori<?= $isTemplate ? '' : ', atau pelanggan' ?>"></div>
        <div class="col-md-3"><label class="visually-hidden" for="design-status">Status</label><select class="form-select" id="design-status" name="status"><option value="">Semua status</option><?php foreach ($statuses as $key => $label): ?><option value="<?= $key ?>" <?= $key === $status ? 'selected' : '' ?>><?= esc($label) ?></option><?php endforeach ?></select></div>
        <div class="col-md-2"><button class="btn btn-dark w-100">Cari</button></div>
    </form>
    <div class="card"><div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Desain</th><th><?= $isTemplate ? 'Kategori' : 'Pelanggan' ?></th><th>Status</th><th>Diperbarui</th><th><span class="visually-hidden">Aksi</span></th></tr></thead><tbody>
    <?php foreach ($records as $item): ?><tr>
        <td><strong><?= esc($item['title']) ?></strong><div class="small text-muted"><?= esc($item['code']) ?></div></td>
        <td><?= esc($isTemplate ? ($item['category'] ?: 'Umum') : ($item['customer_name'] ?: 'Dibuat admin')) ?><?php if (!$isTemplate): ?><div class="small text-muted"><?= esc($item['customer_phone']) ?></div><?php endif ?></td>
        <td><span class="badge <?= $item['status'] === 'published' || $item['status'] === 'approved' ? 'bg-success' : 'bg-secondary' ?>"><?= esc($statuses[$item['status']] ?? $item['status']) ?></span></td>
        <td class="small"><?= esc($item['updated_at']) ?></td><td><a class="btn btn-sm btn-outline-primary" href="<?= base_url($path . '/' . $item['id']) ?>">Preview &amp; kelola</a></td>
    </tr><?php endforeach ?>
    <?php if (!$records): ?><tr><td colspan="5" class="text-center py-5 text-muted"><?= $isTemplate ? 'Belum ada template sesuai pencarian. Klik Tambah Template untuk membuatnya.' : 'Belum ada desain sesuai pencarian. Kiriman melalui tombol Kirim desain ke admin di studio akan tampil di sini.' ?></td></tr><?php endif ?>
    </tbody></table></div></div>
    <div class="mt-3"><?= $pager ? $pager->links() : '' ?></div>
<?php endif ?>
