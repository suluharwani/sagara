<?php $isTemplate = $kind === 'template'; $path = $isTemplate ? 'admin/design-templates' : 'admin/custom-designs'; ?>
<div class="design-admin-editor">
<div class="d-flex justify-content-between gap-3 flex-wrap mb-4"><div><a href="<?= base_url($path) ?>" class="small text-muted">&larr; <?= $isTemplate ? 'Template Desain' : 'Desain Custom' ?></a><h2 class="mt-2"><?= $record ? 'Kelola' : 'Tambah' ?> <?= $isTemplate ? 'Template' : 'Desain Custom' ?></h2><?php if ($record): ?><small><?= esc($record['code']) ?></small><?php endif ?></div><div><button class="btn btn-primary" id="design-admin-save" type="submit" form="design-admin-form" disabled>Simpan <?= $isTemplate ? 'Template' : 'Desain' ?></button><?php if ($record): ?><a href="<?= base_url('admin/design-records/' . $record['id'] . '/download') ?>" class="btn btn-outline-secondary">Unduh file tersimpan</a><?php endif ?></div></div>
<form id="design-admin-form" class="card card-body mb-3">
    <div class="row g-3">
        <div class="col-md-5"><label for="design-title" class="form-label">Nama <?= $isTemplate ? 'template' : 'desain' ?></label><input id="design-title" name="title" class="form-control" required minlength="2" maxlength="60" value="<?= esc($record['title'] ?? '', 'attr') ?>"></div>
        <div class="col-md-3"><label for="design-category" class="form-label">Kategori</label><input id="design-category" name="category" class="form-control" maxlength="80" placeholder="Futsal, keeper, komunitas…" value="<?= esc($record['category'] ?? '', 'attr') ?>"></div>
        <div class="col-md-4"><label for="design-status" class="form-label">Status</label><select id="design-status" name="status" class="form-select"><?php foreach ($statuses as $key => $label): ?><option value="<?= $key ?>" <?= ($record['status'] ?? ($isTemplate ? 'draft' : 'new')) === $key ? 'selected' : '' ?>><?= esc($label) ?></option><?php endforeach ?></select></div>
        <?php if (!$isTemplate): ?><div class="col-md-6"><label for="design-customer" class="form-label">Nama pelanggan</label><input id="design-customer" name="customer_name" class="form-control" maxlength="100" value="<?= esc($record['customer_name'] ?? '', 'attr') ?>"></div><div class="col-md-6"><label for="design-phone" class="form-label">Nomor WhatsApp</label><input id="design-phone" name="customer_phone" class="form-control" maxlength="30" value="<?= esc($record['customer_phone'] ?? '', 'attr') ?>"></div><?php endif ?>
        <div class="col-12"><label for="design-admin-note" class="form-label">Catatan internal admin</label><textarea id="design-admin-note" name="admin_note" class="form-control" rows="2" maxlength="3000"><?= esc($record['admin_note'] ?? '') ?></textarea></div>
    </div>
    <p class="small text-muted mt-3 mb-0"><?= $isTemplate ? 'Gunakan editor di bawah atau buka file JSON desain. Status Publik membuat template tersedia untuk pelanggan; Draft dan Arsip menyembunyikannya. Catatan internal tidak dipublikasikan.' : 'Perubahan desain dan status disimpan setelah menekan Simpan Desain. Pilih Arsip untuk mengeluarkannya dari alur pengerjaan.' ?></p>
</form>
<p id="design-admin-status" role="status" aria-live="polite" class="small">Menyiapkan editor…</p>
<?= $studio ?>
</div>
<script src="<?= base_url('assets/js/design-admin.js') ?>" defer></script>
