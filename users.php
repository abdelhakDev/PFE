// page gerer profil user


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
  $insertSQL = sprintf("INSERT INTO utilisateur (nom, date_naissance, grade, email, adresse, tel, sexe) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nom'], "text"),
                       GetSQLValueString($_POST['date_naissance'], "text"),
                       GetSQLValueString($_POST['grade'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['adresse'], "text"),
                       GetSQLValueString($_POST['tel'], "text"),
                       GetSQLValueString($_POST['sexe'], "text"));

  mysql_select_db($database_c, $c);
  $Result1 = mysql_query($insertSQL, $c) or die(mysql_error());

  $insertGoTo = "users.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_c, $c);
$query_Recordset1 = "SELECT * FROM utilisateur";
$Recordset1 = mysql_query($query_Recordset1, $c) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php require('php-version/header.php'); ?>
<div class="row">
  <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i>Utilisateurs</h2>

        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>
    <div class="box-content">
<center><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
Ajouter</button>
</center>
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
              <td nowrap align="right">Nom:</td>
              <td><input type="text" class="form-control" required name="nom" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Date_naissance:</td>
              <td><input type="date" class="form-control" required name="date_naissance" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Email:</td>
              <td><input type="email" class="form-control" required name="email" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right" valign="top">Adresse:</td>
              <td><textarea class="form-control" name="adresse" cols="50" rows="5"></textarea></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Tel:</td>
              <td><input type="number" class="form-control" required name="tel" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Sexe:</td>
              <td valign="baseline"><table>
                <tr>
                  <td><input type="radio" name="sexe" value="Homme" >
                    Homme</td>
                </tr>
                <tr>
                  <td><input type="radio" name="sexe" value="Femme" >
                    Femme</td>
                </tr>
              </table></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="submit" value="Ajouter" class="btn btn-primary"></td>
            </tr>
          </table>
          <input type="hidden" name="grade" value="user">
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
        <th>Nom</th>
        <th>Date naissance</th>
        <th>tel</th>
        <th>Adresse</th>
        <th>sexe</th>
        <th>E-mail</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
      <?php do { ?>
        <tr>
          <td><?php echo $row_Recordset1['nom']; ?></td>
          <td class="center"><?php echo $row_Recordset1['date_naissance']; ?></td>
          <td class="center"><?php echo $row_Recordset1['tel']; ?></td>
          <td class="center"><?php echo $row_Recordset1['adresse']; ?></td>
          <td class="center"><?php echo $row_Recordset1['sexe']; ?></td>
          <td class="center"><?php echo $row_Recordset1['email']; ?></td>
          <td class="center"><a class="btn btn-danger" href="supu.php?id=<?php echo $row_Recordset1['idu']; ?>">
            <i class="glyphicon glyphicon-trash icon-white"></i>
            Supprimer
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
?>
