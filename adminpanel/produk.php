<?php
require "session.php";
require "../koneksi.php";

$queryProduk = mysqli_query($con, 'SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.id_kategori = b.id_kategori');
$jumlahProduk = mysqli_num_rows($queryProduk);

$queryKategori = mysqli_query($con, 'SELECT * FROM kategori');
$jumlahKategori = mysqli_num_rows($queryKategori);


function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Produk
                </li>
            </ol>
        </nav>

        <!-- Tambah Produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" autocomplete="off">
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="">Pilih salah satu</option>
                        <?php
                        $data = mysqli_fetch_all($queryKategori, MYSQLI_ASSOC);
                        foreach ($data as $kategori) {
                        ?>
                            <option value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="" harga="">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div><label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div><label for="ketersediaan_stock">Ketersediaan Stock</label>
                    <select name="ketersediaan_stock" id="ketersediaan_stock" class="form-control">
                        <option value="tersedia">tersedia</option>
                        <option value="habis">habis</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="simpanBtn">Simpan</button>
                </div>
            </form>
            <?php
            if (isset($_POST['simpanBtn'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan_stock = htmlspecialchars($_POST['ketersediaan_stock']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $imageSize = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;



                if ($nama == '' || $kategori == '' || $harga == '') {
            ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Nama, kategori dan harga wajib diisi!.
                    </div>
                    <?php
                } else {
                    if ($nama_file !== 0) {
                        if ($imageSize > 500000000) {
                    ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File tidak boleh lebih dari 500KB!.
                            </div>
                            <?php
                        } else {
                            if ($imageFileType !== 'jpg' && $imageFileType !== 'jpeg' && $imageFileType !== 'png' && $imageFileType !== 'gif') {
                            ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    File wajib bertipe JPG, PNG & GIF.
                                </div>
                        <?php
                            } else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            }
                        }
                    }
                    // query insert into produk table
                    $queryInsertProd = mysqli_query($con, "INSERT INTO produk (id_kategori, nama, harga, foto, detail, ketersediaan_stock) VALUES ('$kategori', '$nama', '$harga', 
                    '$new_name', '$detail', '$ketersediaan_stock')");

                    if ($queryInsertProd) {
                        ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Produk Berhasil Tersimpan.
                        </div>

                        <meta http-equiv="refresh" content="1; url=produk.php">
            <?php
                    } else {
                        echo mysqli_error($con);
                    }
                }
            }
            ?>
        </div>

        <div class="mt-3 mb-5">
            <h2>List Produk</h2>
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Ketersediaan Stock</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahProduk == 0) {
                        ?>
                            <tr>
                                <td colspan="6" class="text-center">Data produk tidak tersedia.</td>
                            </tr>
                            <?php
                        } else {
                            $data = mysqli_fetch_all($queryProduk, MYSQLI_ASSOC);
                            foreach ($data as $produk) {
                            ?>
                                <tr>
                                    <td><?php echo $produk['id_produk']; ?></td>
                                    <td><?php echo $produk['nama']; ?></td>
                                    <td><?php echo $produk['nama_kategori']; ?></td>
                                    <td><?php echo $produk['harga']; ?></td>
                                    <td><?php echo $produk['ketersediaan_stock']; ?></td>
                                    <td>
                                        <a href="produk-detail.php?p=<?php echo $produk['id_produk']; ?>" class="btn btn-info">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>