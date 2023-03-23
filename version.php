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
/**
 * Datos de la Version.
 * @package RegiMed 
 */
class seguVersion {
	var $PRODUCT 	= 'Registro de Medios Inform&aacute;ticos.';
	var $RELEASE 	= 'v3';
	var $DEV_STATUS = 'Stable';
	var $DEV_LEVEL 	= '1.1';
	var $BUILD	 	= '$Revision: 3040 $';
	var $RELDATE 	= 'Ene, 01 de 2023';
	var $RELDATE1 	= 'Ene, 01 of 2023';
	var $RELTZ 		= 'UTC';
	var $COPYRIGHT 	= "Copyright(C) 2011 - 2023. Todos los Derechos Reservados.";
	var $URL 		= '<a href="http://localhost/regimed/">RegiMed!</a> es Software Libre distribuido bajo licencia GNU/GPL.';
	var $SITE 		= 2;
	var $RESTRICT	= 0;
	var $SVN		= 0;


	function getLongVersion() {
		return $this->PRODUCT .' '. $this->RELEASE .'.'. $this->DEV_LEVEL .' '
			. $this->DEV_STATUS
			.' [ '.$this->CODENAME .' ] '. $this->RELDATE .' '
			. $this->RELTIME .' '. $this->RELTZ;
	}

	function getShortVersion() {
		return $this->RELEASE .'.'. $this->DEV_LEVEL;
	}

	function getHelpVersion() {
		if ($this->RELEASE > '1.0') {
			return '.' . str_replace( '.', '', $this->RELEASE );
		} else {
			return '';
		}
	}
}
$_VERSION = new seguVersion();

$version = $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '
. $_VERSION->DEV_STATUS;
$BUILD=	$_VERSION->RELDATE;
$BUILD1=	$_VERSION->RELDATE1;
?>

<style type="text/css">
.edita{
	background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
	height: 16px;
	background-position: 0 -80px;
}
</style>
<style>
.modalmask {
	position: fixed;
	font-family: Arial, sans-serif;
	top: -102px;
	right: 0;
	bottom: 0;
	left: 0;
	background: rgba(0,0,0,0.25);
	z-index: 99999;
	opacity:0;
	-webkit-transition: opacity 400ms ease-in;
	-moz-transition: opacity 400ms ease-in;
	transition: opacity 400ms ease-in;
	pointer-events: none;
	border-radius: 4px 4px 4px  4px ;
}
.modalmask:target {
	opacity:1;
	pointer-events: auto;
}
.modalbox{
	width: 526px;
	position: relative;
	padding: 5px 20px 13px 20px;
	background: #fff;
	border-radius:3px;
	-webkit-transition: all 500ms ease-in;
	-moz-transition: all 500ms ease-in;
	transition: all 500ms ease-in;
	border-radius: 4px 4px 0 0;
}

.rotate {
	margin: 10% auto;
	-webkit-transform: scale(-5,-5); 
	transform: scale(-5,-5);
}

.modalmask:target .rotate{		
	transform: rotate(360deg) scale(1,1);
        -webkit-transform: rotate(360deg) scale(1,1);
}

.close {
	color: #FFFFFF;
	line-height: 25px;
	position: absolute;
	right: 6px;
	text-align: center;
	top: 5px;
	width: 24px;
	text-decoration: none;
	font-weight: bold;
	border-radius: 3px ;
    margin-top: 6px;
}

