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
include('script.php'); 
				if (isset($_POST['query_Re']) AND $_POST['query_Re']!="-1" ){				 
					$query_Re=@$_POST['query_Re'];
					$sql = "SELECT * FROM usuarios WHERE id_area ='".$query_Re."' ORDER By nombre ASC";
				}else{
				  $sql = "SELECT * FROM usuarios ORDER By nombre ASC";	
				}
				$Recordset1 = mysqli_query($miConex, $sql) or die(mysqli_error($miConex));
				//$row_Recordset1 = mysqli_fetch_array($Recordset1);
?>	
		<select name="custo" size="1" class="form-control" id="custo">
			 <option value="-1"><?php echo "--"; ?></option>
			<?php 
				while ($row_Recordset1 = mysqli_fetch_array($Recordset1)) { ?>
			     <option value="<?php echo $row_Recordset1['nombre']; ?>"><?php echo $row_Recordset1['nombre']; ?></option>	
				<?php } ?>				 
		</select> 

