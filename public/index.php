<?php
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
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<title>Home - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
	<div class="hero-head">
		<nav class="navbar is-fixed-top" style="background: #ffffff">
			<div class="container">
				<div class="navbar-brand">
					<a class="navbar-item" href="#">
						<img src="img/logos/oryx-trans.png" alt="Logo">
					</a>
					<a class="navbar-item" href="index.php">
						Home
					</a>
					<a class="navbar-item" href="#">
						Privacy
					</a>
					<a class="navbar-item" href="#">
						Contact
					</a>
					<a class="navbar-item" href="#">
						API
					</a>
				</div>
			</div>
		</nav>
	</div>
	<div class="hero-body">
		<div class="container has-text-centered">
			<div class="columns is-vcentered">

				<div class="column is-one-third is-hidden-mobile">
					<figure class="image">
						<img src="img/homepage/homepage-image.jpg" alt="" style="border-radius: 5%"/>
					</figure>
				</div>

				<div class="column is-one-third">
					<h1 class="title is-1">
						Oryx Network
					</h1>
					<h2 class="subtitle is-4">
						The best place to make new friends
					</h2>
					<a class="button is-danger is-outlined is-rounded" href="login.php">
						Login
					</a>
				</div>

				<div class="column is-one-third">
					<h4 class="title is-4">
						Don't have an account?
					</h4>
					<h5 class="subtitle is-5">
						Register Now!
					</h5>
					<form action="includes/signup.inc.php" method="POST" enctype="multipart/form-data">

						<div class="field">
							<div class="control has-icons-left">
								<input class="input is-primary is-info is-rounded" id="registerFirstname"
									   name="registerFirstname" type="text" placeholder="Firstname"/>
								<span class="icon is-small is-left">
									<i class="fa fa-address-card"></i>
    							</span>
							</div>
						</div>

						<div class="field">
							<div class="control has-icons-left">
								<input class="input is-primary is-info is-rounded" id="registerLastname"
									   name="registerLastname" type="text" placeholder="Lastname"/>
								<span class="icon is-small is-left">
									<i class="fa fa-address-card"></i>
    							</span>
							</div>
						</div>

						<div class="field">
							<div class="control has-icons-left">
								<input class="input is-primary is-info is-rounded" id="registerEmail"
									   name="registerEmail" type="email" placeholder="Email"/>
								<span class="icon is-small is-left">
									<i class="fa fa-envelope"></i>
    							</span>
							</div>
						</div>

						<div class="field">
							<div class="control has-icons-left">
								<input class="input is-primary is-info is-rounded" id="registerPassword"
									   name="registerPassword" type="password" placeholder="Password"/>
								<span class="icon is-small is-left">
									<i class="fa fa-lock"></i>
    							</span>
							</div>
						</div>

						<div class="field">
							<div class="control">
								<label class="checkbox">
									<input type="checkbox" name="registerTOF" id="registerTOF" value="accepted"/>
									I agree to the <a href="#">terms and conditions</a>
								</label>
							</div>
						</div>

						<input type="submit" id="submit" name="submit" class="button is-danger is-outlined is-rounded"
							   value="Register"/>
						<input type="reset" name="reset" class="button is is-danger is-outlined is is-rounded"
							   value="Reset"/>

					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="hero-foot">
		<div class="container">
			<div class="tabs is-centered">
				<ul>
					<li><a>&copy; <?php CopyrightYear(); ?> Oryx Network</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<script src="js/main.js"></script>
</body>

</html>