<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "koneksi.php";
$sessionId = session_id();
$jumlahCart = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(*) AS jml FROM cart WHERE session_id='$sessionId'"))['jml'];
?>

<nav class="navbar navbar-expand-lg navbar-dark warna1">
  <div class="container">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <!-- MENU KIRI -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item me-4">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item me-4">
          <a class="nav-link" href="tentang-kami.php">Tentang Kami</a>
        </li>
        <li class="nav-item me-4">
          <a class="nav-link" href="produk.php">Produk</a>
        </li>
      </ul>

      <!-- CART KANAN -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link position-relative" href="cart.php">
            <i class="fas fa-shopping-cart fa-lg"></i>
            <?php if($jumlahCart > 0) { ?>
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                <?= $jumlahCart ?>
            </span>
            <?php } ?>
          </a>
        </li>
      </ul>

    </div>
  </div>
</nav>