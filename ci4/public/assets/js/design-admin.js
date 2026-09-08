(async function () {
    'use strict';
    const studio = window.SagaraStudio, form = document.getElementById('design-admin-form');
    if (!studio || !form) return;
    form.addEventListener('submit', event => event.preventDefault());
    const config = studio.config, button = document.getElementById('design-admin-save'), status = document.getElementById('design-admin-status');
    const metadata = () => Object.fromEntries(new FormData(form));
    let savedMetadata = JSON.stringify(metadata());
    try {
        if (config.loadUrl) {
            const response = await fetch(config.loadUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!response.ok) throw new Error('Desain tidak dapat dimuat atau sesi admin berakhir. Muat ulang setelah login.');
            const record = await response.json(); await studio.setDocument(record.document); config.revision = record.revision;
        }
        button.disabled = false; status.textContent = 'Editor siap. Perubahan disimpan melalui tombol Simpan di atas.';
    } catch (error) { status.textContent = error.message; return; }
    form.addEventListener('submit', async event => {
        event.preventDefault(); if (!form.reportValidity()) return;
        button.disabled = true; status.textContent = 'Menyimpan desain…';
        try {
            const fields = metadata(), document = studio.getDocument(), snapshot = JSON.stringify(document); document.name = fields.title.trim();
            if (config.kind === 'template') { document.notes = ''; document.quantities = { S: 0, M: 1, L: 0, XL: 0, '2XL': 0, '3XL': 0 }; }
            const result = await studio.request(config.saveUrl, { ...fields, kind: config.kind, id: config.recordId || null, revision: config.revision, document, thumbnail: await studio.thumbnail(document) });
            config.recordId = result.id; config.revision = result.revision;
            // Do not overwrite edits the admin made while the save request was in flight.
            savedMetadata = JSON.stringify(fields);
            status.textContent = result.message;
            if (JSON.stringify(studio.getDocument()) === snapshot) studio.markSaved();
            window.history.replaceState(null, '', result.url);
        } catch (error) { status.textContent = error.message; }
        finally { button.disabled = false; }
    });
    window.addEventListener('beforeunload', event => { if (JSON.stringify(metadata()) !== savedMetadata) { event.preventDefault(); event.returnValue = ''; } });
}());
