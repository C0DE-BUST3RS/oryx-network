<div class="hero-head">
    <nav class="navbar is-fixed-top" style="background: #ffffff">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="feed.php">
                    <img src="img/logos/oryx-trans.png" alt="Logo">
                </a>
				<span class="navbar-burger burger" data-target="navMenu">
					<span></span>
					<span></span>
					<span></span>
				  </span>
            </div>
			<div id="navMenu" class="navbar-menu">
				<div class="navbar-end">
					<a href="feed.php" class="navbar-item <?php if (basename($_SERVER['PHP_SELF']) == 'feed.php') { echo 'is-active'; } ?>"><i class="fa fa-home" aria-hidden="true"></i>
						&nbsp;Feed</a>
					<a href="privacy.php" class="navbar-item <?php if (basename($_SERVER['PHP_SELF']) == 'privacy.php') { echo 'is-active'; } ?>"><i class="fa fa-user-o" aria-hidden="true"></i> &nbsp;Privacy</a>
					<a href="api.php" class="navbar-item <?php if (basename($_SERVER['PHP_SELF']) == 'api.php') { echo 'is-active'; } ?>"><i class="fa fa-cogs" aria-hidden="true"></i> &nbsp;API</a>
					<a href="contact.php" class="navbar-item <?php if (basename($_SERVER['PHP_SELF']) == 'contact.php') { echo 'is-active'; } ?>"><i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp;Contact</a>
                    <a href="includes/logout.inc.php" class="navbar-item"><i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp; Logout</a>
                </div>
			</div>
        </div>
    </nav>
</div>