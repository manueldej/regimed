<?php 
/********************************************************************************************
* Software: Seguridad                                                                       * 
* (Registro de Medios Informáticos)     					                         		*
* Version:  2.0                                                     				        *
* Fecha:    01/06/2013                                             					        *
* Autores:  Lic. Manuel de Jesús Núñez Guerra   											*
*          	Msc. Carlos Pollan Estrada														*
* Licencia: Freeware                                                				        *
*                                                                       				    *
* Usted puede usar y modificar este software si asi lo desee, pero debe mencional la fuente *
*********************************************************************************************/
$i="es";
if(isset($_COOKIE['seulang'])){
	if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
}
if(($i) =="es"){include('../../esp.php');}else{include('../../eng.php');}
class foot {
	var $Version 	= '2.0';
	var $Correo 	= '<a href="mailto:manuel.jesus@zetifmf.azcuba.cu">webmaster</a>';
	var $soporte    = '<a href="http://www.zeti.azcuba.cu/" target="_blank">ZETI</a>';
	var $plataforma = '<a href="http://safari.oreilly.com/">Ajax | Framework</a>';	
}

$pie = new foot();


$ver = $pie->Version;

$footer1 = $pie->Correo;
$soporte_u = $pie ->soporte;
$plataf = $pie ->plataforma;

echo '<div  align="center">'. $btversion.' 2.0';?> | <?php echo $terminos;?> <?php echo $footer1; ?> <br> <?php echo $derechos.'</div>'; 
?>
<div  align="center">
<a href="http://www.debian.org" target="_blank"><img src="../../images/debian.png" width="40" height="40" border="0" align="absmiddle"></a>
<a href="http://www.apache.com" target="_blank"><img src="../../images/apache.png" width="40" height="40" border="0" align="absmiddle"></a>
<a href="http://www.ajax.nl" target="_blank"><img src="../../images/ajax.png" width="40" height="40" border="0" align="absmiddle"></a>
<a href="http://jquery.com" target="_blank"><img src="../../images/jquery.png" width="63" height="40" border="0" align="absmiddle"></a>
<a href="http://www.mysql.com" target="_blank"><img src="../../images/mysql.png" width="49" height="40" border="0" align="absmiddle"></a>
<a href="http://www.php.net" target="_blank"><img src="../../images/php.png" width="47" height="40" border="0" align="absmiddle"></a>
<a href="http://www.css3.info" target="_blank"><img src="../../images/css3.png" width="40" height="40" border="0" align="absmiddle"></a>
<script type='text/javascript'>findInPage('<?php echo @$txtState;?>');</script>
