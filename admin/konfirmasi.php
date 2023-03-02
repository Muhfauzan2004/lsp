<?php 
require "../koneksi.php";

$querypembelian = mysqli_query($con, "SELECT * FROM pembelian");
$pembelian = mysqli_fetch_array($querypembelian);

if( isset($_POST["verifikasi"]) ) {
    $idpembelian = $_POST["idpembelian"];

    $result = mysqli_query($con, "UPDATE pembelian SET status = 2 WHERE idpembelian = $idpembelian");

    if($result) {
        header("Location: konfirmasi.php?p=Berhasil melakukan konfirmasi transaksi");
    }
}

if( isset($_POST["tolak"]) ) {
    $idpembelian = $_POST["idpembelian"];

    $result = mysqli_query($con, "UPDATE pembelian SET status = 3 WHERE idpembelian = $idpembelian");

    if($result) {
        header("Location: konfirmasi.php?p=Berhasil menolak transaksi");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi | Fakbar Printers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
    <?php include "navbar.php"; ?>

    <div class="container">
    <?php 
    if(isset($_GET["p"])) {
        $pesan = $_GET["p"];

        echo '<div class="alert alert-secondary alert-dismissible fade show my-3" role="alert">
        <strong>'.$pesan.'</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>
    <h3 class="text-center my-3">Daftar konfirmasi pembayaran</h3>

    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover table-bordered">
            <tr class="bg-dark text-white">
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah Beli</th>
                <th>Pengiriman</th>
                <th>Total Pembayaran</th>
                <th>Konfirmasi</th>

        </tr>
        <?php 
            $result = mysqli_query($con, 
            "SELECT pembelian.username, 
            produk.nama AS produk, 
            produk.harga,
            pembelian.alamat, 
            pembelian.jumlah, 
            pembelian.jasa_pengiriman, 
            pembelian.status,
            pembelian.idpembelian,
            produk.id_produk  
            FROM pembelian JOIN produk ON pembelian.id_produk = produk.id_produk JOIN users ON pembelian.id_user = users.id_user WHERE pembelian.status = 0");
            $no = 1; 
            while($pembelian = mysqli_fetch_assoc($result)): 
            $idpembelian = $pembelian["idpembelian"];
            $idproduk = $pembelian["id_produk"];
            $qty = $pembelian["jumlah"];
        ?>
        <tr>
            <form action="" method="post">
            <td style="font-weight: bold;"><?= $no++; ?></td>
            <td><?= $pembelian["username"]; ?></td>
            <td><?= $pembelian["alamat"]; ?></td>
            <td><?= $pembelian["produk"] ?></td>
            <td><?= number_format($pembelian["harga"]) ; ?></td>
            <td><?= $pembelian["jumlah"]; ?></td>
            <td><?= $pembelian["jasa_pengiriman"]; ?></td>
            <td><?= number_format($pembelian["jumlah"]*$pembelian["harga"]) ;?></td>
            <td>
                <!-- <button type="submit" name="verifikasi" class="btn btn-success">Konfirmasi</button> -->
                <button type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#konfirmasi<?= $idpembelian; ?>">Confirm</button>
                <button type="button" class="btn btn-danger my-2" data-bs-toggle="modal" data-bs-target="#tolak<?= $idpembelian; ?>">Reject</button>
            </td>
            </form>
        </tr>

        <!-- modal konfirmasi -->
        <div class="modal fade" id="konfirmasi<?= $idpembelian; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Transaksi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <form action="" method="post">
                    <p>Apakah ingin mengkonfirmasi transaksi ini?</p>
                    <input type="hidden" name="idpembelian" value="<?= $idpembelian; ?>">
                    <button type="submit" name="verifikasi" class="btn btn-success">Confirm</button>
                </form>
            </div>
        </div>
        </div>
    </div>

        <!-- modal tolak -->
        <div class="modal fade" id="tolak<?= $idpembelian; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tolak Konfirmasi</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="" method="post">
                  <p>Apakah yakin ingin menolak transaksi ini?</p>
                  <input type="hidden" name="idproduk" value="<?= $idproduk; ?>">
                  <input type="hidden" name="kty" value="<?= $qty; ?>">
                  <input type="hidden" name="idpembelian" value="<?= $idpembelian; ?>">
                  <button type="submit" class="btn btn-danger" name="tolak">Reject</button>
              </form>
            </div>
          </div>
        </div>
      </div>
        <?php endwhile; ?>
      </table>
    </div>
  </div>

<br><br><br><br><br>
<?php require "footer.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>