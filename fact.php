
// page facture à imprimer
<?php require_once('Connections/c.php'); ?>
<?php
session_start();
if(!isset($_SESSION['MM_Username']))
{
header("location:index.php");	
	
	
}



 ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE commande SET etat=%s WHERE `user`=%s",
                       GetSQLValueString('fait', "text"),
                       GetSQLValueString($_GET['id'], "text"));

  mysql_select_db($database_c, $c);
  $Result1 = mysql_query($updateSQL, $c) or die(mysql_error());

  $updateGoTo = "commande.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_c, $c);
$query_Recordset1 = sprintf("SELECT * FROM commande, utilisateur, lentille WHERE user = %s AND commande.etat='en cours' AND utilisateur.idu=user AND lentille.idl= commande.id_prod", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $c) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php //require('php-version/header.php'); ?>

<style>
td
{
	text-align:center;
	font-size:14px;
	font-weight:bold;}

.btn{
	color:#FFFFFF;
	background-color:#359AFF;
	text-align:center;
	height:50px;
	font-weight:bold;
	border-radius:8px;
	}
	table
	{
		
	width:80%;
	border-width:2px;}
</style>
<div class="row">
  <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2 align="center"><i class="glyphicon glyphicon-user"></i>Facturation</h2>

        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>
    <div class="box-content">
<center>
</center>
<!-- Modal -->
<p>&nbsp;</p>
    <table align="center" width="80%" border="0" class="table">
    <thead>
    <tr>
        <th>Commande</th>
        <th>Date</th>
        <th>quantité</th>
        <th>Prix à payer</th>
        </tr>
    </thead>
    <tbody>
      <?php $s=0; do { ?>
        <tr>
          <td><?php echo $row_Recordset1['idc']; ?></td>
          <td class="center"><?php echo $row_Recordset1['date']; ?></td>
          <td class="center"><?php echo $row_Recordset1['quantitec']; ?></td>
          <td class="center"><?php echo $row_Recordset1['quantitec']*$row_Recordset1['prix'];
						$s=$s+$row_Recordset1['quantitec']*$row_Recordset1['prix'];  
						   ?></td>
          </tr>
        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    </tbody>
    </table>
    <p>&nbsp;</p>
      <h3 align="center">T.H.T:<?php echo $s; ?></h3>
       <h3 align="center">Taux de TVA:<?php echo ($s*12)/100; ?></h3>
        <h3 align="center">Totale à payer:<?php echo  $s-($s*12)/100; ?></h3>
      <form name="form1" method="post" action="">
      </form>
      <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
        <table align="center">
          <tr valign="baseline">
            <td nowrap align="right">&nbsp;</td>
            <td><input class="btn" onClick="window.print();" type="submit" value="Cloturer et imprimer"></td>
          </tr>
        </table>
        <input type="hidden" name="user" value="<?php echo $row_Recordset1['user']; ?>">
        <input type="hidden" name="etat" value="fait">
        <input type="hidden" name="MM_update" value="form2">
        <input type="hidden" name="user" value="<?php echo $row_Recordset1['user']; ?>">
      </form>
      <p>&nbsp;</p>
<p align="center">&nbsp;</p>
    </div>
    </div>
    </div>
    <!--/span-->

  </div><!--/row--><!--/row--><!--/row--><!--/row--><!--/span-->

<?php // require('php-version/footer.php'); ?>
<?php
mysql_free_result($Recordset1);
?>
