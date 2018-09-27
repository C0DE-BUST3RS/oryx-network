<?php
//Require the functions and start the session
require '../includes/functions.inc.php';

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
    <title>API Keys - Oryx Network</title>
</head>

<body>
<section class="hero is-fullheight is-default is-bold">
    <?php
    require '../includes/nav-login.php';
    ?>
    <div class="container">
        <div class="columns">
            <div class="column is-3">
                <?php
                require 'nav-admin.php';
                ?>
            </div>
            <div class="column is-9">
                <div class="columns">
                    <div class="column is-12">
                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    API Keys
                                </p>
                                <a href="#" class="card-header-icon" aria-label="more options">
								  <span class="icon">
									<i class="fa fa-angle-down" aria-hidden="true"></i>
								  </span>
                                </a>
                            </header>
                            <div class="card-table">
                                <div class="content">
                                    <!-- Start api key requests -->
                                    <div class="content">
                                        <table class="table is-fullwidth is-striped">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Last IP</th>
                                                    <th>Email</th>
                                                    <th>Times used</th>
                                                    <th>Enable</th>
                                                    <th>Disable</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $stmt = $conn->prepare("SELECT * FROM `api-key` ORDER BY id DESC;");
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            while ($row = $result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        if ($row['active'] == 1) {
                                                            echo "<span class='tag is-success'>Active</span>";
                                                        } else {
                                                            echo "<span class='tag is-danger'>Not active</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <p><?php echo $row['id']; ?></p>
                                                    </td>
                                                    <td>
                                                        <p><?php echo date('d-m-y ', strtotime($row['date'])); ?></p>
                                                    </td>
                                                    <td>
                                                        <p><?php echo $row['last_ip']; ?></p>
                                                    </td>
                                                    <td>
                                                        <p><?php echo $row['email']; ?></p>
                                                    </td>
                                                    <td>
                                                        <p><?php echo $row['used']; ?></p>
                                                    </td>

                                                    <?php if ($row['active'] == 1) { ?>
                                                        <td>
                                                            <form action="includes/enable-disable-key.php" method="POST">
                                                                <input type="text" name="email"
                                                                       value="<?php echo $row['email']; ?>" hidden/>
                                                                <input type="text" name="status" value="enable" hidden/>
                                                                <button type="submit" id="submit" name="submit"
                                                                        class="button is-small is-success">
                                                                    <span class="icon"><i class="fas fa-check"></i></span>
                                                                    <span>Enable</span>
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form action="includes/enable-disable-key.php" method="POST" hidden>
                                                                <input type="text" name="email"
                                                                       value="<?php echo $row['email']; ?>" hidden/>
                                                                <input type="text" name="status" value="disable" hidden/>
                                                                <button type="submit" id="submit" name="submit"
                                                                        class="button is-small is-danger">
                                                                    <span class="icon"><i class="fas fa-times"></i></span>
                                                                    <span>Disable</span>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td>
                                                            <form action="includes/enable-disable-key.php" method="POST">
                                                                <input type="text" name="email"
                                                                       value="<?php echo $row['email']; ?>" hidden/>
                                                                <input type="text" name="status" value="enable" hidden/>
                                                                <button type="submit" id="submit" name="submit"
                                                                        class="button is-small is-success">
                                                                    <span class="icon"><i class="fas fa-check"></i></span>
                                                                    <span>Enable</span>
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form action="includes/enable-disable-key.php" method="POST" hidden>
                                                                <input type="text" name="email"
                                                                       value="<?php echo $row['email']; ?>" hidden/>
                                                                <input type="text" name="status" value="disable" hidden/>
                                                                <button type="submit" id="submit" name="submit"
                                                                        class="button is-small is-danger">
                                                                    <span class="icon"><i class="fas fa-times"></i></span>
                                                                    <span>Disable</span>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End api keys -->
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