<?php
require_once('connections/miConex.php');
$campo=$_REQUEST['campo'];
$id=$_REQUEST['id'];
$valor=$_REQUEST['valor'];

$querq="UPDATE componentes SET ".$campo."='".$valor."' WHERE id='".$id."'";
mysqli_query($miConex, $querq) or die(mysql_error());

?>