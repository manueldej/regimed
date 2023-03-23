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
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}

require_once('connections/miConex.php');
 $os ="";
 $option_block ="";
 $usuario ="";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $bttitulo;?></title>
<script type="text/javascript" src="js/script.js"></script>
<link href="css/template.css" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE="JavaScript">
	function cierrz(){
		document.getElementById('cir').innerHTML="";
	}
  </SCRIPT>
<?php
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
	$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
	$btruta= $_SERVER['SERVER_NAME'].str_ireplace('meiler/','',$pht1);
?>
<style type="text/css">
<!--
div.message {
	font-family : "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size : 14px;
	color : #c30;
	text-align: center;
	width: auto;
	background-color: #f9f9f9;
	border: solid 1px #d5d5d5;
	margin: 3px 0px 10px;
	padding: 3px 20px;
}
-->
</style>
</head>
<body>
<div class="message">
<?php 
require_once('connections/miConex.php');
$query_Recordset1 = "SELECT * FROM datos_generales";
$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysqli_fetch_array($Recordset1);
$m_Priority = 3; // 1 Urgente, 3 Normal
$m_r_Greeting = "Estimado(a): ";
$m_Thanks = "Con toda consideracion, ";
$mailserver = $row_Recordset1['smtp'];//"192.168.1.2";172.26.11.1
$m_From_Adress =$row_Recordset1['mail'];
$m_Signature = 'Equipo Desarrollador';

	$nomb = htmlentities(trim ($_POST["nomb"]));
	$email = trim ($_POST["email"]);
			  
	if (!$nomb || !$email)  {
		echo "No has completado el formulario.  Por favor vuelve e int&eacute;ntalo de nuevo.";
		echo "<font color=blue>";
		echo "<a href=\"Recupeclave.php\">Atr&aacute;s...</a><br>";
		exit;
	}
	$nomb = addslashes($nomb);
	$email = addslashes($email);
	if (!$miConex)  {
		echo "Error: No se ha podido conectar a la base de datos.  Por favor, prueba de nuevo m&aacute;s tarde.";
		exit;
    }
    $consulta = "select * from usuarios where (nombre like '%".$nomb."%' AND email = '".$email."') OR (login = '".$nomb."' AND email = '".$email."')";  
	$resultado = mysqli_query($miConex, $consulta) or die(mysql_error());
	$num_resultados = mysqli_num_rows($resultado);
	$row= mysqli_fetch_array($resultado);
	$correo=$row["email"];	
	$nom_ap=$row["nombre"];
	$clave=base64_decode($row["passwd"]);
	$cargo=$row["cargo"];
	$login=$row["login"];
	if (! $num_resultados)  {
		echo "<p>".$apodo."<font color=blue> ".$nomb."</font>".$mess1."<font color=blue>".$email."</font> ".$mess2."</p>";
		echo "<a href=\"recupeclave.php\">".$mess3."</a><br>";
	} else {
    //Enviando correo de confirmacion.... 				
		$cuerpo = $m_r_Greeting.$nom_ap."\n\nEste correo es para informarle sus datos personales registrados en este Sitio Web.\n\nNombre y Apellidos: ".$nom_ap."\nUsuario: ".$login."\nClave: ".$clave."\nE-Mail: ".$correo."\nCargo: ".$cargo."\n\nPara acceder al Sitio Web, por favor de click en este enlace: http://".$btruta." \n\n\n".$m_Thanks."\n\n".$m_Signature;
		$a = str_replace('&aacute;', '', $cuerpo);
		$e = str_replace('&eacute;', '', $a);
		$i = str_replace('&iacute;', '', $e);
		$o = str_replace('&oacute;', '', $i);
		$u = str_replace('&uacute;', '', $o);
		$n = str_replace('&ntilde;', '', $u);
		$A = str_replace('&Aacute;', '', $n);
		$E = str_replace('&Eacute;', '', $A);
		$I = str_replace('&Iacute;', '', $E);
		$O = str_replace('&Oacute;', '', $I);
		$U = str_replace('&Uacute;', '', $O);
		$finall = str_replace('&Ntilde;', '', $U);
		$destino = array($correo) ;
		$asunto = $sol_registr3 ;
		$encabezados = 'From: Equipo Desarrollador <'.$m_From_Adress.'>' ;
			$cuta=0;
			for($r=0; $r<count($destino);$r++){
				if(@mail($destino[$r], $asunto, $finall, $encabezados)){
					$cuta++;
				}
			}		
		if(($cuta) ==0)	{			
			echo "<p>".$mess4."<br>";
			echo "<a href=\"recupeclave.php\">".$mess3."</a><br>";
		}else{
			echo "<p>".$mess5."<font color=blue>".$correo."</p>";
		}
	}
 ?>
</div>
</body>
</html>
 