<?php require_once('Connections/c.php'); ?>
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
  $updateSQL = sprintf("UPDATE lentille SET quantite=%s WHERE idl=%s",
                       GetSQLValueString($_POST['quantite'], "int"),
                       GetSQLValueString($_POST['idl'], "int"));

  mysql_select_db($database_c, $c);
  $Result1 = mysql_query($updateSQL, $c) or die(mysql_error());
}

$colname_ql = "-1";
if (isset($_POST['id_produit'])) {
  $colname_ql = $_POST['id_produit'];
}
mysql_select_db($database_c, $c);
$query_ql = sprintf("SELECT * FROM lentille WHERE idl = %s", GetSQLValueString($colname_ql, "int"));
$ql = mysql_query($query_ql, $c) or die(mysql_error());
$row_ql = mysql_fetch_assoc($ql);
$totalRows_ql = mysql_num_rows($ql);

mysql_free_result($ql);
?>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Idl:</td>
      <td><?php echo $row_ql['idl']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Quantite:</td>
      <td><input type="text" name="quantite" value="<?php echo htmlentities($row_ql['quantite'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idl" value="<?php echo $row_ql['idl']; ?>" />
</form>
<p>&nbsp;</p>
