<?php require "../includes/header.php" ?>

<?php require "../config/config.php" ?>

<?php

if (isset($_GET['id'])) {

	$id = $_GET['id'];

	// 

	$topic = $conn->query("SELECT users.id AS user_id, users.username, users.avatar, topics.* 
				FROM topics 
				INNER JOIN users
				ON topics.user_id = users.id
				WHERE topics.id = '$id'");

	$topic->execute();

	$singleTopic = $topic->fetch(PDO::FETCH_OBJ);

	// number of post for every user

	$topicCount = $conn->query("SELECT COUNT(*) AS count_topics
				FROM topics 
				WHERE user_id = '$singleTopic->user_id'");

	$topicCount->execute();

	$count = $topicCount->fetch((PDO::FETCH_OBJ));

	// 

	$reply = $conn->query("SELECT 
					users.username AS username,
					users.avatar AS user_avatar,
					replies.*
				FROM replies
				INNER JOIN users ON replies.user_id = users.id
				WHERE topic_id = '$id'");

	$reply->execute();

	$allReplies = $reply->fetchAll(PDO::FETCH_OBJ);
} else header("location: " . APPURL . "/404.php");

if (isset($_POST['submit'])) {

	if (empty($_POST['reply'])) {

		echo "<script>alert('inputs are empty')</script>";
	} else {

		$user_id = $_SESSION['user_id'];
		$topic_id = $id;
		$reply = $_POST['reply'];

		$insert = $conn->prepare("INSERT INTO replies (user_id, topic_id, reply) VALUES (:user_id, :topic_id, :reply)");

		$insert->execute([

			":user_id" => $user_id,
			":topic_id" => $topic_id,
			":reply" => $reply,

		]);

		header("location: " . APPURL . "/topics/topic.php?id=" . $id . "");
	}
}

?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left"><?php echo $singleTopic->title; ?></h1>
					<h4 class="pull-right">A Simple Forum</h4>
					<div class="clearfix"></div>
					<hr>
					<ul id="topics">
						<li id="main-topic" class="topic topic">
							<div class="row">
								<div class="col-md-2">
									<div class="user-info">
										<img class="avatar pull-left" src="../img/<?php echo (isset($singleTopic->avatar)) ? $singleTopic->avatar : "gravatar.jpg"; ?>" />
										<ul>
											<li><strong><?php echo $singleTopic->username; ?></strong></li>
											<li><?php echo $count->count_topics; ?> Posts</li>
											<li><a href="<?php echo APPURL ?>/users/profile.php?id=<?php echo $_SESSION["user_id"] ?>">Profile</a>
										</ul>
									</div>
								</div>
								<div class="col-md-10">
									<div class="topic-content pull-right">
										<p><?php echo $singleTopic->body; ?></p>
									</div>
									<?php if (isset($_SESSION['user_id'])) : ?>
										<?php if ($singleTopic->user_id == $_SESSION['user_id']) : ?>
											<a href="delete.php?id=<?php echo $singleTopic->id; ?>" class="btn btn-danger" role="button">Delete</a>
											<a href="update.php?id=<?php echo $singleTopic->id; ?>" class="btn btn-warning" role="button">Update</a>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
						</li>
						<?php foreach ($allReplies as $reply) : ?>
							<li class="topic topic">
								<div class="row">
									<div class="col-md-2">
										<div class="user-info">
											<img class="avatar pull-left" src="../img/<?php echo (isset($reply->user_avatar)) ? $reply->user_avatar : "gravatar.jpg"; ?>" />
											<ul>
												<li><strong><?php echo $reply->username; ?></strong></li>
												<li>43 Posts</li>
												<li><a href="<?php echo APPURL ?>/users/profile.php?id=<?php echo $_SESSION["user_id"] ?>">Profile</a>
											</ul>
										</div>
									</div>
									<div class="col-md-10">
										<div class="topic-content pull-right">
											<p><?php echo $reply->reply; ?></p>
										</div>

										<?php if (isset($_SESSION['user_id'])) : ?>

											<?php if ($reply ->user_id == $_SESSION['user_id']) : ?>
												<a href="../replies/delete.php?id=<?php echo $reply-> id; ?>" class="btn btn-danger" role="button">Delete</a>
												<a href="../replies/update.php?id=<?php echo $reply-> id; ?>" class="btn btn-warning" role="button">Update</a>
											<?php endif; ?>

										<?php endif; ?>

									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
					<h3>Reply To Topic</h3>
					<form role="form" method="POST" action="topic.php?id=<?php echo $id ?>">
						<div class="form-group">
							<textarea name="reply" id="reply" rows="10" cols="80" class="form-control"></textarea>
							<script>
								CKEDITOR.replace('reply');
							</script>
						</div>
						<button name="submit" type="submit" class="color btn btn-default">Reply</button>
					</form>
				</div>
			</div>
		</div>
		<?php require "../includes/footer.php"  ?>