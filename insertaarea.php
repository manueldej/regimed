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
		mysqli_query($miConex, $sql0) or die(mysqli_error($miConex));	

		$sql = "UPDATE areas SET nombre='".$_POST['t2']."', t_computadoras='".$_POST['t3']."', t_impresoras='".$_POST['t4']."' ,t_ploter='".$_POST['t5']."',t_escanner='".$_POST['t6']."',t_monitores='".$_POST['t7']."',t_fotocop='".$_POST['t8']."',t_camara='".$_POST['t9']."',t_flash='".$_POST['t10']."',t_switch='".$_POST['t11']."',t_modem='".$_POST['t12']."', idunidad='".$_POST['unidades']."' WHERE idarea='".$_SESSION['id']."'";
		$result = mysqli_query($miConex, $sql) or die(mysqli_error($miConex)); 
		$sql2 = "SET FOREIGN_KEY_CHECKS=1;";
		mysqli_query($miConex, $sql2) or die(mysqli_error($miConex));	
?>
		<script language="javascript">
			window.parent.location="registroareas.php";
		</script><?php
	}
	if(isset($_POST["insertar"])){
		$sqla = "SET FOREIGN_KEY_CHECKS=0;";
		mysqli_query($miConex, $sqla) or die(mysqli_error($miConex));	

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
				$result = mysqli_query($miConex, $sql) or die (mysqli_error($miConex));
		}	
		$sqld = "SET FOREIGN_KEY_CHECKS=1;";
		mysqli_query($miConex, $sqld) or die(mysqli_error($miConex));	?>
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