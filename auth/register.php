<?php require "../includes/header.php" ?>

<?php require "../config/config.php" ?>

<?php   

	if (isset($_SESSION['username'])) header("location: " . APPURL . "");

	if (isset($_POST['register'])) {

		if (empty($_POST['name']) OR empty($_POST['email']) OR empty($_POST['username']) OR empty($_POST['password']) OR empty($_POST['about'])) {

			echo "<script>alert('on or more inputs are empty')</script>";
	
		} else {
	
			$name = $_POST['name'];
			$email = $_POST['email'];
			$username = $_POST['username'];
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$about = $_POST['about'];

			if(isset($_FILES['avatar'])) {
				// Pega o nome do arquivo enviado
				$avatar = $_FILES['avatar']['name'];
				
				// Define o diretório de destino
				$dir = "../img/" . basename($avatar);
				
				// Verifica se o arquivo foi enviado sem erros
				if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dir)) {
					// echo "Upload do avatar feito com sucesso!";
				} else {
					echo "<script>alert('Erro ao fazer upload do avatar.')</script>";
				}
			} else $avatar = "gravatar.jpg";

			$insert = $conn -> prepare("INSERT INTO users (name, email, username, password, avatar, about) VALUES (:name, :email, :username, :password, :avatar, :about)");

			$insert -> execute([

				":name" => $name,
				":email" => $email,
				":username" => $username,
				":password" => $password,
				":avatar" => $avatar,
				":about" => $about,

			]);

			header("location: login.php");
	
		}

	}


?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left">Register</h1>
					<h4 class="pull-right">A Simple Forum</h4>
					<div class="clearfix"></div>
					<hr>
					<form role="form" enctype="multipart/form-data" method="post" action="register.php">
						<div class="form-group">
							<label>Name*</label> <input type="text" class="form-control"
								name="name" placeholder="Enter Your Name">
						</div>
						<div class="form-group">
							<label>Email Address*</label> <input type="email" class="form-control"
								name="email" placeholder="Enter Your Email Address">
						</div>
						<div class="form-group">
							<label>Choose Username*</label> <input type="text"
								class="form-control" name="username" placeholder="Create A Username">
						</div>
						<div class="form-group">
							<label>Password*</label> <input type="password" class="form-control"
								name="password" placeholder="Enter A Password">
						</div>
						<div class="form-group">
							<label>Confirm Password*</label> <input type="password"
								class="form-control" name="password2"
								placeholder="Enter Password Again">
						</div>
						<div class="form-group">
							<label>Upload Avatar</label>
							<input type="file" name="avatar">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<label>About Me</label>
							<textarea id="about" rows="6" cols="80" class="form-control"
								name="about" placeholder="Tell us about yourself (Optional)"></textarea>
						</div>
						<input name="register" type="submit" class="color btn btn-default" value="Register" />
					</form>
				</div>
			</div>
		</div>

		<?php require "../includes/footer.php" ?>