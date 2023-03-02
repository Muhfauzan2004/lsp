<?php
require "../koneksi.php";
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$queryproduk = mysqli_query($con, "SELECT * FROM produk");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Produk | Fakbar Printers</title>
</head>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5 shadow-lg p-3 mb-5">
    <h2>halo <?php echo $_SESSION['name']?>,Selamat Berbelanja</h2>
        <div class="row">
            <div class="col">
                <h3 class="text-center">Produk</h3>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover table-bordered">
                        <thead class="table-dark ">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Printers</th>
                                <th scope="col">Detail</th>
                                <th scope="col">Harga</th>
                                <th scope="col" width="10%">Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $jumlah = 1;
                            while ($data = mysqli_fetch_assoc($queryproduk)) { ?>
                                <tr>
                                    <td style="font-weight: bold;"><?php echo $jumlah++; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['detail']; ?></td>
                                    <td><?php echo number_format($data['harga']); ?></td>
                                    <?php if($data["stok"] == "tersedia"): ?>
                                        <td><a href="beli.php?beli=<?php echo $data['id_produk']; ?>" class="btn btn-primary w-100"><i class="bi bi-bag"></i></a></td>
                                    <?php elseif($data["stok"] == "habis"): ?>
                                        <td><button class="btn btn-secondary w-100"><b>Sold Out</b></button></td>
                                    <?php endif; ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

<br><br><br><br>
<?php require "footer.php"; ?>

</html>