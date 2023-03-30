<!DOCTYPE html>
<html lang="es"><?php
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
$versphpvieja = str_ireplace('.','',phpversion());
$versphpnueva = 540;
if($versphpvieja < $versphpnueva ){?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php 
}else{ ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php 
}?>
<link rel="shortcut icon" href="../images/logo1.png" />
<link rel="stylesheet" href="install.css" type="text/css" />
<script  type="text/javascript" src="ajax.js"></script>
<script type='text/javascript'>
	var nav4 = window.Event ? true : false;
	function acceptNum(evt){	
		var key = nav4 ? evt.which : evt.keyCode;	
		return (key <= 13 || (key >= 48 && key <= 57));
	}
	function handleEnter (field, event) { var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode; if (keyCode == 13) { var i; for (i = 0; i < field.form.elements.length; i++) if (field == field.form.elements[i]) break; i = (i + 1) % field.form.elements.length; field.form.elements[i].focus(); return false; } else return true; } </script>
</head>
<?php
define( "_VALID_MOS", 1 );
$seulang ="es";

 	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){@$seulang="es"; }else{@$seulang="en";}
	}
	if((@$seulang) =="es"){include('../esp.php');} else { include('../eng.php');}

$provin = array("Pinar del R&iacute;o","La Habana","Mayabeque","Artemisa","Matanzas","Cienfuegos","Villa Clara","Santi Sp&iacute;ritus","Ciego de &Aacute;vila","Camag&uuml;ey","Las Tunas","Holgu&iacute;n","Granma","Santiago de Cuba","Guant&aacute;namo","Isla de la Juventud");

/** Include common.php */
require_once( 'common.php' );

$DBhostname  = mosGetParam( $_POST, 'DBhostname', '' );
$DBuserName  = mosGetParam( $_POST, 'DBuserName', '' );
$DBpassword  = mosGetParam( $_POST, 'DBpassword', '' );
$DBname      = mosGetParam( $_POST, 'DBname', '' );
$NombreAdmin = mosGetParam( $_POST, 'NombreAdmin', '' );
$LoginAdmin  = mosGetParam( $_POST, 'LoginAdmin', '' );
$PassAdmin   = mosGetParam( $_POST, 'PassAdmin', '' );
$CorreoAdmin = mosGetParam( $_POST, 'CorreoAdmin', '' );
        $sex = mosGetParam( $_POST, 'sexo', '' );
    $entidad = mosGetParam( $_POST, 'entidad', '' );
 	  $reup  = mosGetParam( $_POST, 'reup', '' );
     $sector = mosGetParam( $_POST, 'sector', '' );
	   $PROV = mosGetParam( $_POST, 'provincia', '' );
       $smtp = mosGetParam( $_POST, 'smtp', '' );
 	    $web = mosGetParam( $_POST, 'web', '' );	  

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
?>
<script  type="text/javascript">
<!--
function chequea() {
	// form validation check
	var formValid=false;

	var f = document.form;
	if ( f.DBhostname.value == '' ) {
		alert('Por favor, escriba el nombre del servidor');
		f.DBhostname.focus();
		formValid=false;
	} else if ( f.DBuserName.value == '' ) {
		alert('Por favor, escriba el nombre del usuario de la Base de Datos');
		f.DBuserName.focus();
		formValid=false;
	} else if ( f.DBname.value == '' ) {
		alert('Por favor, escriba el nombre de la nueva Base de Datos');
		f.DBname.focus();
		formValid=false;
	} else if ( f.DBPrefix.value == '' ) {
		alert('Debe ingresar un prefijo de tabla para la Base de Datos, es parte esencial del correcto funcionamiento de este Sitio!.');
		f.DBPrefix.focus();
		formValid=false;
	} else if ( f.DBPrefix.value == 'old_' ) {
		alert('No puede usar "old_" como el prefijo de la tabla MySQL porque Seguridad! utiliza dicho prefijo para las tablas de respaldo.');
		f.DBPrefix.focus();
		formValid=false;
	} else if ( f.NombreAdmin.value == '' ) {
		alert('Por favor, es necesario el Nombre del Administrador');
		f.NombreAdmin.focus();
		formValid=false;
	} else if ( f.LoginAdmin.value == '' ) {
		alert('Por favor, es necesario el Login que utilizar\u00E1 el Administrador');
		f.LoginAdmin.focus();
		formValid=false;
	} else if ( f.CorreoAdmin.value == '' ) {
		alert('Por favor, es necesario el E-Mail del Administrador');
		f.CorreoAdmin.focus();
		formValid=false;
	} else if (f.CorreoAdmin.value.indexOf('@', 0) == -1 || f.CorreoAdmin.value.indexOf('.', 0) == -1){ 
	    alert("El E-Mail no es correcto, por favor verifique."); 
        f.CorreoAdmin.focus(); 
		formValid=false; 	
	} else if ( f.entidad.value == '' ) {
		alert('Por favor, es necesario el Nombre de la entidad');
		f.entidad.focus();
		formValid=false;
	} else if ( f.sector.value == '' ) {
		alert('Por favor, es necesario el sector');
		f.sector.focus();
		formValid=false;
	}else if ( f.smtp.value == '' ) {
		alert('Por favor, es necesario Servidor Saliente (Smtp)');
		f.smtp.focus();
		formValid=false;
	}else if ( f.reup.value == '' ) {
		alert('Por favor, es necesario el codigo de la Entidad');
		f.reup.focus();
		formValid=false;
	}else if ( f.provincia.value == '' ) {
		alert('Por favor, es necesario la Provincia');
		f.provincia.focus();
		formValid=false;
	}
		else if ( confirm('<?php echo $soncorrector;?>')) {
		formValid=true;
	}

	return formValid;
}
//-->
</script>
<body onLoad="<?php if(($DBhostname) ==""){ ?>document.form.DBhostname.focus(); <?php }else{?>document.form.DBuserName.focus();<?php }?>">
  	<div id="wrapper">
		<div id="header">
			<div id="el sitio" align="center">
			<div align="center" <?php if (($seulang) =="es") { ?> class="Headeresp-jpeg" <?php }else {?>class="Headereng-jpeg" <?php }?>></div>
		</div>
		</div>
	</div>
