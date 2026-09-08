(function () {
    'use strict';
    const root = document.getElementById('design-studio');
    if (!root || !window.SagaraDesign) return;
    const C = window.SagaraDesign;
    const $ = id => document.getElementById(`ds-${id}`);
    const all = selector => Array.from(root.querySelectorAll(selector));
    const serverConfig = JSON.parse($('server-config')?.textContent || '{}');
    const STORAGE_KEY = 'sagara.design-studio.v1';
    let design = C.createDesign(), side = 'front', piece = 'shirt', selected = null;
    let history = new C.History(design), drag = null, pendingDraft = null, saveTimer;
    let localSaved = true, fileSaved = JSON.stringify(design), nextId = 0;
    const canvas = $('canvas'), dialog = $('export-dialog');
    let library = serverConfig.templatesUrl ? [] : null, libraryPage = 0, libraryRequest = 0;

    function status(message, error = false) {
        $('status').textContent = message;
        $('status').classList.toggle('is-error', error);
    }
    function exportStatus(message, error = false) {
        $('export-status').textContent = message;
        $('export-status').classList.toggle('is-error', error);
    }
    function currentData() { return C.pieceData(design, piece); }
    function currentLayers() { return C.layersFor(design, side, piece); }
    function activeLayer() { return currentLayers().find(layer => layer.id === selected); }
    function isOverflow(layer) { return C.overflows(layer, C.areasFor(design, piece)); }
    function defaultX(targetPiece = piece) { return targetPiece === 'pants' ? 221 : 300; }
    function uniqueId() { return `layer-${Date.now().toString(36)}-${++nextId}`; }
    function saveLocal() {
        clearTimeout(saveTimer);
        if (serverConfig.admin) { localSaved = false; status('Gunakan tombol Simpan di bagian atas untuk menyimpan ke admin.'); return; }
        if (pendingDraft) {
            localSaved = false;
            status('Draft lama tetap disimpan. Pilih Lanjutkan draft atau Mulai baru di atas untuk menyimpan perubahan ini.');
            return;
        }
        try {
            const data = JSON.stringify(design);
            if (data.length > C.MAX_FILE) throw new Error('large');
            localStorage.setItem(STORAGE_KEY, data);
            localSaved = true;
            status('Draft tersimpan di browser ini.');
        } catch (_) {
            localSaved = false;
            status('Draft belum tersimpan: penyimpanan browser penuh atau tidak tersedia. Gunakan Simpan file desain.', true);
        }
    }
    function scheduleSave() { localSaved = false; clearTimeout(saveTimer); saveTimer = setTimeout(saveLocal, 700); }
    function commit() { history.push(design); renderHistory(); scheduleSave(); }
    function renderHistory() { $('undo').disabled = !history.canUndo; $('redo').disabled = !history.canRedo; }
    function sync(id, value) { if (String($(id).value) !== String(value)) $(id).value = value; }
    function renderCanvas() {
        canvas.innerHTML = C.svgInner(design, side, { piece, guides: $('guides').checked, selected, prefix: 'editor' });
        canvas.setAttribute('aria-label', `Preview ${piece === 'pants' ? C.PANTS[design.pants.style] : C.modelLabel(design)}, sisi ${side === 'front' ? 'depan' : 'belakang'}. ${currentLayers().length} elemen. Gunakan daftar Lapisan untuk memilih elemen dengan keyboard.`);
    }
    function renderLayers() {
        const layers = currentLayers();
        $('layer-count').textContent = `${layers.length} elemen`;
        const nodes = layers.slice().reverse().map(layer => {
            const button = document.createElement('button');
            button.type = 'button'; button.className = 'ds-layer';
            button.setAttribute('aria-pressed', String(layer.id === selected));
            const icon = document.createElement('span'), label = document.createElement('span');
            icon.setAttribute('aria-hidden', 'true'); icon.textContent = layer.type === 'text' ? 'T' : layer.type === 'image' ? '▧' : '◆';
            label.textContent = layer.type === 'text' ? layer.text || '(Teks kosong)' : layer.type === 'image' ? 'Logo / gambar' : { circle: 'Lingkaran', rect: 'Kotak', star: 'Bintang' }[layer.shape];
            button.title = label.textContent; button.append(icon, label);
            button.addEventListener('click', () => { selected = layer.id; renderCanvas(); renderProperties(); updateLayerSelection(); });
            button.dataset.layer = layer.id;
            return button;
        });
        if (!nodes.length) { const empty = document.createElement('p'); empty.className = 'ds-muted'; empty.textContent = 'Sisi ini belum memiliki elemen.'; nodes.push(empty); }
        $('layers').replaceChildren(...nodes);
    }
    function updateLayerSelection() { all('[data-layer]').forEach(button => button.setAttribute('aria-pressed', String(button.dataset.layer === selected))); }
    function renderProperties() {
        const l = activeLayer(), index = currentLayers().findIndex(layer => layer.id === selected);
        $('selection-empty').hidden = Boolean(l); $('properties').hidden = !l;
        $('forward').disabled = !l || index === currentLayers().length - 1;
        $('backward').disabled = !l || index === 0;
        if (!l) return;
        $('text-properties').hidden = l.type !== 'text'; $('element-color-row').hidden = l.type === 'image';
        if (l.type === 'text') { sync('text', l.text); sync('font', l.font); $('bold').checked = l.bold; }
        if (l.color) sync('element-color', l.color);
        sync('scale', Math.round(l.scale * 100)); $('scale-value').textContent = `${Math.round(l.scale * 100)}%`;
        sync('rotation', Math.round(l.rotation)); $('rotation-value').textContent = `${Math.round(l.rotation)}°`;
        sync('x', Math.round(l.x)); sync('y', Math.round(l.y));
        $('overflow').hidden = !isOverflow(l);
        $('leg-controls').hidden = piece !== 'pants';
        $('center').textContent = piece === 'pants' ? 'Tengahkan pada kaki aktif' : 'Ratakan ke tengah';
    }
    function render() {
        if (piece === 'pants' && design.pants.style === 'none') { piece = 'shirt'; selected = null; }
        const data = currentData(), label = piece === 'pants' ? 'celana' : 'atasan';
        sync('name', design.name); sync('product', design.product); sync('collar', design.collar); sync('sleeves', design.sleeves); sync('pants-style', design.pants.style);
        sync('base', data.base); sync('accent', data.accent); sync('pattern', data.pattern); sync('material', data.material); sync('material-note', data.materialNote);
        $('material-custom').hidden = data.material !== 'custom';
        $('material-label').textContent = `Bahan kain ${label}`; $('pattern-label').textContent = `Motif ${label}`;
        $('editing-label').textContent = `SEDANG MENGEDIT ${label.toUpperCase()}`;
        $('keeper-note').hidden = design.product !== 'keeper'; $('pants-note').hidden = design.pants.style === 'none';
        $('edit-pants').disabled = design.pants.style === 'none'; $('match-shirt').hidden = piece !== 'pants';
        all('.ds-piece-switch [data-piece]').forEach(button => button.setAttribute('aria-pressed', String(button.dataset.piece === piece)));
        $('color-value').textContent = data.base.toUpperCase();
        all('[data-color]').forEach(button => button.setAttribute('aria-pressed', String(button.dataset.color === data.base)));
        all('[data-side]').forEach(button => button.setAttribute('aria-pressed', String(button.dataset.side === side)));
        $('side-label').textContent = `${label.toUpperCase()} / ${side === 'front' ? 'DEPAN' : 'BELAKANG'}`;
        renderCanvas(); renderProperties(); renderLayers(); renderHistory();
    }
    function switchTab(name, focus = false) {
        all('[data-tab]').forEach(button => {
            const active = button.dataset.tab === name;
            button.setAttribute('aria-selected', String(active)); button.tabIndex = active ? 0 : -1;
            $(`panel-${button.dataset.tab}`).hidden = !active;
            if (active && focus) button.focus();
        });
    }
    all('[data-tab]').forEach((button, index, tabs) => {
        button.addEventListener('click', () => switchTab(button.dataset.tab));
        button.addEventListener('keydown', event => {
            let next;
            if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
            if (event.key === 'ArrowLeft') next = (index + tabs.length - 1) % tabs.length;
            if (event.key === 'Home') next = 0;
            if (event.key === 'End') next = tabs.length - 1;
            if (next !== undefined) { event.preventDefault(); switchTab(tabs[next].dataset.tab, true); }
        });
    });
    all('[data-open-tab]').forEach(button => button.addEventListener('click', () => {
        switchTab(button.dataset.openTab, true);
        if (window.matchMedia('(max-width: 580px)').matches) $(`panel-${button.dataset.openTab}`).scrollIntoView({ block: 'nearest' });
    }));
    all('[data-side]').forEach(button => button.addEventListener('click', () => { history.push(design); side = button.dataset.side; selected = null; render(); }));
    all('.ds-piece-switch [data-piece]').forEach(button => button.addEventListener('click', () => { history.push(design); piece = button.dataset.piece; selected = null; render(); }));
    $('guides').addEventListener('change', renderCanvas);
    ['#10233d', '#f1eee6', '#111111', '#234acb', '#8b202c', '#173f36', '#e97132', '#7661a6'].forEach(hex => {
        const button = document.createElement('button'); button.type = 'button'; button.className = 'ds-swatch';
        button.style.backgroundColor = hex; button.dataset.color = hex; button.title = hex;
        button.setAttribute('aria-label', `Warna ${hex}`);
        button.addEventListener('click', () => { currentData().base = hex; commit(); render(); }); $('swatches').append(button);
    });
    function renderTemplates() {
        const term = $('template-search').value.trim().toLowerCase();
        const nodes = (library || C.TEMPLATES).filter(t => `${t.name} ${t.tag}`.toLowerCase().includes(term)).map(template => {
            const button = document.createElement('button'); button.type = 'button'; button.className = 'ds-template';
            button.setAttribute('aria-label', `Gunakan template ${template.name}`);
            if (template.url) {
                const img = document.createElement('img'); img.src = template.thumbnail; img.alt = `Preview ${template.name}`; img.loading = 'lazy';
                img.addEventListener('error', () => { img.hidden = true; }); button.append(img);
            } else {
                button.innerHTML = C.svgDocument(C.createDesign(template.id), 'front', { prefix: `template-${template.id}` });
                button.querySelector('svg').setAttribute('aria-hidden', 'true');
            }
            const name = document.createElement('strong'), tag = document.createElement('small');
            name.textContent = template.name; tag.textContent = template.tag; button.append(name, tag);
            button.addEventListener('click', async () => {
                if (template.url) {
                    button.disabled = true;
                    try {
                        const response = await fetch(template.url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                        if (!response.ok) throw new Error('Template sudah tidak tersedia. Muat ulang daftar template.');
                        const data = await response.json(), candidate = C.validateDesign(data.document);
                        await verifyImages(candidate);
                        history.push(design); candidate.quantities = design.quantities; candidate.notes = design.notes;
                        design = candidate; piece = 'shirt'; selected = null; commit(); render(); status(`Template ${template.name} diterapkan. Urungkan untuk kembali.`);
                    } catch (error) { status(error.message, true); }
                    finally { button.disabled = false; }
                    return;
                }
                history.push(design);
                const previous = design;
                design = C.createDesign(template.id);
                Object.assign(design, { name: previous.name, product: previous.product, collar: previous.collar, sleeves: previous.sleeves, material: previous.material, materialNote: previous.materialNote, pants: previous.pants, quantities: previous.quantities, notes: previous.notes });
                piece = 'shirt'; selected = null; commit(); render(); status(`Template ${template.name} diterapkan ke atasan depan dan belakang. Desain celana tetap tersimpan.`);
            }); return button;
        });
        if (!nodes.length) { const empty = document.createElement('p'); empty.className = 'ds-muted'; empty.textContent = 'Template tidak ditemukan.'; nodes.push(empty); }
        $('templates').replaceChildren(...nodes);
    }
    $('template-search').addEventListener('input', renderTemplates);
    async function loadTemplates(append = false) {
        if (!serverConfig.templatesUrl) return;
        const requestId = ++libraryRequest, page = append ? libraryPage + 1 : 1;
        $('more-templates').disabled = true;
        try {
            const url = new URL(serverConfig.templatesUrl); url.searchParams.set('page', page); url.searchParams.set('search', $('template-search').value.trim());
            const response = await fetch(url); if (!response.ok) throw new Error('Pustaka template belum tersedia.');
            const payload = await response.json(); if (requestId !== libraryRequest) return;
            const templates = payload.templates.map(item => ({ ...item, name: item.title, tag: item.category }));
            library = append && library ? library.concat(templates) : templates; libraryPage = page;
            $('more-templates').hidden = !payload.hasMore; $('more-templates').textContent = 'Muat template lainnya'; renderTemplates();
        } catch (_) {
            if (requestId === libraryRequest) {
                status('Daftar template belum dapat diperbarui. Klik Coba muat ulang template.', true);
                $('more-templates').hidden = false; $('more-templates').textContent = 'Coba muat ulang template';
            }
        }
        finally { if (requestId === libraryRequest) $('more-templates').disabled = false; }
    }
    $('more-templates').addEventListener('click', () => loadTemplates(true));
    let searchTimer;
    $('template-search').addEventListener('input', () => { clearTimeout(searchTimer); searchTimer = setTimeout(() => loadTemplates(), 250); });
    ['product', 'collar', 'sleeves'].forEach(id => $(id).addEventListener('change', () => { design[id] = $(id).value; commit(); render(); }));
    ['pattern', 'material'].forEach(id => $(id).addEventListener('change', () => { currentData()[id] = $(id).value; commit(); render(); }));
    $('pants-style').addEventListener('change', () => { design.pants.style = $('pants-style').value; selected = null; commit(); render(); });
    $('match-shirt').addEventListener('click', () => { Object.assign(design.pants, { base: design.base, accent: design.accent, pattern: design.pattern }); commit(); render(); });
    ['base', 'accent', 'name', 'material-note'].forEach(id => {
        $(id).addEventListener('input', () => {
            if (id === 'name') design.name = $(id).value;
            else currentData()[id === 'material-note' ? 'materialNote' : id] = $(id).value;
            scheduleSave(); renderCanvas(); if (id === 'base') $('color-value').textContent = currentData().base.toUpperCase();
        });
        $(id).addEventListener('change', () => { commit(); render(); });
    });
    function addLayer(layer, targetSide = side, targetPiece = piece) {
        const layers = C.layersFor(design, targetSide, targetPiece);
        if (layers.length >= 20) { status('Maksimal 20 elemen per sisi. Hapus elemen sebelum menambahkan lagi.', true); return; }
        layers.push(layer);
        if (JSON.stringify(design).length > C.MAX_FILE) {
            layers.pop(); status('Desain terlalu besar. Hapus beberapa gambar atau gunakan gambar lebih kecil.', true); return;
        }
        side = targetSide; piece = targetPiece; selected = layer.id; commit(); render();
    }
    $('add-text').addEventListener('click', () => {
        const value = $('new-text').value.trim();
        if (!value) { status('Tulis teks atau nomor terlebih dahulu.', true); $('new-text').focus(); return; }
        addLayer({ ...C.textLayer(uniqueId(), value, 300, piece === 'pants' ? 18 : 30, '#ffffff'), x: defaultX() }); $('new-text').value = '';
    });
    $('new-text').addEventListener('keydown', event => { if (event.key === 'Enter') { event.preventDefault(); $('add-text').click(); } });
    all('[data-shape]').forEach(button => button.addEventListener('click', () => addLayer({ id: uniqueId(), type: 'shape', shape: button.dataset.shape, x: defaultX(), y: 300, scale: piece === 'pants' ? .75 : 1, rotation: 0, color: currentData().accent })));

    const layerInputs = { text: ['text', v => v], font: ['font', v => v], 'element-color': ['color', v => v], scale: ['scale', v => C.clamp(Number(v) / 100, .25, 2)], rotation: ['rotation', v => C.clamp(Number(v), -180, 180)], x: ['x', v => C.clamp(Number(v), 180, 420)], y: ['y', v => C.clamp(Number(v), 190, 610)] };
    Object.entries(layerInputs).forEach(([id, [key, convert]]) => {
        $(id).addEventListener('input', () => {
            const layer = activeLayer(); if (!layer || (['x', 'y'].includes(id) && $(id).value === '')) return;
            layer[key] = convert($(id).value); scheduleSave(); renderCanvas();
            // Keep typing/caret and partially-entered numeric positions intact.
            $('scale-value').textContent = `${Math.round(layer.scale * 100)}%`;
            $('rotation-value').textContent = `${Math.round(layer.rotation)}°`;
            $('overflow').hidden = !isOverflow(layer);
            if (id === 'text') renderLayers();
        });
        $(id).addEventListener('change', () => { commit(); renderProperties(); });
    });
    $('bold').addEventListener('change', () => { const l = activeLayer(); if (l) { l.bold = $('bold').checked; commit(); renderCanvas(); } });
    function editSelected(edit) { const l = activeLayer(); if (!l) return; edit(l); commit(); render(); }
    $('center').addEventListener('click', () => editSelected(l => { l.x = piece === 'pants' ? (l.x < 300 ? 221 : 379) : 300; }));
    $('leg-left').addEventListener('click', () => editSelected(l => { l.x = 221; }));
    $('leg-right').addEventListener('click', () => editSelected(l => { l.x = 379; }));
    $('duplicate').addEventListener('click', () => {
        const layer = activeLayer(); if (!layer) return;
        addLayer({ ...C.clone(layer), id: uniqueId(), x: C.clamp(layer.x + 12, 180, 420), y: C.clamp(layer.y + 12, 190, 610) });
    });
    function deleteSelected() { if (!activeLayer()) return; currentData().sides[side] = currentLayers().filter(l => l.id !== selected); selected = null; commit(); render(); }
    $('delete').addEventListener('click', deleteSelected);
    function reorder(delta) {
        const layers = currentLayers(), index = layers.findIndex(l => l.id === selected), target = index + delta;
        if (index < 0 || target < 0 || target >= layers.length) return;
        [layers[index], layers[target]] = [layers[target], layers[index]]; commit(); render();
    }
    $('forward').addEventListener('click', () => reorder(1)); $('backward').addEventListener('click', () => reorder(-1));
    function undo() { history.push(design); design = history.undo(); selected = null; scheduleSave(); render(); }
    function redo() { design = history.redo(); selected = null; scheduleSave(); render(); }
    $('undo').addEventListener('click', undo); $('redo').addEventListener('click', redo);
    function point(event) {
        const p = canvas.createSVGPoint(); p.x = event.clientX; p.y = event.clientY;
        return p.matrixTransform(canvas.getScreenCTM().inverse());
    }
    canvas.addEventListener('pointerdown', event => {
        if (event.button !== 0 || drag) return;
        const target = event.target.closest('[data-layer-id]');
        selected = target ? target.dataset.layerId : null;
        const layer = activeLayer();
        if (layer) {
            const p = point(event); drag = { id: event.pointerId, x: p.x, y: p.y, startX: layer.x, startY: layer.y };
            canvas.setPointerCapture(event.pointerId); event.preventDefault();
        }
        canvas.focus({ preventScroll: true }); renderCanvas(); renderProperties(); updateLayerSelection();
    });
    canvas.addEventListener('pointermove', event => {
        if (!drag || event.pointerId !== drag.id) return;
        const layer = activeLayer(); if (!layer) return;
        const p = point(event); layer.x = Math.round(C.clamp(drag.startX + p.x - drag.x, 180, 420)); layer.y = Math.round(C.clamp(drag.startY + p.y - drag.y, 190, 610));
        renderCanvas(); renderProperties();
    });
    function endDrag(event) {
        if (!drag || (event && event.pointerId !== drag.id)) return;
        const id = drag.id; drag = null;
        if (canvas.hasPointerCapture(id)) canvas.releasePointerCapture(id);
        commit();
    }
    canvas.addEventListener('pointerup', endDrag); canvas.addEventListener('pointercancel', endDrag); canvas.addEventListener('lostpointercapture', endDrag);
    canvas.addEventListener('keydown', event => {
        const moves = { ArrowLeft: [-1, 0], ArrowRight: [1, 0], ArrowUp: [0, -1], ArrowDown: [0, 1] };
        if (moves[event.key] && activeLayer()) {
            event.preventDefault(); const d = moves[event.key], step = event.shiftKey ? 10 : 1;
            editSelected(l => { l.x = C.clamp(l.x + d[0] * step, 180, 420); l.y = C.clamp(l.y + d[1] * step, 190, 610); });
        }
        if (event.key === 'Delete' || event.key === 'Backspace') { event.preventDefault(); deleteSelected(); }
        if (event.key === 'Escape') { selected = null; render(); }
    });
    document.addEventListener('keydown', event => {
        if (dialog.open) return;
        const typing = event.target.matches('input,textarea,select,[contenteditable="true"]');
        if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 's') { event.preventDefault(); saveProject(); }
        if (typing) return;
        if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'z') { event.preventDefault(); event.shiftKey ? redo() : undo(); }
        if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'y') { event.preventDefault(); redo(); }
    });

    function loadImage(src) { return new Promise((resolve, reject) => { const img = new Image(); img.onload = () => resolve(img); img.onerror = () => reject(new Error('Gambar tidak dapat dibaca. Pilih PNG, JPG, atau WebP yang valid.')); img.src = src; }); }
    async function addImage(file) {
        if (!file) return;
        if (!['image/png', 'image/jpeg', 'image/webp'].includes(file.type) || file.size > 5 * 1024 * 1024) { status('Gunakan PNG, JPG, atau WebP dengan ukuran maksimal 5 MB.', true); return; }
        const targetSide = side, targetPiece = piece, url = URL.createObjectURL(file);
        $('image').disabled = true; status('Menyiapkan gambar…');
        try {
            const img = await loadImage(url);
            if (!img.naturalWidth || img.naturalWidth * img.naturalHeight > 24000000) throw new Error('Resolusi gambar terlalu besar. Gunakan gambar maksimal 24 megapiksel.');
            const ratio = Math.min(1, 1200 / Math.max(img.naturalWidth, img.naturalHeight));
            const scratch = document.createElement('canvas'); scratch.width = Math.max(1, Math.round(img.naturalWidth * ratio)); scratch.height = Math.max(1, Math.round(img.naturalHeight * ratio));
            scratch.getContext('2d').drawImage(img, 0, 0, scratch.width, scratch.height);
            let src = scratch.toDataURL('image/png');
            if (src.length > 1800000) src = scratch.toDataURL('image/webp', .85);
            if (src.length > 1800000) throw new Error('Gambar masih terlalu besar setelah dioptimalkan. Gunakan logo dengan resolusi lebih kecil.');
            const scale = Math.min((targetPiece === 'pants' ? 70 : 160) / img.naturalWidth, (targetPiece === 'pants' ? 90 : 180) / img.naturalHeight);
            const width = Math.max(1, img.naturalWidth * scale), height = Math.max(1, img.naturalHeight * scale);
            addLayer({ id: uniqueId(), type: 'image', src, x: defaultX(targetPiece), y: 270, width, height, rotation: 0, scale: 1 }, targetSide, targetPiece);
        } catch (error) { status(error.message, true); }
        finally { URL.revokeObjectURL(url); $('image').disabled = false; $('image').value = ''; }
    }
    $('image').addEventListener('change', event => addImage(event.target.files[0]));
    ['dragenter', 'dragover'].forEach(type => $('drop').addEventListener(type, event => { event.preventDefault(); $('drop').classList.add('is-over'); }));
    ['dragleave', 'drop'].forEach(type => $('drop').addEventListener(type, event => { event.preventDefault(); $('drop').classList.remove('is-over'); }));
    $('drop').addEventListener('drop', event => { if (!$('image').disabled) addImage(event.dataTransfer.files[0]); });
    async function verifyImages(candidate) {
        const sources = [...new Set(C.PIECES.flatMap(p => C.SIDES.flatMap(s => C.layersFor(candidate, s, p).filter(l => l.type === 'image').map(l => l.src))))];
        for (const src of sources) {
            const img = await loadImage(src);
            if (!img.naturalWidth || img.naturalWidth * img.naturalHeight > 24000000) throw new Error('File desain memuat gambar dengan resolusi terlalu besar.');
        }
    }
    $('import').addEventListener('change', async event => {
        const file = event.target.files[0]; if (!file) return;
        $('import').disabled = true;
        try {
            if (file.size > C.MAX_FILE) throw new Error('File desain maksimal 8 MB.');
            const candidate = C.validateDesign(JSON.parse(await file.text()));
            await verifyImages(candidate); history.push(design); design = candidate; piece = 'shirt'; selected = null;
            commit(); render(); status('File desain berhasil dibuka. Kedua sisi dapat diedit kembali.');
        } catch (error) { status(error instanceof SyntaxError ? 'JSON tidak dapat dibaca. Gunakan file desain yang diunduh dari Sagara.' : error.message, true); }
        finally { $('import').disabled = false; $('import').value = ''; }
    });
    try {
        const raw = serverConfig.admin ? null : localStorage.getItem(STORAGE_KEY);
        if (raw && raw.length <= C.MAX_FILE) { pendingDraft = C.validateDesign(JSON.parse(raw)); $('draft').hidden = false; }
    } catch (_) { status('Draft lama tidak dapat dibaca. Anda tetap bisa membuat desain baru.', true); }
    $('restore').addEventListener('click', async () => {
        if (!pendingDraft) return;
        const candidate = pendingDraft;
        $('restore').disabled = true;
        try {
            await verifyImages(candidate);
            if (pendingDraft !== candidate) return;
            history.push(design); design = candidate; pendingDraft = null; piece = 'shirt'; selected = null;
            $('draft').hidden = true; commit(); render(); status('Draft dilanjutkan.');
        } catch (error) { status(error.message, true); }
        finally { $('restore').disabled = false; }
    });
    $('dismiss-draft').addEventListener('click', () => { pendingDraft = null; $('draft').hidden = true; saveLocal(); });

    function filename(suffix) { return `${(design.name.trim() || 'sagara-design').replace(/[^a-zA-Z0-9_-]+/g, '-').slice(0, 60)}-${suffix}`; }
    function download(blob, name) {
        const url = URL.createObjectURL(blob), a = document.createElement('a'); a.href = url; a.download = name;
        document.body.append(a); a.click(); a.remove(); setTimeout(() => URL.revokeObjectURL(url), 30000);
    }
    function saveProject() {
        try {
            const clean = C.validateDesign(design), json = JSON.stringify(clean);
            download(new Blob([json], { type: 'application/json' }), filename('desain.json'));
            fileSaved = JSON.stringify(design); saveLocal();
            exportStatus('File desain diunduh. Gunakan Buka file desain untuk mengeditnya kembali.');
        } catch (error) { status(error.message, true); exportStatus(error.message, true); }
    }
    $('save').addEventListener('click', saveProject); $('download-json').addEventListener('click', saveProject);
    function updateQuote() {
        let valid = true;
        all('[data-size]').forEach(input => {
            const value = Number(input.value);
            const ok = input.value !== '' && Number.isInteger(value) && value >= 0 && value <= 999;
            input.setAttribute('aria-invalid', String(!ok));
            if (ok) design.quantities[input.dataset.size] = value;
            else valid = false;
        });
        const total = C.SIZES.reduce((sum, size) => sum + design.quantities[size], 0);
        $('qty-total').textContent = valid ? `Total ${total} ${design.pants.style === 'none' ? 'pcs' : 'set'}` : 'Isi jumlah 0–999 per ukuran';
        valid = valid && total > 0 && [design, ...(design.pants.style === 'none' ? [] : [design.pants])].every(data => data.material !== 'custom' || data.materialNote.trim());
        $('whatsapp').setAttribute('aria-disabled', String(!valid));
        if (valid) $('whatsapp').href = `https://wa.me/6282137300307?text=${encodeURIComponent(C.quoteMessage(design))}`;
        else $('whatsapp').removeAttribute('href');
        return valid;
    }
    all('[data-size]').forEach(input => { input.addEventListener('input', () => { updateQuote(); scheduleSave(); }); input.addEventListener('change', commit); });
    $('notes').addEventListener('input', () => { design.notes = $('notes').value; updateQuote(); scheduleSave(); });
    $('notes').addEventListener('change', commit);
    $('whatsapp').addEventListener('click', event => { if (!updateQuote()) { event.preventDefault(); exportStatus('Isi jumlah minimal 1 dan lengkapi nama bahan bila memilih Bahan lainnya.', true); } });
    $('review').addEventListener('click', () => {
        history.push(design); renderHistory();
        $('export-preview').innerHTML = C.boardSvg(design);
        $('set-size-note').hidden = design.pants.style === 'none';
        const specs = [['Model', C.PRODUCTS[design.product]], ['Leher / kerah', C.COLLARS[design.collar]], ['Lengan', C.SLEEVES[design.sleeves]], ['Bahan atasan', C.materialLabel(design)], ['Paket', C.PANTS[design.pants.style]]];
        if (design.pants.style !== 'none') specs.push(['Bahan celana', C.materialLabel(design.pants)]);
        $('order-specs').replaceChildren(...specs.map(([label, value]) => {
            const row = document.createElement('div'), term = document.createElement('dt'), detail = document.createElement('dd');
            term.textContent = label; detail.textContent = value; row.append(term, detail); return row;
        }));
        all('[data-size]').forEach(input => { input.value = design.quantities[input.dataset.size]; });
        $('notes').value = design.notes; updateQuote();
        const overflow = C.PIECES.filter(p => p === 'shirt' || design.pants.style !== 'none').some(p => C.SIDES.some(s => C.layersFor(design, s, p).some(layer => C.overflows(layer, C.areasFor(design, p)))));
        exportStatus(overflow ? 'Ada elemen di luar area desain yang terpotong pada hasil. Tutup dan perbaiki posisinya bila diperlukan.' : '', overflow);
        dialog.showModal();
    });
    $('close-dialog').addEventListener('click', () => dialog.close());
    dialog.addEventListener('close', () => { commit(); $('review').focus(); });
    $('download-svg').addEventListener('click', () => {
        try {
            download(new Blob([C.svgDocument(C.validateDesign(design), side, { piece })], { type: 'image/svg+xml' }), filename(`${piece === 'pants' ? 'celana' : 'atasan'}-${side === 'front' ? 'depan' : 'belakang'}.svg`));
            exportStatus(`Mockup SVG ${piece === 'pants' ? 'celana' : 'atasan'} sisi aktif diunduh.`);
        } catch (error) { exportStatus(error.message, true); }
    });
    $('download-png').addEventListener('click', async () => {
        const button = $('download-png'); button.disabled = true; exportStatus('Menyiapkan PNG resolusi tinggi…');
        let url;
        try {
            const svg = C.boardSvg(C.validateDesign(design));
            url = URL.createObjectURL(new Blob([svg], { type: 'image/svg+xml;charset=utf-8' }));
            const img = await loadImage(url), output = document.createElement('canvas'); output.width = 2400; output.height = 1600;
            const ctx = output.getContext('2d'); if (!ctx) throw new Error('Browser tidak mendukung ekspor PNG. Gunakan unduhan SVG.');
            ctx.drawImage(img, 0, 0, output.width, output.height);
            const blob = await new Promise(resolve => output.toBlob(resolve, 'image/png'));
            if (!blob) throw new Error('PNG gagal dibuat. Coba lagi atau gunakan unduhan SVG.');
            download(blob, filename('mockup.png')); exportStatus('PNG seluruh paket depan dan belakang diunduh. Lampirkan gambar ini saat menghubungi Sagara.');
        } catch (error) { exportStatus(error.message, true); }
        finally { if (url) URL.revokeObjectURL(url); button.disabled = false; }
    });
    window.addEventListener('beforeunload', event => {
        if (!localSaved) saveLocal();
        if (!localSaved && JSON.stringify(design) !== fileSaved) { event.preventDefault(); event.returnValue = ''; }
    });
    document.addEventListener('visibilitychange', () => { if (document.hidden && !localSaved) saveLocal(); });
    async function thumbnail(document) {
        let url;
        try {
            url = URL.createObjectURL(new Blob([C.boardSvg(document)], { type: 'image/svg+xml' }));
            const img = await loadImage(url), output = window.document.createElement('canvas'); output.width = 600; output.height = 400;
            output.getContext('2d').drawImage(img, 0, 0, 600, 400);
            const result = output.toDataURL('image/png'); return result.length <= 600000 ? result : null;
        } catch (_) { return null; }
        finally { if (url) URL.revokeObjectURL(url); }
    }
    async function serverRequest(url, payload) {
        const body = JSON.stringify(payload);
        if (new Blob([body]).size > C.MAX_FILE) throw new Error('Kiriman melebihi 8 MB. Kurangi gambar atau simpan file desain terlebih dahulu.');
        const response = await fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', [serverConfig.csrfHeader || 'X-CSRF-TOKEN']: serverConfig.csrf || '' }, body });
        let result;
        try { result = await response.json(); } catch (_) { throw new Error('Sesi atau koneksi bermasalah. Simpan file desain lalu muat ulang halaman.'); }
        if (result.csrf) serverConfig.csrf = result.csrf;
        if (!response.ok) throw new Error(result.error || 'Permintaan gagal. Simpan file desain lalu muat ulang halaman.');
        return result;
    }
    window.SagaraStudio = {
        config: serverConfig,
        getDocument: () => C.validateDesign(C.clone(design)),
        async setDocument(document) {
            const candidate = C.validateDesign(document); await verifyImages(candidate); design = candidate;
            piece = 'shirt'; selected = null; history = new C.History(design); render(); fileSaved = JSON.stringify(design); localSaved = true;
        },
        markSaved() { fileSaved = JSON.stringify(design); localSaved = true; clearTimeout(saveTimer); },
        thumbnail, request: serverRequest,
    };
    if ($('submit-form')) {
        let submitted = '';
        $('submit-form').addEventListener('submit', async event => {
            event.preventDefault();
            if (!updateQuote() || !$('submit-form').reportValidity() || !/^[0-9]{8,15}$/.test($('customer-phone').value.replace(/\D/g, ''))) { $('submit-status').textContent = 'Lengkapi nama, nomor WhatsApp (8–15 digit), jumlah, dan pilihan bahan.'; return; }
            if (!serverConfig.submitUrl) { $('submit-status').textContent = 'Penerimaan desain belum tersedia.'; return; }
            const document = C.validateDesign(C.clone(design));
            const payload = { document, customer_name: $('customer-name').value.trim(), customer_phone: $('customer-phone').value.trim() };
            const fingerprint = JSON.stringify(payload);
            if (submitted === fingerprint) { $('submit-status').textContent = 'Versi desain ini sudah diterima admin. Ubah desain bila ingin mengirim revisi.'; return; }
            $('submit').disabled = true; $('submit-status').textContent = 'Menyimpan desain ke admin…';
            try {
                const result = await serverRequest(serverConfig.submitUrl, { ...payload, thumbnail: await thumbnail(document) });
                submitted = fingerprint; $('submit-status').textContent = `${result.message} Referensi: ${result.code}`;
            } catch (error) { $('submit-status').textContent = error.message; }
            finally { $('submit').disabled = false; }
        });
    }
    renderTemplates(); render();
    loadTemplates();
    window.dispatchEvent(new Event('sagara-studio-ready'));
}());
