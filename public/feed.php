<?php
// Require DB file for feed.
require 'includes/functions.inc.php';

If (CheckIfLoggedIn() == false) {
    header("Location: ../index.php");
}
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
    <link rel="stylesheet" href="css/font-awesome.min.css">

	<title><?php echo ucwords($_SESSION['user']['firstname']) . "'s Feed"; ?> - Oryx Network</title>
	<!-- TinyMCE WYSIWYG Editor -->
	<script type="text/javascript" src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=qkl3ur6pbinq8wcnwumww78ep4232ddwba6vn0qqhfugd0g7"></script>
	<script type="text/javascript">
		tinymce.init({
            selector: 'textarea',  // change this value according to your HTML
            toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
			max_height: 500,
            max_width: 500,
            min_height: 100,
            min_width: 400,
            statusbar: false
        });
	</script>
</head>
<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    	require 'includes/nav-login.php';
    ?>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns is-vcentered">

                <div class="column">

					<article class="media is-fixed-top">
						<figure class="media-left">
							<p class="image is-64x64">
								<img src="https://bulma.io/images/placeholders/128x128.png">
							</p>
						</figure>
						<div class="media-content">
							<div class="field">
								<p class="control">
									<textarea class="textarea" placeholder="Add a comment..."></textarea>
								</p>
							</div>
							<nav class="level">
								<div class="level-left">
									<div class="level-item">
										<a class="button is-info">Submit</a>
									</div>
								</div>
								<div class="level-right">
									<div class="level-item">
										<label class="checkbox">
											<input type="checkbox"> Press enter to submit
										</label>
									</div>
								</div>
							</nav>
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