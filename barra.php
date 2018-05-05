<?php
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Informáticos)     					                                		           #
# Version:  3.0.1                                                     				                       #
# Fecha:    01/06/2016 - 03/04/2018                                             					                       #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################
require_once('connections/miConex.php');
$query_Recordset2 = "SELECT * FROM tipos_medios ORDER BY nombre";
$Recordset2 = mysqli_query($miConex, $query_Recordset2) or die(mysql_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$dage="select * from datos_generales where id_datos='".$_COOKIE['unidades']."'";
}else{
	$dage="select * from datos_generales";
}
$qdage=mysqli_query($miConex,$dage) or die(mysql_error());
$rdage=mysqli_fetch_array($qdage);
$us = mysqli_query($miConex, "select * from usuarios where login='".@$_SESSION["valid_user"]."' AND idunidades='".$rdage['id_datos']."'") or die(mysql_error());
$rus = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us);

$usx = mysqli_query($miConex, "select * from usuarios where login='".@$_SESSION["valid_user"]."'") or die(mysql_error());
$russx = mysqli_fetch_array($usx);
$nrusx=mysqli_num_rows($usx);
?>
<script type="text/javascript">
	function busca_tipo(frm){
		if((frm.palabra.value) != "-1"){
			frm.submit();
		}
		return false;
    }
</script>
<fieldset class="fieldset">
<form name="comp" method="post" action="registromedios1.php"><input type="hidden" name="palabra" value="COMPUTADORAS"></form>
<form name="imp" method="post" action="registromedios1.php"><input type="hidden" name="palabra" value="IMPRESORA"></form>
<form name="esc" method="post" action="registromedios1.php"><input type="hidden" name="palabra" value="ESCANNER"></form>
<form name="moni" method="post" action="registromedios1.php"><input type="hidden" name="palabra" value="MONITOR"></form>
<form name="vari" method="post" action="registromedios1.php"><input type="hidden" name="otras" value="VARIAS"></form>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
				  <td width="18%"><div align="center"><span><a href="#"><img onClick="javascript:document.comp.submit();" src="images/pc2.png" alt="Computadoras" width="36" height="32" border="0"/><span></span></a></div></td>
				  <td width="17%"><div align="center"><span><a href="#"><img onClick="javascript:document.imp.submit();" src="images/impresoras.png" alt="Impresoras" width="36" height="32" border="0"/><span></span></a></span></div></td>
				  <td width="18%"><div align="center"><span><a href="#"><img onClick="javascript:document.esc.submit();" src="images/scan.png" alt="Escanner y/o Fotocopiadoras" width="36" height="32" border="0"/><span></span></a></span></div></td>
				  <td width="17%"><div align="center"><span><a href="#"><img onClick="javascript:document.moni.submit();" src="images/monitores.png" alt="Monitores" width="50" height="36" border="0"/><span></span></a></span></div></td>
				  <td width="16%"><div align="center"><span><a href="#"><img onClick="javascript:document.vari.submit();" src="images/categoriasearch.png" alt="Ver Todos" width="36" height="32" border="0"/><span></span></a></span></div></td>
				</tr>
				
				<tr>
				  <td valign="top">
					<form action="registromedios1.php" method="post" name="tipocompu" id="tipocompu">
					    <div align="center">
					      <select name="palabra" id="palabra" class="imputf" onChange="return busca_tipo(this.form);">
					        <option value="-1"><?php echo @strtoupper($btpc);?>...</option>
						    <option value="Escritorio"><?php echo $pcescritorio;?></option>
					        <option value="PORT&Aacute;TIL"><?php echo $pcportatil;?></option>
					        <option value="Cliente Ligero"><?php echo $pccliente;?></option>
					        <option value="Servidor"><?php echo $pcservidor;?></option>
							<option value="Servidor NAS"><?php echo $pcservidorNAS;?></option>
				          </select>
					   	  <input name="in" type="hidden" value="i"/>
						  <input name="m" type="hidden"/>
			            </div>
				    </form>					</td>
					<td valign="top">
						<form action="registromedios1.php" method="post" name="tipoimpresora" id="tipoimpresora">
							<div align="center">
							  <select name="palabra" id="palabra" class="imputf" onChange="return busca_tipo(this.form);">
						        <option value="-1"><?php echo @strtoupper($btimp);?>...</option>
								<option value="Matricial">Matricial</option>
							    <option value="Laser">L&aacute;ser</option>
								<option value="Chorro">Chorro de tinta</option>
								<option value="T&eacute;rmica">T&eacute;rmica</option>
								<option value="3d">3D</option>
						      </select>
							<input name="m" type="hidden"/>
							<input name="in" type="hidden" value="i"/>
					      </div>
						</form>
					</td>
					<td valign="top">
						<form action="registromedios1.php" method="post" name="tipoescanner" id="tipoescanner">
							<div align="center">
							  <select name="palabra" id="palabra" class="imputf" onChange="return busca_tipo(this.form);">
							    <option value="-1"><?php echo strtoupper($btesc);?>...</option>
								<option value="DE MESA">Planos (de mesa)</option>
								<option value="DE TRAYECTORIA">De trayectoria</option>
								<option value="DE TAMBOR">De tambor</option>
						      </select>
							<input name="m" type="hidden"/>
					      </div>
						</form>					</td>
					<td valign="top">
						<form action="registromedios1.php" method="post" name="tipomonitor" id="tipomonitor">
							<div align="center">
							  <select name="palabra" id="palabra" class="imputf" onChange="return busca_tipo(this.form);">
    						     <option value="-1"><?php echo strtoupper($btmon);?>...</option>
								<option value="LCD">LCD</option>
								<option value="CRT">CRT</option>
								<option value="LED">LED</option>
						      </select>
							  <input name="m" type="hidden"/>
							  <input name="in" type="hidden" value="i"/>
						   </div>
						</form>					</td>
					<td valign="top">
						<form action="registromedios1.php" method="post" name="tipotodos" id="tipotodos">
							<div align="center">
							  <select name="palabra" id="palabra" class="imputf" onChange="return busca_tipo(this.form);">
							     <option value="-1"><?php echo strtoupper($bttipo);?>...</option>
								<?php
							do { ?>
							    <option value="<?php echo $row_Recordset2['nombre']?>"><?php echo $row_Recordset2['nombre']?></option>
							    <?php
							} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
							$rows = mysqli_num_rows($Recordset2);
							if($rows > 0) {
								mysqli_data_seek($Recordset2, 0);
								$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
							}	?>
						      </select>
							  <input name="m" type="hidden"/>
					      </div>
						</form>					</td>
				</tr>
</table>
</fieldset>



