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

