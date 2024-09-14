<?php require "../includes/header.php" ?>

<?php require "../config/config.php" ?>

<?php   

	if (!isset($_SESSION['username'])) header("location: " . APPURL . "");

	if (isset($_POST['submit'])) {

		if (empty($_POST['title']) OR empty($_POST['category']) OR empty($_POST['body'])) {

			echo "<script>alert('on or more inputs are empty')</script>";
	
		} else {
	
			$title = $_POST['title'];
			$category = $_POST['category'];
			$body = $_POST['body'];
			$user_id = $_SESSION['user_id'];

			$insert = $conn -> prepare("INSERT INTO topics (user_id, title, category, body) VALUES (:user_id, :title, :category, :body)");

			$insert -> execute([
				
				":user_id" => $user_id,
				":title" => $title,
				":category" => $category,
				":body" => $body,

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
					<form role="form" method="POST" action="create.php">
						<div class="form-group">
							<label>Topic Title</label>
							<input name="title" type="text" class="form-control" placeholder="Enter Post Title">
						</div>
						<div class="form-group">
							<label>Category</label>
							<select name="category" class="form-control">
								<option value="Design">Design</option>
								<option value="Development">Development</option>
								<option value="Business & Marketing">Business & Marketing</option>
								<option value="Search Engines">Search Engines</option>
								<option value="Cloud & Hosting">Cloud & Hosting</option>
							</select>
						</div>
						<div class="form-group">
							<label>Topic Body</label>
							<textarea  name="body" id="body" rows="10" cols="80" class="form-control"></textarea>
							<script>
								CKEDITOR.replace('body');
							</script>
						</div>
						<button name="submit" type="submit" class="color btn btn-default">Submit</button>
					</form>
				</div>
			</div>
		</div>
		<?php require "../includes/footer.php" ?>