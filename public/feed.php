<?php
// Require DB file for feed.
require 'includes/functions.inc.php';

If (CheckIfLoggedIn() == false) {
	header("Location: ../index.php");
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
	<title><?php echo $_SESSION['user']['firstname'] . "'s Feed"; ?> - Oryx Network</title>
</head>
<body>
<?php echo $_SESSION['user']['id']; ?>
</body>
</html>