/* Shared, dependency-free document model and SVG renderer. No uploaded SVG/HTML is executed. */
(function (root, factory) {
    if (typeof module === 'object' && module.exports) module.exports = factory();
    else root.SagaraDesign = factory();
}(typeof globalThis !== 'undefined' ? globalThis : this, function () {
    'use strict';
    const SIDES = ['front', 'back'];
    const PRODUCTS = { player: 'Pemain / reguler', keeper: 'Keeper / kiper' };
    const COLLARS = { 'v-classic': 'V-neck klasik', 'v-cross': 'V-neck silang', 'round-classic': 'Round neck klasik', 'round-rib': 'Round neck rib', 'polo-button': 'Kerah polo kancing', 'polo-zip': 'Kerah polo resleting' };
    const SLEEVES = { short: 'Lengan pendek', long: 'Lengan panjang' };
    const PANTS = { none: 'Tanpa celana', short: 'Celana pendek', long: 'Celana panjang' };
    // References already used in Sagara's product archive; availability is confirmed in the quote.
    const MATERIALS = { undecided: 'Bantu pilihkan bahan', milano: 'Milano', serena: 'Serena', emboss: 'Emboss', jarum: 'Jarum', custom: 'Bahan lainnya' };
    const PIECES = ['shirt', 'pants'];
    const PATTERNS = ['plain', 'diagonal', 'stripe', 'chevron', 'split', 'hoops'];
    const FONTS = ['Arial', 'Impact', 'Georgia', 'Courier New'];
    const SIZES = ['S', 'M', 'L', 'XL', '2XL', '3XL'];
    const AREA = { x: 180, y: 190, width: 240, height: 420 };
    const MAX_FILE = 8 * 1024 * 1024;
    const TEMPLATES = [
        { id: 'velocity', name: 'Velocity', tag: 'Sport · Diagonal', base: '#10233d', accent: '#c7f000', pattern: 'diagonal' },
        { id: 'heritage', name: 'Heritage', tag: 'Classic · Garis', base: '#8b202c', accent: '#f1e6d3', pattern: 'stripe' },
        { id: 'electric', name: 'Electric', tag: 'Bold · Chevron', base: '#234acb', accent: '#72f0d2', pattern: 'chevron' },
        { id: 'mono', name: 'Essential', tag: 'Minimal · Polos', base: '#f1eee6', accent: '#18232e', pattern: 'plain' },
        { id: 'duo', name: 'Duo Club', tag: 'Team · Dua warna', base: '#173f36', accent: '#f3d593', pattern: 'split' },
        { id: 'rally', name: 'Rally', tag: 'Retro · Horizontal', base: '#e97132', accent: '#192e40', pattern: 'hoops' },
    ];
    const clone = value => JSON.parse(JSON.stringify(value));
    const escape = value => String(value).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&apos;' }[c]));
    const clamp = (n, min, max) => Math.min(max, Math.max(min, n));
    function textLayer(id, text, y, size, color) {
        return { id, type: 'text', text, x: 300, y, size, scale: 1, rotation: 0, color, font: 'Arial', bold: true };
    }
    function createDesign(templateId = 'velocity') {
        const t = TEMPLATES.find(item => item.id === templateId) || TEMPLATES[0];
        const ink = t.id === 'mono' ? '#18232e' : '#ffffff';
        return { version: 2, name: 'Sagara Team', product: 'player', collar: 'v-classic', sleeves: 'short', material: 'undecided', materialNote: '', base: t.base, accent: t.accent, pattern: t.pattern,
            sides: { front: [textLayer('front-team', 'SAGARA', 300, 37, ink), textLayer('front-tag', 'YOUR TEAM', 340, 13, ink)],
                back: [textLayer('back-name', 'NAMA PEMAIN', 260, 22, ink), textLayer('back-number', '07', 385, 125, ink)] },
            pants: createPants(t.base, t.accent),
            quantities: { S: 0, M: 1, L: 0, XL: 0, '2XL': 0, '3XL': 0 }, notes: '' };
    }
    function createPants(base = '#10233d', accent = '#c7f000') {
        return { style: 'none', base, accent, pattern: 'plain', material: 'undecided', materialNote: '', sides: { front: [{ ...textLayer('pants-number', '07', 290, 42, '#ffffff'), x: 221 }], back: [] } };
    }
    const pieceData = (design, piece = 'shirt') => piece === 'pants' ? design.pants : design;
    const layersFor = (design, side, piece = 'shirt') => pieceData(design, piece).sides[side];
    function areasFor(design, piece = 'shirt') {
        if (piece === 'shirt') return [AREA];
        const height = design.pants.style === 'short' ? 240 : 410;
        return [{ x: 180, y: 200, width: 82, height }, { x: 338, y: 200, width: 82, height }];
    }
    const materialLabel = data => data.material === 'custom' ? `Lainnya: ${data.materialNote.trim() || 'belum diisi'}` : MATERIALS[data.material];
    const modelLabel = design => `${PRODUCTS[design.product]} · ${COLLARS[design.collar]} · ${SLEEVES[design.sleeves]}`;
    function color(value) { return typeof value === 'string' && /^#[0-9a-f]{6}$/i.test(value); }
    function finite(value, min, max) { return typeof value === 'number' && Number.isFinite(value) && value >= min && value <= max; }
    function boundedString(value, max) { return typeof value === 'string' && value.length <= max && !/[\u0000-\u0008\u000b\u000c\u000e-\u001f\ufffe\uffff]/.test(value); }
    function validateDesign(raw) {
        const fail = () => { throw new Error('File desain tidak valid atau versinya belum didukung. Gunakan file JSON dari Sagara Design Studio.'); };
        if (!raw || ![1, 2].includes(raw.version)) fail();
        if (raw.version === 1) {
            if (!['jersey', 'tshirt', 'longsleeve'].includes(raw.product)) fail();
            raw = { ...raw, version: 2, product: 'player', collar: raw.product === 'tshirt' ? 'round-classic' : 'v-classic', sleeves: raw.product === 'longsleeve' ? 'long' : 'short', material: 'undecided', materialNote: '', pants: createPants(raw.base, raw.accent) };
            // A legacy project may already use the new default pants-layer ID.
            raw.pants.sides.front = [];
        }
        const choice = (map, value) => typeof value === 'string' && Object.hasOwn(map, value);
        if (!choice(PRODUCTS, raw.product) || !choice(COLLARS, raw.collar) || !choice(SLEEVES, raw.sleeves) || !boundedString(raw.name, 60) || !boundedString(raw.notes, 500) || !raw.pants || !choice(PANTS, raw.pants.style)) fail();
        const clean = { version: 2, name: raw.name, product: raw.product, collar: raw.collar, sleeves: raw.sleeves, sides: {}, pants: { style: raw.pants.style, sides: {} }, quantities: {}, notes: raw.notes };
        const ids = new Set();
        for (const piece of PIECES) {
            const source = pieceData(raw, piece), target = pieceData(clean, piece);
            if (!color(source.base) || !color(source.accent) || !PATTERNS.includes(source.pattern) || !choice(MATERIALS, source.material) || !boundedString(source.materialNote, 80)) fail();
            Object.assign(target, { base: source.base, accent: source.accent, pattern: source.pattern, material: source.material, materialNote: source.materialNote });
            for (const side of SIDES) {
                if (!source.sides || !Array.isArray(source.sides[side]) || source.sides[side].length > 20) fail();
                target.sides[side] = source.sides[side].map(l => {
                    if (!l || !['text', 'image', 'shape'].includes(l.type) || !boundedString(l.id, 80) || !/^[a-zA-Z0-9_-]+$/.test(l.id) || ids.has(l.id) || !finite(l.x, 180, 420) || !finite(l.y, 190, 610) || !finite(l.scale, .25, 2) || !finite(l.rotation, -180, 180)) fail();
                    ids.add(l.id);
                    const item = { id: l.id, type: l.type, x: l.x, y: l.y, scale: l.scale, rotation: l.rotation };
                    if (l.type === 'text') {
                        if (!boundedString(l.text, 40) || !FONTS.includes(l.font) || !color(l.color) || typeof l.bold !== 'boolean' || !finite(l.size, 8, 150)) fail();
                        Object.assign(item, { text: l.text, font: l.font, color: l.color, bold: l.bold, size: l.size });
                    } else if (l.type === 'image') {
                        // Only embedded raster data. External URLs and SVG can contain active content.
                        if (!boundedString(l.src, 1800000) || !/^data:image\/(png|jpeg|webp);base64,[A-Za-z0-9+/]+={0,2}$/.test(l.src) || !finite(l.width, 1, 240) || !finite(l.height, 1, 300)) fail();
                        Object.assign(item, { src: l.src, width: l.width, height: l.height });
                    } else {
                        if (!['circle', 'rect', 'star'].includes(l.shape) || !color(l.color)) fail();
                        Object.assign(item, { shape: l.shape, color: l.color });
                    }
                    return item;
                });
            }
        }
        for (const size of SIZES) {
            const qty = raw.quantities && raw.quantities[size];
            if (!Number.isInteger(qty) || qty < 0 || qty > 999) fail();
            clean.quantities[size] = qty;
        }
        if (JSON.stringify(clean).length > MAX_FILE) fail();
        return clean;
    }
    function layerSize(layer) {
        if (layer.type === 'image') return { width: layer.width * layer.scale, height: layer.height * layer.scale };
        if (layer.type === 'shape') return { width: 80 * layer.scale, height: 80 * layer.scale };
        return { width: Math.max(12, [...layer.text].length * layer.size * .65) * layer.scale, height: layer.size * 1.2 * layer.scale };
    }
    function bounds(layer) {
        const size = layerSize(layer), radians = layer.rotation * Math.PI / 180;
        const w = Math.abs(size.width * Math.cos(radians)) + Math.abs(size.height * Math.sin(radians));
        const h = Math.abs(size.width * Math.sin(radians)) + Math.abs(size.height * Math.cos(radians));
        return { x: layer.x - w / 2, y: layer.y - h / 2, width: w, height: h };
    }
    function overflows(layer, areas = [AREA]) {
        const b = bounds(layer);
        return !areas.some(area => b.x >= area.x && b.y >= area.y && b.x + b.width <= area.x + area.width && b.y + b.height <= area.y + area.height);
    }
    function renderLayer(l) {
        let content;
        if (l.type === 'text') content = `<text x="0" y="0" text-anchor="middle" dominant-baseline="central" font-family="${escape(l.font)}" font-size="${l.size}" font-weight="${l.bold ? 700 : 400}" fill="${l.color}" xml:space="preserve">${escape(l.text)}</text>`;
        else if (l.type === 'image') content = `<image href="${escape(l.src)}" x="${-l.width / 2}" y="${-l.height / 2}" width="${l.width}" height="${l.height}" preserveAspectRatio="xMidYMid meet"/>`;
        else if (l.shape === 'circle') content = `<circle r="40" fill="${l.color}"/>`;
        else if (l.shape === 'rect') content = `<rect x="-40" y="-40" width="80" height="80" rx="3" fill="${l.color}"/>`;
        else content = `<path d="M0-40 12-13 40-12 19 8 25 38 0 23-25 38-19 8-40-12-12-13Z" fill="${l.color}"/>`;
        return `<g data-layer-id="${escape(l.id)}" transform="translate(${l.x} ${l.y}) rotate(${l.rotation}) scale(${l.scale})">${content}</g>`;
    }
    function garmentPath(sleeves) {
        return sleeves === 'long'
            ? 'M240 92 Q300 120 360 92 L435 128 485 182 554 468 483 493 433 290 447 646 Q300 675 153 646 L167 290 117 493 46 468 115 182 165 128Z'
            : 'M240 92 Q300 120 360 92 L435 128 520 234 445 292 420 257 447 646 Q300 675 153 646 L180 257 155 292 80 234 165 128Z';
    }
    function patternMarkup(pattern, accent) {
        const attr = `fill="${accent}"`;
        if (pattern === 'diagonal') return `<path d="M120 520 480 230 510 295 130 604Z" ${attr}/><path d="M135 628 480 350 486 362 138 641Z" ${attr} opacity=".6"/>`;
        if (pattern === 'stripe') return [195, 280, 365].map(x => `<rect x="${x}" y="100" width="40" height="570" ${attr} opacity=".8"/>`).join('');
        if (pattern === 'chevron') return `<path d="M120 360 300 430 480 360V413L300 486 120 413Z" ${attr}/><path d="M120 440 300 510 480 440V455L300 525 120 455Z" ${attr} opacity=".6"/>`;
        if (pattern === 'split') return `<rect x="300" y="80" width="260" height="600" ${attr} opacity=".9"/>`;
        if (pattern === 'hoops') return [220, 355, 490, 625].map(y => `<rect x="130" y="${y}" width="340" height="55" ${attr}/>`).join('');
        return '';
    }
    function collarMarkup(design, side) {
        const style = design.collar, accent = design.accent;
        const polo = style.startsWith('polo'), round = style.startsWith('round');
        const path = side === 'back' ? 'M242 96 Q300 132 358 96' : round ? 'M242 96 Q300 190 358 96' : 'M242 96 300 169 358 96';
        let markup = `<g data-collar="${style}"><path d="${path}" fill="none" stroke="#000" stroke-opacity=".18" stroke-width="20"/><path d="${path}" fill="none" stroke="${accent}" stroke-width="${style === 'round-rib' ? 18 : 10}"/>`;
        if (style === 'round-rib') markup += `<path d="${path}" fill="none" stroke="${design.base}" stroke-width="2" stroke-dasharray="2 3"/>`;
        if (style === 'v-cross' && side === 'front') markup += `<path d="M241 97 309 176 320 162 254 90Z" fill="${accent}" stroke="${design.base}" stroke-width="2"/>`;
        if (polo) {
            if (side === 'back') markup += `<path d="M240 94 Q300 125 360 94L354 124Q300 152 246 124Z" fill="${accent}"/>`;
            else {
                markup += `<path d="M240 91 300 119 360 91 373 125 333 158 300 119 267 158 227 125Z" fill="${accent}" stroke="${design.base}" stroke-width="2"/><path d="M300 125V183" stroke="${accent}" stroke-width="15"/>`;
                markup += style === 'polo-button' ? '<g fill="#ffffff"><circle cx="300" cy="150" r="3"/><circle cx="300" cy="174" r="3"/></g>' : '<path d="M300 133V181" stroke="#10233d" stroke-width="2" stroke-dasharray="2 2"/><rect x="297" y="158" width="6" height="12" rx="2" fill="#e2e7ec"/>';
            }
        }
        return markup + '</g>';
    }
    function pantsPath(style) {
        return style === 'short' ? 'M170 130H430L455 470 325 482 300 285 275 482 145 470Z' : 'M170 130H430L444 650H328L300 285 272 650H156Z';
    }
    function keeperPanels(design, piece) {
        if (design.product !== 'keeper') return '';
        let paths;
        if (piece === 'pants') paths = design.pants.style === 'long'
            ? '<rect x="177" y="432" width="81" height="89" rx="24"/><rect x="342" y="432" width="81" height="89" rx="24"/>'
            : '<path d="M156 180 188 184 181 310 148 300ZM444 180 412 184 419 310 452 300Z"/>';
        else paths = design.sleeves === 'long'
            ? '<path d="M95 323 149 338 126 418 74 405Z"/><path d="M505 323 451 338 474 418 526 405Z"/>'
            : '<path d="M165 130 229 108 206 170 127 206ZM435 130 371 108 394 170 473 206Z"/>';
        return `<g data-keeper-panels="${piece}" fill="${pieceData(design, piece).accent}" fill-opacity=".65" stroke="#10233d" stroke-opacity=".2" stroke-width="2">${paths}</g>`;
    }
    function svgInner(design, side, options = {}) {
        const piece = options.piece || 'shirt', data = pieceData(design, piece), pants = piece === 'pants';
        if (pants && design.pants.style === 'none') return '';
        const prefix = options.prefix || `ds-${piece}-${side}`;
        const path = pants ? pantsPath(data.style) : garmentPath(design.sleeves);
        const areas = areasFor(design, piece);
        const rectangles = areas.map(a => `<rect x="${a.x}" y="${a.y}" width="${a.width}" height="${a.height}"/>`).join('');
        let svg = `<defs><clipPath id="${prefix}-garment"><path d="${path}"/></clipPath><clipPath id="${prefix}-area">${rectangles}</clipPath><linearGradient id="${prefix}-shade" x1="0" x2="1"><stop stop-color="#000" stop-opacity=".14"/><stop offset=".32" stop-color="#fff" stop-opacity=".04"/><stop offset=".65" stop-color="#fff" stop-opacity=".02"/><stop offset="1" stop-color="#000" stop-opacity=".18"/></linearGradient></defs>`;
        const bottom = pants ? (data.style === 'short' ? 499 : 674) : 674;
        svg += `<ellipse cx="300" cy="${bottom}" rx="158" ry="13" fill="#10233d" opacity=".08"/><path data-piece="${piece}" d="${path}" fill="${data.base}" stroke="#10233d" stroke-opacity=".2" stroke-width="2"/>`;
        svg += `<g clip-path="url(#${prefix}-garment)">${patternMarkup(data.pattern, data.accent)}${keeperPanels(design, piece)}<path d="${pants ? 'M174 161 160 650M426 161 440 650' : 'M165 130 235 102M365 102 435 130'}" fill="none" stroke="${data.accent}" stroke-width="${pants ? 12 : 15}"/><path d="${path}" fill="url(#${prefix}-shade)"/>`;
        if (pants) {
            svg += `<rect x="155" y="130" width="290" height="32" fill="${data.accent}"/><path d="M165 155H435" stroke="#10233d" stroke-opacity=".3" stroke-dasharray="3 4"/>`;
            if (side === 'front') svg += '<path d="M299 158Q270 180 286 178L300 161 314 178Q330 180 301 158M297 164 288 197M303 164 312 197" fill="none" stroke="#e4e8ec" stroke-width="3"/>';
            else svg += '<path d="M300 161V282M336 186H401V225H336Z" fill="none" stroke="#ffffff" stroke-opacity=".25" stroke-width="2"/>';
        } else svg += '<path d="M145 630Q300 655 455 630M181 249 166 610M419 249 434 610" fill="none" stroke="#fff" stroke-opacity=".14" stroke-width="2"/>';
        svg += '</g>';
        if (!pants) svg += collarMarkup(design, side);
        svg += `<g clip-path="url(#${prefix}-area)">${layersFor(design, side, piece).map(renderLayer).join('')}</g>`;
        if (options.guides) svg += `<g fill="none" stroke="#8f9ca7" stroke-width="1" stroke-dasharray="5 5" pointer-events="none">${rectangles}</g><text x="300" y="184" text-anchor="middle" font-family="Arial" font-size="8" letter-spacing="1" fill="#84939e" pointer-events="none">AREA DESAIN${pants ? ' CELANA' : ''}</text>`;
        const selected = layersFor(design, side, piece).find(l => l.id === options.selected);
        if (selected) {
            const b = layerSize(selected), stroke = overflows(selected, areas) ? '#ed9631' : '#a5ce00';
            svg += `<g transform="translate(${selected.x} ${selected.y}) rotate(${selected.rotation})" pointer-events="none"><rect x="${-b.width / 2 - 5}" y="${-b.height / 2 - 5}" width="${b.width + 10}" height="${b.height + 10}" fill="none" stroke="${stroke}" stroke-width="1.5"/>${[-1, 1].flatMap(x => [-1, 1].map(y => `<rect x="${x * (b.width / 2 + 5) - 3}" y="${y * (b.height / 2 + 5) - 3}" width="6" height="6" fill="white" stroke="${stroke}"/>`)).join('')}</g>`;
        }
        return svg;
    }
    function svgDocument(design, side, options = {}) {
        return `<svg xmlns="http://www.w3.org/2000/svg" width="600" height="720" viewBox="0 0 600 720"><title>${escape(design.name)} — ${options.piece === 'pants' ? 'Celana' : 'Atasan'} ${side === 'front' ? 'depan' : 'belakang'}</title>${svgInner(design, side, options)}</svg>`;
    }
    function boardSvg(design) {
        const withPants = design.pants.style !== 'none';
        const views = SIDES.map((side, index) => {
            const shirt = svgInner(design, side, { prefix: `board-${side}` });
            const content = withPants ? `<g transform="translate(126 10) scale(.58)">${shirt}</g><g transform="translate(126 324) scale(.58)">${svgInner(design, side, { piece: 'pants', prefix: `board-pants-${side}` })}</g>` : `<g transform="translate(0 12)">${shirt}</g>`;
            return `<g transform="translate(${index * 600} 0)">${content}</g>`;
        }).join('');
        const fabrics = `Bahan atasan: ${materialLabel(design)}${withPants ? ` · Bahan celana: ${materialLabel(design.pants)}` : ''}`;
        return `<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="800" viewBox="0 0 1200 800"><rect width="1200" height="800" fill="#f1f3f4"/><text x="45" y="40" font-family="Arial" font-size="14" font-weight="700" fill="#10233d">SAGARA / DESIGN STUDIO</text><text x="1155" y="40" text-anchor="end" font-family="Arial" font-size="14" fill="#10233d">${escape(design.name)}</text>${views}<g font-family="Arial" fill="#637083" text-anchor="middle" font-size="12"><text x="300" y="731">DEPAN</text><text x="900" y="731">BELAKANG</text><text x="600" y="752" font-size="11">${escape(modelLabel(design))} · ${escape(PANTS[design.pants.style])}</text><text x="600" y="770" font-size="10" textLength="${fabrics.length > 150 ? 1080 : Math.min(1000, fabrics.length * 5.2)}" lengthAdjust="spacingAndGlyphs">${escape(fabrics)}</text><text x="600" y="789" font-size="9">Mockup ilustrasi — bahan, warna, dan detail produksi dikonfirmasi bersama Sagara.</text></g></svg>`;
    }
    function quoteMessage(design) {
        const quantities = SIZES.filter(s => design.quantities[s] > 0).map(s => `${s}: ${design.quantities[s]}`).join(', ');
        const total = SIZES.reduce((sum, s) => sum + design.quantities[s], 0);
        const pants = design.pants.style === 'none' ? 'Tanpa celana' : `${PANTS[design.pants.style]}\nWarna celana: ${design.pants.base}; aksen: ${design.pants.accent}\nMotif celana: ${design.pants.pattern}\nBahan celana: ${materialLabel(design.pants)}`;
        return `Halo Sagara Jersey, saya ingin meminta penawaran desain custom.\nNama desain: ${design.name}\nModel: ${modelLabel(design)}\nBahan atasan: ${materialLabel(design)}\nWarna dasar: ${design.base}; aksen: ${design.accent}\nMotif atasan: ${design.pattern}\nPaket: ${pants}\nUkuran: ${quantities}\nTotal: ${total} ${design.pants.style === 'none' ? 'pcs' : 'set (atasan + celana)'}\n${design.notes ? `Catatan: ${design.notes}\n` : ''}Saya akan melampirkan mockup PNG dari Sagara Design Studio. Mohon konfirmasi bahan, harga, dan waktu produksi.`;
    }
    class History {
        constructor(initial) { this.entries = [JSON.stringify(initial)]; this.index = 0; }
        push(state) {
            const value = JSON.stringify(state);
            if (value === this.entries[this.index]) return;
            this.entries = this.entries.slice(0, this.index + 1); this.entries.push(value);
            // Bound memory when logos are embedded; keep at least the previous edit.
            while (this.entries.length > 2 && (this.entries.length > 35 || this.entries.reduce((sum, entry) => sum + entry.length, 0) > 24000000)) this.entries.shift();
            this.index = this.entries.length - 1;
        }
        undo() { if (this.index > 0) this.index--; return JSON.parse(this.entries[this.index]); }
        redo() { if (this.index < this.entries.length - 1) this.index++; return JSON.parse(this.entries[this.index]); }
        get canUndo() { return this.index > 0; }
        get canRedo() { return this.index < this.entries.length - 1; }
    }
    return { SIDES, PRODUCTS, COLLARS, SLEEVES, PANTS, MATERIALS, PIECES, PATTERNS, FONTS, SIZES, AREA, MAX_FILE, TEMPLATES, clone, escape, clamp, textLayer, createDesign, validateDesign, pieceData, layersFor, areasFor, materialLabel, modelLabel, layerSize, bounds, overflows, svgInner, svgDocument, boardSvg, quoteMessage, History };
}));
