<?php
require "koneksi.php";
session_start();
$sessionId = session_id();

$data = mysqli_query($mysqli, "
    SELECT cart.size AS ukuran, cart.quantity, produk.nama, produk.foto, produk.harga
    FROM cart
    JOIN produk ON cart.produk_id = produk.id
    WHERE cart.session_id='$sessionId'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php" ?>
    
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">🛒 Keranjang Belanja</h2>

        <?php if (mysqli_num_rows($data) > 0) { ?>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Ukuran</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grandtotal = 0;
                    while($row = mysqli_fetch_assoc($data)) {
                    $subtotal = $row['harga'] * $row['quantity'];
                    $grandtotal += $subtotal;
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="image/<?= $row['foto']; ?>" width="70" class="rounded me-3">
                                <?= $row['nama']; ?>
                            </div>
                        </td>

                        <td><?= $row['ukuran']; ?></td>  <!-- tampil ukuran -->

                        <td><?= $row['quantity']; ?></td>
                        <td>Rp <?= number_format($row['harga']); ?></td>
                        <td>Rp <?= number_format($subtotal); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <h4>Total Belanja: <span class="text-success">Rp <?= number_format($grandtotal); ?></span></h4>
            <a href="payment.php" class="btn btn-primary btn-lg">Checkout</a>
        </div>

        <?php } else { ?>
            <div class="alert alert-warning text-center fs-5">
                Keranjang masih kosong. <a href="produk.php" class="fw-bold">Belanja sekarang</a>
            </div>
        <?php } ?>
    </div>


     <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
     <script src="fontawesome/js/all.min.js"></script>
</body>
</html>