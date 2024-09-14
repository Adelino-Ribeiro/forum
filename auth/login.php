<?php require "../includes/header.php" ?>

<?php require "../config/config.php" ?>

<?php

if (isset($_POST['login'])) {

	if (empty($_POST['email']) or empty($_POST['password'])) {

		echo "<script>alert('on or more inputs are empty')</script>";
	} else {

		$email = $_POST['email'];

		$password = $_POST['password'];

		$login = $conn->query("SELECT * FROM users WHERE email = '$email'");

		$login->execute();

		$fetch = $login->fetch(PDO::FETCH_ASSOC);

		if ($login->rowCount() > 0) {

			if (password_verify($password, $fetch['password'])) {

				// $_SESSION['email'] = $fetch['email'];

				echo "<script>alert('LOGGED IN')</script>";

				header("location: ../index.php");
			} else echo "<script>alert('email or password is wrong')</script>";
		} else echo "<script>alert('email or password is wrong')</script>";
	}
}

?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left">Login</h1>
					<h4 class="pull-right">A Simple Forum</h4>
					<div class="clearfix"></div>
					<hr>
					<form role="form" enctype="multipart/form-data" method="post" action="login.php">

						<div class="form-group">
							<label>Email Address*</label> <input type="email" class="form-control"
								name="email" placeholder="Enter Your Email Address">
						</div>

						<div class="form-group">
							<label>Password*</label> <input type="password" class="form-control"
								name="password" placeholder="Enter A Password">
						</div>

						<input name="login" type="submit" class="color btn btn-default" value="Login" />
					</form>
				</div>
			</div>
		</div>
		<?php require "../includes/footer.php" ?>