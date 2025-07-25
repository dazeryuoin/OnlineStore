<?php
require 'koneksi.php';

$queryProduk = mysqli_query($con, "SELECT id_produk, nama, harga, foto, detail FROM produk LIMIT 6")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-eval';">
    <title>Online Store | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    require 'front-nav.php';
    ?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Online Fashion Store</h1>
            <h3>Kami Hadir Untuk Kebutuhan Fashion Anda.</h3>
            <div class="col-md-8 offset-md-2">
                <form action="front-prod.php" method="get">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Ada barang yang anda cari ?" aria-label="Recipient’s username" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn warna2 text-white"><i class="fas fa-search"></i> Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- highlighted kategori -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori Terlaris</h3>

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-baju-pria d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="front-prod.php?kategori=Baju Pria">Baju Pria</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-baju-wanita d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="front-prod.php?kategori=Baju Wanita">Baju Wanita</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-sepatu d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="front-prod.php?kategori=Sepatu">Sepatu</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- tentang kami -->
    <div class="container-fluid warna2 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque fuga laudantium repellendus inventore c
                upiditate tempore. Facere aut commodi assumenda nihil in excepturi atque expedita, ipsa praesentium iure libero earum voluptas deleniti quasi harum dolorem voluptatum fugiat perspiciatis iusto dolore nisi! Similique accusantium nesciunt doloremque? Ratione doloremque rerum sequi similique mollitia eaque dicta maiores? Nisi quo modi voluptates id amet repellendus, consectetur sunt deleniti, praesentium quod sed cupiditate corporis totam nihil asperiores dolorem veniam perspiciatis hic tempore cumque est quidem quis!
            </p>
        </div>
    </div>

    <!-- produk -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>

            <div class="row mt-5">
                <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="image/<?php echo $data['foto']; ?>" class="card-img-top" alt="...">
                            </div>

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $data['nama']; ?></h5>
                                <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                                <p class="card-text text-harga">Rp <?php echo $data['harga']; ?></p>
                                <a href="front-prod-detail.php?name=<?php echo $data['nama']; ?>" class="btn warna2 text-white">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
                    <a href="front-prod.php" class="btn btn-outline-info mt-3">See More</a>
        </div>
    </div>

    <!-- footer  -->
    <?php require 'footer.php';?>
    

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>