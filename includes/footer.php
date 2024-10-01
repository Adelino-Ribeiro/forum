<?php

// forum topics
$topics = $conn->query("SELECT 
		count(*) AS all_topics
	FROM topics");

$topics->execute();

$allTopics = $topics->fetch(PDO::FETCH_OBJ);

// foruum categories
$categories = $conn->query("SELECT categories.id AS id, categories.name AS name,
		COUNT(topics.category_id) AS count_category
	FROM categories 
	LEFT JOIN topics 
	ON categories.id = topics.category_id
	GROUP BY (topics.category_id)");

$categories->execute();

$allCategories = $categories->fetchAll(PDO::FETCH_OBJ);

// forum users
$users = $conn->query("SELECT 
		count(*) AS all_users
	FROM users");

$users->execute();

$allUsers = $users->fetch(PDO::FETCH_OBJ);

// forum topics
$categ = $conn->query("SELECT 
		count(*) AS all_categories
	FROM categories");

$categ ->execute();

$allCateg = $categ->fetch(PDO::FETCH_OBJ);


?>

<div class="col-md-4">
	<div class="sidebar">


		<div class="block">
			<h3>Categories</h3>
			<div class="list-group block ">
				<a href="#" class="list-group-item active">All Topics <span class="badge pull-right"><?php echo $allTopics->all_topics; ?></span></a>
				
				<?php foreach ($allCategories as $category) : ?>
				
					<a href="<?php echo APPURL ?>/categories/show.php?id=<?php echo $category -> id ?>" class="list-group-item"><?php echo $category->name; ?><span class="color badge pull-right"><?php echo $category->count_category; ?></span></a>
				
				<?php endforeach; ?>

			</div>
		</div>

		<div class="block" style="margin-top: 20px;">
			<h3 class="margin-top: 40px">Forum Statistics</h3>
			<div class="list-group">
				<a href="#" class="list-group-item">Total Number of Users:<span class="color badge pull-right"><?php echo $allUsers->all_users; ?></span></a>
				<a href="#" class="list-group-item">Total Number of Topics:<span class="color badge pull-right"><?php echo $allTopics->all_topics; ?></span></a>
				<a href="#" class="list-group-item">Total Number of Categories: <span class="color badge pull-right"><?php echo $allCateg->all_categories; ?></span></a>

			</div>
		</div>
	</div>
</div>
</div>
</div>
</div><!-- /.container -->


<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php echo APPURL ?>/js/bootstrap.js"></script>
</body>

</html>