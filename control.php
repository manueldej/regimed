<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los términos de la Licencia Pública General GNU publicada por la Fundación de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versión 2 de la Licencia, o (en su opción)   #
# cualquier posterior versión. REGIMED es distribuido con la esperanza de que será útil, pero SIN CUALQUIER #
# GARANTÍA; Sin aún la garantía implícita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROPÓSITO PARTICULAR.  #
# Vea la Licencia Pública General del GNU para más detalles. Usted debería haber recibido una copia de la   #
# Licencia  Pública General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
if (!file_exists('connections/miConex.php')){ ?>
	<script type="text/javascript">window.parent.location="installation/index.php";</script><?php	
	return;	
}
include ("data_valid_fns.php");
@session_start();
date_default_timezone_set('America/Havana');
setlocale(LC_TIME, "es_CU");
$fecha = date("Y-m-d");
require_once('connections/miConex.php');
$roo = $_SERVER['DOCUMENT_ROOT'];
$posicion = strripos($roo, "/");
$ruta = substr($roo, 0, $posicion)."/tmp/"; 

if(!isset($_SESSION ["valid_user"])){
 $upcoses = mysqli_query($miConex, "delete from conectado where fecha < '".$fecha."'") or die(mysql_error());	
}
?><script type="text/javascript">document.cookie="username=<?php echo $_POST['usuario'];?>;";</script><?php

	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php
		return;
	}

	$ip = getenv("HTTP_X_FORWARDED_FOR"); //getenv('REMOTE_ADDR');
	if(($ip) ==""){ $ip = getenv('REMOTE_ADDR'); }
	$hora = date("h:i:s a");
	$contrasena ="";
	$idunids ="1";
	$lang ="es";

	if(($_POST["usuarioz"])){ $usuarioz = $_POST["usuarioz"]; }
	if(($_POST["usuario"])){ $usuario = $_POST["usuario"]; }
	if(($_POST["contrasena"])){ $contrasena = $_POST["contrasena"]; }
	if(($_POST["lang"])){ $lang = $_POST["lang"]; }

	if (($usuario) !="" AND ($contrasena) !="" AND ($usuario) !="invitado" AND ($usuarioz) =="invitado"){
		$query = "select * from usuarios  where login='".$usuario."' AND passwd = '" . base64_encode($contrasena) . "'";
		$result = mysqli_query($miConex, $query) or die(mysql_error());
		$rws = mysqli_fetch_array($result);

		if (mysqli_num_rows($result) >0 )  {
			$consultases ="SELECT * FROM conectado where conectado = '".$usuario."'";
			//usuario y passorw validos
			$resultadoses = mysqli_query($miConex, $consultases) or die(mysql_error());
			$filases = mysqli_num_rows($resultadoses);
			
			$consultases1 ="SELECT * FROM conectado";
			$resultadoses1 = mysqli_query($miConex, $consultases1) or die(mysql_error());
			$filases1 = mysqli_num_rows($resultadoses1);
			if(($filases) ==0){
				@session_start();
				//defino una sesion y guardo datos
				$_SESSION["valid_user"]= $_REQUEST["usuario"];

				$fp = fopen("visitas.txt", "a+");
				if (!$fp){ exit; }
				fwrite($fp, $ip.", ".$hora.", ".$fecha.", ".$_SESSION ["valid_user"]."\n");
				flock($fp, 3);
				fclose($fp);
				?><script type="text/javascript">document.cookie="username=<?php echo $_POST['usuario'];?>";</script><?php
			    //session
				$ses = "insert into conectado (id,conectado,fecha,hora,sexo,idunidades) values(NULL,'".$_SESSION ["valid_user"]."','".$fecha."','".$hora."','".$rws['sexo']."','1')";
				$qinses = mysqli_query($miConex, $ses) or die(mysql_error());

				//visita
				$in = "insert into visitas (ip, hora, fecha,user) values('".$ip."','".$hora."','".$fecha."','".$_SESSION ["valid_user"]."')";
				$qin = mysqli_query($miConex, $in) or die(mysql_error()); ?>
				<script type="text/javascript" src="ajax.js"></script>
				<script type="text/javascript">
					Nuevos();
					document.location="expedientes.php";
				</script><?php
			}else{ ?>
				<script type="text/javascript">
					document.location="index.php?u=<?php echo $usuario;?>";
				</script><?php
				exit;
			}
		}else{ ?>
				<script type="text/javascript">
					document.location="index.php?e=s";
				</script><?php
		}
		//usuario=admin&usuarioz=invitado&contrasena=s&lang=es&submit=Aceptar
	}elseif (($usuario) =="invitado" AND ($usuarioz) =="invitado" AND ($contrasena) ==""){   //	@session_destroy();
		$_SESSION ["valid_user"]="invitado";
		$sqlconn = "INSERT INTO conectado values(NULL,'invitado','".$fecha."','".$hora."','h','1')";
		$rsconn = mysqli_query($miConex, $sqlconn) or die(mysql_error());
		$in = "insert into visitas (ip, hora, fecha,user) values('".$ip."','".$hora."','".$fecha."','invitado')";
		$qin = mysqli_query($miConex, $in) or die(mysql_error());
			
		$fp = fopen("visitas.txt", "a+");
		if (!$fp){ exit; }
		fwrite($fp, $ip.", ".$hora.", ".$fecha.", invitado\n");
		flock($fp, 3);
		fclose($fp);?>
				<script type="text/javascript">
					document.location="expedientes.php";
				</script><?php			
	}elseif(($usuario) =="invitado" AND ($usuarioz) =="invitado") {
	//	@session_destroy();
		$_SESSION ["valid_user"]="invitado";
		$sqlconn = "INSERT INTO conectado values(NULL,'invitado','".$fecha."','h','1')";
		$rsconn = mysqli_query($miConex,$sqlconn) or die(mysql_error());
		$in = "insert into visitas (ip, hora, fecha,user) values('".$ip."','".$hora."','".$fecha."','invitado')";
		$qin = mysqli_query($miConex, $in) or die(mysql_error());
			
		$fp = fopen("visitas.txt", "a+");
		if (!$fp){ exit; }
		fwrite($fp, $ip.", ".$hora.", ".$fecha.", invitado\n");
		flock($fp, 3);
		fclose($fp);?>
				<script type="text/javascript">
					document.location="expedientes.php";
				</script><?php
   }else{ ?>
		<script type="text/javascript">
			document.location="index.php?e=s";
		</script><?php 
   }
   			
?>

