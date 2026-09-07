<?php
$categoryNames = [
    '1' => 'Semua Kategori',
];
foreach ($groups as $g) {
    $categoryNames[$g['id']] = $g['group'];
}
$currentCategoryName = isset($categoryNames[$category]) ? $categoryNames[$category] : 'Semua Kategori';
?>

<!-- Breadcrumb -->
<section class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5" style="background-image: url('<?= base_url('assets/HTML/img/bg/breadcrumb.jpg') ?>');">
    <div class="container">
        <div class="row">
            <div class="col-md-12 order-2 order-md-1 align-self-center p-static">
                <h1 class="text-8 font-weight-bold">Produk Kami</h1>
                <span class="text-4">Koleksi Jersey & Kaos Custom Berkualitas</span>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">

    <!-- Filter & Sort -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <form method="get" action="<?= base_url('product') ?>" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="<?= esc($search ?? '') ?>">
                <select name="category" class="form-select" style="max-width: 200px;">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($groups as $g): ?>
                        <option value="<?= $g['id'] ?>" <?= ($category ?? '') == $g['id'] ? 'selected' : '' ?>>
                            <?= esc($g['group']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="col-lg-6 text-end">
            <div class="d-inline-flex gap-2">
                <a href="<?= base_url('product?sort=newest' . ($search ? '&search=' . $search : '') . ($category ? '&category=' . $category : '')) ?>" 
                   class="btn btn-sm <?= ($sort ?? 'newest') == 'newest' ? 'btn-primary' : 'btn-outline-primary' ?>">Terbaru</a>
                <a href="<?= base_url('product?sort=cheapest' . ($search ? '&search=' . $search : '') . ($category ? '&category=' . $category : '')) ?>" 
                   class="btn btn-sm <?= ($sort ?? '') == 'cheapest' ? 'btn-primary' : 'btn-outline-primary' ?>">Termurah</a>
                <a href="<?= base_url('product?sort=expensive' . ($search ? '&search=' . $search : '') . ($category ? '&category=' . $category : '')) ?>" 
                   class="btn btn-sm <?= ($sort ?? '') == 'expensive' ? 'btn-primary' : 'btn-outline-primary' ?>">Termahal</a>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="row">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <!-- Thumbnail -->
                        <div class="product-image-wrapper">
                            <?php if (!empty($product['picture'])): ?>
                                <img src="<?= base_url('assets/upload/image/' . $product['picture']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= esc($product['nama']) ?>"
                                     style="height: 300px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Sale Badge -->
                            <?php if (!empty($product['sale_price']) && $product['sale_price'] > 0 && $product['sale_price'] < $product['price']): ?>
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                    -<?= number_format((1 - $product['sale_price'] / $product['price']) * 100, 0) ?>%
                                </span>
                            <?php endif; ?>
                            
                            <!-- Hover Overlay -->
                            <div class="product-overlay">
                                <a href="<?= base_url('product/' . $product['slug']) ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="card-body">
                            <h5 class="card-title mb-1">
                                <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-decoration-none text-dark">
                                    <?= esc($product['nama']) ?>
                                </a>
                            </h5>
                            <?php if (!empty($product['material'])): ?>
                                <small class="text-muted"><?= esc($product['material']) ?></small>
                            <?php endif; ?>
                            <div class="mt-2">
                                <?php if (!empty($product['sale_price']) && $product['sale_price'] > 0 && $product['sale_price'] < $product['price']): ?>
                                    <span class="text-danger font-weight-bold fs-5">Rp <?= number_format($product['sale_price'], 0, ',', '.') ?></span>
                                    <span class="text-muted text-decoration-line-through ms-2">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                <?php elseif (!empty($product['price']) && $product['price'] > 0): ?>
                                    <span class="text-primary font-weight-bold fs-5">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                <?php else: ?>
                                    <span class="text-muted">Hubungi untuk harga</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Card Footer -->
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="<?= base_url('product/' . $product['slug']) ?>" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-shopping-cart me-1"></i> Tambah ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-search fa-2x mb-3"></i>
                    <h5>Produk Tidak Ditemukan</h5>
                    <p>Coba ubah kata kunci pencarian atau filter kategori.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($pager && $pager->getPageCount() > 1): ?>
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Product pagination">
                    <?= $pager->links() ?>
                </nav>
            </div>
        </div>
    <?php endif; ?>

</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
.product-image-wrapper {
    position: relative;
    overflow: hidden;
}
.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.product-card:hover .product-overlay {
    opacity: 1;
}
</style>