<html>

<head>
  <title>Registrasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style type="text/css">
  body {
    background-color: white;
  }

  div.container {
    width: 25%;
    margin-top: 135px;
    box-shadow: 0 5px 12px rgba(0, 0, 0, 2);
    padding: 35px;
    background-color: white;
  }

  h2 {
    font-size: 25px;
    font-weight: 350px;

  }

  button {
    width: 100%;
  }

  .alert {
    background-color: rgba(161, 7, 40, 0.685);
    color: white;
    padding: 10px;
    text-align: center;
    border: 1px solid black;
  }
</style>

<body>
  <?php
  require 'koneksi.php';

  if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($password) {
      $password = password_hash($password, PASSWORD_DEFAULT);
      $sql = "SELECT * FROM users WHERE username='$username'";
      $result = mysqli_query($con, $sql);
      if (!$result->num_rows > 0) {
        $sql = "INSERT INTO users (username, password, level ) VALUES ('$username', '$password', 'user')";
        $result = mysqli_query($con, $sql);
        if ($result) {
          echo "<script>alert('Selamat, registrasi berhasil!')
          window.location.href = 'index.php'
          </script>";
          $username = "";
          $_POST['password'] = "";
        } else {
          echo "<script>alert('Woops! Terjadi kesalahan.')</script>";
        }
      } else {
        echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
      }
    } else {
      echo "<script>alert('Password Tidak Sesuai')</script>";
    }
  }

  ?>
  <div class="container">
    <h4 class="text-center">Register</h4>
    <form name="daftar" action="" method="post">
      <div class="form-group">
        <label for="">Username :</label>
        <div class="input-group">
          <input type="username" name="username" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label for="">Password</label>
        <div class="input-group">
          <input type="password" name="password" class="form-control" required>
        </div>
      </div>
      <br>
      <button class="btn btn-success" type="submit" name="submit" value="Register">Register</button>
    </form>
    <h10 class="text-center" style="color: blue;">Already have an account?</h10><br>
    <a class="btn btn-primary w-40" href="index.php">Login</a>
  </div>
  <?php ?>
</body>
</html>