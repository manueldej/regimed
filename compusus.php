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

require_once('connections/miConex.php');
$i = "es";

	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){@$i="es"; }else{@$i="en";}
	}
	
	if((@$i) =="es"){include('esp.php');} else { include('eng.php');}
	
if (isset($_GET['ent']) && $_GET['ent']!==""){
  $h = $_GET['ent'];
   $result = mysqli_query($miConex, "select * from usuarios where login='".$h."'") or die(mysql_error());
	if(mysqli_num_rows($result) >0 ){
	 echo sprintf($scri_imp6,"<font color='red'><em>".$h.".</em></font>");
	}
	if (mysqli_num_rows($result) ==0 AND $h !="" ){
	  echo "<font color='red'><em>".$apodo2." aceptado.</em></font>";
    }
}else{
  $h = "";
  if ($h ==""){
	echo "<font color='red'><em>El ".$apodo2." no puede ser nulo o vacio, Por favor rectifique.</em></font>";
   }
}



?>
