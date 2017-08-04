<?php require_once('Connections/c.php'); ?>
<?php
session_start();
if(!isset($_SESSION['MM_Username']))
{
header("location:index.php");	
	
	
}



 ?>
<!--Il s'agit d'une fonction obsolète de DREAMWEAVER qui permettait de formater (protéger) une valeur avant de l'insérer dans une base de donnée.
-->
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_c, $c);
$query_users = "SELECT Count(idu) FROM utilisateur";
$users = mysql_query($query_users, $c) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

mysql_select_db($database_c, $c);
$query_Recordset1 = "SELECT Count(commande.idc) FROM commande WHERE commande.etat='en cours'";
$Recordset1 = mysql_query($query_Recordset1, $c) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_c, $c);
$query_Recordset2 = "SELECT * FROM commande, utilisateur, lentille WHERE utilisateur.idu=commande.`user` AND lentille.idl=commande.id_prod AND etat='en cours'";
$Recordset2 = mysql_query($query_Recordset2, $c) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<?php 
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php require('php-version/header.php'); ?>
<p>&nbsp;</p>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Dashboard</a>
        </li>
    </ul>
</div>
<div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="#">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Clients</div>
            <div class="notification yellow" ><?php echo $row_users['Count(idu)']; ?></div>
       
        </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-6">
      <a data-toggle="tooltip"  class="well top-block" href="#">
        <i class="glyphicon glyphicon-shopping-cart yellow"></i>
        
        <div>Commandes en cours</div>
            <div></div>
            <span class="notification yellow"><?php echo $row_Recordset1['Count(commande.idc)']; ?></span>
        </a>
  </div>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Introduction</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content row">
                <div class="col-lg-7 col-md-12">
                    <h1>Gestion commercial <br>
                        <small>Application d'intranet.</small>
                    </h1>
                    <p>Ici vous gérer vos produits et commande</p>

                    <p><b>Le calcule et la facturation aussi.</b></p>
                    <h5><strong>Factures en cours:</strong></h5>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Client</th>
                          <th>prix à payer</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
						$s=0;
						
						 do { ?>
                        <tr>
                          <td class="center"><?php echo $row_Recordset2['nom']; ?></td>
                          <td class="center"><?php echo $row_Recordset2['quantitec']*$row_Recordset2['prix'];
						$s=$s+$row_Recordset2['quantitec']*$row_Recordset2['prix'];  
						   ?></td>
                        </tr>
                        <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
                      </tbody>
                    </table>
                    <p>&nbsp;</p>

                    <p class="center-block download-buttons">
                    <h5 align="center">Votre chiffre totale de rentabilité est <?php echo $s; ?></h5>
                    </p>
                </div>
                <!-- Ads, you can remove these -->
              

            </div>
        </div>
    </div>
</div>

<div class="row"><!--/span--><!--/span--><!--/span-->
</div><!--/row-->

<div class="row"><!--/span--><!--/span--><!--/span-->
</div><!--/row-->
<?php require('php-version/footer.php'); ?>
<?php
mysql_free_result($users);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
