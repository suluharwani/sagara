const test = require('node:test');
const assert = require('node:assert/strict');
const C = require('../../public/assets/js/design-studio-core.js');

test('all templates produce editable, valid documents without clipped initial text', () => {
    for (const template of C.TEMPLATES) {
        const doc = C.createDesign(template.id);
        assert.deepEqual(C.validateDesign(JSON.parse(JSON.stringify(doc))), doc);
        for (const side of C.SIDES) assert.ok(doc.sides[side].every(layer => !C.overflows(layer)));
    }
});

test('front and back edits survive serialization independently', () => {
    const doc = C.createDesign();
    doc.sides.front[0].text = 'GARUDA FC';
    doc.sides.back[1].text = '10';
    doc.sides.back[1].rotation = 12;
    const restored = C.validateDesign(JSON.parse(JSON.stringify(doc)));
    assert.equal(restored.sides.front[0].text, 'GARUDA FC');
    assert.equal(restored.sides.back[1].text, '10');
    assert.equal(restored.sides.back[1].rotation, 12);
    assert.match(C.svgDocument(restored, 'front'), /GARUDA FC/);
    assert.doesNotMatch(C.svgDocument(restored, 'back'), /GARUDA FC/);
});

test('user text and names cannot inject SVG markup', () => {
    const doc = C.createDesign();
    doc.name = '<script>alert(1)</script>';
    doc.sides.front[0].text = '<image onload="alert(1)"/>';
    const svg = C.boardSvg(C.validateDesign(doc));
    assert.doesNotMatch(svg, /<script|<image onload/);
    assert.match(svg, /&lt;script&gt;/);
    assert.match(svg, /&lt;image onload=&quot;/);
});

test('untrusted documents reject invalid versions, attributes, IDs and coordinates', () => {
    const cases = [
        doc => { doc.version = 3; }, doc => { doc.product = '__proto__'; }, doc => { doc.product = ['player']; },
        doc => { doc.base = '#fff" onload="alert(1)'; },
        doc => { doc.sides.back[0].id = doc.sides.front[0].id; },
        doc => { doc.sides.front[0].x = NaN; }, doc => { doc.sides.front[0].scale = 100; },
        doc => { doc.sides.front[0].rotation = Infinity; }, doc => { doc.sides.front[0].font = 'url(https://example.com)'; },
        doc => { doc.sides.front[0].text = 'x'.repeat(41); }, doc => { doc.name = 'invalid\u0000xml'; },
        doc => { doc.sides.front = new Array(21).fill(doc.sides.front[0]); },
        doc => { doc.quantities.M = -1; }, doc => { doc.quantities.M = 1.5; },
        doc => { doc.quantities.M = '2'; }, doc => { doc.quantities.M = 1000; },
    ];
    for (const mutate of cases) { const doc = C.createDesign(); mutate(doc); assert.throws(() => C.validateDesign(doc)); }
    for (const value of [null, {}, [], 'bad', 10]) assert.throws(() => C.validateDesign(value));
});

test('legacy v1 documents migrate without changing either shirt design', () => {
    for (const [product, collar, sleeves] of [['jersey', 'v-classic', 'short'], ['tshirt', 'round-classic', 'short'], ['longsleeve', 'v-classic', 'long']]) {
        const old = C.createDesign(); old.version = 1; old.product = product;
        for (const key of ['collar', 'sleeves', 'material', 'materialNote', 'pants']) delete old[key];
        old.sides.back[1].text = '99';
        const before = C.clone(old), migrated = C.validateDesign(old);
        assert.equal(migrated.version, 2); assert.equal(migrated.product, 'player');
        assert.equal(migrated.collar, collar); assert.equal(migrated.sleeves, sleeves);
        assert.equal(migrated.pants.style, 'none'); assert.deepEqual(migrated.sides, old.sides);
        assert.deepEqual(old, before); assert.deepEqual(C.validateDesign(migrated), migrated);
    }
});

