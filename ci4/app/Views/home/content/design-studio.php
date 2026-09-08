<link rel="stylesheet" href="<?= base_url('assets/css/design-studio.css') ?>">
<script type="application/json" id="ds-server-config"><?= json_encode($studioConfig ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
<section class="ds" id="design-studio" aria-labelledby="ds-title">
    <header class="ds-heading">
        <div><span class="ds-eyebrow">SAGARA / DESIGN STUDIO</span><h1 id="ds-title">Ide Anda. Jersey Anda.</h1><p>Pilih template, buat jadi milik tim Anda, lalu unduh desainnya.</p></div>
        <div class="ds-heading-actions"><button type="button" class="ds-btn" id="ds-save">Simpan file desain</button><button type="button" class="ds-btn ds-primary" id="ds-review">Unduh &amp; pesan <span aria-hidden="true">↗</span></button></div>
    </header>
    <noscript><p class="ds-notice">Aktifkan JavaScript untuk menggunakan editor desain.</p></noscript>
    <div class="ds-draft" id="ds-draft" hidden><span>Draft sebelumnya tersedia di perangkat ini.</span><button type="button" class="ds-btn" id="ds-restore">Lanjutkan draft</button><button type="button" class="ds-btn" id="ds-dismiss-draft">Mulai baru</button></div>
    <div class="ds-workspace">
        <aside class="ds-sidebar" aria-label="Alat desain">
            <div class="ds-tabs" role="tablist" aria-label="Kategori alat">
                <button type="button" role="tab" id="ds-tab-product" aria-controls="ds-panel-product" aria-selected="true" data-tab="product"><i class="fas fa-shirt" aria-hidden="true"></i>Produk</button>
                <button type="button" role="tab" id="ds-tab-template" aria-controls="ds-panel-template" aria-selected="false" tabindex="-1" data-tab="template"><i class="fas fa-border-all" aria-hidden="true"></i>Template</button>
                <button type="button" role="tab" id="ds-tab-elements" aria-controls="ds-panel-elements" aria-selected="false" tabindex="-1" data-tab="elements"><i class="fas fa-font" aria-hidden="true"></i>Teks &amp; logo</button>
            </div>
            <div class="ds-panel" id="ds-panel-product" role="tabpanel" aria-labelledby="ds-tab-product">
                <h2>Mulai dari modelnya</h2><p class="ds-muted">Satu desain, identitas seluruh tim.</p>
                <label for="ds-product">Model pakaian</label><select id="ds-product"><option value="player">Pemain / reguler</option><option value="keeper">Keeper / kiper</option></select>
                <label for="ds-collar">Model leher / kerah</label><select id="ds-collar"><optgroup label="V-neck"><option value="v-classic">V-neck klasik</option><option value="v-cross">V-neck silang</option></optgroup><optgroup label="Round neck"><option value="round-classic">Round neck klasik</option><option value="round-rib">Round neck rib</option></optgroup><optgroup label="Kerah"><option value="polo-button">Kerah polo kancing</option><option value="polo-zip">Kerah polo resleting</option></optgroup></select>
                <label for="ds-sleeves">Panjang lengan</label><select id="ds-sleeves"><option value="short">Lengan pendek</option><option value="long">Lengan panjang</option></select>
                <p id="ds-keeper-note" class="ds-muted" hidden>Model keeper memakai panel aksen khusus. Detail panel produksi dikonfirmasi saat pemesanan.</p>
                <label for="ds-pants-style">Paket pakaian</label><select id="ds-pants-style"><option value="none">Atasan saja / tanpa celana</option><option value="short">Atasan + celana pendek</option><option value="long">Atasan + celana panjang</option></select>
                <p id="ds-pants-note" class="ds-muted" hidden>Pilih tab Celana di atas preview untuk mendesain celana. Desain tetap tersimpan jika pilihan celana dinonaktifkan.</p>
                <label for="ds-name">Nama desain</label><input id="ds-name" maxlength="60" value="Sagara Team">
                <div class="ds-editing-label" id="ds-editing-label">SEDANG MENGEDIT ATASAN</div>
                <label for="ds-material" id="ds-material-label">Bahan kain atasan</label><select id="ds-material"><option value="undecided">Bantu pilihkan bahan</option><option value="milano">Milano</option><option value="serena">Serena</option><option value="emboss">Emboss</option><option value="jarum">Jarum</option><option value="custom">Bahan lainnya</option></select>
                <div id="ds-material-custom" hidden><label for="ds-material-note">Nama bahan yang diinginkan</label><input id="ds-material-note" maxlength="80" placeholder="Tulis nama bahan"></div>
                <p class="ds-muted">Ketersediaan dan harga bahan dikonfirmasi oleh Sagara.</p>
                <div class="ds-section-label">Warna dasar <span id="ds-color-value">#10233D</span></div><div class="ds-swatches" id="ds-swatches" aria-label="Pilihan warna dasar"></div>
                <div class="ds-color-row"><label for="ds-base">Warna lainnya</label><input type="color" id="ds-base" value="#10233d"></div>
                <div class="ds-color-row"><label for="ds-accent">Warna aksen</label><input type="color" id="ds-accent" value="#c7f000"></div>
                <label for="ds-pattern" id="ds-pattern-label">Motif atasan</label><select id="ds-pattern"><option value="plain">Polos</option><option value="diagonal">Diagonal</option><option value="stripe">Garis vertikal</option><option value="chevron">Chevron</option><option value="split">Dua warna</option><option value="hoops">Garis horizontal</option></select>
                <button type="button" class="ds-btn ds-wide" id="ds-match-shirt" hidden>Samakan warna &amp; motif dengan atasan</button>
                <div class="ds-tip"><i class="fas fa-lightbulb" aria-hidden="true"></i><p>Ingin lebih cepat? Pilih <button type="button" class="ds-text-btn" data-open-tab="template">template siap edit</button>, lalu ganti nama dan nomor tim.</p></div>
                <label class="ds-file-link">Buka file desain (.json)<input type="file" id="ds-import" accept=".json,application/json"></label>
            </div>
            <div class="ds-panel" id="ds-panel-template" role="tabpanel" aria-labelledby="ds-tab-template" hidden>
                <h2>Langsung punya desain</h2><p class="ds-muted">Template asli Sagara. Semua warna dan tulisan bisa diubah.</p>
                <label class="ds-sr" for="ds-template-search">Cari template</label><input id="ds-template-search" type="search" placeholder="Cari template…">
                <div class="ds-template-grid" id="ds-templates"></div><p class="ds-muted"><?= empty($studioConfig['admin']) ? 'Template publik memuat model dan desain seluruh paket. Jumlah dan catatan pesanan tetap tersimpan. Gunakan Urungkan untuk kembali.' : 'Template bawaan mengganti atasan depan dan belakang. Model, bahan, dan desain celana tetap tersimpan. Gunakan Urungkan untuk kembali.' ?></p>
                <button class="ds-btn ds-wide" type="button" id="ds-more-templates" hidden>Muat template lainnya</button>
            </div>
            <div class="ds-panel" id="ds-panel-elements" role="tabpanel" aria-labelledby="ds-tab-elements" hidden>
                <h2>Tambahkan identitas tim</h2><label for="ds-new-text">Teks, nama, atau nomor</label><input id="ds-new-text" maxlength="40" placeholder="Contoh: GARUDA FC">
                <button type="button" class="ds-btn ds-wide" id="ds-add-text"><span aria-hidden="true">＋</span> Tambah teks</button>
                <label class="ds-upload" id="ds-drop"><i class="fas fa-cloud-arrow-up" aria-hidden="true"></i><strong>Tambahkan logo / gambar</strong><span>PNG, JPG, WebP · maks. 5 MB<br>Klik atau jatuhkan gambar di sini</span><input type="file" id="ds-image" accept="image/png,image/jpeg,image/webp"></label>
                <p class="ds-muted">Gunakan PNG transparan untuk logo. Gambar diproses di perangkat Anda.</p>
                <div class="ds-section-label">Bentuk</div><div class="ds-row"><button type="button" class="ds-btn" data-shape="circle">● Lingkaran</button><button type="button" class="ds-btn" data-shape="rect">■ Kotak</button><button type="button" class="ds-btn" data-shape="star">★ Bintang</button></div>
            </div>
        </aside>
        <div class="ds-preview">
            <div class="ds-piece-switch" role="group" aria-label="Bagian pakaian yang diedit"><button type="button" data-piece="shirt" aria-pressed="true">Atasan</button><button type="button" data-piece="pants" id="ds-edit-pants" aria-pressed="false" disabled>Celana</button></div>
            <div class="ds-toolbar"><div class="ds-row"><button type="button" class="ds-icon-btn" id="ds-undo" title="Urungkan (Ctrl+Z)" aria-label="Urungkan" disabled>↶</button><button type="button" class="ds-icon-btn" id="ds-redo" title="Ulangi (Ctrl+Shift+Z)" aria-label="Ulangi" disabled>↷</button><span class="ds-divider"></span><label class="ds-guide-toggle"><input type="checkbox" id="ds-guides" checked> Area desain</label></div><span class="ds-live"><span></span> Preview langsung</span></div>
            <div class="ds-canvas-wrap" id="ds-canvas-wrap"><svg id="ds-canvas" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 720" role="img" tabindex="0" aria-label="Preview desain jersey. Pilih elemen untuk mengedit, gunakan tombol panah untuk menggeser." aria-describedby="ds-canvas-help"></svg><span class="ds-canvas-label" aria-hidden="true">YOUR TEAM. YOUR IDENTITY.</span></div>
            <div class="ds-side-switch" role="group" aria-label="Sisi pakaian"><button type="button" data-side="front" aria-pressed="true">Depan</button><button type="button" data-side="back" aria-pressed="false">Belakang</button></div>
            <p class="ds-canvas-help" id="ds-canvas-help">Klik elemen untuk mengedit · Geser untuk mengatur posisi</p>
            <div class="ds-status" id="ds-status" role="status" aria-live="polite">Siap membuat desain. Tidak perlu login.</div>
        </div>
        <aside class="ds-inspector" aria-label="Properti dan lapisan desain">
            <div class="ds-inspector-title"><h2>Atur desain</h2><span class="ds-side-badge" id="ds-side-label">DEPAN</span></div>
            <div id="ds-selection-empty" class="ds-empty"><span aria-hidden="true">↖</span><p>Pilih teks atau logo pada bagian pakaian aktif untuk mengubahnya.</p><button type="button" class="ds-btn" data-open-tab="elements">Tambah elemen</button></div>
            <div id="ds-properties" hidden>
                <div id="ds-text-properties"><label for="ds-text">Isi teks</label><input id="ds-text" maxlength="40"><label for="ds-font">Jenis huruf</label><select id="ds-font"><option value="Arial">Sport / Arial</option><option value="Impact">Bold / Impact</option><option value="Georgia">Classic / Georgia</option><option value="Courier New">Mono / Courier</option></select><label class="ds-check"><input type="checkbox" id="ds-bold"> Tebal</label></div>
                <div id="ds-element-color-row" class="ds-color-row"><label for="ds-element-color">Warna elemen</label><input type="color" id="ds-element-color" value="#ffffff"></div>
                <label for="ds-scale">Ukuran <output id="ds-scale-value"></output></label><input type="range" id="ds-scale" min="25" max="200" step="1">
                <label for="ds-rotation">Rotasi <output id="ds-rotation-value"></output></label><input type="range" id="ds-rotation" min="-180" max="180" step="1">
                <div class="ds-row"><div><label for="ds-x">Posisi X</label><input type="number" id="ds-x" min="180" max="420" step="1"></div><div><label for="ds-y">Posisi Y</label><input type="number" id="ds-y" min="190" max="610" step="1"></div></div>
                <button type="button" class="ds-btn ds-wide" id="ds-center">Ratakan ke tengah</button><div class="ds-row"><button type="button" class="ds-btn" id="ds-duplicate">Duplikat</button><button type="button" class="ds-btn ds-danger" id="ds-delete">Hapus</button></div>
                <div class="ds-row" id="ds-leg-controls" hidden><button type="button" class="ds-btn" id="ds-leg-left">Kiri pada layar</button><button type="button" class="ds-btn" id="ds-leg-right">Kanan pada layar</button></div>
                <p class="ds-warning" id="ds-overflow" hidden>Elemen melewati area desain. Perkecil atau pindahkan ke dalam garis agar hasil tidak terpotong.</p>
            </div>
            <div class="ds-layer-heading"><h3>Lapisan</h3><span id="ds-layer-count">0 elemen</span></div><div id="ds-layers" class="ds-layers"></div>
            <p class="ds-muted ds-layer-hint">Lapisan teratas tampil paling depan. Maksimal 20 elemen per sisi.</p>
            <div class="ds-row"><button type="button" class="ds-btn" id="ds-forward" disabled>Naik ↑</button><button type="button" class="ds-btn" id="ds-backward" disabled>Turun ↓</button></div>
        </aside>
    </div>
    <div class="ds-footnote"><span><i class="fas fa-lock" aria-hidden="true"></i> Draft tersimpan di browser ini</span><span>Mockup adalah ilustrasi. Ukuran dan warna produksi dikonfirmasi bersama Sagara.</span></div>
    <dialog id="ds-export-dialog" class="ds-dialog" aria-labelledby="ds-export-title">
        <div class="ds-dialog-head"><div><span class="ds-eyebrow">DESAIN ANDA SIAP</span><h2 id="ds-export-title">Dari ide, jadi seragam.</h2></div><button type="button" class="ds-icon-btn" id="ds-close-dialog" aria-label="Tutup">×</button></div>
        <div id="ds-export-preview" class="ds-export-preview"></div>
        <dl id="ds-order-specs" class="ds-order-specs"></dl>
        <p class="ds-muted">Periksa kedua sisi. Unduh mockup untuk dibagikan, atau simpan file desain agar bisa diedit lagi.</p>
        <div class="ds-row ds-export-actions"><button type="button" class="ds-btn ds-primary" id="ds-download-png">Unduh mockup PNG</button><button type="button" class="ds-btn" id="ds-download-svg">Unduh SVG sisi aktif</button><button type="button" class="ds-btn" id="ds-download-json">File desain (.json)</button></div>
        <p class="ds-muted">PNG 2400 × 1600 px memuat seluruh paket · SVG berisi bagian dan sisi aktif, bukan pola potong produksi.</p>
        <p class="ds-muted" id="ds-set-size-note" hidden>Ukuran yang dipilih berlaku untuk atasan dan celana dalam satu set. Jika ukurannya berbeda, tulis di catatan pesanan.</p>
        <div class="ds-order"><h3>Wujudkan bersama Sagara</h3><p class="ds-muted">Isi kebutuhan ukuran untuk meminta penawaran. Harga dikonfirmasi oleh tim Sagara.</p><div class="ds-size-grid">
        <?php foreach (['S', 'M', 'L', 'XL', '2XL', '3XL'] as $size): ?>
            <div><label for="ds-qty-<?= $size ?>"><?= $size ?></label><input type="number" id="ds-qty-<?= $size ?>" data-size="<?= $size ?>" min="0" max="999" value="<?= $size === 'M' ? 1 : 0 ?>" step="1" inputmode="numeric"></div>
        <?php endforeach ?>
        </div><label for="ds-notes">Catatan pesanan (opsional)</label><textarea id="ds-notes" rows="2" maxlength="500" placeholder="Bahan, nama pemain, tenggat waktu…"></textarea><div class="ds-order-bottom"><strong id="ds-qty-total">Total 1 pcs</strong><a id="ds-whatsapp" class="ds-btn ds-primary" target="_blank" rel="noopener noreferrer">Minta penawaran via WhatsApp ↗</a></div><p class="ds-muted">Unduh PNG lalu lampirkan sendiri di chat. Membuka WhatsApp tidak mengirim file atau membuat pesanan otomatis.</p></div>
        <p class="ds-status" id="ds-export-status" role="status" aria-live="polite"></p>
        <?php if (empty($studioConfig['admin'])): ?>
        <form id="ds-submit-form" class="ds-order" method="post" action="<?= base_url('design/submit') ?>">
            <h3>Kirim desain ke admin Sagara</h3><p class="ds-muted">Desain, kebutuhan ukuran, nama, dan nomor WhatsApp Anda akan disimpan untuk ditinjau tim Sagara.</p>
            <div class="ds-row"><div><label for="ds-customer-name">Nama Anda</label><input id="ds-customer-name" required minlength="2" maxlength="100" autocomplete="name"></div><div><label for="ds-customer-phone">Nomor WhatsApp</label><input id="ds-customer-phone" type="tel" required minlength="8" maxlength="25" pattern="[+0-9 ()\-]{8,25}" autocomplete="tel" placeholder="08…"></div></div>
            <button class="ds-btn ds-primary ds-wide" type="submit" id="ds-submit">Kirim desain ke admin</button><p id="ds-submit-status" role="status" aria-live="polite" class="ds-muted"></p>
        </form>
        <?php endif ?>
    </dialog>
</section>
<script src="<?= base_url('assets/js/design-studio-core.js') ?>" defer></script>
<script src="<?= base_url('assets/js/design-studio.js') ?>" defer></script>
