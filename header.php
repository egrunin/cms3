<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <title><?php echo $page_title; ?></title>
    <?php ob_start(); ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS Section -->
    <link rel="stylesheet" href="Content/css/bootstrap.min.css" />
    <link rel="stylesheet" href="Content/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="Content/css/font-awesome.min.css" />
    <link rel="stylesheet" href="Content/normalize.css" media="screen" />
    <link rel="stylesheet" href="Content/app.css" media="screen" />
</head>
<body>

<!--  Include the JavaScript SDK on your page once, ideally right after the opening <body> tag -->   
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
            aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="default.php"><i class="fa fa-fort-awesome fa-lg"></i></a>
        </div>
        
        <a href="pages.php" title="CMS Site" class="navbar-brand">
            </i>CMS</a>
        
        <!-- Collect the nav links -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
            <?php 

            // session_start();
            if (!empty($_SESSION['user_id'])) {
                //private setup
                echo  '<li><a href="admins.php" title="Admins">Admins</a></li>
                       <li><a href="register.php" title="Register">Register</a></li>
                       <li><a href="pages.php" title="Pages">Pages</a></li>        
                       <li><a href="default.php" title="Public Site">Public Site</a></li>
                       <li><a href="logout.php" title="Logout">Logout</a></li>';
                }
                
                //public links
                else {
                echo '<li><a href="adminlogin.php" title="Login">Login</a></li>';
                }
            ?>
            </ul>
        </div>
    </div><!-- /.container-fluid -->
</nav>

<main>