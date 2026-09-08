<?php
$waNumber = env('WHATSAPP_NUMBER', '6282137300307');
$waMessage = "Halo Sagara, saya tertarik dengan produk: {$product['nama']}. Apakah masih tersedia?";
$waLink = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);
?>

<!-- Breadcrumb -->
<section class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5" style="background-image: url('<?= base_url('assets/HTML/img/bg/breadcrumb.jpg') ?>');">
    <div class="container">
        <div class="row">
            <div class="col-md-12 order-2 order-md-1 align-self-center p-static">
                <h1 class="text-8 font-weight-bold"><?= esc($product['nama']) ?></h1>
                <span class="text-4">Detail Produk</span>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">

    <!-- Breadcrumb Nav -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('product') ?>">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($product['nama']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-gallery">
                <?php if (!empty($product['picture'])): ?>
                    <div class="main-image mb-3">
                        <img src="<?= base_url('assets/upload/image/' . $product['picture']) ?>" 
                             class="img-fluid rounded shadow" 
                             alt="<?= esc($product['nama']) ?>"
                             id="mainImage"
                             style="width: 100%; max-height: 500px; object-fit: cover;">
                    </div>
                <?php else: ?>
                    <div class="main-image mb-3 bg-light d-flex align-items-center justify-content-center rounded" style="height: 500px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6 mb-4">
            <h2 class="font-weight-bold mb-3"><?= esc($product['nama']) ?></h2>
            
            <?php if (!empty($product['material'])): ?>
                <p class="text-muted mb-2"><strong>Bahan:</strong> <?= esc($product['material']) ?></p>
            <?php endif; ?>

            <!-- Price -->
            <div class="mb-3">
                <?php if (!empty($product['sale_price']) && $product['sale_price'] > 0 && $product['sale_price'] < $product['price']): ?>
                    <span class="text-danger font-weight-bold fs-3">Rp <?= number_format($product['sale_price'], 0, ',', '.') ?></span>
                    <span class="text-muted text-decoration-line-through fs-5 ms-2">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                    <span class="badge bg-danger ms-2">Hemat <?= number_format((1 - $product['sale_price'] / $product['price']) * 100, 0) ?>%</span>
                <?php elseif (!empty($product['price']) && $product['price'] > 0): ?>
                    <span class="text-primary font-weight-bold fs-3">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                <?php else: ?>
                    <span class="text-muted fs-5">Hubungi kami untuk harga</span>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <?php if (!empty($product['description'])): ?>
                <div class="mb-3">
                    <h5>Deskripsi</h5>
                    <p><?= nl2br(esc($product['description'])) ?></p>
                </div>
            <?php endif; ?>

            <!-- Add to Cart Form -->
            <form action="<?= base_url('cart/add') ?>" method="post" class="mb-4">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                
                <!-- Size Selection -->
                <?php if (count($sizes) > 0): ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ukuran</label>
                        <div class="size-options">
                            <?php foreach ($sizes as $size): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="size" 
                                           id="size_<?= $size['id'] ?>" value="<?= esc($size['size']) ?>" required>
                                    <label class="form-check-label" for="size_<?= $size['id'] ?>">
                                        <?= esc($size['size']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Quantity -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Jumlah</label>
                    <div class="input-group" style="max-width: 150px;">
                        <button type="button" class="btn btn-outline-secondary" onclick="decrementQty()">-</button>
                        <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="100" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="incrementQty()">+</button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i> Tambah ke Keranjang
                    </button>
                    <a href="<?= $waLink ?>" target="_blank" class="btn btn-success btn-lg">
                        <i class="fab fa-whatsapp me-2"></i> Beli via WhatsApp
                    </a>
                </div>
            </form>

            <!-- Share Buttons -->
            <div class="mb-3">
                <h6>Bagikan:</h6>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="btn btn-sm btn-outline-primary me-1">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($product['nama']) ?>" target="_blank" class="btn btn-sm btn-outline-info me-1">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://wa.me/?text=<?= urlencode($product['nama'] . ' - ' . current_url()) ?>" target="_blank" class="btn btn-sm btn-outline-success">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (count($related) > 0): ?>
        <hr class="my-5">
        <h3 class="mb-4">Produk Terkait</h3>
        <div class="row">
            <?php foreach ($related as $rel): ?>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <?php if (!empty($rel['picture'])): ?>
                            <img src="<?= base_url('assets/upload/image/' . $rel['picture']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= esc($rel['nama']) ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="<?= base_url('product/' . $rel['slug']) ?>" class="text-decoration-none text-dark">
                                    <?= esc($rel['nama']) ?>
                                </a>
                            </h6>
                            <?php if (!empty($rel['price']) && $rel['price'] > 0): ?>
                                <span class="text-primary font-weight-bold">Rp <?= number_format($rel['price'], 0, ',', '.') ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script>
function incrementQty() {
    const input = document.querySelector('input[name="quantity"]');
    input.value = parseInt(input.value) + 1;
}

function decrementQty() {
    const input = document.querySelector('input[name="quantity"]');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}
</script>
