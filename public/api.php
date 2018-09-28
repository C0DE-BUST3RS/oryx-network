<?php
//Require the functions and start the session
require 'includes/functions.inc.php';

// Define user api key.
if (CheckIfLoggedIn()) {
    $apiKey = getUserAPIKey($_SESSION['user']['id']);
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

				<?php
				//Check if the user has an valid API key
				if (!checkUserAPIKey()) { ?>

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
								<a href="#endpoints" class="panel-block">
									<span class="panel-icon">
									  <i class="fas fa-book" aria-hidden="true"></i>
									</span>
									Endpoints
								</a>
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
								<a href="#user-profile" class="panel-block">
									<span class="panel-icon">
									  <i class="fas fa-book" aria-hidden="true"></i>
									</span>
									User Profile
								</a>
								<a href="#user-posts" class="panel-block">
									<span class="panel-icon">
									  <i class="fas fa-book" aria-hidden="true"></i>
									</span>
									User Posts
								</a>
							</nav>
						</div>
						<div class="column has-text-left api-content">
							<div class="container is-widescreen">

								<!-- Endpoints -->
								<section id="endpoints" class="hero">
									<div class="hero-body">
										<div class="container">
											<h1 class="title">
												<span>Endpoints</span>
											</h1>
											<h2 class="subtitle">
												<span>How to authenticate with the api</span>
											</h2>
											<div class="content box has-text-black">
												<p>
													The Authentication API is served over HTTPS. All URLs referenced in
													the documentation have the following base:
												</p>
												<pre>
https://www.oryx.network/api/v1/
</pre>
											</div>
										</div>
									</div>
								</section>
								<!-- End Eindpoints -->
								<!-- Authentication -->
								<section id="authentication" class="hero">
									<div class="hero-body">
										<div class="container">
											<h1 class="title">
												<span class="tag is-link is-large">POST</span>
												<span>- Authentication</span>
											</h1>
											<h2 class="subtitle">
												<span>How to authenticate with the API</span>
											</h2>
											<div class="content box has-text-black">
												<p>
													The Authentication API is served over HTTPS. All URLs referenced in
													the documentation have the following base:
												</p>
												<pre>
https://www.oryx.network/api/v1/<?php echo $apiKey; ?>
</pre>
												<p>
													Responses:
												</p>
												<table>
													<thead>
													<th width="10px">Code</th>
													<th></th>
													</thead>
													<tbody>
													<tr>
														<th width="15%">200</th>
														<th>
<pre>
{
	"auth": "boolean",
	"key": "string",
	"assigned-to": "string"
}
</pre>
														</th>
													</tr>
													<tr>
														<th width="15%">400</th>
														<th>Bad request</th>
													</tr>
													<tr>
														<th width="15%">401</th>
														<th>Unauthorized</th>
													</tr>
													<tr>
														<th width="15%">403</th>
														<th>Forbidden</th>
													</tr>
													<tr>
														<th width="15%">404</th>
														<th>Not Found</th>
													</tr>
													<tr>
														<th width="15%">429</th>
														<th>Too many requests</th>
													</tr>
													</tbody>
												</table>
											</div>


											<p>

											</p>
										</div>
									</div>
								</section>
								<!-- End Authentication -->
								<!-- Users -->
								<section id="users" class="hero">
									<div class="hero-body">
										<div class="container">
											<h1 class="title">
												<span class="tag is-success is-large">GET</span> <span>- Users</span>
											</h1>
											<h2 class="subtitle">
												<span>Fetch data about all the users</span>
											</h2>
											<div class="content box has-text-black">
												<table>
													<thead>
													<th width="10px">Parameters</th>
													<th></th>
													</thead>
													<tbody>
													<tr>
														<th width="15%">API Key *</th>
														<th>
															<?php echo $apiKey; ?>
														</th>
													</tr>
													<tr>
														<th width="15%">Limit</th>
														<th>Default value is 50 users</th>
													</tr>
													</tbody>
												</table>
<pre>
https://www.oryx.network/api/v1/<?php echo $apiKey; ?>/users/50
</pre>
												<p>
													Responses:
												</p>
												<table>
													<thead>
													<th width="10px">Code</th>
													<th></th>
													</thead>
													<tbody>
													<tr>
														<th width="15%">200</th>
														<th>
<pre>
{
"users": [
		{
			 "user_id": "string",
			 "firstname": "string",
			 "lastname": "string",
			 "email": "string",
			 "last_login": "datetime"
		},
		{
			"user_id": "string",
			"firstname": "string",
			"lastname": "string",
			"email": "string",
			"last_login": "datetime"
		}
	]
}
</pre>
														</th>
													</tr>
													<tr>
														<th width="15%">400</th>
														<th>Bad request</th>
													</tr>
													<tr>
														<th width="15%">401</th>
														<th>Unauthorized</th>
													</tr>
													<tr>
														<th width="15%">403</th>
														<th>Forbidden</th>
													</tr>
													<tr>
														<th width="15%">404</th>
														<th>Not Found</th>
													</tr>
													<tr>
														<th width="15%">429</th>
														<th>Too many requests</th>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</section>
								<!-- End Users -->

								<!-- User Profile -->
								<section id="user-profile" class="hero">
									<div class="hero-body">
										<div class="container">
											<h1 class="title">
												<span class="tag is-success is-large">GET</span> <span>- User Profile</span>
											</h1>
											<h2 class="subtitle">
												<span>Fetch profile information about a specific user</span>
											</h2>
											<div class="content box has-text-black">
												<table>
													<thead>
													<th width="10px">Parameters</th>
													<th></th>
													</thead>
													<tbody>
													<tr>
														<th width="15%">API Key *</th>
														<th>
															<?php echo $apiKey; ?>
														</th>
													</tr>
													<tr>
														<th width="15%">User ID *</th>
														<th>
															<?php echo $_SESSION['user']['id']; ?>
														</th>
													</tr>
													</tbody>
												</table>
												<pre>
https://www.oryx.network/api/v1/<?php echo $apiKey; ?>/user/profile/<?php echo $_SESSION['user']['id'];?>
</pre>
												<p>
													Responses:
												</p>
												<table>
													<thead>
													<th width="10px">Code</th>
													<th></th>
													</thead>
													<tbody>
													<tr>
														<th width="15%">200</th>
														<th>
<pre>
{
	"user_id": "string",
	"profile_picture": "string",
	"profile_desc": "string"
}
</pre>
														</th>
													</tr>
													<tr>
														<th width="15%">400</th>
														<th>Bad request</th>
													</tr>
													<tr>
														<th width="15%">401</th>
														<th>Unauthorized</th>
													</tr>
													<tr>
														<th width="15%">403</th>
														<th>Forbidden</th>
													</tr>
													<tr>
														<th width="15%">404</th>
														<th>Not Found</th>
													</tr>
													<tr>
														<th width="15%">429</th>
														<th>Too many requests</th>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</section>
								<!-- End User Profile -->

								<!-- User Posts -->
								<section id="user-posts" class="hero">
									<div class="hero-body">
										<div class="container">
											<h1 class="title">
												<span class="tag is-success is-large">GET</span> <span>- User Posts</span>
											</h1>
											<h2 class="subtitle">
												<span>Fetch every post from a specific user</span>
											</h2>
											<div class="content box has-text-black">
												<table>
													<thead>
													<th width="10px">Parameters</th>
													<th></th>
													</thead>
													<tbody>
													<tr>
														<th width="15%">API Key *</th>
														<th>
															<?php echo $apiKey; ?>
														</th>
													</tr>
													<tr>
														<th width="15%">User ID *</th>
														<th>
															<?php echo $_SESSION['user']['id']; ?>
														</th>
													</tr>
													</tbody>
												</table>
												<pre>
https://www.oryx.network/api/v1/<?php echo $apiKey; ?>/user/posts/<?php echo $_SESSION['user']['id'];?>
</pre>
												<p>
													Responses:
												</p>
												<table>
													<thead>
													<th width="10px">Code</th>
													<th></th>
													</thead>
													<tbody>
													<tr>
														<th width="15%">200</th>
														<th>
<pre>
{
	"user_id": "string",
	"content": "string",
	"likes": "integer",
	"date": "datetime"
}
</pre>
														</th>
													</tr>
													<tr>
														<th width="15%">400</th>
														<th>Bad request</th>
													</tr>
													<tr>
														<th width="15%">401</th>
														<th>Unauthorized</th>
													</tr>
													<tr>
														<th width="15%">403</th>
														<th>Forbidden</th>
													</tr>
													<tr>
														<th width="15%">404</th>
														<th>Not Found</th>
													</tr>
													<tr>
														<th width="15%">429</th>
														<th>Too many requests</th>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</section>
								<!-- End User Posts -->

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