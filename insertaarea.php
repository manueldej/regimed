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
require_once('connections/miConex.php');
		include('chequeo.php');
			$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
include('script.php'); ?>
<div id="buscad"><?php
	if(isset($_POST["editar"])){
		$sql0 = "SET FOREIGN_KEY_CHECKS=0;";
		mysqli_query($miConex, $sql0) or die(mysql_error());	

		$sql = "UPDATE areas SET nombre='".$_POST['t2']."', t_computadoras='".$_POST['t3']."', t_impresoras='".$_POST['t4']."' ,t_ploter='".$_POST['t5']."',t_escanner='".$_POST['t6']."',t_monitores='".$_POST['t7']."',t_fotocop='".$_POST['t8']."',t_camara='".$_POST['t9']."',t_flash='".$_POST['t10']."',t_switch='".$_POST['t11']."',t_modem='".$_POST['t12']."', idunidad='".$_POST['unidades']."' WHERE idarea='".$_SESSION['id']."'";
		$result = mysqli_query($miConex, $sql) or die(mysql_error()); 
		$sql2 = "SET FOREIGN_KEY_CHECKS=1;";
		mysqli_query($miConex, $sql2) or die(mysql_error());	
?>
		<script language="javascript">
			window.parent.location="registroareas.php";
		</script><?php
	}
	if(isset($_POST["insertar"])){
		$sqla = "SET FOREIGN_KEY_CHECKS=0;";
		mysqli_query($miConex, $sqla) or die(mysql_error());	

		$valores = htmlentities($_POST['nombre']);
		$iddunid = $_POST['idunidades'];
		if((stristr($valores, 'inform&aacute;tica')) !="" OR (stristr($valores, 'informatica')) !=""){
			echo "<br>";
			show_message($strerror,$nometearea,"cancel","form-insertarareas.php"); ?>
			<br><div id="footer" class="degradado" align="center">
				<div class="container">
					<p class="credit"><?php include ("version.php");?></p>
				</div>
			</div>
			<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
			<script type="text/javascript" src="js/bootstrap.min.js"></script>
			
			<script type="text/javascript" src="js/main.js"></script><?php
			exit;		
		}else{ 
				$sql ="INSERT INTO areas (idarea,nombre,idunidades) VALUES (NULL,'".$valores."',".$iddunid.")";
				$result = mysqli_query($miConex, $sql) or die (mysql_error());
		}	
		$sqld = "SET FOREIGN_KEY_CHECKS=1;";
		mysqli_query($miConex, $sqld) or die(mysql_error());	?>
		<script language="javascript">
			window.parent.location="registroareas.php";
		</script><?php	
	}
?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>