<?php
    session_start();
    require "../koneksi.php";

    $start = $_GET['start'] ?? '';
    $end   = $_GET['end'] ?? '';
    $type  = $_GET['type'] ?? '';

    if ($start && $end) {
        $sql = "
            SELECT DATE(tanggal) AS label,
                COUNT(id) AS total_order,
                SUM(total_harga) AS total
            FROM orders
            WHERE DATE(tanggal) BETWEEN '$start' AND '$end'
            GROUP BY DATE(tanggal)
            ORDER BY tanggal ASC
        ";
        $judul = "Report $start s/d $end";
    }
    elseif ($type == 'weekly') {
        $sql = "
            SELECT DATE(tanggal) AS label,
                COUNT(id) AS total_order,
                SUM(total_harga) AS total
            FROM orders
            WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY DATE(tanggal)
        ";
        $judul = "Weekly Report";
    }
    elseif ($type == 'monthly') {
        $sql = "
            SELECT DATE(tanggal) AS label,
                COUNT(id) AS total_order,
                SUM(total_harga) AS total
            FROM orders
            WHERE MONTH(tanggal)=MONTH(CURDATE())
            AND YEAR(tanggal)=YEAR(CURDATE())
            GROUP BY DATE(tanggal)
        ";
        $judul = "Monthly Report";
    }
    else {
        $sql = "
            SELECT MONTH(tanggal) AS label,
                COUNT(id) AS total_order,
                SUM(total_harga) AS total
            FROM orders
            WHERE YEAR(tanggal)=YEAR(CURDATE())
            GROUP BY MONTH(tanggal)
        ";
        $judul = "Yearly Report";
    }

    // ✅ QUERY CUKUP SEKALI
    $query = mysqli_query($mysqli, $sql);


// DATA UNTUK GRAFIK
    $labels = [];
    $totals = [];
    $orders = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $labels[] = $row['label'];
        $totals[] = $row['total'];
        $orders[] = $row['total_order'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php require "navbar.php"; ?>
    <h3 class="mb-3"><?= $judul ?></h3>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="date" name="start" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="date" name="end" class="form-control" required>
        </div>
        <div class="col-md-4">
            <button class="btn btn-dark w-100">Filter</button>
        </div>
    </form>

    <div class="mb-3">
        <a href="?type=weekly" class="btn btn-primary">Weekly</a>
        <a href="?type=monthly" class="btn btn-success">Monthly</a>
        <a href="?type=yearly" class="btn btn-warning">Yearly</a>
    </div>

    <!-- TABLE -->
     <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">📊 Grafik Penjualan</h5>
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Periode</th>
                <th>Total Order</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <?php for($i=0; $i<count($labels); $i++): ?>
            <tr>
                <td><?= $labels[$i]; ?></td>
                <td><?= $orders[$i]; ?></td>
                <td>Rp <?= number_format($totals[$i]); ?></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <script>
    const labels = <?= json_encode($labels); ?>;
    const totals = <?= json_encode($totals); ?>;

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: totals,
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString()
                    }
                }
            }
        }
    });
    </script>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>