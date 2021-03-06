<?php
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	header("location: login.php");
  }
  if(isset($_SESSION['success'])) {
    include('../db/db.php');
    include("./functions.php");
    $conn = database();
  }

    if (isset($_SESSION['success']) && isset($_POST['submit'])) {

        $name = $_POST['name'];
        $description = $_POST['description'];
        $ip = $_POST['ip'];

        $filename = $_FILES["file"]["name"];
        $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
        $file_ext = substr($filename, strripos($filename, '.')); // get file name
        $filesize = $_FILES["file"]["size"];
        $allowed_file_types = array('.png');

        if (in_array($file_ext,$allowed_file_types) && ($filesize < 1000000))
        {
            // Rename file
            $newfilename = $name . $file_ext;
            if (file_exists("../Images/companies/" . $newfilename))
            {
                // file already exists error
                $_SESSION['buildrequestReport2'] = "The file you tried to upload already exists.";
            }
            else
            {
                $query2 = "SELECT partnername FROM parners WHERE partnername='".$name."';";
                $result2 = mysqli_query($conn, $query2);

                if (mysqli_num_rows($result2) == 0) {
                    $query1 = "INSERT INTO partners(partnername, description, ip) VALUES ('".$name."', '".$description."', '".$ip."');";
                    $result1 = mysqli_query($conn, $query1);

                    if ($result1) {
                        move_uploaded_file($_FILES["file"]["tmp_name"], "../Images/companies/" . $newfilename);
                        $_SESSION['buildrequestReport1'] = "Partner has been succesfully added to the website";
                    }
                    else {
                        $_SESSION['buildrequestReport2'] = "The website couldn't register that partner, please try it again or contact the Web-developer.";
                    }
                }
            }
        }
        elseif (empty($file_basename))
        {
            // file selection error
            $_SESSION['buildrequestReport2'] = "Please select a valid file.";
        }
        elseif ($filesize > 1000000)
        {
            // file size error
            $_SESSION['buildrequestReport2'] = "The file you tried to upload is bigger then 1 mb, please try it again.";
        }
        else
        {
            // file type error
            $_SESSION['buildrequestReport2'] = "Make sure the file is a .png file";
        }


        header('refresh:0; url=settings.php');
    }
    else {
        header('refresh:0; url=settings.php');
    }


?>