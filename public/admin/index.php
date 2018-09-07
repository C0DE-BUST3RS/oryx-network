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
						<li><a>Customers</a></li>
					</ul>
					<p class="menu-label">
						Administration
					</p>
					<ul class="menu-list">
						<li><a>Team Settings</a></li>
						<li>
							<a>Manage Your Team</a>
							<ul>
								<li><a>Members</a></li>
								<li><a>Plugins</a></li>
								<li><a>Add a member</a></li>
							</ul>
						</li>
						<li><a>Invitations</a></li>
						<li><a>Cloud Storage Environment Settings</a></li>
						<li><a>Authentication</a></li>
					</ul>
					<p class="menu-label">
						Transactions
					</p>
					<ul class="menu-list">
						<li><a>Payments</a></li>
						<li><a>Transfers</a></li>
						<li><a>Balance</a></li>
					</ul>
				</aside>
			</div>
			<div class="column is-9">
				<nav class="breadcrumb" aria-label="breadcrumbs">
					<ul>
						<li><a href="../">Bulma</a></li>
						<li><a href="../">Templates</a></li>
						<li><a href="../">Examples</a></li>
						<li class="is-active"><a href="#" aria-current="page">Admin</a></li>
					</ul>
				</nav>
				<section class="hero is-info welcome is-small">
					<div class="hero-body">
						<div class="container">
							<h1 class="title">
								Hello, Admin.
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
									Events
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
										<tr>
											<td width="5%"><i class="fa fa-bell-o"></i></td>
											<td>Lorum ipsum dolem aire</td>
											<td><a class="button is-small is-primary" href="#">Action</a></td>
										</tr>
										<tr>
											<td width="5%"><i class="fa fa-bell-o"></i></td>
											<td>Lorum ipsum dolem aire</td>
											<td><a class="button is-small is-primary" href="#">Action</a></td>
										</tr>
										<tr>
											<td width="5%"><i class="fa fa-bell-o"></i></td>
											<td>Lorum ipsum dolem aire</td>
											<td><a class="button is-small is-primary" href="#">Action</a></td>
										</tr>
										<tr>
											<td width="5%"><i class="fa fa-bell-o"></i></td>
											<td>Lorum ipsum dolem aire</td>
											<td><a class="button is-small is-primary" href="#">Action</a></td>
										</tr>
										<tr>
											<td width="5%"><i class="fa fa-bell-o"></i></td>
											<td>Lorum ipsum dolem aire</td>
											<td><a class="button is-small is-primary" href="#">Action</a></td>
										</tr>
										<tr>
											<td width="5%"><i class="fa fa-bell-o"></i></td>
											<td>Lorum ipsum dolem aire</td>
											<td><a class="button is-small is-primary" href="#">Action</a></td>
										</tr>
										<tr>
											<td width="5%"><i class="fa fa-bell-o"></i></td>
											<td>Lorum ipsum dolem aire</td>
											<td><a class="button is-small is-primary" href="#">Action</a></td>
										</tr>
										<tr>
											<td width="5%"><i class="fa fa-bell-o"></i></td>
											<td>Lorum ipsum dolem aire</td>
											<td><a class="button is-small is-primary" href="#">Action</a></td>
										</tr>
										<tr>
											<td width="5%"><i class="fa fa-bell-o"></i></td>
											<td>Lorum ipsum dolem aire</td>
											<td><a class="button is-small is-primary" href="#">Action</a></td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
							<footer class="card-footer">
								<a href="#" class="card-footer-item">View All</a>
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