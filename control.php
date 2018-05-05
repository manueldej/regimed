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
<head>
		<title>Control</title>
		  <link rel="stylesheet" href="css/pace-theme-center-circle.css" />

		  <script>
		    paceOptions = {
		      elements: true
		    };
		  </script>
		  <script src="js/pace.js"></script>
		  <script>
		    function load(){
		      var x = new XMLHttpRequest()
		      //x.open('GET', "http://localhost/webmail/", true);
		     // x.send();
		    };

		    load();
		    setTimeout(function(){
		      Pace.ignore(function(){
			load();
		      });
		    }, 4000);

		    Pace.on('hide', function(){
		      console.log('done');
		    });

		  </script>
		</head>
<body></body>

<?php

	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php	
		return;	
	}
include ("data_valid_fns.php");
@session_start();
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

	$ip = getenv("HTTP_X_FORWARDED_FOR");//getenv('REMOTE_ADDR');
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
				$ses = "insert into conectado (id,conectado,fecha,sexo,idunidades) values(NULL,'".$_SESSION ["valid_user"]."','".$fecha."','".$rws['sexo']."','1')";
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
	}elseif (($usuario) =="invitado" AND ($usuarioz) =="invitado" AND ($contrasena) ==""){//	@session_destroy();
		$_SESSION ["valid_user"]="invitado";
		$sqlconn = "INSERT INTO conectado values(NULL,'invitado','".$fecha."','h','1')";
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

