<?php
$karyawan =
    [
        ['nama' => 'Naufal', 'alamat' => 'Bandung', 'jenis_kelamin' => 'Pria'],
        ['nama' => 'Winda', 'alamat' => 'Surabaya', 'jenis_kelamin' => 'Wanita'],
        ['nama' => 'Abyasa', 'alamat' => 'Bandung', 'jenis_kelamin' => 'Pria']
    ];
?>
<html>

<head></head>

<body>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
        </tr>
        <?php
        foreach ($karyawan as $key => $value) {
        ?>
            <tr>
                <td><?php echo $value['nama']; ?></td>
                <td><?php echo $value['alamat']; ?></td>
                <td><?php echo $value['jenis_kelamin']; ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <!-- Menulis dan membaca file di php -->
    <?php
    echo "<br>";
    $pesan = "TESTING\n";
    file_put_contents("File.txt", $pesan);
    $isi_file = file_get_contents("File.txt");
    echo $isi_file;
    ?>

    <!-- Mengubah Array dalam bentuk Serialize dan memasukkannya kedalam file -->
    <?php
    echo "<br>";
    $dataSerialize = serialize($karyawan);
    file_put_contents("dataSerialize.txt", $dataSerialize);
    $output = file_get_contents('dataSerialize.txt');
    $Serialize_array = unserialize($output);
    print_r($Serialize_array);
    ?>

    <!-- Mengubah Array dalam bentuk Json dan memasukkannya kedalam file -->
    <?php
    echo "<br>";
    $dataJson = json_encode($karyawan);
    file_put_contents("dataJson.txt", $dataJson);
    $output = file_get_contents('dataJson.txt');
    $Json_array = json_decode($output);
    print_r($Json_array);
    ?>
</body>

</html