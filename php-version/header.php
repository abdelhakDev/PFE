<?php include 'config.php' ?>
<?php 
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   
    <meta charset="utf-8">
    <title>OPTIMOM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Abdelhak Blidaoui">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="../img/logo20.png">

</head>

<body>
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="accueil.php"> <img alt="Charisma Logo" src="img/logo20.png" class="hidden-xs"/>
                <span>OPTIMOM</span></a>

            <!-- user dropdown starts -->
          
            <!-- user dropdown ends -->

            <!-- theme selector starts -->
           
            <!-- theme selector ends -->

         

        </div>
    </div>
    <!-- topbar ends -->
<?php } ?>
<div class="ch-container">
    <div class="row">
        <?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>

        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Menu</li>
                        <li><a class="ajax-link" href="accueil.php">
                        <i class="glyphicon glyphicon-home"></i><span> Accueil</span></a>
                        </li> <li><a class="ajax-link" href="profil.php">
                        <i class="glyphicon glyphicon-user"></i><span> Profil</span></a>
                        </li>
                        <li><a class="ajax-link" href="commande.php">
                        <i class="glyphicon glyphicon-eye-open"></i><span>
                         Facturation et commandes</span></a>
                        </li>
                        <li><a class="ajax-link" href="lent.php">
                        <i class=" glyphicon glyphicon-adjust"></i><span> Lentilles</span></a></li>
                        <li><a class="ajax-link" href="cat.php">
                        <i class="glyphicon glyphicon-list-alt"></i><span> Catégories</span></a></li> 								
                        
                        <li> <a class="ajax-link" href="users.php">
                         <i class="glyphicon glyphicon-user"></i><span> Utilisateurs</span></a></li>
     
                     
                        <li><a href="deco.php"><i class="glyphicon glyphicon-lock"></i>
                        <span> Déconnexion</span></a>
                        </li>
                    </ul>
                   
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

      

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <?php } ?>
