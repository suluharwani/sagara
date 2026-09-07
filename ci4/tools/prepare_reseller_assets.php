<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$root = dirname(__DIR__);
$sourceDirectory = $root . '/public/assets/img/';
$targetDirectory = $root . '/public/assets/images/reseller/';

if (!is_dir($targetDirectory) && !mkdir($targetDirectory, 0775, true) && !is_dir($targetDirectory)) {
    fwrite(STDERR, "Folder aset reseller tidak dapat dibuat.\n");
    exit(1);
}

$assets = [
    'WhatsApp Image 2026-09-07 at 10.39.41 PM (1).jpeg' => 'reseller-hero.webp',
    'WhatsApp Image 2026-09-07 at 10.39.38 PM (1).jpeg' => 'model-combo-1.webp',
    'WhatsApp Image 2026-09-07 at 10.39.38 PM.jpeg' => 'model-ultimate.webp',
    'WhatsApp Image 2026-09-07 at 10.39.39 PM (1).jpeg' => 'model-atasan.webp',
    'WhatsApp Image 2026-09-07 at 10.39.39 PM.jpeg' => 'model-combo-2.webp',
    'WhatsApp Image 2026-09-07 at 10.39.39 PM (2).jpeg' => 'benefit-design.webp',
    'WhatsApp Image 2026-09-07 at 10.39.40 PM (1).jpeg' => 'benefit-price.webp',
    'WhatsApp Image 2026-09-07 at 10.39.40 PM (2).jpeg' => 'benefit-quality.webp',
    'WhatsApp Image 2026-09-07 at 10.39.40 PM (3).jpeg' => 'benefit-speed.webp',
];

foreach ($assets as $sourceName => $targetName) {
    $source = $sourceDirectory . $sourceName;
    if (!is_file($source)) {
        fwrite(STDERR, 'Aset tidak ditemukan: ' . $sourceName . PHP_EOL);
        exit(1);
    }

    $image = imagecreatefromjpeg($source);
    if ($image === false || !imagewebp($image, $targetDirectory . $targetName, 84)) {
        fwrite(STDERR, 'Aset gagal diproses: ' . $sourceName . PHP_EOL);
        exit(1);
    }

    echo $targetName . PHP_EOL;
}