<div id="ctr" align="center">
	<form action="genera_db.php" method="post" name="form" id="form" onSubmit="return chequea();">
		<div class="install">
			<div id="stepbar">
				<div class="step-off"><?php echo $preinstall; ?></div>
				<div class="step-off"><?php echo $licence; ?></div>
				<div class="step-on"><?php echo $paso; ?> 1</div>
				<div class="step-off"><?php echo $paso; ?> 2</div>
		    </div>
			<div id="right">
				<div id="step1"><?php echo $paso; ?> 1</div>
				<div class="clr"></div>
				<h1><?php echo $confsql;?>:</h1>
				<p><br><b><?php echo $btpuede;?>...</b></p>
			<div class="form-block"> 			
			  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="content2">
				<tr> 
				  <td width="3%"></td>
				  <td width="28%"></td>
				  <td width="69%"></td>
				</tr>
				<tr> 
				  <td colspan="2"><div align="justify"> 
					  <input onKeyPress="return handleEnter(this, event)" name="DBhostname" id="DBhostname" type="text" class="inputbox" value="<?php echo $DBhostname; ?>" size="22" />
					</div></td>
				  <td><div align="justify"><em><?php echo $name_ser;?>, <?php echo $u_mente;?></em>.</div></td>
				</tr>
				<tr> 
				  <td colspan="2"><div align="justify"> 
					  <input onKeyPress="return handleEnter(this, event)" name="DBuserName" id="DBuserName" type="text" class="inputbox" value="<?php echo $DBuserName; ?>" size="22" />
					</div></td>
				  <td><div align="justify"><em><?php echo $name_use;?> </em>.</div></td>
				</tr>
				<tr> 
				  <td colspan="2"><div align="justify"> 
					  <input onKeyPress="return handleEnter(this, event)" name="DBpassword" id="DBpassword" type="password" class="inputbox" value="<?php echo $DBpassword; ?>" size="22" onChange="compruebasql(document.getElementById('DBhostname').value,document.getElementById('DBuserName').value,this.value);" onBlur="compruebasql(document.getElementById('DBhostname').value,document.getElementById('DBuserName').value,this.value);"  />
					</div></td>
				  <td><div id ="compsq"  align="justify"><em><?php echo $name_pas;?>, <?php echo $name_pas1;?></em></div></td>
				</tr>
				<tr> 
				  <td colspan="2"><div align="justify"> 
					  <input onKeyPress="return handleEnter(this, event)" name="DBname" type="text" class="inputbox" value="<?php echo $DBname;?>" onKeyUp="compruebabd(document.getElementById('DBhostname').value,document.getElementById('DBuserName').value,document.getElementById('DBpassword').value,this.value);" size="22" />
					</div></td>
				  <td><div id ="comp" align="justify"><em><?php echo $name_ndb;?>. </em></div></td>
				</tr>
				</table>
				<div id="oculta">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" class="content2">
				<tr> 
				  <td><input onKeyPress="return handleEnter(this, event)" name="NombreAdmin" type="text" class="inputbox" id="NombreAdmin" value="<?php echo $NombreAdmin;?>" size="22" /></td>
				  <td width="69%"><em><?php echo $nombreapell.$of1;?>. </em></td>
				</tr>
				<tr> 
				  <td><input onKeyPress="return handleEnter(this, event)" name="LoginAdmin" type="text" class="inputbox" id="LoginAdmin" value="<?php echo $LoginAdmin;?>" size="22" /></td>
				  <td><em><?php echo $nick.$of1;?>.</em></td>
				</tr>
				<tr> 
				  <td><input onKeyPress="return handleEnter(this, event)" name="PassAdmin" type="password" class="inputbox" id="PassAdmin" value="<?php echo $PassAdmin;?>" size="22" /></td>
				  <td><em><?php echo $pass.$of1;?>. <font color="#FF0000" size="2">*</font></em></td>
				</tr>
				<tr> 
				  <td height="23"><input onKeyPress="return handleEnter(this, event)" name="CorreoAdmin" type="email" class="inputbox" id="CorreoAdmin" value="<?php echo $CorreoAdmin;?>" size="22" /></td>
				  <td><em><?php echo $electron.$of1;?>. </em> </td>
				</tr>
				<tr>
				  <td height="23">
					<select onkeypress="return handleEnter(this, event)" name="sexo" class="inputbox" id="sexo"/>
					<option value="h" <?php if(($sex) =="h"){ echo "selected";}?>>Hombre</option>
					<option value="m"<?php if(($sex) =="m"){ echo "selected";}?>>Mujer</option>			  </td>
				  <td><?php echo $Sexo;?></td>
				</tr>
				<tr> 
				  <td height="23"><input onKeyPress="return handleEnter(this, event)" name="entidad" type="text" class="inputbox" id="entidad" value="<?php echo $entidad;?>" size="22" /></td>
				  <td><em><?php echo $btdatosentidad5;?>. </em> </td>
				</tr>
				<tr> 
				  <td height="23"><input onKeyPress="return acceptNum(event); return handleEnter(this, event);" name="reup" type="text" class="inputbox" id="reup" value="<?php echo $reup;?>" size="22" /></td>
				  <td><em><?php echo $btCodigo.$dela.$btdatosentidad3;?>. </em> </td>
				</tr>
				<tr> 
				  <td height="23"><input onKeyPress="return handleEnter(this, event)" name="sector" type="text" class="inputbox" id="sector" value="<?php echo $sector;?>" size="22" /></td>
				  <td><em><?php echo $perteneciente;?>. </em> </td>
				</tr>
				<tr> 
				  <td height="23"><input onKeyPress="return handleEnter(this, event)" name="web" type="url" class="inputbox" id="web" value="<?php echo $web;?>" size="22" /></td>
				  <td><em><?php echo $Web.$dela.$btdatosentidad3;?>  Ej: http://www.miweb.com </em> (<?php echo $btOpcional;?>)</td>
				</tr>
				<tr> 
				  <td height="23"><select onkeypress="return handleEnter(this, event)" name="provincia" class="inputbox" id="provincia"><?php 					
							$d=0;
							while($d< count($provin)){ ?>
				  <option value="<?php echo ($d + 1);?>"><?php echo $provin[$d];?></option><?php 
								$d++;
							} ?>
				  </select></td>
				  <td><em><?php echo $btprovincia;?>. </em></td>
				</tr>
				<tr> 
				  <td height="23"><input onKeyPress="return handleEnter(this, event)" name="smtp" type="text" class="inputbox" id="smtp" value="<?php echo $smtp;?>" size="22" /></td>
				  <td><em><?php echo $serv1;?>. </em> </td>
				</tr>
				<tr> 
				  <td height="23" colspan="2"><font color="#FF0000" size="2">* </font><font color="#FF0000"><?php echo $hint;?>. </font></td>
				</tr>			
			  </table>
			  </div>
			 <div class="far-right">
				<input class="btn" type="submit" name="next" value="<?php echo $sigui; ?> &gt;&gt;" style="cursor:pointer"/>
				<input class="inputbox" type="hidden" name="DBPrefix" value="seg" />
				<input type="hidden" name="DBDel" id="DBDel2" value="1" />
				<input type="hidden" name="DBBackup" id="DBBackup2" value="1"/>
				<input type="hidden" name="DBSample" id="DBSample2" value="1"/>
			</div><br><br>
			</div>
			</div> 
			<div class="clr"></div>
		</div>
    </form>
</div>
<div class="clr"></div>
<div class="ctr">
	<span class="piepagina"><?php echo $footer;?>. </span>
	<br>
</div>
</body>
</html>
