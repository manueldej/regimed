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
