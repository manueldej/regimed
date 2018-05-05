<?php
require_once('connections/miConex.php');
$exp=$_REQUEST['exp'];
$tipo=$_REQUEST['tipo'];
$compon=$_REQUEST['compon'];
$nuevo=$_REQUEST['nuevo'];
$fecha=date('Y-m-d');
$n_pc=$_REQUEST['n_pc'];
$idunidades=$_REQUEST['iduni'];

if (($exp!="") AND ($tipo!=$nuevo) ) {
 $querq="INSERT INTO `upgrade` (id,exp,componente,tipo,remplazado_por,fecha,n_pc, idunidades) VALUES (NULL, '".$exp."','".$compon."','".$tipo."','".$nuevo."','".$fecha."','".$n_pc."','".$idunidades."')";
 mysqli_query($miConex, $querq) or die(mysql_error());
 
  if ($compon=="Microprocesador"){
	  $compon ="CPU";
  }elseif ($compon =="Motherboard"){
	  $compon ="PLACA";
  }elseif ($compon =="Disco Duro"){
	  $compon ="DRIVE1";
  }elseif ($compon =="Memorias"){
	  $compon ="MEMORIA";
  }
  $querq1="UPDATE exp SET ".$compon."='".$nuevo."' where inv='".$exp."'";
  mysqli_query($miConex, $querq1) or die(mysql_error());
 
}else{
  exit;
}


?>

