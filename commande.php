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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

mysql_select_db($database_c, $c);
$query_ql = sprintf("SELECT quantite FROM lentille WHERE idl = %s", GetSQLValueString($_POST['id_prod'], "int"));
$ql = mysql_query($query_ql, $c) or die(mysql_error());
$row_ql = mysql_fetch_assoc($ql);

	if($_POST['quantite']<$row_ql['quantite'])
	{	
	
	  $updateSQL = sprintf("UPDATE lentille SET quantite=%s WHERE idl=%s",
                       GetSQLValueString($row_ql['quantite']-$_POST['quantite'], "int"),
                       GetSQLValueString($_POST['idl'], "int"));

  mysql_select_db($database_c, $c);
  $Result1 = mysql_query($updateSQL, $c) or die(mysql_error());
  
  $insertSQL = sprintf("INSERT INTO commande (id_prod, quantitec, user) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_prod'], "int"),
                       GetSQLValueString($_POST['quantite'], "int"),
                       GetSQLValueString($_POST['user'], "int"));

  mysql_select_db($database_c, $c);
  $Result1 = mysql_query($insertSQL, $c) or die(mysql_error());

  $insertGoTo = "commande.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else
{$erreur="quantité insuffisante";}}

mysql_select_db($database_c, $c);
$query_Recordset1 = "SELECT * FROM commande, utilisateur, lentille WHERE utilisateur.idu=commande.`user` AND lentille.idl=commande.id_prod AND etat='en cours'";
$Recordset1 = mysql_query($query_Recordset1, $c) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_c, $c);
$query_Recordset2 = "SELECT * FROM lentille";
$Recordset2 = mysql_query($query_Recordset2, $c) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_c, $c);
$query_Recordset3 = "SELECT * FROM utilisateur";
$Recordset3 = mysql_query($query_Recordset3, $c) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<?php require('php-version/header.php'); ?>
<div class="row">
  <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2>&nbsp;</h2>

        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>
    <div class="box-content">
   <!-- Button trigger modal -->
<center><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
Ajouter</button>
</center>
<br>

<h1><?php   if(isset($erreur))
{
echo $erreur;	
	
} ?></h1>
<br>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ajout</h4>
      </div>
      <div class="modal-body">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          <table align="center">
            <tr valign="baseline">
              <td nowrap align="right">numéro du paire de lentille:</td>
              <td><select  class="form-control" name="id_prod">
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['idl']?>"><?php echo $row_Recordset2['titre']?></option>
                <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
              </select></td>
            <tr>
            <tr valign="baseline">
              <td nowrap align="right">Quantite:</td>
              <td><input  class="form-control" type="number" name="quantite" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">User:</td>
              <td><select  class="form-control" name="user">
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset3['idu']?>"><?php echo $row_Recordset3['nom']?></option>
                <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
              </select></td>
            <tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input class="btn btn-primary" type="submit" value="Créer commande"></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
        </form>
        <p>&nbsp;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">fermer</button>
      </div>
    </div>
  </div>
</div>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th>Commande</th>
        <th>Lentille</th>
        <th>Client</th>
        <th>Photo</th>
        <th>prix à payer</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
      <?php do { ?>
        <tr>
          <td><?php echo $row_Recordset1['idc']; ?></td>
          <td class="center"><?php echo $row_Recordset1['titre']; ?></td>
          <td class="center"><?php echo $row_Recordset1['nom']; ?></td>
          <td class="center">
         <center> <img src="<?php echo $row_Recordset1['url']; ?>" height="150" width="80%"></center></td>
          <td class="center"><?php echo $row_Recordset1['quantitec']*$row_Recordset1['prix']; ?></td>
          <td class="center"><a class="btn btn-info" href="fact.php?id=<?php echo $row_Recordset1['idu']; ?>">
              <i class="glyphicon glyphicon-edit icon-white"></i>Facturer
              </a>
            <a class="btn btn-danger" href="supc.php?id=<?php echo $row_Recordset1['idc']; ?>">
              <i class="glyphicon glyphicon-trash icon-white"></i>
              Annuler
              </a>
          </td>
        </tr>
        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

  </div><!--/row--><!--/row--><!--/row--><!--/row--><!--/span-->

<?php require('php-version/footer.php'); ?>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
