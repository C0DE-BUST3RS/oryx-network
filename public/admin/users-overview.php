<?php
//Require the functions and start the session
require '../includes/functions.inc.php';

//Load the latest profile data
LoadProfileData($_SESSION['user']['id']);

//Check if the user is logged in
If (!CheckIfLoggedIn()) {
	header("Location: ../../index.php");
}

//Check if the user is logged in
If (!CheckIfAdmin($_SESSION['user']['email'])) {
	header("Location: ../../index.php");
}

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
	<title>Dashboard - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
	<?php
	require '../includes/nav-login.php';
	?>
	<div class="container">
		<div class="columns">
			<div class="column is-2">
				<?php
				require 'nav-admin.php';
				?>
			</div>

			<div class="column is-10">
				<div class="columns">
					<div class="column is-12">

						<?php if (isset($_SESSION['tokensend'])) { ?>
							<div class="notification is-success">
								<?php echo $_SESSION['tokensend'];
								unset($_SESSION['tokensend']); ?>
							</div>
						<?php } ?>

						<div class="card events-card">
							<header class="card-header">
								<p class="card-header-title">
									All Users
								</p>
								<a href="#" class="card-header-icon" aria-label="more options">
								  <span class="icon">
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								  </span>
								</a>
							</header>
							<div class="card-table">
								<div class="content">
									<!-- Start all users -->
									<div class="content">
										<table class="table is-fullwidth is-striped">
											<thead>
											<tr>
												<th>#</th>
												<th>Level</th>
												<th>Rank</th>
												<th>First name</th>
												<th>Last name</th>
												<th>Reg. Date</th>
												<th>Last Login</th>
												<th>Last IP</th>
												<th>Email</th>
												<th>Reset</th>
											</tr>
											</thead>
											<tbody>

											<?php
											$stmt = $conn->prepare("SELECT u.id, u.firstname, u.lastname, u.admin,  u.activated,  u.date, u.email, u.last_ip,  u.date, u.last_login, pr.profile_picture, lv.current_level, lv.amount_to_level_up, lv.last_level_up, lv.level_icon FROM user u INNER JOIN profiles pr on pr.user_id = u.id INNER JOIN level lv on u.id = lv.user_id ORDER BY u.date DESC");
											$stmt->execute();
											$result = $stmt->get_result();

											while ($row = $result->fetch_assoc()) { ?>
												<tr>
													<td width="6%">
														<img class="is-centered"
															 src="<?php echo $row['profile_picture']; ?>" alt="">
													</td>
													<td width="1%">
														<img class="#" src="/../<?php echo $row['level_icon']; ?>">
													</td>
													<td>
														<?php
														if ($row['admin'] === 1) { ?>
															<span class="tag is-danger">Admin</span>
														<?php } else { ?>
															<span class="tag is-success">User</span>
														<?php } ?>
													</td>
													<td>
														<p><?php echo ucfirst($row['firstname']); ?></p>
													</td>
													<td>
														<p><?php echo ucfirst($row['lastname']); ?></p>
													</td>
													<td>
														<?php
														echo date('d M Y', strtotime($row['date']));
														?>
													</td>
													<td>
														<?php echo date('d M Y', strtotime($row['last_login'])); ?>
													</td>
													<td>
														<?php echo $row['last_ip']; ?>
													</td>
													<td>
														<?php echo $row['email']; ?>
													</td>
													<td>
														<form action="../includes/requestpw.inc.php" method="POST">
															<input type="text" name="resetEmail"
																   value="<?php echo $row['email']; ?>" hidden/>
															<input type="text" name="resetAdmin" value="true" hidden/>
															<button type="submit" id="submit" name="submit"
																	class="button is-small is-primary">
																<span class="icon"><i class="fas fa-edit"></i></span>
																<span>PW</span>
															</button>
														</form>
													</td>
												</tr>
											<?php } ?>

											</tbody>
										</table>
									</div>
									<!-- End all users -->
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