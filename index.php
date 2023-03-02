<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>TokoKu</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<?php


require 'koneksi.php';

error_reporting(0);

if (isset($_POST['loginbtn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$result = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION["id_user"] = $row["id_user"];
		$_SESSION["name"] = $username;

		if ($row['level'] == 'user') {
			header("Location: user/user.php");
		} else if ($row['level'] = 'admin') {
			header("Location: admin/produk.php");
		}
	} else {
		echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
	}
}

?>

<style>
	.main {
		height: 100vh;
	}

	.login-box {
		width: 500px;
		height: 380px;
		box-sizing: border-box;
		border-radius: 10px;
	}
	div.container {
    width: 25%;
    margin-top: 135px;
    box-shadow: 0 5px 12px rgba(0, 0, 0, 2);
    padding: 35px;
    background-color: white;
	}
</style>

<body>
	<div class="container ">
		<div class="">
			<form action="" method="post">
				<h4 class="text-center">Login</h4>
				<div>
					<label for="username">Username</label>
					<input type="text" class="form-control" name="username" id="Username" required="required">
				</div>
				<div>
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" id="password" required="required">
				</div>
				<div>
					<button class="btn btn-success form-control mt-3" type="submit" name="loginbtn">Login</button>
				</div>
				<div>
					<p class="mt-3">Don't Have account?</p>
					<a href="register.php" class="btn btn-primary">Register</a>
				</div>

			</form>
		</div>
	</div>
</body>

</html>