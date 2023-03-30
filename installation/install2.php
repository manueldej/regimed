<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    01/06/2016                                             					                        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada											         		            #
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
?>
<!DOCTYPE html>
<head>
<html lang="es"><?php
$versphpvieja = str_ireplace('.','',phpversion());
$versphpnueva = 540;
if($versphpvieja < $versphpnueva ){?>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php 
}else{ ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php 
}?>
<title>Registro de Medios - Wizard</title>
<link rel="shortcut icon" href="../images/logo1.png" />
<link rel="stylesheet" href="install.css" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {font-size: 14px}
.Estilo2 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<?php 
define( "_VALID_MOS", 1 );
require_once( 'common.php' );
require_once( '../includes/database.php' );
$DBhostname  = $_POST['DBhostname'];
$DBuserName  = $_POST['DBuserName'];
$DBpassword  = $_POST['DBpassword'];
$DBname      = $_POST['DBname'];
@$salva       = $_POST['salva'];
$NombreAdmin = $_POST['NombreAdmin'];
$LoginAdmin  = $_POST['LoginAdmin'];
$PassAdmin   = $_POST['PassAdmin'];
$CorreoAdmin = $_POST['CorreoAdmin'];
$sex = $_POST['sexo'];
$entidad = $_POST['entidad'];
$reup = $_POST['reup'];
$sector = $_POST['sector'];
$PROV = $_POST['provincia'];
$smtp = $_POST['smtp'];
@$web = $_POST['web'];

$miConex1 = mysqli_connect($DBhostname, $DBuserName, $DBpassword, $DBname) or die(mysqli_error());
mysqli_select_db($miConex1,$DBname);
$sql = "SET FOREIGN_KEY_CHECKS=0;";
mysqli_query($miConex1, $sql) or die(mysql_error());	

if (isset($_POST['reemplazar'])) {
	$sql="INSERT INTO `areas` (`idarea`,`nombre`,`teclado`,`switch`,`router`,`modem`,`computadoras`,`adaptadores`,`monitor`,`ploter`, `mouse`,`impresora`,`escanner`,`camara`,`memorias`, `ups`,`pinza`,`bocinas`,`fax`,`dataswitch`,`datashow`, `fotocopiadora`,`idunidades`) VALUES (2, 'Inform&aacute;tica','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1')";
	mysqli_query($miConex1, $sql) or die (mysql_error());			
	$sql1="INSERT INTO `usuarios` (`id`,`id_area`,  `nombre`, `login`, `passwd`, `email`, `cargo`, `tipo`, `idarea`, `sexo`, `idunidades`) VALUES (1,'2','".htmlentities($NombreAdmin)."', '".$LoginAdmin."', '".base64_encode($PassAdmin)."', '".$CorreoAdmin."', '".'Inform&aacute;tico'."', 'root', '".'Inform&aacute;tica'."','".$sex."','1')";
	mysqli_query($miConex1, $sql1) or die (mysql_error());			
}elseif (isset($_POST['actualiza'])) {
	$sql2="UPDATE `usuarios` SET idunidades='1'";
	mysqli_query($miConex1, $sql2) or die (mysql_error());
}

if(isset($_POST['conecta'])){
	$seleusu = mysqli_query($miConex1,"SELECT * from usuarios where idunidades='1' AND id_area='2' AND tipo ='root'") or die (mysql_error());
	$resusua = mysqli_fetch_array($seleusu);
	
	$sql1u="UPDATE usuarios  set nombre = '".htmlentities($NombreAdmin)."', login =  '".$LoginAdmin."', passwd ='".base64_encode($PassAdmin)."', email =  '".$CorreoAdmin."', cargo = 'Inform&aacute;tico', tipo = 'root', idarea = 'Inform&aacute;tica', sexo = '".$sex."'  WHERE idunidades = '1' AND id_area='2' AND login='".$resusua['login']."'";
	mysqli_query($miConex1, $sql1u) or die (mysql_error());

	$sql1aft="UPDATE aft  set custodio = '".htmlentities($NombreAdmin)."'  WHERE idunidades = '1' AND id_area='2' AND custodio='".$resusua['nombre']."'";
	mysqli_query($miConex1, $sql1aft) or die (mysql_error());
	$sql1bajas_aft="UPDATE bajas_aft  set custodio = '".htmlentities($NombreAdmin)."'  WHERE idunidades = '1' AND id_area='2' AND custodio='".$resusua['nombre']."'";
	mysqli_query($miConex1,$sql1bajas_aft) or die (mysql_error());
	$sql1bajas_exp="UPDATE bajas_exp  set custodio = '".htmlentities($NombreAdmin)."'  WHERE idunidades = '1' AND id_area='2' AND custodio='".$resusua['nombre']."'";
	mysqli_query($miConex1, $sql1bajas_exp) or die (mysql_error());
	$sql1exp="UPDATE exp  set custodio = '".htmlentities($NombreAdmin)."'  WHERE idunidades = '1' AND id_area='2' AND custodio='".$resusua['nombre']."'";
	mysqli_query($miConex1, $sql1exp) or die (mysql_error());
	$sql1plan_rep="UPDATE plan_rep  set custodio = '".htmlentities($NombreAdmin)."'  WHERE idunidades = '1' AND id_area='2' AND custodio='".$resusua['nombre']."'";
	mysqli_query($miConex1, $sql1plan_rep) or die (mysql_error());
	
	$sql1udg="UPDATE datos_generales  set provincia = '".$PROV."' WHERE id_datos = '1'";
	mysqli_query($miConex1, $sql1udg) or die (mysql_error());
}	

