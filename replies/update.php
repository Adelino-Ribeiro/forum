<?php require "../includes/header.php" ?>

<?php require "../config/config.php" ?>

<?php

    if (!isset($_SESSION['username'])) header("location: " . APPURL . "");

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $select = $conn -> query("SELECT * FROM replies WHERE id = '$id'");

        $select -> execute();

        $reply = $select -> fetch(PDO::FETCH_OBJ);

		if ($reply -> user_id != $_SESSION['user_id']) header("location: " . APPURL . "");

    }

	if (isset($_POST['submit'])) {

		if (empty($_POST['reply'])) {

			echo "<script>alert('on or more inputs are empty')</script>";
	
		} else {
	
			$r = $_POST['reply'];

			$update = $conn -> prepare("UPDATE replies 
				SET reply = :reply 
				WHERE id = '$id'");

			$update -> execute([
				
				":reply" => $r,

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
					<form role="form" method="POST" action="update.php?id=<?php echo $id ?>">				
						<div class="form-group">
							<label>Reply</label>
							<textarea  name="reply" id="body" rows="10" cols="80" class="form-control"> <?php echo $reply -> reply; ?> </textarea>
							<script>
								CKEDITOR.replace('body');
							</script>
						</div>
						<button name="submit" type="submit" class="color btn btn-default">Update</button>
					</form>
				</div>
			</div>
		</div>
		<?php require "../includes/footer.php" ?>