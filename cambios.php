<?php include("esp.php");
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
?>
<!DOCTYPE html>
<style type="text/css">
<!--
.Estilo1 {
	font-style: normal;
	font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;
	font-size: 9px;
	font-weight: normal;
	color: #485860;
}
-->
<!--
.Estilo2 {
	font-style: normal;
	font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;
	font-size: 9px;
	font-weight: normal;
	color: #485860;
}
-->
</style>
<?php 
   $i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}

	if ($i=="es") {
	  include('esp.php');
	}else{
	  include('eng.php');
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<p align="left" class="Estilo1"><b><?php echo $btversi;?> 3.1.1 Final. (<?php echo $ene.","; ?> 2023)  </b></p>
<div align="left">
  <div align="justify" class="Estilo2"><?php echo $a_311; ?></div>
  <ul class="Estilo2" style="margin-left: -25px;">
      <div align="justify"><?php echo $a_312; ?></div>
  </ul>
</div>
<p align="left" class="Estilo1"><b><?php echo $btversi;?> 3.0.1 (<?php echo $feb.","; ?> 2018)  </b></p>
<div align="left">
  <ul class="Estilo2" style="margin-left: -25px;">
	 <li>
      <div align="justify"><?php echo $a13; ?></div>
    </li>
	<li>
      <div align="justify"><?php echo $a14; ?></div>
    </li>
	<li>
      <div align="justify"><?php echo $a15; ?></div>
    </li>
	<li>
      <div align="justify"><?php echo $a15a; ?></div>
    </li>
	<li>
      <div align="justify"><?php echo $a17; ?></div>
    </li>
	<li>
      <div align="justify"><?php echo $a18; ?></div>
    </li>
  </ul>
</div>
<p align="left" class="Estilo1"><b><?php echo $btversi;?> 2.1.1 (<?php echo $dic.","; ?> 2014)  </b></p>
<div align="left">
  <ul class="Estilo1" style="margin-left: -25px;">
    <li>
      <div align="justify"><?php echo $a6; ?> </div>
    </li>
    <li><?php echo $a7; ?></li>
    <li><?php echo $a8; ?></li>
    <li><?php echo $a9; ?></li>
    <li>
      <div align="justify"><?php echo $a10; ?></div>
    </li>
    <li>
      <div align="justify"><?php echo $a11; ?></div>
    </li>
  </ul>
</div>
<p align="left" class="Estilo1"><b><?php echo $btversi;?> 2.1.0 (<?php echo $may.","; ?> 2013)  </b></p>
<div align="left">
  <ul class="Estilo1" style="margin-left: -25px;">
    <li>
      <div align="justify"><?php echo $a3; ?></div>
    </li>
    <li>
      <div align="justify"><?php echo $a4; ?></div>
    </li>
    <li>
      <div align="justify"><?php echo $a5; ?> </div>
    </li>
  </ul>
</div>
<p align="left" class="Estilo1"><b><?php echo $btversi;?> 2.0.0 (<?php echo $mar.","; ?> 2011)</b></p>
<div align="left">
  <ul class="Estilo1" style="margin-left: -25px;">
    <li><?php echo $a1; ?></li>
    <li><?php echo $a2; ?></li>
  </ul>
</div>
