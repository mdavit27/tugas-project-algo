<?php
session_start();
require "../koneksi.php";

$query = mysqli_query($mysqli, "
    SELECT p.*, k.nama AS kategori
    FROM produk p
    JOIN kategori k ON p.kategori_id = k.id
    ORDER BY p.nama ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stook Report</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<body>
    <?php require "navbar.php"; ?>
    <h3 class="mb-3">📦 Laporan Stok Produk</h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Kategori</th>
                <th>S</th>
                <th>M</th>
                <th>L</th>
                <th>XL</th>
                <th>XXL</th>
                <th>Total Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p = mysqli_fetch_assoc($query)) : 
                $total = $p['stok_s'] + $p['stok_m'] + $p['stok_l'] + $p['stok_xl'] + $p['stok_xxl'];
            ?>
            <tr>
                <td><?= $p['nama']; ?></td>
                <td><?= $p['kategori']; ?></td>
                <td><?= $p['stok_s']; ?></td>
                <td><?= $p['stok_m']; ?></td>
                <td><?= $p['stok_l']; ?></td>
                <td><?= $p['stok_xl']; ?></td>
                <td><?= $p['stok_xxl']; ?></td>
                <td><strong><?= $total; ?></strong></td>
                <td>
                    <?php if ($total == 0): ?>
                        <span class="badge bg-danger">Habis</span>
                    <?php elseif ($total < 5): ?>
                        <span class="badge bg-warning text-dark">Menipis</span>
                    <?php else: ?>
                        <span class="badge bg-success">Aman</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>