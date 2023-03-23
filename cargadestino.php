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
$aftt="";
	if (isset($_POST['udes']) AND ($_POST['udes'] !="")){
		$aftt .= " WHERE idunidades='".$_POST['udes']."'";
	}
	$query_Recordset4= "SELECT * FROM areas".$aftt;
	$Recordset1 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error());?>
&nbsp;
<select class="combo_box" name="area" size="1" id="area">
	<option value="-1"><?php echo $seleccione.$El.substr($btAreas,0,-1)." ".ucfirst($btDESTINO);?></option><?php
		while ($row_R = mysqli_fetch_array($Recordset1)) {  
			if((@$rse['idarea']) !=$row_R['nombre']){	?>
				<option onclick="dame_custodio('<?php echo base64_encode($row_R['nombre'])?>','<?php echo base64_encode($row_R['idunidades'])?>',document.getElementById('invent1').value);" value="<?php echo $row_R['nombre'];?>"<?php if(($row_R['nombre']) ==base64_decode(@$_POST["adestino"])){echo "selected";}?>><?php echo $row_R['nombre'];?></option><?php
			}
		} ?>
</select>