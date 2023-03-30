<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                     				                        #
# Fecha:    01/06/2016 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada (IN MEMORIAM)							         		            #
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
define( '_VALID_MOS', 1 );

if (file_exists( '../connections/miConex.php' ) && filesize( '../connections/miConex.php' ) > 10) {
	header( "Location: ../index.php" );
	exit();
}

require_once( '../includes/version.php' );
/** Include common.php */
include_once( 'common.php' );
view();
function view() {	
	$sp = ini_get('session.save_path');
	$_VERSION = new seguVersion();				 	
	$versioninfo = $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '. $_VERSION->DEV_STATUS;
	$version = $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '. $_VERSION->DEV_STATUS.' [ '.$_VERSION->CODENAME .' ] '. $_VERSION->RELDATE;
	echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
	?>
	<html>
	<head>
	<title>Registro de Medios - Instalador Web</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" href="../images/logo1.png" />
	<link rel="stylesheet" href="install.css" type="text/css" />
	<style type="text/css">
		.Estilo1 {color: #83A810;
			font-size: 8px;
		}
    </style>
<script language="JavaScript" >
function mandacookie(valc,un){
	if((valc) !="-1"){
		if((valc) =="invitado"){
			document.getElementById('contrasena').style.display="none";
		}
		document.cookie="username="+valc;
		document.cookie="manuni="+un;
		document.location="index.php";
	}
}
function guarda(i){
	document.cookie="seulang="+i;
	document.cookie="lgmi=0";
	document.location='index.php';
}
</script>
<?php 
$seulang ="es";
if(isset($_COOKIE['seulang'])){
  if(($_COOKIE['seulang']) =="es"){@$seulang="es"; }else{@$seulang="en";}
}
if(($seulang) =="es"){include('../esp.php');} else { include('../eng.php');}
?>
</head>
<body>
	<div id="wrapper" >
	<div id="header">
		<div id="el sitio" align="center">
			<div align="center" <?php if (($seulang) =="es") { ?> class="Headeresp-jpeg" <?php }else {?>class="Headereng-jpeg" <?php }?>></div>
		</div>
	</div>
	<div id="ctr" align="center" >
		<div class="install">
			<div id="stepbar">
				<div class="step-on"><?php echo $preinstall; ?></div>
                <div class="step-off"><?php echo $licence; ?></div>
                <div class="step-off"><?php echo $paso; ?> 1</div>
                <div class="step-off"><?php echo $paso; ?> 2</div>
          </div>
			<div id="right">
				<div class="Estilo1" id="step"><?php echo $btversion;?></div>
				<div class="clr"></div>				
				<h1 style="text-align: center; border-bottom: 0px; margin-top:-17px;"><?php echo $version; ?></h1>
	   		    <h1><?php echo $preinstall; ?></h1><div align="right"><img <?php if((@$seulang) =="es"){ echo 'style="opacity: .5;"'; } ?> src="../images/es.png" width="20" height="14" border="0" title="<?php echo $btidiomes;?>" align="absmiddle" onMouseOver="this.style.cursor='pointer';" onClick="guarda('es');" />&nbsp;&nbsp;<img title="<?php echo $btidiomen;?>" <?php if((@$seulang) =="en"){ echo 'style="opacity: .5;"';} ?> src="../images/en.png" width="20" height="14" border="0" align="absmiddle" onMouseOver="this.style.cursor='pointer';" onClick="guarda('en');" /></div><br>
				
			<div class="install-text">
				<p><?php echo $texto1; ?></p>
				<div class="ctr"></div>
			</div>
	
				<div class="install-form">
					<div class="form-block">
						<table class="content">
						<tr>
							<td class="item">PHP version >= 4.1.0</td>
							<td align="left"><?php echo phpversion() < '4.1' ? '<b><font color="red">No</font></b>' : '<b><font color="green">Si</font></b>';?><?php echo "&nbsp;&nbsp;&nbsp;(versi&oacute;n detectada: ".phpversion(); ?>)</td>
						</tr>
						<tr>
							<td>&nbsp; - Soporte compresi&oacute;n zlib</td>
							<td align="left"><?php echo extension_loaded('zlib') ? '<b><font color="green">Disponible</font></b>' : '<b><font color="red">No disponible</font></b>';?></td>
						</tr>
						<tr>
							<td>&nbsp; - Soporte XML</td>
							<td align="left"><?php echo extension_loaded('xml') ? '<b><font color="green">Disponible</font></b>' : '<b><font color="red">No disponible</font></b>';?></td>
						</tr>
						<tr>
							<td>&nbsp; - Soporte MySQL</td>
							<td align="left"><?php echo function_exists( 'mysqli_connect' ) ? '<b><font color="green">Disponible</font></b>' : '<b><font color="red">No disponible</font></b>';?></td>
						</tr>
						<tr>
							<td valign="top" class="item">Carpeta	de	Configuraci&oacute;n</td>
							<td align="left">
								<?php
								if (is_writable( '../connections/' )) {
									echo '<b><font color="green">Puede ser escrito</font></b>';
								} else {
									echo '<b><font color="red">No puede ser escrito</font></b><br /><span class="small">Todav�a podr�s continuar con la instalaci&oacute;n ya que la configuraci&oacute;n te ser� mostrada al final, copiala, p�gala y s�bela.</span>';
								} 
								?>	
							</td>
						</tr>
						<tr>
							<td class="item">Ruta de guardado de sesiones</td>
							<td align="left" valign="top">
								<?php echo is_writable( $sp ) ? '<b><font color="green">Se puede escribir</font></b>' : '<b><font color="red">No puede ser escrito</font></b>';?>							</td>
						</tr>
						</table>
					</div>
				</div>
				<div class="clr"></div>
					
					<?php
				$wrongSettingsTexts = array();
				
				if ( ini_get('magic_quotes_gpc') != '1' ) {
					$wrongSettingsTexts[] = 'La configuraci&oacute;n del PHP magic_quotes_gpc esta `APAGADO` en vez de `ACTIVADO`';
				}
				if ( ini_get('register_globals') == '1' ) {
					$wrongSettingsTexts[] = 'La configuraci&oacute;n del PHP registros_globales (register_globals) esta `ACTIVADO` en vez de `APAGADO`';
				}
			?>
												
				<h1>
					Ajustes recomendados:				</h1>
				
				<div class="install-text">
					<?php echo $texto2; ?>
					<div class="ctr"></div>
				</div>
		
				<div class="install-form">
					<div class="form-block">
		
						<table class="content">
						<tr>
							<td class="toggle" width="500">
								Directiva	</td>
	<td class="toggle">
	Recomendado	</td>
	<td class="toggle">
	Actual	</td>
