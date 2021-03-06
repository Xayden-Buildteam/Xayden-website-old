<?php
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
  if(isset($_SESSION['success'])) {
    include('../db/db.php');
    include("./functions.php");
    $conn = database();
?>
<?php include_once("../config/config.php") ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8"/>
			<meta name="description" content="Xayden is a Minecraft buildteam and official Minecraft Partner. We specializes in creating impressive Minecraft builds for all clients, and server owners.">
			<meta name="keywords" content="Xayden,Buildteam,Minecraft,Builds">
			<meta name="author" content="TheChasoCode">
			<meta name="viewport" content="width=device-width, initial-scale=1">		
			<title>Applications | Xayden - Minecraft Buildteam</title>
            <link rel="stylesheet" href="main.css" media="screen"/>
            <link rel="shortcut icon" href="../Xayden/xayden_logo_1_250x250.jpg"/>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
        </head>

        <body>

        <?php echo menu1($_SESSION['username'], $_SESSION['rank']); ?>


        <section class="news">
            <div class="news-box">
                <article class="news-box-header">
                    <h1 class="news-box-header-text">Applications</h1>
                </article>
                <div class="news-box-messages">
                    <?php

                    switch ($_SESSION['rank'])
                        {

                            case 'Director':
                            case 'Manager':
                            case 'SalesManager':
                            case 'Admin':
                            case 'Bypass':
                            case 'Support':

                            $query1 = "SELECT * FROM applications ORDER BY registerdate DESC";
                            $result1 = mysqli_query($conn, $query1);

                            if (mysqli_num_rows($result1) == 0)
                            {
                                echo "<i>There are no applications yet . . .</i>";
                            }

                            else
                            {
                                while ($row1 = mysqli_fetch_array($result1))
                                {
                                    echo '
                                    <a class="news-box-messages-application" href="./Application-view.php?ID=' . $row1['ID'] . '">
                                        <p class="news-box-messages-application-text">' . $row1['username'] . '</p>
                                        ';

                                    if ($row1['status'] == "accepted") {
                                        echo '<p class="news-box-messages-application-text4">Accepted</p>';
                                    }
                                    elseif ($row1['status'] == "denied") {
                                        echo '<p class="news-box-messages-application-text3">Denied</p>';
                                    }
                                    else {
                                        echo '<p class="news-box-messages-application-text">Undecided</p>';
                                    }

                                    echo '
                                        <p class="news-box-messages-application-text2">' . $row1['applydate'] . '</p>
                                    </a>';
                                }
                        }
                        break;

                        default:
                                echo "<i>This intel isn't available with your rank. . .</i>";
                    }

                    ?>
                </div>
            </div>
        </section>

        <?php echo menu2(); ?>

        </body>
        </html>
        <?php
    }

    else {
        header('refresh:0; url=login.php');
    }
?>