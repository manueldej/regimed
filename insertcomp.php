<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los términos de la Licencia Pública General GNU publicada por la Fundación de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versión 2 de la Licencia, o (en su opción)   #
# cualquier posterior versión. REGIMED es distribuido con la esperanza de que será útil, pero SIN CUALQUIER #
# GARANTÍA; Sin aún la garantía implícita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROPÓSITO PARTICULAR.  #
# Vea la Licencia Pública General del GNU para más detalles. Usted debería haber recibido una copia de la   #
# Licencia  Pública General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
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

