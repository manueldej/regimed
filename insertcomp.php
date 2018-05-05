<?php
require_once('connections/miConex.php');
	$exp=$_REQUEST['exp'];
	$nombre=$_REQUEST['nombre'];
	$marc=$_REQUEST['marc'];
	$model=$_REQUEST['model'];
	$nser=$_REQUEST['nser'];
	$fab=$_REQUEST['fab'];
	$capac=$_REQUEST['capac'];
	$tas=$_REQUEST['tas'];
	$frecuencia=$_REQUEST['frecuencia'];
	$cach=$_REQUEST['cach'];
	$rpm=$_REQUEST['rpm'];
	$intz=$_REQUEST['intz'];
	$tipo=$_REQUEST['tipo'];
	$cpuid=$_REQUEST['cpuid'];
	$cpucores=$_REQUEST['cpucores'];
	$cpulogicos=$_REQUEST['cpulogicos'];
	$socket=$_REQUEST['socket'];
	$compon=$_REQUEST['compon'];
if ($nombre!="") {
  $querq="INSERT INTO `componentes` (id,idexp,nombre,marca,modelo,no_serie,fabricante,capacidad,tasa,frecuencia,cache,rpm,interfaz,tipo,cpuid,cpucores,cpulogicos,socket) VALUES (NULL,'".$exp."','".$nombre."','".$marc."','".$model."','".$nser."','".$fab."','".$capac."','".$tas."','".$frecuencia."','".$cach."','".$rpm."','".$intz."','".$tipo."','".$cpuid."','".$cpucores."','".$cpulogicos."','".$socket."')";
  mysqli_query($miConex, $querq) or die(mysql_error());
}else{
  exit;
}


?>

