<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                     				                        #
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

/**
* @version $Id: install.php 4675 2006-08-23 16:55:24Z stingrey $
* @Official Joomla! Spanish Translation Partner <www.joomlaspanish.org>
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Set flag that this is a parent file
define( "_VALID_MOS", 1 );

$seulang ="es";

if (file_exists( '../configuration.php' ) && filesize( '../configuration.php' ) > 10) {
	header( 'Location: ../index.php' );
	exit();
}
/** Include common.php */
include_once( 'common.php' );
function writableCell( $folder ) {
	echo "<tr>";
	echo "<td class=\"item\">" . $folder . "/</td>";
	echo "<td align=\"left\">";
	echo is_writable( "../$folder" ) ? '<b><font color="green">Puede ser escrito</font></b>' : '<b><font color="red">No puede ser escrito</font></b>' . "</td>";
	echo "</tr>";
}
$i = "es";
 	 if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){@$seulang="es"; }else{@$seulang="en";}
	}
	if((@$seulang) =="es"){include('../esp.php');} else { include('../eng.php');}

echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<script language="javascript">
 function _checka(valor){
   if(valor==false){ 
      alert('Si ha quedado conforme con la Licencia GNU/GPL, marque la casilla "Estoy de acuerdo".');
	  return false; 
   }else{
     document.adminForm.submit();
   }
 }
</script>
<html>
<head>
<title>Registro de Medios - Instalador Web</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../images/logo1.png" />
<link rel="stylesheet" href="install.css" type="text/css" />
</head>
<body>
  	<div id="wrapper">
		<div id="header">
		  <div id="el sitio" align="center">
			<div align="center" <?php if (($seulang) =="es") { ?> class="Headeresp-jpeg" <?php }else {?>class="Headereng-jpeg" <?php }?>></div>
		</div>
	</div>
<div id="ctr" align="center">
	<form action="install1.php" method="post" name="adminForm" id="adminForm" >
	<div class="install">
	<div id="stepbar">
				<div class="step-off"><?php echo $preinstall; ?></div>
                <div class="step-on"><?php echo $licence; ?></div>
                <div class="step-off"><?php echo $paso; ?> 1</div>
                <div class="step-off"><?php echo $paso; ?> 2</div>
	  </div>
	<div id="right">
		<div id="step_licencia"><?php echo $licence; ?></div>
		<div class="clr"></div>
		<h1><?php echo $licence; ?> GNU/GPL:</h1>
		<div class="clr"></div>
		<div class="license-form">
			<div class="form-block" style="padding: 0px;">
				<iframe src="<?php if ($seulang =="es"){ ?>gpl.html<?php }else{ ?>gpl_english.html<?php } ?>" class="license" frameborder="0" scrolling="auto"></iframe>
			</div><br>
			<div style="float:left"><span><b><?php echo $btacuerdo; ?></b></span>
			<input name="terminos" id="terminos" type="checkbox" style="cursor:pointer;">
			</div>			
		</div>
		<div class="clr"></div>
		<div class="clr"></div>
	</div>
	<div id="break"></div>	
	<div class="clr"></div>
	
	<div class="far-right">
		<input class="btn" type="button" onclick="_checka(adminForm.terminos.checked);" name="next" value="<?php echo $sigui; ?> &gt;&gt;" style="cursor:pointer"/>
	</div><div class="clr"></div>
	</div>
	</form>
</div>
<div class="ctr">
	<span class="piepagina"><?php echo $footer;?>. </span>
	<br>
</body>
</html>
