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
?>
<?php
class foot {
	var $Software 	= 'Registro de Medios Inform&aacute;ticos';
	var $Version 	= '3.1.1';
	var $Correo 	= '<a href="mailto:manuel.jesus@zetifmf.azcuba.cu">webmaster</a>';
	var $derechos   = '<a href="mailto:manuel.jesus@zetifmf.azcuba.cu">el sitio! es un Software Libre con licencia de GNU/GPL.</a>';
	var $terminos   = '<a href="../Terminos de Uso" target="_blank">T&eacute;rminos de Uso';
	var $soporte    = '<a href="http://www.zeti.azcuba.cu/">ZETI</a>';
	var $plataforma = '<a href="http://safari.oreilly.com/">Ajax | Framework</a>';
}

$pie = new foot();

$version = $pie->Software .' '. $pie->Version .' ';

$ver = $pie->Version;
$title = $pie->Software;
$footer = @$archi3;
$footer1 = @$archi4.'<BR>'.$pie->Correo;
$derecho_autor = $pie ->derechos; 
$terminos_uso = $pie ->terminos; 
$soporte_u = $pie ->soporte;
$plataf = $pie ->plataforma;

?>
<div class="Footer-inner" align="center">
	<div class="Footer-text" align="center">
		<?php echo $version;?> | <?php echo $terminos_uso;?> <?php echo $footer1; ?> | <?php echo $derecho_autor; ?><br/><?php echo $soporte_u." Plataforma: ".$plataf; ?>
	</div>
</div>