@session_start();
$_SESSION["valid_user"]= $LoginAdmin;

	$fecha = date("Y-m-d");
	$ip = getenv('REMOTE_ADDR');
	$hora = date("h:i:s a");
	$in = "insert into visitas values(NULL,'".$ip."','".$hora."','".$fecha."','".$_SESSION ["valid_user"]."')";
	$qin = mysqli_query($miConex1, $in) or die(mysqli_error());

	$sqlf = "SET FOREIGN_KEY_CHECKS=1;";
	mysqli_query($miConex1, $sqlf) or die(mysqli_error());
		
	$configArray['DBhostname']	= $DBhostname;
	$configArray['DBuserName']	= $DBuserName;
	$configArray['DBpassword']	= $DBpassword;
	$configArray['DBname']	 	= $DBname;
				
				
	$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
	$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
	$pht = str_replace("/installation/","", $pht1);

	$config = "<?php\n";
	$config .= "\$hostname_miConex = '{$configArray['DBhostname']}';\n";
	$config .= "\$username_miConex = '{$configArray['DBuserName']}';\n";
	$config .= "\$password_miConex = '{$configArray['DBpassword']}';\n";
	$config .= "\$database_miConex = '{$configArray['DBname']}';\n";
	$config .= "\$miConex = mysqli_connect(\$hostname_miConex, \$username_miConex, \$password_miConex, \$database_miConex) or die();\n";
	$config .= "mysqli_select_db(\$miConex, \$database_miConex);\n";
	$config .= "\$app_dir = '".$pht."/';\n";
	$config .= "\$app_img = '".$pht."/images/';\n";
	$config .= "?>";

if (file_exists( '../connections/miConex.php' )) {
	$canWrite = is_writable( '../connections/miConex.php' );
} else {
	$canWrite = is_writable( '..' );
}

	if ($canWrite && ($fp = fopen("../connections/miConex.php", "w"))) {
		fputs( $fp, $config, strlen( $config ) );
		fclose( $fp );
	}
// Cambiar los permisos a miConex.php
	$chmod_report = "";

		$mosrootfiles = array(
			'miConex.php'
		);

		$filePerms = '0777';
		$dirPerms  = '0777';
		$filemode = octdec($filePerms);
		$dirmode = octdec($dirPerms);
		$chmodOk = TRUE;
		foreach ($mosrootfiles as $file) {
			if (!mosChmodRecursive('../connections/'.$file, $filemode, $dirmode)) {
				$chmodOk = FALSE;
			}
		}
		if (!$chmodOk) {
			$chmod_report = 'Nota: Los permisos del directorio y de los archivos no han podido ser cambiados.<br />'.
							'Cambia los permisos de los archivos y directorios manualmente.';
		}
		$seulang = "es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){ $seulang="es"; }else{ $seulang="en";}
	}
	if(( $seulang) =="es"){include('../esp.php'); $imgn="headeresp.png"; } else { include('../eng.php'); $imgn="headereng.png"; }
?> 
<body>
  	<div id="wrapper">
		<div id="header">
			<div id="el sitio" align="center"><img src="../images/<?php echo $imgn;?>" /></div>
		</div>
	</div>
	<div id="ctr" align="center">
			<div class="install">
				<div id="stepbar">
					<div class="step-off"><?php echo $preinstall; ?></div>
					<div class="step-off"><?php echo $licence; ?></div>
					<div class="step-off"><?php echo $paso; ?> 1</div>
					<div class="step-on"><?php echo $paso; ?> 2</div>
				</div>
				<div align="right">
					<div id="step1"><?php echo $paso; ?> 2 </div>
					 <p>&nbsp;</p>
					 <p>&nbsp;</p>
					 <p>&nbsp;</p>
					<div class="form-block1">
						<h3 align="justify" class="Estilo1" id="wrapper">
					
						<?php if((@$conecta) =="n"){ echo $exte;?> <span class="Estilo2"><?php echo $DBname;?> </span><?php echo $seinstalo;?>.</h3>
						<p><h5 align="justify">&nbsp;&nbsp;<?php echo $Opci;?>:</h5>
						<?php } else{ ?>
						&nbsp;&nbsp;<?php echo $btconexcion;?> <span class="Estilo2"><?php echo $DBname;?> </span><?php echo $btestablecido;?>.</h3>
						<p><h5 align="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Opci;?>:</h5>
						<?php }?>
						<div align="justify" >&nbsp;&nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $btusuario;?>:<b><?php echo $LoginAdmin;?></b><br>
							  &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;<?php echo $btpassw;?>: <b><?php echo $PassAdmin;?></b> <br>
							  &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ServidorMySQL?>:<b> <?php echo $DBhostname;?></b><br>
							  &nbsp;  &nbsp;&nbsp;  &nbsp;<?php echo $UsuarioMySQL?>:<b> <?php echo $DBuserName;?></b><br>
							 Contrase&ntilde;a MySQL:<b> <?php if(($DBpassword) !=""){ echo $DBpassword;} else{ echo "-";}?></b></div>
					</div>
					 <p align="justify"><?php echo $chmod_report;?></p>
					<div class="izuierda">
							<input class="btn" type="button" name="next" value="<?php echo $btfinalizar;?>" onClick="javascript: document.location='../expedientes.php';"/>
					</div>
				</div>
					<div class="clr"></div>
			</div>
	</div>
	<div class="clr"></div>
	<div class="ctr">
		<span class="piepagina">Regimed! es un software libre bajo licencia GNU/GPL.</span>
		<br>
	</div>
</body>
</html>
