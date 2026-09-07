<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$root = dirname(__DIR__);
$settings = parse_ini_file($root . DIRECTORY_SEPARATOR . '.env', false, INI_SCANNER_RAW);

if ($settings === false) {
    fwrite(STDERR, "Tidak dapat membaca konfigurasi database.\n");
    exit(1);
}

$database = trim((string) ($settings['database.default.database'] ?? ''));
$connection = new mysqli(
    trim((string) ($settings['database.default.hostname'] ?? 'localhost')),
    trim((string) ($settings['database.default.username'] ?? '')),
    trim((string) ($settings['database.default.password'] ?? '')),
    $database
);

if ($connection->connect_errno) {
    fwrite(STDERR, "Koneksi database gagal.\n");
    exit(1);
}

$connection->set_charset('utf8mb4');
$backupDirectory = $root . DIRECTORY_SEPARATOR . 'writable' . DIRECTORY_SEPARATOR . 'backups';

if (!is_dir($backupDirectory) && !mkdir($backupDirectory, 0775, true) && !is_dir($backupDirectory)) {
    fwrite(STDERR, "Folder backup tidak dapat dibuat.\n");
    exit(1);
}

$backupPath = $backupDirectory . DIRECTORY_SEPARATOR . 'sagara-before-reseller-' . date('Ymd-His') . '.sql';
$handle = fopen($backupPath, 'wb');

if ($handle === false) {
    fwrite(STDERR, "File backup tidak dapat dibuat.\n");
    exit(1);
}

fwrite($handle, "-- Sagara database backup\n");
fwrite($handle, '-- Created: ' . date(DATE_ATOM) . "\n");
fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\nSET NAMES utf8mb4;\n\n");

$tables = $connection->query('SHOW FULL TABLES WHERE Table_type = \'BASE TABLE\'');

while ($tableRow = $tables->fetch_row()) {
    $table = (string) $tableRow[0];
    $quotedTable = '`' . str_replace('`', '``', $table) . '`';
    $createResult = $connection->query('SHOW CREATE TABLE ' . $quotedTable);
    $createRow = $createResult->fetch_row();

    fwrite($handle, 'DROP TABLE IF EXISTS ' . $quotedTable . ";\n");
    fwrite($handle, $createRow[1] . ";\n\n");

    $rows = $connection->query('SELECT * FROM ' . $quotedTable, MYSQLI_USE_RESULT);
    while ($row = $rows->fetch_assoc()) {
        $columns = [];
        $values = [];

        foreach ($row as $column => $value) {
            $columns[] = '`' . str_replace('`', '``', $column) . '`';
            $values[] = $value === null ? 'NULL' : "'" . $connection->real_escape_string((string) $value) . "'";
        }

        fwrite(
            $handle,
            'INSERT INTO ' . $quotedTable . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $values) . ");\n"
        );
    }

    fwrite($handle, "\n");
}

fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
fclose($handle);
$connection->close();

echo $backupPath . PHP_EOL;
