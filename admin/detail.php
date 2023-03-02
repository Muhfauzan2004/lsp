<?php
 require "../koneksi.php";
 $id = $_GET['q'];

 $query = mysqli_query($con,"SELECT * FROM kategori WHERE id='$id'");
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
    <title>detail</title>
</head>
<body>
    <?php require "navbar.php";?>

    <div class="container mt-4">
    <h3>Detail kategori</h3>
   <div class="col-12 col-md-6">
   <form action="" method="post">
    <div>
        <label for="kategori">kategori :</label>
        <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama'];?>">
    </div>
    <div class="mt-4">
        <button type="submit" class="btn btn-primary" name="editbtn"><i class="bi bi-pen"></i></button>
        <button type="submit" class="btn btn-danger" name="deletebtn"><i class="bi bi-trash3"></i></button>
    </div>
    </form>
    <!--edit-->
    <?php
      if(isset($_POST['editbtn'])){
        $kategori = htmlspecialchars($_POST['kategori']);

        if($data['nama']==$kategori){
            ?>
            <meta http-equiv="refresh" content="0; url=kategori.php" />
            <?php
        }
        else{
            $query = mysqli_query($con,"SELECT * FROM kategori WHERE nama='$kategori'");
            $jumlahdata = mysqli_num_rows($query);
            
            if($jumlahdata > 0){
                ?>
                 <div class="alert alert-danger mt-3" role="alert">
                    Kategori Sudah Ada
                  </div>
                <?php
            }
            else{
                $querysimpan = mysqli_query($con,"UPDATE kategori SET nama='$kategori' WHERE id='$id'");

                if ($querysimpan) {
                    ?>
                    <div class="alert alert-success mt-3" role="alert">
                         Kategori Diupdate
                    </div>
                    
                    <meta http-equiv="refresh" content="1; url=kategori.php" />
                    <?php

                }else{
                    echo mysqli_error($con);
                }
            }
        }
      }
      if(isset($_POST['deletebtn'])) {
         $querydelete = mysqli_query($con,"DELETE FROM kategori WHERE id='$id'");

         if($querydelete){
            ?>
            <div class="alert alert-primary mt-3" role="alert">
              Kategori Berhasil dihapus
            </div>
                    
            <meta http-equiv="refresh" content="0; url=kategori.php" />
         <?php
         }
         else{
            echo mysqli_error($con);
         }
      }
    
    ?>
   </div>
</div>
</body>
</html>