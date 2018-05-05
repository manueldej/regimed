<?php 
require_once('connections/miConex.php');
if(isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
  $querq="DELETE FROM `componentes` WHERE `componentes`.id='".$id."'";
  mysqli_query($miConex, $querq) or die(mysql_error()); 
}
if(isset($_REQUEST['exp'])) {
 $exp = $_REQUEST['exp'];
 $querq="DELETE FROM `componentes` WHERE `componentes`.idexp='".$exp."'";
 mysqli_query($miConex, $querq) or die(mysql_error()); 
}
?>
