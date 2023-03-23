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

	
	
	if (($_POST['cod'] !="") AND ($_POST['aftt'] =="")){
		$aftt .= " WHERE idunidades='".$_POST['cod']."'";
	}
	
	if(($_POST['aftt']!="") AND ($_POST['cod'] !="")){
			$aftt .= " WHERE (inv LIKE '%".$_POST['aftt']."%') OR (descrip LIKE '%".$_POST['aftt']."%') OR (categ LIKE '%".$_POST['aftt']."%') AND idunidades='".$_POST['cod']."'";
	}
	
	$query_Recordset4= "SELECT * FROM aft".$aftt;
	$Recordset1 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error());

?>
&nbsp;
<select class="combo_box" name="invent1" size="1" id="invent1" onchange="">
	<option value="-1"><?php echo $seleccione.$El.ucfirst($btACTIVOS);?></option><?php 
		while ($row_Recordset1 = mysqli_fetch_array($Recordset1)) {  
			$querdg = mysqli_query($miConex, "SELECT * FROM datos_generales WHERE id_datos='".$row_Recordset1['idunidades']."'");
			$rowquerdg = mysqli_fetch_array($querdg);?>
			<option onClick="ubicar_origen(this.value);" value="<?php echo $row_Recordset1['inv'];?>" <?php if(($row_Recordset1['inv']) ==@$_POST['inv']){ echo "selected";}?>  ><?php echo $row_Recordset1['inv']." -> ".$row_Recordset1['descrip'];?></option><?php
		} ?>
</select>
 
