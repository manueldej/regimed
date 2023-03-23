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
$h="";
require_once('connections/miConex.php');
$i = "es";
 	 if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){@$i="es"; }else{@$i="en";}
	}
	if((@$i) =="es"){include('esp.php');} else { include('eng.php');}
	if(isset($_GET['ent'])){ 
		$h = $_GET['ent'];
		$miConex1 = mysqli_query($miConex, "delete from datos_generales where id_datos='".$h."'") or die(mysql_error()); ?>
		<script type="text/javascript">document.cookie = "unidades=1;";</script><?php
	}
 	if(isset($_GET['entidad'])){ 
		$entidad = $_GET['entidad'];
		$sector = $_GET['sector'];
		$smtp = $_GET['smtp'];
		$web = $_GET['web'];
		$mailent = $_GET['mail'];
		$NombreAdmin = $_GET['NombreAdmin'];
		$LoginAdmin = $_GET['LoginAdmin'];
		$PassAdmin = $_GET['PassAdmin'];
		$sex = $_GET['sex'];
		$prov = $_GET['provincia'];
		$reup = $_GET['reup']; 
		$sql = "SET FOREIGN_KEY_CHECKS=0;";
		mysqli_query($miConex, $sql) or die(mysql_error());
		
		$guarda = "insert into datos_generales (entidad,sector,smtp,codigo,web,mail,provincia) values('".htmlentities($entidad)."', '".$sector."', '".$smtp."', '".$reup."', '".$web."', '".$mailent ."', '".htmlentities($prov)."')";
		$result = mysqli_query($miConex, $guarda) or die (mysql_error()); 
		$ultimoid = mysqli_insert_id($miConex);
		$sql="INSERT INTO `areas` (`idarea`, `nombre`, `teclado`, `switch`, `router`, `modem`, `computadoras`, `adaptadores`, `monitor`, `ploter`, `mouse`, `impresora`, `escanner`, `fotocopiadora`, `camara`, `memorias`, `ups`, `pinza`, `bocinas`, `idunidades`) VALUES (NULL,'Reparaciones', '0', '0', '0','0','0','0','0','0','0','0','0','0','0', '0','0','0','0','".$ultimoid."');";
		mysqli_query($miConex, $sql) or die(mysql_error());	
		$sql="INSERT INTO `areas` (`idarea`, `nombre`, `teclado`, `switch`, `router`, `modem`, `computadoras`, `adaptadores`, `monitor`, `ploter`, `mouse`, `impresora`, `escanner`, `fotocopiadora`, `camara`, `memorias`, `ups`, `pinza`, `bocinas`, `idunidades`) VALUES (NULL, 'Inform&aacute;tica', '0', '0', '0','0','0','0','0','0','0','0','0','0','0', '0','0','0','0','".$ultimoid."')";
		mysqli_query($miConex, $sql) or die (mysql_error());
		$ultimoidA = mysqli_insert_id($miConex);
		$sql1="INSERT INTO `usuarios` (`id`,`id_area`,  `nombre`, `login`, `passwd`, `email`, `cargo`, `tipo`, `idarea`, `sexo`, `idunidades`) VALUES (null,'".$ultimoidA."','".htmlentities($NombreAdmin)."', '".$LoginAdmin."', '".base64_encode($PassAdmin)."', '".$mailent."', '".'Inform&aacute;tico'."', 'usuario', '".'Inform&aacute;tica'."','".$sex."','".$ultimoid."')";
		mysqli_query($miConex, $sql1) or die (mysql_error());	
		
		$sql = "SET FOREIGN_KEY_CHECKS=1;";
		mysqli_query($miConex, $sql) or die(mysql_error());
	}
 $cons="Select * from datos_generales";
  $resulta = mysqli_query($miConex, $cons);
  $existenciadt = mysqli_num_rows($resulta);?>
  		<script type="text/javascript" src="ajax.js"></script>
		<script type="text/javascript">
			function novax(){
				document.getElementById('crpo').style.display='none';
				document.getElementById('nova').style.display='block';
			}
			function novax1(){
				document.getElementById('crpo').style.display='block';
				document.getElementById('nova').style.display='none';
			}
		</script>
<fieldset class='fieldset'>
		<legend class="vistauserx"><?php echo $btdatosentidad2."--> ".$btdatabase.":&nbsp;<font color=red>".$database_miConex."</font>";?></legend>
		<table width="100%" border="0" align="center" class="table">
		  <form id="frm_entidad" name="frm_entidad" method="post" action="configura.php" enctype="multipart/form-data" >
		  <tr>
			<td colspan="2"><b><?php echo $Opciones;?></b></td>
		  </tr><?php
		  while($vale = mysqli_fetch_array ($resulta)){
			$iddentid=$vale['id_datos']; ?>
		  <tr>
			<td width="99%"><div align="left" onmouseover="this.style.cursor='pointer';" title="<?php echo $mostrar6." ".$Opciones.": ". $vale['entidad'];?>"><span onclick="muestraentidad('<?php echo $iddentid;?>');"><?php echo $vale['entidad'];?></span> &nbsp;&nbsp;&nbsp;<?php if(($existenciadt) >1 AND ($vale['id_datos']) ==1){ ?><img align="absmiddle" src="images/fusionar.png" name="fusionar" width="24" height="17" border="0" id="fusionar" title="<?php echo $btfusionar;?>" onClick="window.parent.location='configura.php?fus=<?php echo $vale['id_datos'];?>';" onMouseOver="this.style.cursor='pointer';"><?php }else{ ?><img align="absmiddle" src="images/fusionaroff.png" name="fusionar" width="24" height="17" border="0" id="fusionar" title="<?php echo $btfusionar;?>"><?php } ?> &nbsp;&nbsp;&nbsp;<img onclick="window.parent.location='configura.php?mc=<?php echo $vale['id_datos'];?>';" title='<?php echo $stmodificar." ".$vale['entidad'];?>' style='cursor:pointer' src='images/txt.png' width='15' height='15' align='absmiddle' /><?php if(($vale['id_datos']) !='1'){ ?>&nbsp;&nbsp;&nbsp;<img onclick="if(confirm('<?php echo $cuidado;?>')){ delentidad('<?php echo $vale['id_datos'];?>');}" title='<?php echo $steliminar1." ".$vale['entidad'];?>' style='cursor:pointer' src='images/quitar.png' width='15' height='15' align='absmiddle' /><?php } ?></div></td>			
		  </tr>
		  <?php
		  } ?>
		  <tr>
			<td colspan="2"><br>&nbsp;&nbsp;&nbsp;<input name="nuevaentidad" type="button" class="btn" id="nuevaentidad" onMouseOVer="this.style.cursor='pointer';" onclick="novax(); " value="<?php echo $n_entidad;?>" />
			</td>
		  </tr>
</form>
		</table><hr>
		<div id="muestraent"></div>
</fieldset>
