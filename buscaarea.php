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

 if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$query_R = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."'";
}elseif (isset($_POST['idunidades'])){
	$query_R = "SELECT * FROM areas where idunidades='".$_POST['idunidades']."'";
}else{
	$query_R = "SELECT * FROM areas";
}

$Record = mysqli_query($miConex, $query_R) or die(mysql_error());
?>
<select name="tt" class="form-control" size="1" id="tt" onchange="if((this.value) !='-1'){ verusuarios(this.value, <?php echo $_POST['idunidades']; ?>) }else{document.location='form-insertaraft.php';}"><?php
	if(isset($_POST['idunidades']) OR isset($_COOKIE['unidades'])){ ?>
		<option value="-1"><?php echo $plea8.substr($btAreas,0,-1);?></option><?php
			while ($row_R = mysqli_fetch_array($Record)) {
				if(($row_R['nombre']) !="Reparaciones"){ ?>
	<option value="<?php echo $row_R['idarea'];?>" <?php if((@$_POST['tt']) ==$row_R['idarea']){ echo "selected";}?>><?php echo $row_R['nombre']?></option>
	<?php
			    }
			} 
	} ?>
 </select>


