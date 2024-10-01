<?php require "../includes/header.php" ?>

<?php require "../config/config.php" ?>

<?php

    if (!isset($_SESSION['user_id'])) header("location: " . APPURL . "");

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $select = $conn -> query("SELECT * FROM users WHERE id = '$id'");

        $select -> execute();

        $users = $select -> fetch(PDO::FETCH_OBJ);

		if ($users -> id != $_SESSION['user_id']) header("location: " . APPURL . "");

    }

	if (isset($_POST['submit'])) {

		if (empty($_POST['email']) OR empty($_POST['about'])) {

			echo "<script>alert('on or more inputs are empty')</script>";
	
		} else {
	
			$email = $_POST['email'];
			$about = $_POST['about'];

			$update = $conn -> prepare("UPDATE users 
				SET email = :email, about = :about
				WHERE id = '$id'");

			$update -> execute([
				
				":email" => $email,
				":about" => $about,

			]);

			header("location: " . APPURL . "");
	
		}

	}


?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left">Create A Topic</h1>
					<h4 class="pull-right">A Simple Forum</h4>
					<div class="clearfix"></div>
					<hr>
					<form role="form" method="POST" action="edit-user.php?id=<?php echo $id ?>">
						<div class="form-group">
							<label>Email</label>
							<input name="email" type="email" value="<?php echo $users -> email; ?>" class="form-control" >
						</div>
						
						<div class="form-group">
							<label>About</label>
							<textarea  name="about" id="about" rows="5" cols="80" class="form-control"> <?php echo $users -> about; ?> </textarea>
							<script>
								CKEDITOR.replace('about');
							</script>
						</div>
						<button name="submit" type="submit" class="color btn btn-default">Update</button>
					</form>
				</div>
			</div>
		</div>
		<?php require "../includes/footer.php" ?>