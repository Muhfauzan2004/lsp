<?php
require "../koneksi.php";
session_start();

$query = mysqli_query($con, "SELECT * FROM produk");
$jumlahproduk = mysqli_num_rows($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <title>Produk | Fakbar Printers</title>
</head>

<body>
  <?php require "navbar.php"; ?>
  <div class="container mt-4 shadow-lg p-3 mb-5">
  <h2>Halo <?php echo $_SESSION['name']?></h2>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Produk</li>
      </ol>
    </nav>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">Tambah Produk</button>
    <!--tambah produk-->
    <form action="" method="post">
      <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Produk</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div>
                <label for="nama">Produk :</label>
                <input type="text" id="nama" name="nama" class="form-control">
              </div>
              <div>
                <label for="harga">Harga</label>
                <input type="number" class="form-control" name="harga">
              </div>
              <div>
                <label for="detail">Detail :</label>
                <textarea name="detail" id="detail" cols="30" rows="1" class="form-control"></textarea>
              </div>
              <label for="stok">Ketersedian Stok</label>
              <select name="stok" id="stok" class="form-control">
                <option value="tersedia">Tersedia</option>
                <option value="habis">Habis</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="tambah">Tambah</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <?php
    if (isset($_POST['tambah'])) {
      $nama = htmlspecialchars($_POST['nama']);
      $harga = htmlspecialchars($_POST['harga']);
      $detail = htmlspecialchars($_POST['detail']);
      $stok = htmlspecialchars($_POST['stok']);
      if ($nama == "" || $detail == "") {
    ?>
        <div class="alert alert-warning mt-3" role="alert">
          Harap Diisi
        </div>
        <meta http-equiv="refresh" content="1; url=produk.php" />
      <?php
      }
      //query insert produk
      $querytambah = mysqli_query($con, "INSERT INTO produk (nama,harga,detail,stok) Values ('$nama','$harga','$detail','$stok')");
      if ($querytambah) {
      ?>
        <div class="alert alert-success mt-3" role="alert">
          Produk Tersimpan
        </div>
        <meta http-equiv="refresh" content="1; url=produk.php" />
    <?php
      } else {
        echo (mysqli_error($con));
      }
    }

    ?>
    <!--list produk-->
    <div class="mt-3">
      <h3>List produk</h3>

      <div class="table-responsive">
        <table class="table table-dark table-striped table-hover table-bordered">
          <thead class="bg-dark text-white">
            <tr>
              <th>No</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Stok</th>
              <th width="6%">Detail</th>
            </tr>
          </thead>
          <tbody>
            <!--menampilkan produk-->
            <?php
            if ($jumlahproduk == 0) {
            ?>
              <tr>
                <td colspan=6 class="text-center">Data Produk Tidak Tersedia</td>
              </tr>
              <?php
            } else {
              $jumlah = 1;
              while ($data = mysqli_fetch_array($query)) {
              ?>
                <tr>
                  <td style="font-weight: bold;"><?php echo $jumlah; ?></td>
                  <td><?php echo $data['nama']; ?></td>
                  <td><?php echo number_format($data['harga']); ?></td>
                  <td><?php echo $data['stok']; ?></td>
                  <td><a href="setting.php?q=<?php echo $data['id_produk']; ?>" class="btn btn-info"><i class="bi bi-search"></i></a></td>
                </tr>
            <?php
                $jumlah++;
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

<br>
<?php require "footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


</html>