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
@session_start();
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php
		return;
	}
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	include ('connections/miConex.php');
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
	$uss="";
	$clav="";
	if(($_POST["clav"])){ $clav = $_POST["clav"]; }
	if(($_POST["uss"])){ $uss = $_POST["uss"]; }
	if(($_POST["coneta"])){ $coneta = $_POST["coneta"]; }
	if (($uss) !="" AND ($clav) !="" ){
		$query = "select * from usuarios  where login='".$uss."' AND passwd = '" . base64_encode($clav) . "' AND tipo='root'";
		$result = mysqli_query($miConex, $query) or die(mysql_error());
		if (mysqli_num_rows($result) >0 )  {
			$resultadoses = mysqli_query($miConex, "delete from conectado where id='".$coneta."'") or die(mysql_error());
		}
	}
	?>
	<script type="text/javascript">document.location='index.php';</script>