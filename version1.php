<?php 
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Informáticos)     					                                		           #
# Version:  3.0.1                                                     				                       #
# Fecha:    01/06/2016 - 03/04/2018                                             					       #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################
/**
 * Datos de la Version.
 * @package RegiMed 
 */
class seguVersion {
	var $PRODUCT 	= 'RegiMed';
	var $RELEASE 	= '3';
	var $DEV_STATUS = 'Stable';
	var $DEV_LEVEL 	= '0.1';
	var $BUILD	 	= '$Revision: 01 $';
	var $RELDATE 	= 'Feb, 22 de 2018';
	var $RELDATE1 	= 'Feb, 22 de 2018';
	var $RELTZ 		= 'UTC';
	var $COPYRIGHT 	= "Copyright(C) 2013 - 2018. Todos los Derechos Reservados.";
	var $URL 		= '<a href="http://localhost/regimed/">RegiMed!</a> es Software Libre distribuido bajo licencia GNU/GPL.';
	var $SITE 		= 1;
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
	top: -61px;
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
  background: #000000;
  font-family: Arial;
  font-size: 11px;
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
  opacity:0.8;
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
</style> 
<?php 
$i="es";
if(isset($_COOKIE['seulang'])){
	if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
}
if(($i) =="es"){include('esp.php');}else{include('eng.php');}
$Correo 	= '<a href="mailto:manuel.jesus@zetifmf.azcuba.cu">webmaster</a>';
?>
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
</div></div></div>
<div  align="center" style="font-size: 12px; position: relative; top: 6px;"><b><?php  echo  $btversion." <a href='#modal8' class='tooltip'>". $version ."<span onmouseover=\"this.style.cursor='pointer';\">".$btversion3."<br>";
if(($i) =='es'){
	echo $BUILD."</span></a>"; ?></b> | <?php echo $terminos;?> <?php echo $Correo; ?> <br><b><?php echo $derechos;
}else{
	echo $BUILD1."</span></a>&nbsp;&nbsp;"; ?></b> | <?php echo $terminos;?> <?php echo $Correo; ?><br><?php echo $derechos;
} ?></b>
</div>
<br>
<div id="modal8" class="modalmask">
<div class="modalbox rotate">
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