test('all collars and sleeve variants produce distinct garments for player and keeper', () => {
    const outputs = new Set();
    for (const product of Object.keys(C.PRODUCTS)) for (const collar of Object.keys(C.COLLARS)) for (const sleeves of Object.keys(C.SLEEVES)) {
        const doc = Object.assign(C.createDesign(), { product, collar, sleeves });
        assert.deepEqual(C.validateDesign(doc), doc);
        const svg = C.svgInner(doc, 'front'); outputs.add(svg);
        assert.equal(svg.includes('data-keeper-panels'), product === 'keeper');
        assert.ok(!svg.includes('undefined'));
    }
    assert.equal(outputs.size, 24);
});

test('pants keep independent front/back artwork and material through roundtrip', () => {
    const doc = C.createDesign(); doc.material = 'serena';
    Object.assign(doc.pants, { style: 'short', base: '#ff3300', accent: '#123456', pattern: 'stripe', material: 'milano' });
    doc.pants.sides.front[0].text = '21';
    doc.pants.sides.back.push({ ...C.textLayer('pants-back', 'GK', 300, 22, '#ffffff'), x: 379 });
    const clean = C.validateDesign(JSON.parse(JSON.stringify(doc)));
    assert.deepEqual(clean, doc);
    assert.match(C.svgDocument(clean, 'front', { piece: 'pants' }), />21<\/text>/);
    assert.doesNotMatch(C.svgDocument(clean, 'front', { piece: 'pants' }), /NAMA PEMAIN|SAGARA<\/text>/);
    assert.match(C.svgDocument(clean, 'back', { piece: 'pants' }), />GK<\/text>/);
    assert.equal(clean.material, 'serena'); assert.equal(clean.pants.material, 'milano');
});

test('disabled pants stay editable in the file but are absent from exports and quote', () => {
    const doc = C.createDesign(); doc.pants.sides.front[0].text = 'PANTS-ONLY';
    doc.pants.material = 'milano'; doc.pants.style = 'none';
    assert.doesNotMatch(C.boardSvg(doc), /PANTS-ONLY|Bahan celana/);
    assert.doesNotMatch(C.quoteMessage(doc), /Bahan celana/);
    assert.equal(C.svgInner(doc, 'front', { piece: 'pants' }), '');
    const restored = C.validateDesign(JSON.parse(JSON.stringify(doc))); restored.pants.style = 'long';
    assert.match(C.boardSvg(restored), /PANTS-ONLY/);
    assert.equal(restored.pants.material, 'milano');
});

test('pants clipping detects crotch gap and short hems while allowing either leg', () => {
    const doc = C.createDesign(); doc.pants.style = 'short';
    const layer = doc.pants.sides.front[0];
    assert.equal(C.overflows(layer, C.areasFor(doc, 'pants')), false);
    layer.x = 300; assert.equal(C.overflows(layer, C.areasFor(doc, 'pants')), true);
    layer.x = 379; assert.equal(C.overflows(layer, C.areasFor(doc, 'pants')), false);
    layer.y = 550; assert.equal(C.overflows(layer, C.areasFor(doc, 'pants')), true);
    doc.pants.style = 'long'; assert.equal(C.overflows(layer, C.areasFor(doc, 'pants')), false);
});

test('v2 rejects invalid options and malicious pants layers even when pants are disabled', () => {
    const mutations = [
        d => { d.collar = 'unknown'; }, d => { d.sleeves = ['short']; },
        d => { d.pants.style = 'mini'; }, d => { d.material = '__proto__'; },
        d => { d.pants.materialNote = 'x'.repeat(81); }, d => { d.pants.base = 'red'; },
        d => { d.pants.sides.front[0].id = d.sides.front[0].id; },
        d => { d.pants.sides.front[0].font = 'url(evil)'; }, d => { delete d.pants; },
    ];
    for (const mutate of mutations) { const doc = C.createDesign(); mutate(doc); assert.throws(() => C.validateDesign(doc)); }
});

test('set export and quotation include keeper, collar, sleeves, pants and both fabrics', () => {
    const doc = C.createDesign(); Object.assign(doc, { product: 'keeper', collar: 'polo-zip', sleeves: 'long', material: 'serena' });
    Object.assign(doc.pants, { style: 'long', material: 'custom', materialNote: 'Bahan tim & klub' });
    const svg = C.boardSvg(doc), quote = C.quoteMessage(doc);
    for (const expected of ['Keeper / kiper', 'Kerah polo resleting', 'Lengan panjang', 'Celana panjang', 'Serena']) {
        assert.ok(svg.includes(expected)); assert.ok(quote.includes(expected));
    }
    assert.match(svg, /Bahan tim &amp; klub/); assert.match(quote, /Bahan tim & klub/);
    assert.match(quote, /Total: 1 set \(atasan \+ celana\)/);
    const ids = [...svg.matchAll(/\bid="([^"]+)"/g)].map(m => m[1]);
    assert.equal(ids.length, new Set(ids).size);
    assert.match(svg, /board-pants-front-area/); assert.match(svg, /board-pants-back-area/);
});

