<?php
require "koneksi.php";
session_start();

$sessionId = session_id();

// ambil data cart
$cart = mysqli_query($mysqli, "
    SELECT cart.*, produk.nama, produk.harga
    FROM cart
    JOIN produk ON cart.produk_id = produk.id
    WHERE cart.session_id = '$sessionId'
");

if (mysqli_num_rows($cart) == 0) {
    echo "<script>alert('Keranjang masih kosong!'); window.location='cart.php';</script>";
    exit;
}

// hitung total harga
$total = 0;
while ($row = mysqli_fetch_assoc($cart)) {
    $total += $row['harga'] * $row['quantity'];
}

// buat order baru
mysqli_query($mysqli, "
    INSERT INTO orders (session_id, total_harga, tanggal)
    VALUES ('$sessionId', '$total', NOW())
");

$orderId = mysqli_insert_id($mysqli);

// reset pointer cart
mysqli_data_seek($cart, 0);

// masukkan item ke order_items
while ($row = mysqli_fetch_assoc($cart)) {
    mysqli_query($mysqli, "
        INSERT INTO order_items (order_id, produk_id, qty, harga)
        VALUES ('$orderId', '$row[produk_id]', '$row[quantity]', '$row[harga]')
    ");
}

// kosongkan cart setelah checkout
mysqli_query($mysqli, "DELETE FROM cart WHERE session_id = '$sessionId'");

// redirect
echo "<script>alert('Checkout berhasil! Pesanan kamu sedang diproses.'); window.location='index.php';</script>";
?>