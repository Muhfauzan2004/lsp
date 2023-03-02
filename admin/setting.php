<?php
require "../koneksi.php";
$id = $_GET['q'];

$query = mysqli_query($con, "SELECT * FROM produk WHERE id_produk = $id");
$data  = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <title>Produk detail</title>
</head>

<body>
  <?php require "navbar.php"; ?>
  <div class="container mt-4">
    <h3>Detail Produk</h3>
    <div class="col-12 col-md-6">
      <form action="" method="post" enctype="multipart/form-data">
        <div <label for="nama">Nama :</label>
          <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $data['nama']; ?>">
        </div>
        <div>
          <div>
            <label for="harga">Harga</label>
            <input type="number" class="form-control" value="<?php echo $data['harga']; ?>" name="harga">
          </div>
          <div>
            <label for="detail">Detail :</label>
            <textarea name="detail" id="detail" cols="30" rows="1" class="form-control"><?php echo $data['detail']; ?></textarea>
          </div>
          <label for="stok">Stok</label>
          <select name="stok" id="stok" class="form-control">
            <option value=<?php echo $data['stok'] ?>><?php echo $data['stok']; ?></option>
            <?php
            if ($data['stok'] == 'tersedia') {
            ?>
              <option value="habis">Habis</option>
            <?php
            } else {
            ?>
              <option value="tersedia">tersedia</option>
            <?php
            }
            ?>
          </select>
          <input type="hidden" name="id" value="<?= $data['id_produk']; ?>">
          <div class="mt-3">
            <button class="btn btn-primary" type="submit" name="edit"><i class="bi bi-pen"></i></button>
            <button class="btn btn-danger" type="submit" name="hapus"><i class="bi bi-trash3"></i></button>
          </div>
      </form>
      <?php
      if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $nama = htmlspecialchars($_POST['nama']);
        $harga = htmlspecialchars($_POST['harga']);
        $detail = htmlspecialchars($_POST['detail']);
        $stok = htmlspecialchars($_POST['stok']);
        if ($nama == '' ||  $harga == '') {
      ?>
          <div class="alert alert-warning mt-3" role="alert">
            Harap Diisi
          </div>
          <?php
        } else {
          $queryedit = mysqli_query($con, "UPDATE produk SET nama='$nama',harga='$harga',detail='$detail',stok= '$stok' WHERE id_produk= $id");
          if ($queryedit) {
          ?>
            <div class="alert alert-success mt-3" role="alert">
              Produk berhasil diedit
            </div>
            <meta http-equiv="refresh" content="1; url=produk.php" />
          <?php
          } else {
            echo (mysqli_error($con));
          }
        }
      }
      //hapus produk//
      if (isset($_POST['hapus'])) {
        $id = $_POST['id'];
        $queryhapus = mysqli_query($con, "DELETE FROM produk WHERE id = $id");

        if ($queryhapus) {
          ?>
          <div class="alert alert-success mt-3" role="alert">
            Produk berhasil Dihapus
          </div>
          <meta http-equiv="refresh" content="1; url=produk.php" />
      <?php
        }
      }
      ?>
    </div>
  </div>

</body>

</html>