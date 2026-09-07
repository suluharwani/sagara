<?php
$host = 'localhost';
$dbname = 'lqbilbsg_sagara';
$username = 'root';
$password = '12345';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check all order-related tables
    echo "=== ORDER TABLE ===\n";
    $stmt = $pdo->query("DESCRIBE `order`");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    
    echo "\n=== ORDER_LIST TABLE ===\n";
    $stmt = $pdo->query("DESCRIBE order_list");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    
    echo "\n=== ORDERTABLE TABLE ===\n";
    $stmt = $pdo->query("DESCRIBE ordertable");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    
    echo "\n=== DATA PENGIRIMAN TABLE ===\n";
    $stmt = $pdo->query("DESCRIBE data_pengiriman");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    
    echo "\n=== PAYMENT TABLE ===\n";
    $stmt = $pdo->query("DESCRIBE payment");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    
    // Sample data from order table
    echo "\n=== SAMPLE ORDER DATA ===\n";
    $stmt = $pdo->query("SELECT * FROM `order` LIMIT 3");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
        echo "\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
