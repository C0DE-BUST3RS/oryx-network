<?php
//Require the functions and start the session
require 'includes/functions.inc.php';
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
	<link rel="stylesheet" href="css/api.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
	<title>API - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
	<?php
	CheckIfLoggedIn() ? require 'includes/nav-login.php' : require 'includes/nav-nologin.php';
	?>
	<div class="hero-body">
		<div class="container has-text-centered">
			<div class="columns is-vcentered">

				<?php if (checkUserAPIKey() == false) { ?>

					<div class="column is-one-quarter">
						<i class="fa fa-cogs fa-10x"></i>
					</div>

					<div class="column is-half">
						<h1 class="title is-1">Oryx Network API</h1>
						<h3 class="subtitle is-4">Requirements:</h3>
						<ul>
							<li>
								<?php if (CheckIfLoggedIn()) {
									echo "<i class='fas fa-check'></i>";
								} else {
									echo "<i class='fas fa-times'></i>";
								}
								?> An Oryx Network account
							</li>
							<li>
								<?php if (CheckIfLoggedIn()) {
									echo "<i class='fas fa-check'></i>";
								} else {
									echo "<i class='fas fa-times'></i>";
								}
								?> A valid email-address
							</li>
							<li>
								<?php if (isset ($_SESSION['user']['id']) && CheckIfOlderThan30Days($_SESSION['user']['id'])) {
									echo "<i class='fas fa-check'></i>";
								} else {
									echo "<i class='fas fa-times'></i>";
								}
								?> A minimum account age of 30 days
							</li>
						</ul>
					</div>

					<div class="column is-one-quarter">
						<h1 class="title is-1">Request key</h1>
						<?php

						if (!CheckIfLoggedIn()) { ?>
							<div class='notification is-info is-rounded'>
								You are not logged-in <br> Login to request a API key
							</div>
						<?php } else {

							if (!CheckIfOlderThan30Days($_SESSION['user']['id'])) { ?>
								<div class="notification is-info is-rounded">
									Your account age does not <br> reaches the minimum of 30 days <br> Days left until
									eligible: <?php echo "<b>" . DaysLeftTillEligibleAPIKey($_SESSION['user']['id']) . "</b>"; ?>
								</div>
							<?php } else {

								if (isset($_SESSION['success'])) { ?>
									<div class="notification is-success is-rounded">
										<?php echo $_SESSION['success']; ?>
									</div>
									<?php
									unset($_SESSION['success']);
									$_SESSION['hide'] = '';
								}

								if (isset($_SESSION['failed'])) { ?>
									<div class="notification is-warning is-rounded">
										<?php echo $_SESSION['failed']; ?>
									</div>
									<?php
									unset($_SESSION['failed']);
									$_SESSION['hide'] = '';
								}

								if (isset($_SESSION['age'])) { ?>
									<div class="notification is-danger is-rounded">
										<?php echo $_SESSION['age']; ?>
									</div>
									<?php
									unset($_SESSION['age']);
									$_SESSION['hide'] = '';
								}

								if (!isset($_SESSION['hide'])) { ?>

									<form action="includes/keyrequest.inc.php" method="post">

										<div class="field">
											<div class="control has-icons-left">
												<input class="input is-primary is-info is-rounded" name="requestEmail"
													   type="email"
													   placeholder="Email" value="<?php EmailFillIn(); ?>" required/>
												<span class="icon is-small is-left">
                                            <i class="fas fa-address-card"></i>
                                        </span>
											</div>
										</div>

										<div class="field">
											<div class="select is-info is-rounded">
												<select name="requestValue" required>
													<option disabled selected>How many requests a day?</option>
													<option value="10-100">10 - 250 requests a day</option>
													<option value="250-750">250 - 750 requests a day</option>
													<option value="750-1500">750 - 1500 requests a day</option>
													<option value="1500-2500">1500 - 2000 requests a day</option>
												</select>
											</div>
										</div>

										<div class="field">
											<div class="control">
                                        <textarea class="textarea is-info" placeholder="Why you need access to our API?"
												  name="requestReason" rows="2" required></textarea>
											</div>
										</div>

										<button type="submit" id="submit" name="submit"
												class="button is-info is-outlined is-rounded">
											<i class="fas fa-envelope"></i>&nbsp;Request key
										</button>

									</form>
								<?php }
							}
						} ?>

					</div>

				<?php } else { ?>


					<div class="columns is-widescreen">
						<div class="column is-widescreen api-nav">
							<nav class="panel">
								<p class="panel-heading">
									Introduction
								</p>
								<a href="#authentication" class="panel-block">
									<span class="panel-icon">
									  <i class="fas fa-book" aria-hidden="true"></i>
									</span>
									Authentication
								</a>
								<p class="panel-heading">
									API
								</p>
								<a href="#users" class="panel-block">
									<span class="panel-icon">
									  <i class="fas fa-book" aria-hidden="true"></i>
									</span>
									Users
								</a>
							</nav>
						</div>
						<div class="column has-text-left api-content">
							<div class="container is-widescreen">

								<section id="authentication" class="hero is-dark">
									<div class="hero-body">
										<div class="container">
											<h1 class="title">
												<span class="tag is-link is-large">/POST</span> <span>- Authentication</span>
											</h1>
											<div class="content has-text-white" style="color: white;">
												Info about how to authenticate with the api.
												<ul>
													<li>1</li>
													<li>2</li>
													<li>3</li>
													<li>4</li>
												</ul>
<pre>
{
	"name": "test",
	"format": "json"
}
</pre>
											</div>
										</div>
									</div>
								</section>

								<section id="users" class="hero is-dark">
									<div class="hero-body">
										<div class="container">
											<h1 class="title">
												<span class="tag is-success is-large">/GET</span> <span>- Users</span>
											</h1>
											<div class="content has-text-white" style="color: white;">
												Info about how to fetch data about the users.
												<ul>
													<li>1</li>
													<li>2</li>
													<li>3</li>
													<li>4</li>
												</ul>
<pre>
{
	"name": "test",
	"format": "json"
}
</pre>
											</div>
										</div>
									</div>
								</section>

							</div>
						</div>
					</div>


				<?php } ?>

			</div>

		</div>
	</div>

	<?php
	require 'includes/footer.php';
	unset($_SESSION['hide']);
	?>
</section>

<script src="js/main.js"></script>
<script src="js/navbarMenu.js"></script>
<script src="js/smoothScroll.js"></script>
</body>

</html>