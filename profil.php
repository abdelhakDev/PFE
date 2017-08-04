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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE utilisateur SET email=%s, adresse=%s, tel=%s, login=%s, mdp=%s WHERE idu=%s",
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['adresse'], "text"),
                       GetSQLValueString($_POST['tel'], "text"),
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['mdp'], "text"),
                       GetSQLValueString($_POST['idu'], "int"));

  mysql_select_db($database_c, $c);
  $Result1 = mysql_query($updateSQL, $c) or die(mysql_error());

  $updateGoTo = "profil.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_c, $c);
$query_Recordset1 = sprintf("SELECT * FROM utilisateur WHERE login = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $c) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php include('php-version/header.php'); ?>


<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Profil</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Profil</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <p>
                  <!-- put your content here -->
                </p>
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                  <table align="center">
                    <tr valign="baseline">
                      <td nowrap align="right">Email:</td>
                      <td><input type="text" class="form-control" required name="email" value="<?php echo htmlentities($row_Recordset1['email'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right" valign="top">Adresse:</td>
                      <td><textarea name="adresse" cols="50" rows="5"><?php echo htmlentities($row_Recordset1['adresse'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Tel:</td>
                      <td><input type="text" class="form-control" required name="tel" value="<?php echo htmlentities($row_Recordset1['tel'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Login:</td>
                      <td><input type="text" class="form-control" required name="login" value="<?php echo htmlentities($row_Recordset1['login'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Mot de passe:</td>
                      <td><input type="text" class="form-control" required name="mdp" value="<?php echo htmlentities($row_Recordset1['mdp'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">&nbsp;</td>
                      <td><input type="submit" class="btn btn-primary" value="Mettre à jour"></td>
                    </tr>
                  </table>
                  <input type="hidden" name="idu" value="<?php echo $row_Recordset1['idu']; ?>">
                  <input type="hidden" name="MM_update" value="form1">
                  <input type="hidden" name="idu" value="<?php echo $row_Recordset1['idu']; ?>">
                </form>
                <p>&nbsp;</p>
<p>&nbsp;</p>
              <p>&nbsp;</p>
            </div>
        </div>
    </div>
</div><!--/row-->


<?php include('php-version/footer.php'); ?>
<!-- libère toute la mémoire et les ressources utilisées par la ressource de résultat  -->
<?php
mysql_free_result($Recordset1);
?>
