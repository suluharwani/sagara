<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Overview</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        .jersey-image {
            width: 100px;
            height: auto;
        }
        .section-title {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 1em;
        }
        .jersey-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .table-custom th, .table-custom td {
            text-align: center;
        }
        .table-outer {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Header Section -->
        <div class="text-center mb-4">
            <h2>Order Overview</h2>
            <p><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($order['created_at'])) ?></p>
            <p><strong>Team:</strong> <?= $order['nama_tim'] ?></p>
            <img src="<?= base_url($order['logo_tim']) ?>" alt="Team Logo" class="jersey-image">
        </div>

        <div class="container mt-5">
    <h2>Product List</h2>
    <div class="row">
        <?php foreach ($orderDetail as $orderDet): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- Display the product image -->
                    <img 
                        src="<?= base_url('assets/upload/image/' . $orderDet['picture']) ?>" 
                        class="card-img-top" 
                        alt="<?= esc($orderDet['product_name']) ?>" 
                        style="height: 200px; object-fit: cover;"
                    >
                    <div class="card-body">
                        <!-- Display product details -->
                        <h5 class="card-title"><?= esc($orderDet['product_name']) ?></h5>
                        <p class="card-text"><strong>Price:</strong> Rp <?= number_format($orderDet['price'], 0, ',', '.') ?></p>
                        <!-- <p class="card-text"><strong>Client:</strong> <?= esc($orderDet['client_name']) ?></p> -->
                        <!-- <a href="<?= base_url('order/view/' . $orderDet['order_id']) ?>" class="btn btn-primary">View Order</a> -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

        <!-- Player List -->
        <div class="table-outer mb-5">
            <div class="section-title">Player List</div>
            <table class="table table-bordered table-custom">
                <thead class="table-light">
                    <tr>
                        <th>Role</th>
                        <th>Size</th>
                        <th>Player Name</th>
                        <th>Jersey Number</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($players as $player): ?>
                        <tr>
                            <td><?= ucfirst($player['keterangan']) ?></td>
                            <td><?= $player['ukuran'] ?></td>
                            <td><?= $player['nama'] ?></td>
                            <td><?= $player['nomor_punggung'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Size Summary -->
        <?php
// Initialize the summary array
$sizeSummary = [
    'Kids' => ['XS' => 0, 'S' => 0, 'M' => 0, 'L' => 0, 'total' => 0],
    'Dewasa' => ['XS' => 0, 'S' => 0, 'M' => 0, 'L' => 0, 'total' => 0]
];

// Process each player and populate the summary array
foreach ($players as $player) {

    $category = $player['size_category'];
    $size = $player['size_value'];
// var_dump($sizeSummary[$category][$size]);

    // Check if the category and size exist in the summary array
    if (isset($sizeSummary[$category][$size])) {
        $sizeSummary[$category][$size]++;
        $sizeSummary[$category]['total']++;
    }
}

// Calculate the overall total
$totalAll = $sizeSummary['Kids']['total'] + $sizeSummary['Dewasa']['total'];
?>

<div class="table-outer mb-5">
    <div class="section-title">Size Summary</div>
    <table class="table table-bordered table-custom">
        <thead class="table-light">
            <tr>
                <th>Category</th>
                <th>XS</th>
                <th>S</th>
                <th>M</th>
                <th>L</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- KIDS Summary Row -->
            <tr>
                <td>KIDS</td>
                <td><?= $sizeSummary['Kids']['XS'] > 0 ? $sizeSummary['Kids']['XS'] : '-' ?></td>
                <td><?= $sizeSummary['Kids']['S'] > 0 ? $sizeSummary['Kids']['S'] : '-' ?></td>
                <td><?= $sizeSummary['Kids']['M'] > 0 ? $sizeSummary['Kids']['M'] : '-' ?></td>
                <td><?= $sizeSummary['Kids']['L'] > 0 ? $sizeSummary['Kids']['L'] : '-' ?></td>
                <td><?= $sizeSummary['Kids']['total'] ?></td>
            </tr>
            <!-- DEWASA Summary Row -->
            <tr>
                <td>DEWASA</td>
                <td><?= $sizeSummary['Dewasa']['XS'] > 0 ? $sizeSummary['Dewasa']['XS'] : '-' ?></td>
                <td><?= $sizeSummary['Dewasa']['S'] > 0 ? $sizeSummary['Dewasa']['S'] : '-' ?></td>
                <td><?= $sizeSummary['Dewasa']['M'] > 0 ? $sizeSummary['Dewasa']['M'] : '-' ?></td>
                <td><?= $sizeSummary['Dewasa']['L'] > 0 ? $sizeSummary['Dewasa']['L'] : '-' ?></td>
                <td><?= $sizeSummary['Dewasa']['total'] ?></td>
            </tr>
            <!-- Total Summary Row -->
            <tr class="table-light">
                <td><strong>TOTAL</strong></td>
                <td colspan="4"></td>
                <td><?= $totalAll ?></td>
            </tr>
        </tbody>
    </table>
</div>


        <!-- Jersey Details -->
        <div class="table-outer">
            <div class="section-title">Jersey Details</div>
            <p><strong>Material:</strong> Milano Fullprint</p>
            <p><strong>Design:</strong> Kerah F</p>
            <p><strong>Color Codes:</strong></p>
            <ul>
                <li>GK: Purple</li>
                <li>GK Alternate: Red</li>
                <li>Top Only</li>
                <li>Long Sleeve</li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
