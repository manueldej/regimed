<?php
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Informáticos)     					                                		           #
# Version:  3.0.1                                                     				                       #
# Fecha:    01/06/2016 - 03/04/2018                                             					                       #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################
$h = $_GET['ent'];
require_once('connections/miConex.php');
$i = "es";
 	 if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){@$i="es"; }else{@$i="en";}
	}
	if((@$i) =="es"){include('esp.php');} else { include('eng.php');}
	
$miCosunt = mysqli_query($miConex, "select * from datos_generales where codigo='".$h."'") or die(mysql_error());
if(mysqli_num_rows($miCosunt) >0){
	echo sprintf($scri_imp7,"<font color='red'><em>".$h.".</em></font>");
}else{
	echo "<font color='red'><em>".$btCodigo." aceptado.</em></font>";
}
?>
