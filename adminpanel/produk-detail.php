<?php
require "session.php";
require "../koneksi.php";

// mendapatkan id dengan var p=?
$id = $_GET['p'];

$queryProd = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.id_kategori=b.id_kategori WHERE a.id_produk='$id'");
$data = mysqli_fetch_array($queryProd);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id_kategori != '$data[id_kategori]'");

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
    <title>Detail Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<style>
    form div {
        margin-bottom: 11px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Produk <?php echo $data['nama']; ?></h2>

        <div class="col-12 col-md-6 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" autocomplete="off"
                        value="<?php echo $data['nama']; ?>">
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="<?php echo $data['id_kategori']; ?>"><?php echo $data['nama_kategori']; ?></option>
                        <?php
                        $dataKategori = mysqli_fetch_all($queryKategori, MYSQLI_ASSOC);
                        foreach ($dataKategori as $kategori) {
                        ?>
                            <option value="<?php echo $kategori['id_kategori']; ?>"><?php echo $kategori['nama']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="" harga="">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control" value="<?php echo $data['harga']; ?>">
                </div>
                <div>
                    <label for="foto">Foto Produk saat ini</label>
                    <img src="../image/<?php echo $data['foto']; ?>" alt="" width="200px" class="form-control">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control" value="">
                </div>
                <div><label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                        <?php echo $data['detail']; ?>
                    </textarea>
                </div>
                <div><label for="ketersediaan_stock">Ketersediaan Stock</label>
                    <select name="ketersediaan_stock" id="ketersediaan_stock" class="form-control">
                        <option value="<?php echo $data['ketersediaan_stock'] ?>"><?php echo $data['ketersediaan_stock'] ?></option>
                        <?php
                        if ($data['ketersediaan_stock'] == 'tersedia') {
                        ?>
                            <option value="habis">habis</option>
                        <?php
                        } else {
                        ?>
                            <option value="tersedia">tersedia</option>
                        <?php
                        }
                        ?>

                    </select>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-primary" name="updateBtn">Update</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php
            if (isset($_POST['updateBtn'])) {
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
                    $queryUpdate = mysqli_query($con, "UPDATE produk SET id_kategori='$kategori', nama='$nama', 
                    harga='$harga', detail='$detail', ketersediaan_stock='$ketersediaan_stock' WHERE id_produk='$id';");

                    if ($nama_file !== '') {
                        if ($imageSize > 500000) {
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

                                $queryUpdateFoto = mysqli_query($con, "UPDATE produk SET foto='$new_name' WHERE id_produk='$id'");

                                if ($queryUpdate && $queryUpdateFoto) {
                                ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Produk Berhasil Diupdate.
                                    </div>

                                    <meta http-equiv="refresh" content="2; url=produk.php">
                    <?php
                                } else {
                                    mysqli_error($con);
                                }
                            }
                        }
                    }
                }
            }

            if (isset($_POST['deleteBtn'])) {
                $queryDelete = mysqli_query($con, "DELETE FROM produk WHERE id_produk='$id'");

                if ($queryDelete) {
                    ?>
                    <div class="alert alert-success mt-3" role="alert">
                        Produk Berhasil Dihapus.
                    </div>

                    <meta http-equiv="refresh" content="2; url=produk.php">
            <?php
                }else{
                    ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Produk Gagal dihapus.
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

</body>

</html>