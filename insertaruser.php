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
?>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:171px;
	top:233px;
	width:375px;
	height:61px;
	z-index:1;
}
-->
</style>

<div id="buscad"> <?php
  require_once("data_valid_fns.php");
if(isset($_POST['nombreqty'])){ $nombreqty=$_POST['nombreqty']; }
if(isset($_POST['cargoqty'])){ $cargoqty =$_POST['cargoqty'];}
if(isset($_POST['loginqty'])){ $loginqty = $_POST['loginqty'];}
if(isset($_POST['passwdqty'])){ $passwdqty = $_POST['passwdqty'];}
if(isset($_POST['emailqty'])){ $emailqty = $_POST['emailqty'];}
if(isset($_POST['idarea'])){ $idarea = $_POST['idarea'];}
if(isset($_POST['sexo'])){ $sexo = $_POST['sexo'];}
if(isset($_POST['unidades'])){ $unidadess = $_POST['unidades'];}
$salida="";
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$btruta= $_SERVER['SERVER_NAME'].$pht1;
//Por DNS
$salida .= 'http://' . $btruta;
//por IP
//$salida .= 'http://' .getenv('REMOTE_ADDR').$pht1;

require_once('connections/miConex.php');
$query_Recordset1 = "SELECT * FROM datos_generales";
$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysqli_fetch_array($Recordset1);
$m_Priority = 3; // 1 Urgente, 3 Normal
$m_r_Greeting = "Estimado(a): ";
$m_Thanks = "Con toda consideracion, ";
$mailserVer = $row_Recordset1['smtp'];//"172.26.11.1
$m_From_Adress =$row_Recordset1['mail'];
$m_Signature = $row_Recordset1['entidad']."\nURL: http://".$row_Recordset1['web'];
  
		$selU = "select login from usuarios where login='".$loginqty."'";
		$qselU = mysqli_query($miConex, $selU) or die(mysql_error());
		$rselU = mysqli_num_rows($qselU);
		if(($rselU) ==0){
			$rselar = "select * from areas where nombre='".$idarea."' AND idunidades='".$unidadess."'";
			$seleare = mysqli_query($miConex, $rselar) or die(mysql_error());
			$qseleare = mysqli_fetch_array($seleare);
			
			$query = "insert into usuarios (id,id_area,nombre,login,passwd,email,cargo,tipo,idarea,sexo,idunidades) values (NULL,'".$qseleare['idarea']."','".htmlentities($nombreqty)."', '".htmlentities($loginqty)."','".base64_encode($passwdqty)."','".$emailqty."', '".htmlentities($cargoqty)."', 'usuario', '".$qseleare['nombre']."', '".htmlentities($sexo)."', '".$unidadess."')";
			$result = mysqli_query($miConex, $query) or die(mysql_error());
			if ($result)     {
/*
				$cuerpo = $m_r_Greeting.$nombreqty."\n\nEste correo es para informarle que Usted ha sido agregado como Usuario de este Sitio Web: ".$salida." con los siguientes datos:\n\nNombre y Apellidos: ".$nombreqty."\nUsuario: ".$loginqty."\nClave: ".$passwdqty."\nCargo: ".$cargoqty."\nE-Mail: ".$emailqty."\n\n\n".$m_Thanks."\n\n".$m_Signature;
				$a = str_replace('&aacute;', 'á', $cuerpo);
				$e = str_replace('&eacute;', 'é', $a);
				$i = str_replace('&iacute;', 'í', $e);
				$o = str_replace('&oacute;', 'ó', $i);
				$u = str_replace('&uacute;', 'ú', $o);
				$n = str_replace('&ntilde;', 'ñ', $u);
				$A = str_replace('&Aacute;', 'Á', $n);
				$E = str_replace('&Eacute;', 'É', $A);
				$I = str_replace('&Iacute;', 'Í', $E);
				$O = str_replace('&Oacute;', 'Ó', $I);
				$U = str_replace('&Uacute;', 'Ú', $O);
				$finall = str_replace('&Ntilde;', 'Ñ', $U);
				$destino = array($emailqty) ;
				$asunto = $btregisusuario ;
				$encabezados = 'From: Equipo Desarrollador <'.$m_From_Adress.'>' ;
				$cuta=0;
				for($r=0; $r<count($destino);$r++){
					if(@mail($destino[$r], $asunto, $finall, $encabezados)){
						$cuta++;
					}
				}		
				if(($cuta) ==0)	{			
					  echo '<br><div align="center"><div class="message" align="center">'.$n_mail.'</div></div>';	  
				}else{
					echo '<br><div align="center"><div class="message" align="center">'.$sol_registr1.'</div></div>';
				} 
				*/?>
				<script type="text/javascript">
					setTimeout(window.parent.location='ej1.php', 15000);
				</script><?php	
			}
		}else{
			echo sprintf($scri_imp5,$loginqty); 
		}
 ?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>
