<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veluna | Checkout</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container py-5" style="max-width:700px">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-4 text-center">Metode Pembayaran</h3>

                <form action="checkout.php" method="POST">

                    <label class="form-label fw-semibold">Pilih Metode</label>
                    <select name="metode" class="form-control mb-3" required>
                        <option value="COD">COD (Bayar di tempat)</option>
                        <option value="Transfer BCA">Transfer Bank BCA</option>
                        <option value="Transfer BRI">Transfer Bank BRI</option>
                        <option value="Dana">Dana</option>
                        <option value="OVO">OVO</option>
                        <option value="Gopay">Gopay</option>
                    </select>

                    <button type="submit" class="btn btn-success w-100 btn-lg mt-3">
                        Lanjutkan Checkout
                    </button>

                </form>
            </div>
        </div>
    </div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>