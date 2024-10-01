<?php require "../includes/header.php" ?>

<?php require "../config/config.php" ?>

<?php

if (!isset($_SESSION['user_id'])) header("location: " . APPURL . "");

if (isset($_GET['id'])) {

  $id = $_GET['id'];

  $select = $conn->query("SELECT *
			FROM users
      WHERE id = '$id'
  ");

  $select->execute();

  $user = $select->fetch(PDO::FETCH_OBJ);

  $num_topics = $conn -> query("SELECT COUNT(*) AS num_topics FROM topics WHERE user_id = '$id'");

  $num_topics -> execute();

  $all_num_topics = $num_topics -> fetch(PDO::FETCH_OBJ);
  
  $num_replies = $conn -> query("SELECT COUNT(*) AS num_replies FROM replies WHERE user_id = '$id'");

  $num_replies -> execute();

  $all_num_replies = $num_replies -> fetch(PDO::FETCH_OBJ);
  
  if ($users -> id != $_SESSION['user_id']) header("location: " . APPURL . "");
  
}



?>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="main-col">
        <div class="block">
          <h1 class="pull-left">Name</h1>
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
                      <li><strong><?php echo $user->username ?></strong></li>
                      <li><a href="profile.php?id=<?php echo $_SESSION["user_id"] ?>">Profile</a>
                    </ul>
                  </div>
                </div>
                <div class="col-md-10">
                  <div class="topic-content pull-right">
                    <p>
                    <strong><?php echo $user->about ?>
                    </p>
                  </div>

                  <a class="btn btn-success" href="" role="button">number of Topics: <?php echo $all_num_topics -> num_topics ?></a>
                  <a class="btn btn-primary" href="" role="button">number of replies: <?php echo $all_num_replies -> num_replies ?></a>

                </div>

              </div>
            </li>


          </ul>

        </div>
      </div>
    </div>

    <?php require "../includes/footer.php" ?>