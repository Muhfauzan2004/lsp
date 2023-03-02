<?php 
session_start();
require "../koneksi.php";


$querypembelian = mysqli_query($con, "SELECT * FROM pembelian");
$pembelian = mysqli_fetch_array($querypembelian);


$id_user = $_SESSION["id_user"];
$result = mysqli_query($con, "SELECT pembelian.username, produk.nama AS produk, produk.harga, pembelian.alamat, pembelian.jumlah, pembelian.jasa_pengiriman, pembelian.status FROM pembelian INNER JOIN produk ON pembelian.id_produk = produk.id_produk WHERE id_user = '$id_user' ORDER BY idpembelian DESC;");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi | Fakbar Printers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<style>
    
</style>
<body>
<?php include "navbar.php"; ?>

<div class="container mt-5 shadow">
    <h2 class="text-center">Daftar Transaksi</h2>

    <div class="table-responsive">
        <table class="table table-dark table-hover table-bordered">
        <tr class="table-dark">
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah Beli</th>
            <th>Pengiriman</th>
            <th>Total Pembayaran</th>
            <th>Status</th>
        </tr>
        <?php $no = 1; while($pembelian = mysqli_fetch_assoc($result)): 
            $status = $pembelian["status"];
        
            $statustext = "";
            if($status == 1 || $status == 0) {
                $statustext = "Belum di Konfirmasi";
            } else if($status == 3) {
                $statustext = "Konfirmasi di Tolak <br> Di Tanggal : ";
            } else { 
            $statustext = "Konfirmasi Sukses <br> Di Tanggal : ";
            }

        ?>
        <tr>
            <td style="font-weight: bold;"><?= $no++; ?></td>
            <td><?= $pembelian["username"]; ?></td>
            <td><?= $pembelian["alamat"]; ?></td>
            <td><?= $pembelian["produk"] ?></td>
            <td><?= number_format($pembelian["harga"]) ; ?></td>
            <td><?= $pembelian["jumlah"]; ?></td>
            <td><?= $pembelian["jasa_pengiriman"]; ?></td>
            <td><?= number_format($pembelian["jumlah"]*$pembelian["harga"]) ;?></td>
            <?php if( $statustext === "Konfirmasi Sukses <br> Di Tanggal : " ) : ?>
                <td><button class="btn btn-success text-white w-100"><b><?= $statustext; echo date("d-m-y"); ?></b></button></td>
            <?php elseif($statustext === "Konfirmasi di Tolak <br> Di Tanggal : "): ?>
                <td><button class="btn btn-danger text-white w-100"><b><?= $statustext; echo date("d-m-y");?></b></button></td>
            <?php elseif($statustext === "Belum di Konfirmasi"): ?>
                <td><button class="btn btn-warning text-white w-100"><b><?= $statustext ?></b></button></td>
            <?php endif; ?>
        </tr>
        <?php endwhile; ?>
        </table>
    </div>
</div>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>

<br><br><br><br><br><br><br>
<?php require "footer.php"; ?>

</body>
</html>