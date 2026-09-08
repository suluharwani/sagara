<?php

/**
 * WhatsApp Helper Functions
 * 
 * @package App\Helpers
 */

if (!function_exists('waBaseUrl')) {
    function waBaseUrl(): string
    {
        return 'https://wa.me/';
    }
}

if (!function_exists('waLink')) {
    function waLink(string $phone, string $text = ''): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $url = waBaseUrl() . $phone;
        if ($text) {
            $url .= '?text=' . urlencode($text);
        }
        return $url;
    }
}

if (!function_exists('waProductLink')) {
    function waProductLink(array $product): string
    {
        $message = "Halo Sagara, saya tertarik dengan produk: {$product['nama']}. Apakah masih tersedia?";
        $phone = env('WHATSAPP_NUMBER', '6282137300307');
        return waLink($phone, $message);
    }
}

if (!function_exists('waOrderLink')) {
    function waOrderLink(array $orderData): string
    {
        $message = "Halo Sagara, saya ingin order:\n";
        $message .= "Nama: {$orderData['name']}\n";
        $message .= "Produk: {$orderData['product_name']}\n";
        $message .= "Ukuran: {$orderData['size']}\n";
        $message .= "Jumlah: {$orderData['quantity']}\n";
        if (!empty($orderData['note'])) {
            $message .= "Catatan: {$orderData['note']}";
        }
        $phone = env('WHATSAPP_NUMBER', '6282137300307');
        return waLink($phone, $message);
    }
}

if (!function_exists('waFloatButton')) {
    function waFloatButton(): string
    {
        $phone = env('WHATSAPP_NUMBER', '6282137300307');
        $message = urlencode('Halo Sagara, saya ingin bertanya tentang produk jersey...');
        return "https://wa.me/{$phone}?text={$message}";
    }
}
