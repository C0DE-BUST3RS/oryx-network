<?php
//Require the functions and start the session
require 'includes/functions.inc.php';

//Check if the user is logged in
if (!CheckIfLoggedIn()) {
    header("Location: ../index.php");
}

//Load the latest profile data
LoadProfileData($_SESSION['user']['id']);
?>
<!doctype html>
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
    <title>Profile - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    require 'includes/nav-login.php';
    ?>
    <div class="hero-body">
        <div class="container has-text-centered">
            <nav class="level">
                <div class="level-item has-text-centered is-hidden-mobile">
                    <div>
                        <p class="heading">Posts</p>
                        <p class="title"><?php echo LoadNumPosts($_SESSION['user']['id']);?></p>
                    </div>
                </div>
                <h1 class="title is-1"><?php echo ucwords($_SESSION['user']['firstname']). " " . ucwords($_SESSION['user']['lastname']);?></h1>
                <div class="level-item has-text-centered">
                    <div>
                        <p class="heading">Followers</p>
                        <p class="title"><?php echo totalUserFollowers($_SESSION['user']['id']); ?></p>
                    </div>
                </div>
                <div class="level-item has-text-centered is-hidden-desktop">
                    <div>
                        <p class="heading">Posts</p>
                        <p class="title"><?php echo LoadNumPosts($_SESSION['user']['id']);?></p>
                    </div>
                </div>
            </nav>

            <div class="tile is-ancestor">
                <div class="tile is-vertical is-8">
                    <div class="tile">
                        <div class="tile is-parent">
                            <article class="tile is-child notification is-info">
                                <p class="title"><?php echo ucwords($_SESSION['user']['firstname']). " " . ucwords($_SESSION['user']['lastname']);?></p>
                                <figure class="image">
                                    <img class="image" src="<?php echo $_SESSION['user']['picture'];?>">
                                </figure>
                                <br>
                                <a href="settings.php" class="button is-info is-outlined is-inverted">Change picture</a>
                            </article>
                        </div>
                        <div class="tile is-parent is-vertical">
                            <article class="tile is-child notification is-primary">
                                <p class="title">Introduction</p>
                                <form action="includes/change-intro.inc.php" method="post">
                                    <div class="field">
                                        <div class="control">
                                            <textarea class="textarea is-info" placeholder="Your intro" name="intro" rows="4"><?php if (isset($_SESSION['user']['introduction'])) {echo $_SESSION['user']['introduction'];}?></textarea>
                                        </div>
                                    </div>
                                    <button class="button is-info is-outlined is-inverted" type="submit">Change intro</button>
                                </form>
                            </article>
                            <article class="tile is-child notification is-warning">
                                <p class="title">Latest Followers</p>
								<div class="allFriends">
									<?php
									$userID = $_SESSION['user']['id'];
									$stmt = $conn->prepare("SELECT u.id, u.firstname, u.lastname, u.email, p.profile_picture FROM user u INNER JOIN profiles p on u.id = p.user_id INNER JOIN follower f on f.follower_id = p.user_id AND f.user_id = '$userID' ORDER BY u.id LIMIT 4;");
									$stmt->execute();
									$result = $stmt->get_result();
									while ($row = $result->fetch_assoc()) { ?>
										<table class="table" style="background-color: #ffdd57; margin-bottom: -2%;">
											<tbody>
											<tr>
												<th>
													<figure class="image is-32x32">
														<img class="is-rounded"
															 src="<?php echo $row['profile_picture']; ?>">
													</figure>
												</th>
												<th>
													<div class="has-addons-centered" style="margin: auto;">
														<strong>
															<span class="tag is-dark"><?php echo ucwords($row['firstname']) . " " . ucwords($row['lastname']); ?></span>
														</strong>
														<small>
															<?php if (CheckIfAdmin($row['email'])) { ?>
																<span class="tag is-danger">Admin</span>
															<?php } ?>
														</small>
													</div>
												</th>
											</tr>
											</tbody>
										</table>
									<?php } ?>
								</div>
                            </article>
                        </div>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child notification is-danger">
                            <p class="title">Description</p>
                            <div class="content is-hidden-mobile">
                                <?php
                                if ($_SESSION['user']['admin'] == 1) { ?>
                                    <div class="field is-grouped is-grouped-centered">
                                        <div class="control">
                                            <div class="tags has-addons">
                                                <span class="tag is-dark">Oryx Network</span>
                                                <span class="tag is-success">Admin</span>
                                            </div>
                                        </div>
                                        <div class="control">
                                            <div class="tags has-addons">
                                                <span class="tag is-dark">Oryx Network</span>
                                                <span class="tag is-primary">Developer</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            </div>
                        </article>
                    </div>
                </div>
				<div class="tile is-parent">
					<article class="tile is-child notification is-success">
						<div class="content">
							<p class="title">Posts</p>
							<div class="content">
								<div class="scrollParent">
									<div class="scrollChild">
										<?php
										$userID = $_SESSION['user']['id'];
										$stmt = $conn->prepare("SELECT u.id ,u.email ,u.firstname ,u.lastname ,po.id ,po.date ,po.user_id ,po.likes ,po.content ,pr.profile_picture ,pr.intro FROM user u INNER JOIN post po on u.id = po.user_id INNER JOIN profiles pr on po.user_id = pr.user_id WHERE u.id = '$userID' ORDER BY po.id DESC");
										$stmt->execute();
										$result = $stmt->get_result();

										while ($row = $result->fetch_assoc()) {
											?>
											<div class="box">
												<article class="media">
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
																<a class="level-item" aria-label="like" style="text-decoration: none; padding-left: 8px;">
																	<span class="icon is-small">
																		<i class="fas fa-heart"></i>&nbsp;<?php echo $row['likes']; ?>
																	</span>
																</a>
															</div>
															<?php if ($row['user_id'] == $_SESSION['user']['id']) { ?>
																<div class="level-right">
																	<a class="level-item">
																		<form action="includes/deletepost.inc.php"
																			  method="POST">
																			<input type="text" name="messageID"
																				   value="<?php echo $row['id']; ?>"
																				   hidden/>
																			<input type="text" name="userID"
																				   value="<?php echo $row['user_id']; ?>"
																				   hidden/>
																			<input type="text" name="redirectPage"
																				   value="profile" hidden>
																			<button class="delete-button" type="submit"
																					name="deletePost">
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
							</div>
						</div>
					</article>
				</div>
            </div>
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