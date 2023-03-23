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

include ('connections/miConex.php'); 
$i="es";
if(isset($_COOKIE['seulang'])){
	if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
}
if(($i) =="es"){include('esp.php');}else{include('eng.php');}

if(isset($_POST['inv'])){
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$se = "select idarea from aft WHERE inv='".$_POST['inv']."' AND idunidades='".$_COOKIE['unidades']."'";
	}else{
		$se = "select idarea from aft WHERE inv='".$_POST['inv']."'";
    }
	$qse = mysqli_query($miConex, $se) or die(mysql_error($miConex));
	$rse = mysqli_fetch_array($qse);
} 
?>
<input class="imput" readonly name="inventx" size="<?php if(isset($_POST['inv'])){ echo strlen($rse['idarea']);}?>" type="text" id="inventx" value="<?php if(isset($_POST['inv'])){ echo $rse['idarea'];}else{ echo "";}?>">