.close:hover { 
	background: #FAAC58; 
	color:#222;
}
.itemW{	
	z-index:9999;
}
a.tooltip {
  position: relative;
  display: inline;
}
a.tooltip span {
  position: absolute;
  color:#FFFFFF;
  width:120px;
  border:1px solid #000000; 
  background:rgba(51,51,51,0.75);
  font-family: Arial;
  font-size: 11px;
  opacity:1;
  height:60x;
  text-align: center;
  text-shadow: 1px 1px 1px  #000000; 
  vertical-align:middle;
  visibility: hidden;
  border-radius:4px ;  
  box-shadow:2px 2px 2px  #000000; 
}
a.tooltip span:after {
  content: '';
  position: absolute;
  top: 102%;
  left: 50%;
  margin-left: -8px;
  width: 0; height: 0;
  border-top: 8px solid #000000; 
  border-right: 8px solid transparent;
  border-left: 8px solid transparent;
  opacity:1;
  z-index: 9999;

}
a:hover.tooltip span {
  visibility: visible;
  opacity: 1;
  bottom: 30px;
  left: 50%;
  margin-left: -59px;
  z-index: 999;

}
 .foo{
	background-color: #626262;
	background-image: linear-gradient(to bottom, #ffffff,#CFBB21 );
	background-repeat: repeat-x;
	border-color: #252525; 
 }
</style> 
<?php 
$i="es";
if(isset($_COOKIE['seulang'])){
	if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
}
if(($i) =="es"){include('esp.php');}else{include('eng.php');}
$Correo 	= '<a href="mailto:manuel.jesus@zetifmf.azcuba.cu">webmaster</a>';
?>
<link href="css/sticky-footer-navbar.css" rel="stylesheet">
<div id="modal3" class="modalmask">
<div class="modalbox rotate">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 548px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2 class="pos"><?php echo $term;?></h2></div>
<p align="center"><?php echo $textoam; ?></p>
</div></div>

<div id="modal7" class="modalmask">
<div class="modalbox rotate" >
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 548px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2 class="pos"><?php echo $cversiones;?></h2></div>
<iframe src="cambios.php" style="border:0px; width: 539px; height: 420px;"></iframe>
</div></div>
<fieldset class="fieldset" style="width:99%;">
<div id="footer" style="height:80px; width:100%;">
<div class="container" align="center" style="width:97%;">
<div><?php echo "<a href='#modal7' class='tooltip'>".$version."<span onmouseover=\"this.style.cursor='pointer';\">".$btversion3."<br>";
if(($i) =='es'){
	echo $BUILD."</span></a>&nbsp;&nbsp;"; ?></b> | <?php echo $terminos;?> | <?php echo $Correo; ?> <br><b><?php echo $derechos;?></b><?php
}else{
	echo $BUILD1."</span></a>&nbsp;&nbsp;"; ?></b> | <?php echo $terminos;?> | <?php echo $Correo; ?> <br><b> <?php echo $derechos;?></b><?php
} ?>
</div>
<a href="http://www.debian.org" target="_blank"><img src="images/debian.png" width="24" height="24" border="0" align="absmiddle" onmouseover="src='images/debian1.png'" onmouseout="src='images/debian.png'" ></a>
<a href="https://www.apachefriends.org/es/index.html" target="_blank"><img src="images/apache.png" width="32" height="32" border="0" align="absmiddle" onmouseover="src='images/apache1.png'" onmouseout="src='images/apache.png'"></a>
<a href="http://api.jquery.com/jquery.ajax/" target="_blank"><img src="images/ajax.png" width="32" height="32" border="0" align="absmiddle" onmouseover="src='images/ajax1.png'" onmouseout="src='images/ajax.png'"></a>
<a href="http://jquery.com" target="_blank"><img src="images/jquery.png" width="32" height="32" border="0" align="absmiddle" onmouseover="src='images/jquery1.png'" onmouseout="src='images/jquery.png'"></a>
<a href="http://www.mysql.com" target="_blank"><img src="images/mysql.png" width="32" height="32" border="0" align="absmiddle" onmouseover="src='images/mysql1.png'" onmouseout="src='images/mysql.png'"></a>
<a href="http://www.php.net" target="_blank"><img src="images/php.png" width="32" height="32" border="0" align="absmiddle" onmouseover="src='images/php1.png'" onmouseout="src='images/php.png'"></a>
<a href="http://www.css3.info" target="_blank"><img src="images/css3.png" width="32" height="32" border="0" align="absmiddle" onmouseover="src='images/css31.png'" onmouseout="src='images/css3.png'"></a>
<br>
</div>
</fieldset><br>