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
include ('connections/miConex.php');
			// no cargar de la cache del navegador.
			header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
			header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
			header( "Cache-Control: no-cache, must-revalidate" ); 
			header( "Pragma: no-cache" );

	$query1 = "SELECT * FROM conectado ORDER BY id DESC";
	$lista1 = mysqli_query($query1,$miConex) or die(mysql_error());
	$nnum1 = mysqli_num_rows($lista1);	
	$row1 = mysqli_fetch_array($lista1); 

	$query11 = "SELECT * FROM conectadotmp WHERE conectado ='".$row1["conectado"]."' ORDER BY id DESC";
	$lista11 = mysqli_query($query11,$miConex) or die(mysql_error());
	$nnum11 = mysqli_num_rows($lista11);	
	$row11 = mysqli_fetch_array($lista11); 
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){ $i="es"; }else{ $i="en"; }
	}
	if(($i) =="es"){ include('esp.php'); }else{ include('eng.php');} ?>
	<link href="css/template.css" rel="stylesheet" type="text/css" /><?php
	if(($_SESSION["ctado"]) != $nnum1){
		$_SESSION["ctado"] = $nnum1; ?>
		<div class="contdo"><?php echo ucfirst($row1["conectado"]).$seconcto;?></div><?php	
	}
?>