test('import accepts embedded raster and rejects SVG, remote and script image sources', () => {
    const doc = C.createDesign();
    const image = { id: 'logo', type: 'image', x: 300, y: 200, scale: 1, rotation: 0, width: 40, height: 40, src: 'data:image/png;base64,iVBORw0KGgo=' };
    doc.sides.front.push(image);
    assert.equal(C.validateDesign(doc).sides.front[2].type, 'image');
    for (const src of ['https://example.com/logo.png', 'javascript:alert(1)', 'data:image/svg+xml;base64,PHN2Zz4=', 'data:text/html;base64,PHN2Zz4=']) {
        image.src = src; assert.throws(() => C.validateDesign(doc));
    }
});

test('unknown imported fields are discarded', () => {
    const doc = C.createDesign(); doc.html = '<script/>'; doc.sides.front[0].onclick = 'alert(1)';
    const clean = C.validateDesign(doc);
    assert.equal(clean.html, undefined); assert.equal(clean.sides.front[0].onclick, undefined);
});

test('undo/redo restores both sides and drops redo after a new edit', () => {
    const initial = C.createDesign(), history = new C.History(initial);
    const changed = C.clone(initial); changed.base = '#ff0000'; changed.sides.back[1].text = '99'; history.push(changed);
    assert.deepEqual(history.undo(), initial); assert.deepEqual(history.redo(), changed);
    const branch = history.undo(); branch.sides.front[0].text = 'NEW TEAM'; history.push(branch);
    assert.equal(history.canRedo, false); assert.equal(history.undo().sides.front[0].text, 'SAGARA');
});

test('history is bounded and duplicate commits do not consume undo steps', () => {
    const doc = C.createDesign(), history = new C.History(doc);
    history.push(doc); assert.equal(history.canUndo, false);
    for (let n = 0; n < 50; n++) { doc.name = `Desain ${n}`; history.push(doc); }
    assert.ok(history.entries.length <= 35); assert.equal(history.undo().name, 'Desain 48');
});

test('rotated/scaled elements report clipping against the printable area', () => {
    const layer = { id: 'test', type: 'shape', shape: 'rect', x: 230, y: 300, color: '#ffffff', scale: 1, rotation: 0 };
    assert.equal(C.overflows(layer), false);
    layer.rotation = 45; assert.equal(C.overflows(layer), true);
    layer.x = 300; assert.equal(C.overflows(layer), false);
    layer.scale = 2; layer.x = 380; assert.equal(C.overflows(layer), true);
});

test('mockup export omits editing guides and separates front/back clip IDs', () => {
    const doc = C.createDesign(), board = C.boardSvg(doc);
    assert.match(board, /width="1200" height="800"/);
    assert.match(board, /board-front-area/); assert.match(board, /board-back-area/);
    const ids = [...board.matchAll(/\bid="([^"]+)"/g)].map(match => match[1]);
    assert.equal(new Set(ids).size, ids.length);
    assert.doesNotMatch(board, /AREA DESAIN|stroke-dasharray/);
    assert.match(C.svgInner(doc, 'front', { guides: true }), /AREA DESAIN/);
});

test('quote carries model, sizes, total and notes without inventing price or attachment', () => {
    const doc = C.createDesign(); doc.quantities.M = 12; doc.quantities.XL = 5; doc.notes = 'Nama pemain berbeda';
    const message = C.quoteMessage(doc);
    assert.match(message, /M: 12, XL: 5/); assert.match(message, /Total: 17 pcs/);
    assert.match(message, /Nama pemain berbeda/); assert.match(message, /akan melampirkan/);
    assert.doesNotMatch(message, /Rp|telah dikirim|sudah dilampirkan/);
});
