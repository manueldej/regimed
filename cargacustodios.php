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
	
	if (isset($_POST['adestino']) AND ($_POST['adestino'] !="")){
		$aftt .= " WHERE idarea='".base64_decode($_POST['adestino'])."' AND idunidades='".base64_decode($_POST['uni'])."'";
	}
	$query_Recordset4= "SELECT * FROM usuarios".$aftt;
	$Recordset1 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error($miConex));
	$af="";
	
	if(isset($_POST['af'])){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$af .= " WHERE (inv = '".$_POST['af']."') AND (idunidades='".$_COOKIE['unidades']."')";
		}else{
			$af .= " WHERE (inv = '".$_POST['af']."')";
		}
	}else{
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$af .= " WHERE (idunidades='".$_COOKIE['unidades']."')";
		}
	}
$query_Recordset1s = "SELECT * FROM aft ".$af." order by inv";
$Recordset1s = mysqli_query($miConex, $query_Recordset1s) or die(mysql_error($miConex));
$rocue = mysqli_fetch_array($Recordset1s);
$custodiod = $rocue['custodio'];?>
 	<tr>
		<td>
<?php	
	if(isset($_POST["adestino"])){
		if((base64_decode($_POST["adestino"])) !="Reparaciones"){ ?>
			<select class="combo_box" name="custodio" size="1" id="custodio"><?php
			    while ($row_Recordset4 = mysqli_fetch_array($Recordset1)) {  ?>
					<option value="<?php echo $row_Recordset4['nombre']?>" <?php if(isset($_POST['custo'])){ if((base64_decode($_POST['custo'])) ==$row_Recordset4['nombre']){ echo "selected"; }	}?>><?php echo $row_Recordset4['nombre']?></option><?php
				} ?>
			</select><?php 
		}else{ 
		    echo '<input type="hidden" class="imput" name="custodio" readonly id="sireparar" value="'.$custodiod.'">';}
		}
 ?>
	    </td>
	</tr>
 
