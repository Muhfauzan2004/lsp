<?php 
require '../koneksi.php'; //memanggil database
session_start(); //memulai session

$username = $_SESSION["name"];

if( isset($_POST["checkout"]) ) {
    $username = $_POST["username"];
    $alamat = $_POST["alamat"];
    $pengiriman = $_POST["pengiriman"];
    $jumlah = $_POST["jumlah"];
    $iduser = $_POST["iduser"];
    $idproduk = $_POST["idproduk"];
    //user memasukkan data diri mereka
    $result = mysqli_query($con, "INSERT INTO pembelian ( id_produk, id_user, username, alamat, jasa_pengiriman,jumlah, status) VALUES ( '$idproduk', '$iduser','$username', '$alamat', '$pengiriman', $jumlah, 0)");
    //inputnya masuk ke dalam databse
    if($result) {
      //mengirim pesan ke user bahwa transaksi berhasil
      echo "<script>alert(' Selamat, Pembelian Printers Berhasil Silakan Cek Menu Pembelian.');
      window.location.href = 'user.php';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
    
<?php include "navbar.php"; ?>

    <div class="container col-md-6 mt-5">
      <div class="card">
        <div class="card-header bg-dark text-white">Info Produk</div>
        <div class="card-body">
        <?php 
          $id = $_GET["beli"];
          //menampilkan data dari produk dari halaman produk
          $result = mysqli_query($con, "SELECT * FROM produk WHERE id_produk = '$id'");
          while($row = mysqli_fetch_assoc($result)):
              $produk = $row["nama"];
              $harga = $row["harga"];
              $stok = $row["stok"];
              $deskripsi = $row["detail"];
        ?>
        <h5><?= $produk; ?></h5>
        <p><?= $deskripsi; ?></p>
        <h4><?= "Rp " . number_format($harga,0,',',','); ?></h4>
        <?php endwhile; ?>
        </div>
      </div>

      <div class="card my-4">
        <div class="card-header bg-dark text-white">Form Pembelian</div>
        <div class="card-body">
          <form action="" method="post">
            <div class="col">
              <label>Nama</label>
              <input type="text" name="username" class="form-control" value="<?= $username ?>" readonly>
            </div>
            <div class="col">
              <label>Alamat Tujuan Pengiriman</label>
              <input type="text" name="alamat" class="form-control" required>
            </div>
            <div class="col">
              <label>Jumlah Pembelian</label>
              <input type="number" name="jumlah" class="form-control" required>
            </div>
            <div class="col">
              <label>Jasa Pengiriman</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pengiriman" value="JNE" id="jne" required> <label for="jne">JNE</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pengiriman" value="J&T" id="jnt" required> <label for="jnt">J&T</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="pengiriman" value="Sicepat" id="sicepat" required> <label for="sicepat">Sicepat</label>
              </div>
            </div>
              <?php
                $result = mysqli_query($con, "SELECT * FROM produk WHERE id_produk = '$id'");
                $id_produk = $_GET["beli"];
                $name = $_SESSION["name"];
                $ambiliduser = mysqli_query($con, "SELECT id_user FROM users WHERE username = '$name'");
                $data = mysqli_fetch_assoc($ambiliduser);
              ?>
              <br>
              <input type="hidden" name="iduser" value="<?= $data["id_user"]; ?>">
              <input type="hidden" name="idproduk" value="<?= $id_produk; ?>">
              <button type="submit" name="checkout" class="btn btn-primary">Checkout</button>
          </form>
        </div>
      </div>
    </div>

</body>
</html>