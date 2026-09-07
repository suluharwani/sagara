(function () {
    'use strict';

    var container = document.getElementById('quote-items');
    var template = document.getElementById('quote-item-template');
    var addButton = document.getElementById('add-quote-item');

    if (!container || !template || !addButton) return;

    function bindRow(row) {
        var select = row.querySelector('select[name="product_id[]"]');
        var quantity = row.querySelector('input[name="quantity[]"]');
        var sellingPrice = row.querySelector('input[name="selling_price[]"]');
        var color = row.querySelector('input[name="color[]"]');
        var size = row.querySelector('input[name="size[]"]');
        var baseLabel = row.querySelector('.quote-base');
        var remove = row.querySelector('.quote-remove');

        select.addEventListener('change', function () {
            var option = select.options[select.selectedIndex];
            var base = Number(option.dataset.base || 0);
            var minimum = Number(option.dataset.min || 1);
            quantity.min = String(minimum);
            quantity.value = String(Math.max(Number(quantity.value || 1), minimum));
            sellingPrice.min = String(base);
            if (Number(sellingPrice.value || 0) < base) sellingPrice.value = String(base);
            color.placeholder = option.dataset.colors ? 'Pilihan: ' + option.dataset.colors : 'Tulis warna';
            size.placeholder = option.dataset.sizes ? 'Pilihan: ' + option.dataset.sizes : 'Tulis ukuran';
            baseLabel.textContent = base > 0
                ? 'Harga dasar Rp ' + new Intl.NumberFormat('id-ID').format(base) + ' · minimum ' + minimum + ' pcs'
                : 'Harga dasar belum tersedia.';
        });

        remove.addEventListener('click', function () {
            if (container.querySelectorAll('.quote-item-row').length > 1) row.remove();
        });
    }

    container.querySelectorAll('.quote-item-row').forEach(bindRow);
    addButton.addEventListener('click', function () {
        var fragment = template.content.cloneNode(true);
        var row = fragment.querySelector('.quote-item-row');
        container.appendChild(fragment);
        bindRow(row);
    });
}());
