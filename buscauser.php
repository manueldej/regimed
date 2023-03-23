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
require_once('connections/miConex.php');
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
if(($i) =="es"){include('esp.php');}else{ include('eng.php');}

include ('script.php');
include('mensaje.php');

if(isset($_POST['tt'])){
	$query_Recordset1 = "SELECT * FROM usuarios where id_area='".$_POST['tt']."' AND idunidades='".$_POST['idunidades']."'";
}else{
	$query_Recordset1 = "SELECT * FROM usuarios";
}

$Recordset1 = mysqli_query($miConex, $query_Recordset1) or die(mysql_error());
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

?>

<select onkeypress="return handleEnter(this, event)" name="custod" onchange="document.getElementById('custo').value=this.value" class="form-control" id="custod"><?php
	if(isset($_POST['tt'])){ ?>
		<option value="-1"><?php echo $seleccione.$btCustodios;?></option><?php
			while ($row_Recordset1 = mysqli_fetch_array($Recordset1)){   ?>
				<option value="<?php echo $row_Recordset1['nombre']?>"><?php echo $row_Recordset1['nombre']?></option><?php
			} 
	}?> 
</select>


