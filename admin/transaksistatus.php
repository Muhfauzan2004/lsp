<?php
// koneksi ke db
require "../koneksi.php";

session_start();

// koenksi ke navbar
require "navbar.php";
?>

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
                            <td><button class="btn btn-info text-white w-100"><b><?= $statustext; echo date("d-m-y");?></b></button></td>
                        <?php elseif($statustext === "Belum di Konfirmasi"): ?>
                            <td><button class="btn btn-warning text-white w-100"><b><?= $statustext ?></b></button></td>
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