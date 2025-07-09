<?php
require 'koneksi.php';

$namaproduk = htmlspecialchars($_GET['name']);

$queryDetail = mysqli_query($con, "SELECT * FROM produk WHERE nama = '$namaproduk'");
$produk = mysqli_fetch_array($queryDetail);

$queryProdukTerkait = mysqli_query($con, "SELECT * FROM produk WHERE id_kategori = '$produk[id_kategori]' AND id_produk!='$produk[id_produk]' LIMIT 4");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require 'front-nav.php'; ?>

    <!-- detail produk -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <img src="image/<?php echo $produk['foto']; ?>" alt="" class="w-100">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['nama']; ?></h1>
                    <p class="fs-5">
                        <?php echo $produk['detail']; ?>
                    </p>
                    <p class="text-harga">Rp <?php echo $produk['harga']; ?></p>
                    <p class="fs-5">Status Ketersediaan : <strong><?php echo $produk['ketersediaan_stock']; ?></strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- produk terkait -->
    <div class="container-fluid py-5 warna2">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>

            <div class="row">
                <?php while ($data = mysqli_fetch_array($queryProdukTerkait)) { ?>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="front-prod-detail.php?name=<?php echo $data['nama']; ?>">
                            <img src="image/<?php echo $data['foto']; ?>" alt="" class="img-fluid img-thumbnail ktgori-trkait-img">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php
    require 'footer.php';
    ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>