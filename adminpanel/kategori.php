<?php
require "session.php";
require "../koneksi.php";

$querykategori = mysqli_query($con, 'SELECT * FROM kategori');
$jumlahkategori = mysqli_num_rows($querykategori);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
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
                    Kategori
                </li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Kategori</h3>
            <form action="" method="post">
                <div>
                    <label for="kategori">kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Input nama kategori">
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary" name="simpan_kategori">Tambah</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan_kategori'])) {
                $kategori = htmlspecialchars($_POST['kategori']);

                $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama = '$kategori'");
                $resultNewKategori = mysqli_num_rows($queryExist);

                if ($resultNewKategori > 0) {
            ?>

                    <div class="alert alert-warning mt-3" role="alert">
                        Kategori yang anda inputkan sudah tersedia.
                    </div>

                    <?php
                } else {
                    $querySimpan = mysqli_query($con, "INSERT INTO kategori (nama) VALUES ('$kategori')");

                    if ($querySimpan) {
                    ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Kategori Berhasil Tersimpan.
                        </div>
                        <meta http-equiv="refresh" content="1; url=kategori.php">
                    <?php
                    } else {
                        echo mysqli_error($con);
                    }
                }
            }

            ?>
        </div>

        <div class="mt-3">
            <h2>List Kategori</h2>
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahkategori == 0) {
                        ?>
                            <tr>
                                <td colspan="3" class="text-center">Data kategori tidak tersedia.</td>
                            </tr>
                            <?php
                        } else {
                            while ($data = mysqli_fetch_array($querykategori)) {
                            ?>
                                <tr>
                                    <td><?php echo $data['id_kategori'] ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td>
                                        <a href="kategori-detail.php?k=<?php echo $data['id_kategori']; ?>" class="btn btn-info">
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
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>