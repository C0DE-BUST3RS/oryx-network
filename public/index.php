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
		<nav class="navbar is-fixed-top">
			<div class="container">
				<div class="navbar-brand">
					<a class="navbar-item" href="../">
						<img src="https://bulma.io/images/bulma-logo.png" alt="Logo">
					</a>
					<span class="navbar-burger burger" data-target="navbarMenu">
            			<span></span>
                        <span></span>
                        <span></span>
					</span>
				</div>
				<div id="navbarMenu" class="navbar-menu">
					<div class="navbar-end">
						<div class="tabs is-right">
							<ul>
								<li class="">
									<form>
										<div class="field is-grouped">
											<p class="control has-icons-left">
												<input class="input is-rounded" type="text" placeholder="Username">
												<span class="icon is-small is-left">
												  <i class="fa fa-user"></i>
												</span>
											</p>
											<p class="control has-icons-left">
												<input class="input is-rounded" type="password" placeholder="Password">
												<span class="icon is-small is-left">
												  <i class="fa fa-key"></i>
												</span>
											</p>
										</div>
									</form>
								</li>
								<li class="">
									<a class="button is-success is-outlined is-rounded">Login</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</div>
	<div class="hero-body">
		<div class="container has-text-centered">
			<div class="columns is-vcentered">

				<div class="column is-one-third">
					<figure class="image is-4by3">
						<img src="https://picsum.photos/800/600/?image=1045" alt=""/>
					</figure>
				</div>

				<div class="column is-one-third">
					<h1 class="title is-2">
						Oryx Network
					</h1>
					<h2 class="subtitle is-4">
						Best place to make new friends
					</h2>
					<br>
				</div>

				<div class="column is-one-third">
					<h4 class="title is-4">
						Don't have an account?
					</h4>
					<h5 class="subtitle is-5">
						Register Now!
					</h5>
					<form action="" method="POST">

						<div class="field">
							<label class="label">Email</label>
							<div class="control has-icons-left has-icons-right">
								<input class="input" id="registerEmail" name="registerEmail" type="email" placeholder="Email">
								<span class="icon is-small is-left">
									<i class="fa fa-envelope"></i>
    							</span>
							</div>

							<div class="field">
								<button type="submit" id="registerSubmit" name="registerSubmit" class="button is-danger is-outlined is-rounded">Register</button>
							</div>

						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
	<div class="hero-foot">
		<div class="container">
			<div class="tabs is-centered">
				<ul>
					<li><a>Copyright &copy; OryxNetwork 2018</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<script src="js/main.js"></script>
</body>

</html>