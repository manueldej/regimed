<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                     				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los t�rminos de la Licencia P�blica General GNU publicada por la Fundaci�n de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versi�n 2 de la Licencia, o (en su opci�n)   #
# cualquier posterior versi�n. REGIMED es distribuido con la esperanza de que ser� �til, pero SIN CUALQUIER #
# GARANT�A; Sin a�n la garant�a impl�cita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROP�SITO PARTICULAR.  #
# Vea la Licencia P�blica General del GNU para m�s detalles. Usted deber�a haber recibido una copia de la   #
# Licencia  P�blica General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
$i="es";
if(isset($_COOKIE['seulang'])){
	if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
}
if(($i) =="es"){include('../esp.php');}else{include('../eng.php');}
class foot {
	var $Version 	= '3.1.1';
	var $Correo 	= '<a href="mailto:manuel.jesus@zetifmf.azcuba.cu">webmaster</a>';
	var $soporte    = '<a href="http://www.zeti.azcuba.cu/" target="_blank">ZETI</a>';
	var $plataforma = '<a href="http://safari.oreilly.com/">Ajax | Framework</a>';	
}

$pie = new foot();


$ver = $pie->Version;

$footer1 = $pie->Correo;
$soporte_u = $pie ->soporte;
$plataf = $pie ->plataforma;

echo '<div  align="center">'. $btversion.' | '.$ver; ?><br><?php echo 'Este Sitio Web es un Software Libre con (licencia de GNU/GPL</div>'; 

?>
<script type='text/javascript'>findInPage('<?php echo @$txtState;?>');</script>
