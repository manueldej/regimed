<?php
/********************************************************************************************
* Software: Seguridad                                                                       * 
*(Registro de Medios Informáticos)     					                         			*
* Version:  2.0                                                     				        *
* Fecha:    01/06/2013                                             					        *
* Autores:  Lic. Manuel de Jesús Núñez Guerra   											*
*          	Msc. Carlos Pollan Estrada														*
* Licencia: Freeware                                                				        *
*                                                                       				    *
* Usted puede usar y modificar este software si asi lo desee, pero debe mencionar la fuente *
*********************************************************************************************/
require_once('../../connections/miConex.php');

$query_Recordset2 = "SELECT * FROM tipos_medios ORDER BY id";
$Recordset2 = mysqli_query($miConex, $query_Recordset2) or die(mysql_error());
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$dage="select * from datos_generales where id_datos='".$_COOKIE['unidades']."'";
}else{
	$dage="select * from datos_generales";
}
$qdage=mysqli_query($miConex, $dage) or die(mysql_error());
$rdage=mysqli_fetch_array($qdage);
$us = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."' AND idunidades='".$rdage['id_datos']."'") or die(mysql_error());
$rus = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us);
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
<form name="comp" method="post" action="../../registromedios1.php"><input type="hidden" name="palabra" value="COMPUTADORAS"></form>
<form name="imp" method="post" action="../../registromedios1.php"><input type="hidden" name="palabra" value="IMPRESORA"></form>
<form name="esc" method="post" action="../../registromedios1.php"><input type="hidden" name="palabra" value="ESCANNER"></form>
<form name="moni" method="post" action="../../registromedios1.php"><input type="hidden" name="palabra" value="MONITOR"></form>
<form name="vari" method="post" action="../../registromedios1.php"><input type="hidden" name="otras" value="VARIAS"></form>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
				  <td></td>
				  <td width="18%" rowspan="2"><div align="center"><span class="Estilo5"><a href="#" class="tooltip"><img onMouseOver="this.style.cursor='pointer';" onClick="javascript:document.comp.submit();" src="../../images/pc.jpg" alt="Computadoras" width="36" height="32" border="0"/><span onMouseOver="this.style.cursor='pointer';"><?php echo $btmostrarpc;?>...</span></a></span></div></td>
				  <td width="17%" rowspan="2"><div align="center"><span class="Estilo5"><a href="#" class="tooltip"><img onMouseOver="this.style.cursor='pointer';" onClick="javascript:document.imp.submit();" src="../../images/impresoras.png" alt="Impresoras" width="36" height="32" border="0"/><span onMouseOver="this.style.cursor='pointer';"><?php echo $btmostrarimp;?>...</span></a></span></div></td>
				  <td width="18%" rowspan="2"><div align="center"><span class="Estilo5"><a href="#" class="tooltip"><img onMouseOver="this.style.cursor='pointer';" onClick="javascript:document.esc.submit();" src="../../images/scan.jpg" alt="Escanner y/o Fotocopiadoras" width="36" height="32" border="0"/><span onMouseOver="this.style.cursor='pointer';"><?php echo $btmostraresc;?>...</span></a></span></div></td>
				  <td width="17%" rowspan="2"><div align="center"><span class="Estilo5"><a href="#" class="tooltip"><img onMouseOver="this.style.cursor='pointer';" onClick="javascript:document.moni.submit();" src="../../images/mycomputer.png" alt="Monitores" width="36" height="32" border="0"/><span onMouseOver="this.style.cursor='pointer';"><?php echo $btmostrarmon;?>...</span></a></span></div></td>
				  <td width="16%" rowspan="2"><div align="center"><span class="Estilo5"><a href="#" class="tooltip1"><img onMouseOver="this.style.cursor='pointer';" onClick="javascript:document.vari.submit();" src="../../images/categoriasearch.png" alt="Ver Todos" width="40" height="40" border="0"/><span onMouseOver="this.style.cursor='pointer';"><?php echo $btmostrarall;?>...</span></a></span></div></td>
				</tr>
				<tr>
				  <td width="14%" rowspan="2"><br><div class="btn-group">
							<?php 
								if(($rus['tipo']) =="root"){ ?>
										<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/opciones.png" style="cursor:pointer" width="20" height="20">&nbsp;&nbsp;<?php echo $bthmtas;?><span class="caret"></span></a>
										 <ul class="dropdown-menu">
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataReg, 'Registros')"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/registro.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $btrecords;?></a><ul class="dropdown-menu subReg">...</ul></li>
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataApp, 'Aplicaciones')"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/txt.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $Codificadores;?></a><ul class="dropdown-menu subApp">...</ul></li>
											<li class="dropdown"><a tabindex="-1" href="../../configura.php?p=p"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/icon-tools.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $Preferencias;?></a></li>
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataProd, 'Otros')"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/setting.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $bthmtas;?></a><ul class="dropdown-menu subProd">...</ul></li>
											<li class="dropdown"><a tabindex="-1" href="../../configura.php?p=d"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/datos.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $Opciones;?></a></li>
										</ul><?php
									}elseif(($_SESSION ["valid_user"]) =="invitado"){ ?>
										<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/icon-tools.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $bthmtas;?><span class="caret"></span></a>
										 <ul class="dropdown-menu">
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataReg, 'Registros')"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/txt.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $btrecords;?></a><ul class="dropdown-menu subReg">...</ul></li>
										</ul><?php
									}else{ ?>
										<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/icon-tools.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $bthmtas;?><span class="caret"></span></a>
										 <ul class="dropdown-menu">
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataReg, 'Registros')"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/registro.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $btrecords;?></a><ul class="dropdown-menu subReg">...</ul></li>
											<li class="dropdown-submenu"><a tabindex="-1" href="javascript:showCategorias(dataApp, 'Aplicaciones')"><img border="0" align="absmiddle" class="metadata-icon" src="../../images/txt.png" style="cursor:pointer" width="14" height="14">&nbsp;&nbsp;<?php echo $Codificadores;?></a><ul class="dropdown-menu subApp">...</ul></li>
										</ul><?php
									} ?>
				  </div>					</td>
				</tr>
				<tr>
				  <td valign="top">
					  <form action="../../registromedios1.php" method="post" name="tipocompu" id="tipocompu">
					    <div align="center">
					      <select name="palabra" id="palabra" class="boton" onChange="return busca_tipo(this.form);">
					        <option value="-1"><?php echo $bttipo;?>s...</option>
						    <option value="Escritorio"><?php echo $pcescritorio;?></option>
					        <option value="Portatil"><?php echo $pcportatil;?></option>
					        <option value="Cliente Ligero"><?php echo $pccliente;?></option>
					        <option value="Servidor"><?php echo $pcservidor;?></option>
				          </select>
					   	  <input name="in" type="hidden" value="i"/>
						  <input name="m" type="hidden"/>
			            </div>
				  </form>					</td>
					<td valign="top">
						<form action="../../registromedios1.php" method="post" name="tipoimpresora" id="tipoimpresora">
							<div align="center">
							  <select name="palabra" id="palabra" class="boton" onChange="return busca_tipo(this.form);">
						        <option value="-1"><?php echo $bttipo;?>...</option>
								<option value="Matricial">Matricial</option>
							    <option value="Laser">Laser</option>
						      </select>
							<input name="m" type="hidden"/>
					      </div>
						</form>					</td>
					<td valign="top">
						<form action="../../registromedios1.php" method="post" name="tipoescanner" id="tipoescanner">
							<div align="center">
							  <select name="palabra" id="palabra" class="boton" onChange="return busca_tipo(this.form);">
							    <option value="-1"><?php echo $bttipo;?>...</option>
								<option value="ESCANNER">Escanner</option>
							    <option value="Fotocopiadora"><?php echo $fotocopia;?></option>
							    <option value="Ploter">Ploter</option>
								<option value="Fax">Fax</option>
						      </select>
							<input name="m" type="hidden"/>
					      </div>
						</form>					</td>
					<td valign="top">
						<form action="../../registromedios1.php" method="post" name="tipomonitor" id="tipomonitor">
							<div align="center">
							  <select name="palabra" id="palabra" class="boton" onChange="return busca_tipo(this.form);">
    						     <option value="-1"><?php echo $bttipo;?>...</option>
								<option value="LCD">LCD</option>
								<option value="Tubo"><?php echo $tubo;?></option>
								<option value="LED">LED</option>
						      </select>
							  <input name="m" type="hidden"/>
						   </div>
						</form>					</td>
					<td valign="top">
						<form action="../../registromedios1.php" method="post" name="tipotodos" id="tipotodos">
							<div align="center">
							  <select name="palabra" id="palabra" class="boton" onChange="return busca_tipo(this.form);">
							     <option value="-1"><?php echo $bttipo;?>...</option>
								<?php
							do { ?>
							    <option value="<?php echo $row_Recordset2['nombre']?>"><?php echo $row_Recordset2['nombre']?></option>
							    <?php
							} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
							$rows = mysqli_num_rows($Recordset2);
							if($rows > 0) {
								mysql_data_seek($Recordset2, 0);
								$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
							}	?>
						      </select>
							  <input name="in" type="hidden" value="i"/>
							  <input name="m" type="hidden"/>
					      </div>
						</form>					</td>
				</tr>
</table>
</fieldset>



