<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los t�rminos de la Licencia P�blica General GNU publicada por la Fundaci�n de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versi�n 2 de la Licencia, o (en su opci�n)   #
# cualquier posterior versi�n. REGIMED es distribuido con la esperanza de que ser� �til, pero SIN CUALQUIER #
# GARANT�A; Sin a�n la garant�a impl�cita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROP�SITO PARTICULAR.  #
# Vea la Licencia P�blica General del GNU para m�s detalles. Usted deber�a haber recibido una copia de la   #
# Licencia  P�blica General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
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