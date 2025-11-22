<?php
require "koneksi.php";
session_start();

$sessionId = session_id();
$produkId  = $_GET['id'];
$size      = $_GET['size'];

$cek = mysqli_query($mysqli, "
    SELECT * FROM cart WHERE session_id='$sessionId' AND produk_id='$produkId' AND size='$size'
");

if (mysqli_num_rows($cek)) {
    mysqli_query($mysqli, "
        UPDATE cart 
        SET quantity = quantity + 1 
        WHERE session_id='$sessionId' 
        AND produk_id='$produkId' 
        AND size='$size'
    ");
} else {
    mysqli_query($mysqli, "
        INSERT INTO cart (session_id, produk_id, size, quantity)
        VALUES ('$sessionId', '$produkId', '$size', 1)
    ");
}

header("Location: cart.php");
exit;
?>