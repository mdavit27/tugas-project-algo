<?php
     require "koneksi.php";

     $nama = htmlspecialchars($_GET['nama']);
     $queryProduk = mysqli_query($mysqli, "SELECT * FROM produk WHERE nama='$nama'");
     $produk = mysqli_fetch_array($queryProduk);

     $queryProdukTerkait = mysqli_query($mysqli, "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]
     ' AND id!='$produk[id]' LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veluna | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
     <?php require "navbar.php" ?>
     
     <!-- detail produk -->
     <div class="container-fluid py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 mb-3">
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['nama']; ?></h1>
                    <p class="fs-5">
                        <?php echo $produk['detail']; ?>
                    </p>
                    <p class="text-harga">
                        <strong>Rp <?php echo $produk['harga'] ?></strong>
                    </p>
                    <p class="fs-5">Status Ketersediaan : <strong><?php echo $produk
                    ['ketersediaan_stok']; ?></strong></p>
                    <?php
                    $sizeS  = $produk['stok_s'];
                    $sizeM  = $produk['stok_m'];
                    $sizeL  = $produk['stok_l'];
                    $sizeXL = $produk['stok_xl'];
                    $sizeXXL = $produk['stok_xxl'];
                    ?>

                    <h5 class="mt-4">Pilih Ukuran</h5>

                    <div id="sizeOptions" class="d-flex gap-2 my-3">
                        <button type="button" class="btn btn-outline-dark size-btn"
                                onclick="pilihUkuran('S')">S</button>
                        <button type="button" class="btn btn-outline-dark size-btn"
                                onclick="pilihUkuran('M')">M</button>
                        <button type="button" class="btn btn-outline-dark size-btn"
                                onclick="pilihUkuran('L')">L</button>
                        <button type="button" class="btn btn-outline-dark size-btn"
                                onclick="pilihUkuran('XL')">XL</button>
                        <button type="button" class="btn btn-outline-dark size-btn"
                                onclick="pilihUkuran('XXL')">XXL</button>

                    <a id="addCartBtn" href="tambah-cart.php?id=<?= $produk['id']; ?>&size=" class="btn btn-success">
                        Tambah ke Keranjang
                    </a>

                    <script>
                    let selectedSize = "";

                    // fungsi ketika mengklik tombol ukuran
                    function pilihUkuran(size) {
                        selectedSize = size;
                        document.getElementById("addCartBtn").href =
                            "tambah-cart.php?id=<?= $produk['id']; ?>&size=" + size;
                    }

                    // saat klik tombol keranjang
                    document.getElementById("addCartBtn").addEventListener("click", function (e) {
                        if (selectedSize === "") {
                            e.preventDefault();
                            alert("Silahkan pilih ukuran dulu!");
                        }
                    });


                    document.querySelectorAll(".size-btn").forEach(btn => {
                        btn.addEventListener("click", function () {
                            selectedSize = this.getAttribute("data-size");
                            document.getElementById("selectedSize").value = selectedSize;

                            // reset highlight
                            document.querySelectorAll(".size-btn").forEach(b => b.classList.remove("btn-dark"));
                            document.querySelectorAll(".size-btn").forEach(b => b.classList.add("btn-outline-dark"));

                            // aktifkan yang dipilih
                            this.classList.remove("btn-outline-dark");
                            this.classList.add("btn-dark");
                        });
                    });

                    document.getElementById("addToCartBtn").addEventListener("click", function () {
                        if (!selectedSize) {
                            alert("Silahkan pilih ukuran dulu!");
                            return;
                        }
                        window.location.href = "tambah-cart.php?id=<?php echo $produk['id']; ?>&size=" + selectedSize;
                    });
                    </script>


                </div>
            </div>
        </div>
     </div>

     <!-- produk terkait -->
      <div class="container-fluid py-5 warna2">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>

            <div class="row">
                <?php while($data=mysqli_fetch_array($queryProdukTerkait)){ ?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>">
                        <img src="image/<?php echo $data['foto']; ?>" class="img-fluid img-thumbnail
                        produk-terkait-image" alt="">
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
      </div>

      <!-- footer -->
       <?php require "footer.php"; ?>

     <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
     <script src="fontawesome/js/all.min.js"></script>
</body>
</html>