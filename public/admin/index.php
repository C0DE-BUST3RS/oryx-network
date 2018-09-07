<?php
//Require the functions and start the session
require '../includes/functions.inc.php';

//Check if the user is logged in
If (!CheckIfLoggedIn()) {
	header("Location: ../../index.php");
}

//@TODO Change intro, a function already exists in the functions file so thats already done
if (isset($_POST['changeintro'])) {

}

//@TODO Change profile picture
if (isset($_POST['changepicture'])) {

}

//@TODO Delete profile picture
if (isset($_POST['deletepicture'])) {

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
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/bulma.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
	<title>My settings - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
	<?php
	require '../includes/nav-login.php';
	?>
	<div class="container">
		<div class="columns">
			<div class="column is-3">
				<aside class="menu">
					<p class="menu-label">
						General
					</p>
					<ul class="menu-list">
						<li><a class="is-active">Dashboard</a></li>
					</ul>
				</aside>
			</div>
			<div class="column is-9">
				<section class="hero is-info welcome is-small">
					<div class="hero-body">
						<div class="container">
							<h1 class="title">
								Welcome, <?php echo ucfirst($_SESSION['user']['firstname'])." ".ucfirst($_SESSION['user']['lastname']); ?>
							</h1>
							<h2 class="subtitle">
								I hope you are having a great day!
							</h2>
						</div>
					</div>
				</section>
				<section class="info-tiles">
					<div class="tile is-ancestor has-text-centered">
						<div class="tile is-parent">
							<article class="tile is-child box">
								<p class="title">439k</p>
								<p class="subtitle">Users</p>
							</article>
						</div>
						<div class="tile is-parent">
							<article class="tile is-child box">
								<p class="title">59k</p>
								<p class="subtitle">Products</p>
							</article>
						</div>
						<div class="tile is-parent">
							<article class="tile is-child box">
								<p class="title">3.4k</p>
								<p class="subtitle">Open Orders</p>
							</article>
						</div>
						<div class="tile is-parent">
							<article class="tile is-child box">
								<p class="title">19</p>
								<p class="subtitle">Exceptions</p>
							</article>
						</div>
					</div>
				</section>
				<div class="columns">
					<div class="column is-6">
						<div class="card events-card">
							<header class="card-header">
								<p class="card-header-title">
									Latest Posts
								</p>
								<a href="#" class="card-header-icon" aria-label="more options">
								  <span class="icon">
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								  </span>
								</a>
							</header>
							<div class="card-table">
								<div class="content">
									<table class="table is-fullwidth is-striped">
										<tbody>
										<?php
										$stmt = $conn->prepare("SELECT u.id ,u.email ,u.firstname ,u.lastname, u.admin ,po.id ,po.date ,po.user_id ,po.likes ,po.content ,pr.profile_picture ,pr.intro FROM user u INNER JOIN post po on u.id = po.user_id INNER JOIN profiles pr on po.user_id = pr.user_id ORDER BY po.id DESC");
										$stmt->execute();
										$result = $stmt->get_result();

										while ($row = $result->fetch_assoc()) { ?>
											<tr>
												<td width="10px">
													<div class="media-left">
														<figure class="image is-32x32">
															<img class="is-rounded"
																 src="<?php echo $row['profile_picture']; ?>"
																 alt="Image">
														</figure>
													</div>
												</td>
												<td><a class="button is-small is-info"
													   href="#"><?php echo ucfirst($row['firstname']) . " " . ucfirst($row['lastname']); ?></a>
												</td>
												<td width="300px"><?php echo $row['content']; ?></td>
												<td>
													<?php
													//Display the delete button if the user is the owner or if the loggedin user is an admin
													if ($row['user_id'] == $_SESSION['user']['id'] || $_SESSION['user']['admin'] == 1) { ?>
														<div class="level-right">
															<a class="level-item">
																<form action="../includes/deletepost.inc.php"
																	  method="POST">
																	<input type="text" name="messageID"
																		   value="<?php echo $row['id']; ?>" hidden/>
																	<input type="text" name="userID"
																		   value="<?php echo $row['user_id']; ?>"
																		   hidden/>
																	<input type="text" name="redirectPage"
																		   value="admin" hidden>
																	<button class="delete-button" type="submit"
																			name="deletePost">
																		<i class="fas fa-trash-alt"></i>
																	</button>
																</form>
															</a>
														</div>
													<?php } ?>
												</td>
											</tr>
										<?php } ?>

										</tbody>
									</table>
								</div>
							</div>
							<footer class="card-footer">
								<a href="/../feed.php" class="card-footer-item">View All</a>
							</footer>
						</div>
					</div>
					<div class="column is-6">
						<div class="card">
							<header class="card-header">
								<p class="card-header-title">
									Inventory Search
								</p>
								<a href="#" class="card-header-icon" aria-label="more options">
                  <span class="icon">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
								</a>
							</header>
							<div class="card-content">
								<div class="content">
									<div class="control has-icons-left has-icons-right">
										<input class="input is-large" type="text" placeholder="">
										<span class="icon is-medium is-left">
                      <i class="fa fa-search"></i>
                    </span>
										<span class="icon is-medium is-right">
                      <i class="fa fa-check"></i>
                    </span>
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<header class="card-header">
								<p class="card-header-title">
									User Search
								</p>
								<a href="#" class="card-header-icon" aria-label="more options">
                  <span class="icon">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
								</a>
							</header>
							<div class="card-content">
								<div class="content">
									<div class="control has-icons-left has-icons-right">
										<input class="input is-large" type="text" placeholder="">
										<span class="icon is-medium is-left">
                      <i class="fa fa-search"></i>
                    </span>
										<span class="icon is-medium is-right">
                      <i class="fa fa-check"></i>
                    </span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php
	require '../includes/footer.php';
	?>
</section>

<script src="../js/main.js"></script>
<script src="../js/navbarMenu.js"></script>
</body>

</html>