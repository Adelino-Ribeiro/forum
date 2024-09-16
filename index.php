<?php require "includes/header.php" ?>

<?php require "config/config.php" ?>

<?php

	$topics = $conn->query("SELECT 
			topics.id AS id,
			topics.title AS title,
			topics.category AS category,
			users.username AS username,
			users.avatar AS user_avatar,
			topics.create_at AS created_at,
			COUNT(replies.id) AS count_replies
		FROM topics
		INNER JOIN users ON topics.user_id = users.id
		LEFT JOIN replies ON replies.topic_id = topics.id
		GROUP BY topics.id, topics.title, topics.category, users.username, users.avatar, topics.create_at
		ORDER BY topics.create_at DESC;");

	$topics->execute();

	$allTopics = $topics->fetchAll(PDO::FETCH_OBJ);


?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="main-col">
				<div class="block">
					<h1 class="pull-left">Welcome to Forum</h1>
					<h4 class="pull-right">A Simple Forum</h4>
					<div class="clearfix"></div>
					<hr>
					<ul id="topics">
						<script>
							console.log(<?php echo json_encode($allTopics); ?>);
						</script>
						<?php foreach ($allTopics as $topic) : ?>
							<li class="topic">
								<div class="row">
									<div class="col-md-2">
										<img class="avatar pull-left" src="img/<?php echo (isset($topic->user_avatar)) ? $topic->user_avatar : "gravatar.jpg"; ?>" />
									</div>
									<div class="col-md-10">
										<div class="topic-content pull-right">
											<h3><a href="<?php echo APPURL ?>/topics/topic.php?id=<?php echo $topic -> id; ?>"><?php echo $topic->title; ?></a></h3>
											<div class="topic-info">
												<a href="category.html"><?php echo $topic->category; ?></a> >> <a href="profile.html"><?php echo $topic->username; ?></a> >> Posted on: <?php echo $topic->created_at; ?>
												<span class="color badge pull-right"><?php echo $topic->count_replies; ?></span>
											</div>
										</div>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>

				</div>
			</div>
		</div>

		<?php require "includes/footer.php"  ?>