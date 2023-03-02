<?php
// koneksi ke db
require "../koneksi.php";

session_start();

// koenksi ke navbar

?>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <title>Transaksi | Fakbar Printers</title>
</head>

<?php require "navbar.php";?>
<div class="container">
    <h3 class="text-center my-3"> DAFTAR TRANSAKSI </h3>
    <div class="table-responsive">
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th> Nama Pembeli </th>
                    <th> Nama Barang </th>
                    <th> Jumlah Beli </th>
                    <th> Status </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($con, "SELECT * FROM pembelian INNER JOIN produk ON pembelian.id_produk = produk.id_produk");

                while ($row = mysqli_fetch_assoc($result)) :
                    $status = $row["status"];

                    $statustext = "";
                    if($status == 1 || $status == 0) {
                        $statustext = "Belum di Konfirmasi";
                    } else if($status == 2 || $status == 3) {
                        $statustext = "Sudah Di Konfirmasi <br> Di Tanggal : ";
                    }
                ?>
                    <tr>
                        <td><?= $row["username"] ?></td>
                        <td><?= $row["nama"] ?></td>
                        <td><?= $row["jumlah"] ?></td>
                        <?php if( $statustext === "Sudah Di Konfirmasi <br> Di Tanggal : " ) : ?>
                            <td><button type="" class="btn btn-info text-white w-100" ><b><?= $statustext; echo date("d-m-y");?></b></button></td>
                        <?php elseif($statustext === "Belum di Konfirmasi"): ?>
                            <td><button type="" class="btn btn-warning text-white w-100"><b><?= $statustext ?></b></button></td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>


<br><br><br><br><br>

<?php
// koneksi ke footer
require "footer.php";
?>