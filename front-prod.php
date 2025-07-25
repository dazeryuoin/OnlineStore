<?php 
    require 'koneksi.php';

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

    //get produk by nama produk/keyword
    if (isset($_GET['keyword'])) {
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
    }
    //get produk by kategori
    else if (isset($_GET['kategori'])) {
        $queryGetKategoriId = mysqli_query($con, "SELECT id_kategori FROM kategori WHERE nama = '$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE id_kategori = '$kategoriId[id_kategori]'");
    }
    //get produk by default
    else {
        $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    }

    $countData = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store | Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    require 'front-nav.php';
    ?>

    <!-- banner -->
    <div class="container-fluid banner2 d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center py-5">Produk</h1>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while ($kategori = mysqli_fetch_array($queryKategori)) {?>
                    <a class="no-decoration" href="front-prod.php?kategori=<?php echo $kategori['nama']; ?>">
                        <li class="list-group-item"><?php echo $kategori['nama']; ?></li>
                    </a>
                    <?php }?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>

                <div class="row">
                    <?php 
                    if ($countData < 1) {
                    ?>  
                        <p class="text-center my-5">Maaf Produk yang anda cari tidak ada.</p>
                    <?php
                    }
                    ?>
                    <?php while ($data = mysqli_fetch_array($queryProduk)) {?>
                    <div class="col-md-4 mb-4">
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
                    <?php }?>
                </div>
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