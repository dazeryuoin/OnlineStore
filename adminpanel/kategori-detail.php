<?php
require "session.php";
require "../koneksi.php";

// mendapatkan id dengan var K=?
$id = $_GET['k'];

$query = mysqli_query($con, "SELECT * FROM kategori WHERE id_kategori='$id'");
$data = mysqli_fetch_array($query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Kategori</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama']; ?>">
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-primary" name="updateBtn">Update</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>
            <?php
            if (isset($_POST['updateBtn'])) {
                $kategori = htmlspecialchars($_POST['kategori']);

                if ($data['nama'] == $kategori) {
                    ?>
                    <meta http-equiv="refresh" content="0; url=kategori.php">
                    <?php
                } else {
                    $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama = '$kategori'");
                    $jumlahData = mysqli_num_rows($query);

                    if ($jumlahData > 0) {
                    ?>

                        <div class="alert alert-warning mt-3" role="alert">
                            Mohon inputkan kategori berbeda.
                        </div>

                    <?php
                    } else {
                        $queryUpdate = mysqli_query($con, "UPDATE kategori SET nama='$kategori' WHERE id_kategori='$id'");

                    if ($queryUpdate) {
                    ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Kategori Berhasil DiUpdate.
                        </div>
                        <meta http-equiv="refresh" content="2; url=kategori.php">
                    <?php
                    } else {
                        echo mysqli_error($con);
                    }
                    }
                }
            }

            if(isset($_POST['deleteBtn'])) {
                $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE id_kategori='$id'");
                $delCount = mysqli_num_rows($queryCheck);

                if($delCount > 0) {
                    ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Kategori tidak bisa dihapus karena sudah di gunakan di produk.
                        </div>
                    <?php
                    die();
                }

                $queryDel = mysqli_query($con, "DELETE FROM kategori WHERE id_kategori='$id'");
                if($queryDel) {
                    ?>

                        <div class="alert alert-success mt-3" role="alert">
                            Kategori Berhasil DiHapus.
                        </div>
                        <meta http-equiv="refresh" content="2; url=kategori.php">

                    <?php
                } else {
                    echo mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>