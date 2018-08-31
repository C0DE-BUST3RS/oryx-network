<?php
//Require the functions and start the session
require 'includes/functions.inc.php';

//Check if the user has been logged in
If (!CheckIfLoggedIn()) {
    header("Location: ../index.php");
}

//Load the latest profile data
LoadProfileData($_SESSION['user']['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Oryx Network">
    <meta name="keywords" content="Oryx Network, Oryx, Network">
    <meta name="author" content="C0DE-BUST3RS">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/bulma.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">

    <title><?php echo ucwords($_SESSION['user']['firstname']) . "'s Feed"; ?> - Oryx Network</title>
</head>
<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    require 'includes/nav-login.php';
    ?>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns is-vcentered">

                <div class="column is-one-quarter">

                </div>

                <div class="column is-half is-fixed-top">
                    <?php echo "<h1 class='title is-4'>" . Greetings($_SESSION['user']['firstname']) . "</h1>"; ?>

                    <div class="tile is-parent">
                        <div class="tile is-child box">

                            <div class="is-fixed-top">
                                <article class="media">
                                    <figure class="media-left">
                                        <p class="image is-64x64">
                                            <img class="is-rounded" src="<?php echo $_SESSION['user']['picture']; ?>">
                                        </p>
                                    </figure>


                                    <form action="includes/post.inc.php" method="POST" style="width: 100%;">
                                        <div class="media-content">
                                            <div class="field">
                                                <p class="control">
                                                    <textarea name="textarea" class="textarea"
                                                              placeholder="What are you up to today?"></textarea>
                                                </p>
                                            </div>
                                            <nav class="level">
                                                <div class="level-left">
                                                    <div class="level-item">
                                                        <button type="submit" name="messageSubmit"
                                                                class="button is-success is-rounded is-outlined">Submit
                                                        </button>
                                                        <input type="hidden" name="userID" id="userID"
                                                               value="<?php echo $_SESSION['user']['id']; ?>">
                                                    </div>
                                                </div>
                                                <div class="level-right">
                                                    <div class="level-item">
                                                        <div class="level-item">
                                                            <button type="reset"
                                                                    class="button is-warning is-rounded is-outlined">
                                                                Clear
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </nav>
                                        </div>
                                    </form>
                                </article>
                            </div>
                        </div>
                    </div>

                    <hr/>

                    <?php
                    $stmt = $conn->prepare('SELECT u.id ,u.email ,u.firstname ,u.lastname ,po.id ,po.date ,po.user_id ,po.likes ,po.content ,pr.profile_picture ,pr.intro FROM user u INNER JOIN post po on u.id = po.user_id INNER JOIN profiles pr on po.user_id = pr.user_id ORDER BY po.id DESC');
                    $stmt->execute();
                    $result = $stmt->get_result();
                      while ($row = $result->fetch_assoc()) {

                        ?>
                        <div class="box">
                            <article class="media">
                                <div class="media-left">
                                    <figure class="image is-64x64">
                                        <img class="is-rounded" src="<?php echo $row['profile_picture']; ?>"
                                             alt="Image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <div class="content">
                                        <p>
                                            <strong>
                                                <span class="tag is-warning"><?php echo ucwords($row['firstname']) . " " . ucwords($row['lastname']); ?></span>
                                            </strong>
                                            <small>
                                                <?php if (CheckIfAdmin($row['email'])) { ?>
                                                    <span class="tag is-danger">Admin</span>
                                                <?php } ?>
                                            </small>
                                            <small>
                                                <?php echo time_elapsed_string($row['date'], false); ?>
                                            </small>
                                            <br>
                                            <?php echo htmlspecialchars($row['content']); ?>
                                        </p>
                                    </div>
                                    <nav class="level is-mobile">
                                        <div class="level-left">
                                            <a class="level-item" aria-label="like">
                                                <span class="icon is-small">
                                                    <i class="fas fa-heart"></i>&nbsp;<?php echo $row['likes']; ?>
                                                </span>
                                            </a>
                                        </div>
                                        <?php if ($row['user_id'] == $_SESSION['user']['id']) { ?>
                                            <div class="level-right">
                                                <a class="level-item">
                                                    <form action="includes/deletepost.inc.php" method="POST">
                                                        <input type="text" name="messageID"
                                                               value="<?php echo $row['id']; ?>" hidden/>
                                                        <input type="text" name="userID"
                                                               value="<?php echo $row['user_id']; ?>" hidden/>
                                                        <button class="delete-button" type="submit" name="deletePost">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </nav>
                                </div>
                            </article>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="column is-one-quarter">

        </div>
    </div>
    <?php
    require 'includes/footer.php';
    ?>
</section>

<script src="js/main.js"></script>
<script src="js/navbarMenu.js"></script>
</body>
</html>