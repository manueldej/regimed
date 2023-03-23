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
include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
require_once("data_valid_fns.php");
include('connections/miConex.php');

	if(isset($_POST['insertar'])){
		$t2= strtoupper ($_POST["t2"]);
		$sel = "select * from tipos_medios where nombre = '".htmlentities($t2)."'";
		$qsel = mysqli_query($miConex, $sel) or die (mysql_error());
		$nsel = mysqli_num_rows($qsel);
		
		if(($nsel) ==0){
			$sql = "insert into tipos_medios (id, nombre) values (NULL, '".strtoupper($t2)."')";
			$result = mysqli_query($miConex, $sql) or die(mysql_error());
			
			$campo= strtolower ($_POST['t2']);
			$sql ="ALTER TABLE `areas` ADD `".strtolower($campo)."` INT( 11 ) NULL default 0 AFTER `fotocopiadora`";
			$result = mysqli_query($miConex, $sql) or die(mysql_error());
			?><script type="text/javascript">document.location="categ_medios.php";</script><?php
		}else{
			?><script type="text/javascript">document.location="categ_medios.php?er";</script><?php
		}
	}
	if(isset($_POST['modificar'])){
		$marca = $_POST['marca'];
		$nombrecat = $_POST['nombre'];
		$nombrecatv = $_POST['viejo'];
		$cc=0; 
		foreach($marca as $rest){
			$sql1 = "update tipos_medios set nombre='".strtoupper($nombrecat [$cc])."' where id='".$rest."'";
			$result1 = mysqli_query($miConex, $sql1) or die(mysql_error());
			
			$sqlx ="ALTER TABLE `areas` CHANGE `".strtolower($nombrecatv [$cc])."` `".strtolower($nombrecat [$cc])."` INT( 11 ) NULL default 0 AFTER `fotocopiadora`";
			$resultx = mysqli_query($miConex, $sqlx) or die(mysql_error());	
			$cc++;
		} ?>
		<script type="text/javascript">document.location="categ_medios.php";</script><?php
	}?>
