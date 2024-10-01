<?php require "../includes/header.php" ?>

<?php require "../config/config.php" ?>

<?php

if (!isset($_SESSION['username'])) header("location: " . APPURL . "");

$categories = $conn->query("SELECT * FROM categories");

$categories->execute();

$allCategories = $categories->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['id'])) {

	$id = $_GET['id'];

	$select = $conn->query("SELECT * FROM topics WHERE id = '$id'");

	$select->execute();

	$topic = $select->fetch(PDO::FETCH_OBJ);

	if ($topic->user_id != $_SESSION['user_id']) header("location: " . APPURL . "");
}

if (isset($_POST['submit'])) {

	if (empty($_POST['title']) or empty($_POST['category']) or empty($_POST['body'])) {

		echo "<script>alert('on or more inputs are empty')</script>";
	} else {

		$title = $_POST['title'];
		$category_id = $_POST['category'];
		$body = $_POST['body'];
		$user_id = $_SESSION['user_id'];

		$update = $conn->prepare("UPDATE topics 
				SET title = :title, category_id = :category, body = :body 
				WHERE id = '$id'");

		$update->execute([

			":title" => $title,
			":category" => $category_id,
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
					<form role="form" method="POST" action="update.php?id=<?php echo $id ?>">
						<div class="form-group">
							<label>Topic Title</label>
							<input name="title" type="text" value="<?php echo $topic->title; ?>" class="form-control" placeholder="Enter Post Title">
						</div>
						<div class="form-group">
							<label>Category</label>
							<select name="category" class="form-control">
								<?php foreach ($allCategories as $category) : ?>
									<option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>Topic Body</label>
							<textarea name="body" id="body" rows="10" cols="80" class="form-control"> <?php echo $topic->body; ?> </textarea>
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