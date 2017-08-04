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
	
	$content_dir = 'avatar/'; // dossier où sera déplacé le fichier
        $tmp_file = $_FILES['url']['tmp_name'];
       
        // on vérifie maintenant l’extension
        $type_file = $_FILES['url']['type'];
       
        // on fait un test de sécurité
        $name_file = $_FILES['url']['name'];
       
        // on copie le fichier dans le dossier de destination
		
       if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
        {
                echo("Impossible de copier le fichier dans $content_dir");
        }
        echo "Le fichier a bien été uploadé";

       $avatar= 'avatar/'. $name_file;
	
  $insertSQL = sprintf("INSERT INTO lentille (titre,gauche,droite, prix, quantite, categorie, url, `description`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['titre'], "text"), GetSQLValueString($_POST['gauche'], "text"), GetSQLValueString($_POST['droite'], "text"),
                       GetSQLValueString($_POST['prix'], "double"),
                       GetSQLValueString($_POST['quantite'], "int"),
                       GetSQLValueString($_POST['categorie'], "text"),
                       GetSQLValueString($avatar, "text"),
                       GetSQLValueString($_POST['description'], "text"));

  mysql_select_db($database_c, $c);
  $Result1 = mysql_query($insertSQL, $c) or die(mysql_error());

  $insertGoTo = "lent.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_c, $c);
$query_Recordset1 = "SELECT * FROM lentille";
$Recordset1 = mysql_query($query_Recordset1, $c) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_c, $c);
$query_Recordset2 = "SELECT * FROM categorie";
$Recordset2 = mysql_query($query_Recordset2, $c) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<?php require('php-version/header.php'); ?>
<div class="row">
  <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i>Lentilles</h2>

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
<br />
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ajout</h4>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" name="form1" action="<?php echo $editFormAction; ?>">
          <table align="center">
            <tr valign="baseline">
              <td nowrap align="right">Titre:</td>
              <td><input type="text" class="form-control" required name="titre" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Prix:</td>
              <td><input type="number" min="1" class="form-control" required name="prix" value="" size="32"></td>
            </tr> <tr valign="baseline">
              <td nowrap align="right">correction droite:</td>
              <td><input type="text" class="form-control" required name="droite" value="" size="32"></td>
            </tr> <tr valign="baseline">
              <td nowrap align="right">correction gauche:</td>
              <td><input type="text" class="form-control" required name="gauche" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Quantite:</td>
              <td><input type="number" min="1" class="form-control" required name="quantite" value="" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Categorie:</td>
              <td><select name="categorie">
                <?php 
do {  
?>
                <option value="<?php echo $row_Recordset2['titre']?>" ><?php echo $row_Recordset2['titre']?></option>
                <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
?>
              </select></td>
            <tr>
            <tr valign="baseline">
              <td nowrap align="right">Photo:</td>
              <td><input type="file" class="form-control" required name="url" value="" size="150"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right" valign="top">Description:</td>
              <td><textarea name="description" cols="50" rows="5"></textarea></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="submit" value="Ajouter" onClick="alert('ajouter avec succés');" class="btn btn-primary"></td>
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
        <th>Titre</th>
        <th>Prix</th>
        <th>Quantité totale</th>
        <th>Catégorie</th>
        <th>Photo</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
      <?php do { ?>
      
        <tr <?php  if($row_Recordset1['quantite']<15)
		{ ?>  class="danger"  <?php } ?>>
          <td><?php echo $row_Recordset1['titre']; ?></td>
          <td class="center"><?php echo $row_Recordset1['prix']; ?></td>
          <td class="center"><?php echo $row_Recordset1['quantite']; ?></td>
          <td class="center"><?php echo $row_Recordset1['categorie']; ?></td>
          <td class="center">
         <center> <img src="<?php echo $row_Recordset1['url']; ?>" height="150" width="50%"></center></td>
          <td class="center"><?php echo $row_Recordset1['description']; ?></td>
          <td class="center">
           
            
            <a class="btn btn-danger" href="suplen.php?id=<?php echo $row_Recordset1['idl']; ?>">
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

mysql_free_result($Recordset2);
?>