</tr>
<?php
$php_recommended_settings = array(array ('Modo seguro','safe_mode','APAGADO'),
array ('Mostrar errores','display_errors','ACTIVADO'),
array ('Subir archivos','file_uploads','ACTIVADO'),
array ('Comillas m&aacute;gicas GPC','magic_quotes_gpc','ACTIVADO'),
array ('Ejecuci&oacute;n de Comillas M.','magic_quotes_runtime','APAGADO'),
array ('Memoria de salida','output_buffering','APAGADO'),
array ('Inicio autom&aacute;tico de sesi&oacute;n','session.auto_start','APAGADO'),
);
    foreach ($php_recommended_settings as $phprec) { ?>
		<tr>
			<td class="item"><?php echo $phprec[0]; ?>:</td>
			<td class="toggle"><?php echo $phprec[2]; ?>:</td>
			<td><b><?php	if ( get_php_setting($phprec[1]) == $phprec[2] ) {?> <font color="green"><?php	} else {?><font color="red"><?php } 
				echo get_php_setting($phprec[1]);?></font></b>
			</td>
		</tr><?php } ?>
		
	</table>
		</div><br/>
		<div class="far-right">
			<input name="Button2" type="submit" class="btn" value="<?php echo $sigui; ?> &gt;&gt;" onClick="window.location='install.php';" style="cursor:pointer;" />
			<br/><br/>
			<input type="button" class="btn" value="<?php echo $comprob; ?>" onClick="window.location=window.location" style="cursor:pointer;" />
		</div>
	</div>
		<div class="clr"></div>
			</div>
			<div class="clr"></div>
			
		</div>
	</div>
	
	<div class="ctr">
		<span class="piepagina"><?php echo $footer; ?></span>
		<br>
	</div>
	</body>
	</html>
	<?php
}

function get_php_setting($val) {
	$r =  (ini_get($val) == '1' ? 1 : 0);
	return $r ? 'ACTIVADO' : 'APAGADO';
}

function writableCell( $folder, $relative=1, $text='' ) {
	$writeable 		= '<b><font color="green">Se puede escribir</font></b>';
	$unwriteable 	= '<b><font color="red">No puede ser escrito</font></b>';
	echo '<tr>';
	echo '<td class="item">' . $folder . '/</td>';
	echo '<td align="right">';
	if ( $relative ) {
		echo is_writable( "../$folder" ) 	? $writeable : $unwriteable;
	} else {
		echo is_writable( "$folder" ) 		? $writeable : $unwriteable;
	}
	echo '</tr>';
}
?>
