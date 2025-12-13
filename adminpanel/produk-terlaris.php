<?php
session_start();
require "../koneksi.php";

$query = mysqli_query($mysqli, "
    SELECT p.nama,
           SUM(oi.qty) AS total_terjual,
           SUM(oi.qty * oi.harga) AS omzet
    FROM order_items oi
    JOIN produk p ON oi.produk_id = p.id
    GROUP BY oi.produk_id
    ORDER BY total_terjual DESC
    LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Terlaris</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<body>
    <?php require "navbar.php"; ?>
    <h3 class="mb-3">🔥 Produk Terlaris</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Produk</th>
                <th>Total Terjual</th>
                <th>Total Omzet</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($query)) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['total_terjual']; ?></td>
                <td>Rp <?= number_format($row['omzet']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>