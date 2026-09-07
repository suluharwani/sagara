<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$root = dirname(__DIR__);
$settings = parse_ini_file($root . DIRECTORY_SEPARATOR . '.env', false, INI_SCANNER_RAW);

if ($settings === false) {
    fwrite(STDERR, "Konfigurasi database tidak dapat dibaca.\n");
    exit(1);
}

$connection = new mysqli(
    trim((string) ($settings['database.default.hostname'] ?? 'localhost')),
    trim((string) ($settings['database.default.username'] ?? '')),
    trim((string) ($settings['database.default.password'] ?? '')),
    trim((string) ($settings['database.default.database'] ?? ''))
);

if ($connection->connect_errno) {
    fwrite(STDERR, "Koneksi database gagal.\n");
    exit(1);
}

$connection->set_charset('utf8mb4');

$statements = [
    "ALTER TABLE client
        ADD COLUMN IF NOT EXISTS name VARCHAR(150) NULL AFTER id,
        ADD COLUMN IF NOT EXISTS phone VARCHAR(30) NULL AFTER email,
        ADD COLUMN IF NOT EXISTS account_type ENUM('customer','reseller') NOT NULL DEFAULT 'customer' AFTER phone,
        ADD COLUMN IF NOT EXISTS verification_token VARCHAR(100) NULL AFTER account_type,
        ADD COLUMN IF NOT EXISTS reset_token VARCHAR(100) NULL AFTER verification_token",
    "ALTER TABLE product
        ADD COLUMN IF NOT EXISTS product_type ENUM('portfolio','reseller') NOT NULL DEFAULT 'portfolio' AFTER id_group,
        ADD COLUMN IF NOT EXISTS sku VARCHAR(100) NULL AFTER product_type,
        ADD COLUMN IF NOT EXISTS model_name VARCHAR(150) NULL AFTER sku,
        ADD COLUMN IF NOT EXISTS base_price DECIMAL(15,2) NOT NULL DEFAULT 0 AFTER model_name,
        ADD COLUMN IF NOT EXISTS min_order INT NOT NULL DEFAULT 1 AFTER base_price,
        ADD COLUMN IF NOT EXISTS lead_time_days INT NOT NULL DEFAULT 7 AFTER min_order,
        ADD COLUMN IF NOT EXISTS available_colors TEXT NULL AFTER lead_time_days,
        ADD COLUMN IF NOT EXISTS available_sizes TEXT NULL AFTER available_colors,
        ADD COLUMN IF NOT EXISTS reseller_image VARCHAR(250) NULL AFTER available_sizes",
    "CREATE UNIQUE INDEX IF NOT EXISTS client_email_unique ON client (email)",
    "CREATE UNIQUE INDEX IF NOT EXISTS reseller_product_sku_unique ON product (sku)",
    "CREATE TABLE IF NOT EXISTS resellers (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        client_id INT UNSIGNED NOT NULL,
        code VARCHAR(40) NOT NULL,
        business_name VARCHAR(150) NOT NULL,
        owner_name VARCHAR(150) NOT NULL,
        whatsapp VARCHAR(30) NOT NULL,
        city VARCHAR(100) NULL,
        address TEXT NULL,
        sales_channel VARCHAR(150) NULL,
        status ENUM('pending','approved','rejected','suspended') NOT NULL DEFAULT 'pending',
        admin_note TEXT NULL,
        approved_at DATETIME NULL,
        created_at DATETIME NULL,
        updated_at DATETIME NULL,
        PRIMARY KEY (id),
        UNIQUE KEY resellers_client_id_unique (client_id),
        UNIQUE KEY resellers_code_unique (code),
        KEY resellers_status_index (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS reseller_quotes (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        reseller_id INT UNSIGNED NOT NULL,
        quote_number VARCHAR(60) NOT NULL,
        customer_name VARCHAR(150) NOT NULL,
        customer_phone VARCHAR(30) NULL,
        customer_address TEXT NULL,
        notes TEXT NULL,
        status ENUM('draft','sent','accepted','ordered','cancelled') NOT NULL DEFAULT 'draft',
        base_total DECIMAL(15,2) NOT NULL DEFAULT 0,
        selling_total DECIMAL(15,2) NOT NULL DEFAULT 0,
        created_at DATETIME NULL,
        updated_at DATETIME NULL,
        PRIMARY KEY (id),
        UNIQUE KEY reseller_quotes_number_unique (quote_number),
        KEY reseller_quotes_reseller_index (reseller_id),
        KEY reseller_quotes_status_index (status),
        CONSTRAINT reseller_quotes_reseller_fk FOREIGN KEY (reseller_id) REFERENCES resellers(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "CREATE TABLE IF NOT EXISTS reseller_quote_items (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        quote_id INT UNSIGNED NOT NULL,
        product_id INT UNSIGNED NOT NULL,
        product_name VARCHAR(500) NOT NULL,
        material VARCHAR(150) NULL,
        model_name VARCHAR(150) NULL,
        color VARCHAR(100) NULL,
        size VARCHAR(50) NULL,
        quantity INT NOT NULL DEFAULT 1,
        base_price DECIMAL(15,2) NOT NULL DEFAULT 0,
        selling_price DECIMAL(15,2) NOT NULL DEFAULT 0,
        subtotal DECIMAL(15,2) NOT NULL DEFAULT 0,
        created_at DATETIME NULL,
        updated_at DATETIME NULL,
        PRIMARY KEY (id),
        KEY reseller_quote_items_quote_index (quote_id),
        KEY reseller_quote_items_product_index (product_id),
        CONSTRAINT reseller_quote_items_quote_fk FOREIGN KEY (quote_id) REFERENCES reseller_quotes(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    "UPDATE product SET product_type = 'portfolio' WHERE product_type IS NULL OR product_type = ''",
    "INSERT INTO portfolio (nama, picture, id_product, status, created_at, updated_at)
        SELECT p.nama, p.picture, p.id, p.status, COALESCE(p.created_at, NOW()), NOW()
        FROM product p
        LEFT JOIN portfolio pf ON pf.id_product = p.id AND pf.deleted_at IS NULL
        WHERE p.deleted_at IS NULL AND p.product_type = 'portfolio' AND pf.id IS NULL",
];

foreach ($statements as $statement) {
    if (!$connection->query($statement)) {
        fwrite(STDERR, 'Pemasangan skema gagal: ' . $connection->error . PHP_EOL);
        $connection->close();
        exit(1);
    }
}

$checks = [
    'portfolio_links' => "SELECT COUNT(*) total FROM portfolio WHERE deleted_at IS NULL",
    'resellers' => "SELECT COUNT(*) total FROM resellers",
    'reseller_products' => "SELECT COUNT(*) total FROM product WHERE product_type = 'reseller' AND deleted_at IS NULL",
];

foreach ($checks as $label => $query) {
    $result = $connection->query($query)->fetch_assoc();
    echo $label . '=' . (int) ($result['total'] ?? 0) . PHP_EOL;
}

$connection->close();
