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
?>
<?php
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
require_once("data_valid_fns.php");
require_once('connections/miConex.php');
 
if(isset($_POST["editar"])){
	$kj=0;
	foreach($_POST["marcado"] as $KEY){
		$sql = "UPDATE exp SET CPU='".htmlentities($_POST['cpu'][$kj])."',PLACA='".$_POST['placa'][$kj]."',CHIPSET='".$_POST['chiset'][$kj]."',MEMORIA='".$_POST['mem'][$kj]."',MEMORIA2='".$_POST['mem2'][$kj]."*".$_POST['mem3'][$kj]."*".$_POST['mem4'][$kj]."',GRAFICS='".$_POST['grafic'][$kj]."',DRIVE1='".$_POST['drive1'][$kj]."',DRIVE2='".$_POST['drive2'][$kj]."',DRIVE3='".$_POST['drive3'][$kj]."',DRIVE4='".$_POST['drive4'][$kj]."',SONIDO='".$_POST['sonido'][$kj]."',RED='".$_POST['red0'][$kj]."',RED2='".$_POST['red1'][$kj]."*".$_POST['red2'][$kj]."',OS='".$_POST['so'][$kj]."',custodio='".htmlentities($_POST['custodio'][$kj])."',FUENTE='".htmlentities($_POST['fuente'][$kj])."',n_PC='".$_POST['npc'][$kj]."'  WHERE id='".$KEY."' ";
		$result = mysqli_query($miConex, $sql) or die(mysql_error());
		$kj++;
	} ?>
	<script type="text/javascript">document.location="registromedios1.php?otras=&palabra=&m=m";</script><?php 
}
if(isset($_POST["insertar"])){
	$seleare = mysqli_query($miConex, "select * from areas where nombre='".htmlentities($_POST['id_area'])."'") or die(mysql_error());
	$qseleare = mysqli_fetch_array($seleare);

	$seleare1 = mysqli_query($miConex, "select * from aft where id_area='".$qseleare['idarea']."'") or die(mysql_error());
	$qseleare1 = mysqli_fetch_array($seleare1);

	$sqfk = "SET FOREIGN_KEY_CHECKS=0;";
	mysqli_query($miConex, $sqfk) or die(mysql_error());	
	
	$sql1 = "insert into exp (idarea,id_area,inv,CPU,PLACA,CHIPSET,MEMORIA,MEMORIA2,GRAFICS,DRIVE1,DRIVE2,DRIVE3,DRIVE4,SONIDO,RED,RED2,FUENTE,OS,custodio,n_PC, idunidades) values ('".htmlentities($_POST['id_area'])."', '".$qseleare1['id_area']."', '".$_POST['inv']."', '".htmlentities($_POST['cpu'])."', '".$_POST['placa']."', '".$_POST['chipset']."','".$_POST['mem']."','".$_POST['mem2']."*".$_POST['mem3']."*".$_POST['mem4']."','".$_POST['grafic']."','".$_POST['drive1']."','".$_POST['drive2']."','".$_POST['drive3']."','".$_POST['drive4']."','".$_POST['sonido']."','".$_POST['red0']."','".$_POST['red1']."*".$_POST['red2']."','".$_POST['fuente']."','".$_POST['so']."','".htmlentities($_POST['custodio'])."','".$_POST['npc']."', '".$_POST['idunidades']."')";
	$result = mysqli_query($miConex, $sql1) or die(mysql_error());

	$sqfk1 = "SET FOREIGN_KEY_CHECKS=1;";
	mysqli_query($miConex, $sqfk1) or die(mysql_error());	?>
	<script type="text/javascript">document.location="registromedios1.php";</script><?php 
}
?>