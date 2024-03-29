<?php 
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Inform�ticos)     					                                		            #
# Version:  3.1.1                                                    				                        #
# Fecha:    24/03/2011 - 01/01/2023                                             					        #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			            #
#          	Msc. Carlos Pollan Estrada	(IN MEMORIAN)							         		            #
# Licencia: Freeware                                                				                        #
#                                                                       			                        #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                 #
# LICENCIA: Este archivo es parte de REGIMED. REGIMED es un software libre; Usted lo puede redistribuir y/o #
# lo puede modificar bajo los t�rminos de la Licencia P�blica General GNU publicada por la Fundaci�n de     #
# Software Gratuito (the Free Software Foundation ); Ya sea la versi�n 2 de la Licencia, o (en su opci�n)   #
# cualquier posterior versi�n. REGIMED es distribuido con la esperanza de que ser� �til, pero SIN CUALQUIER #
# GARANT�A; Sin a�n la garant�a impl�cita de COMERCIABILIDAD o ADAPTABILIDAD PARA UN PROP�SITO PARTICULAR.  #
# Vea la Licencia P�blica General del GNU para m�s detalles. Usted deber�a haber recibido una copia de la   #
# Licencia  P�blica General de GNU junto con REGIMED. En Caso de que No, vea <http://www.gnu.org/licenses>. #
#############################################################################################################
include('header.php');
include('script.php');
$validus = "";
if(isset($_SESSION["autentificado"])){
	$validus = " AND idunidades='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
}else{
	$validus = "";
}
$roo = $_SERVER['DOCUMENT_ROOT'];
$posicion = strripos($roo, "/");
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$ruta1 = $roo .$pht1."inspecciones/";
$ruta = substr($roo, 0, $posicion)."/tmp/"; 

$upload_extensions = array(".pdf", ".txt", ".rtf", ".doc", ".docx", ".odt",".PDF", ".TXT", ".RTF", ".DOC", ".DOCX", ".ODT"); 
		function mosChmodRecursive($path, $filemode=NULL, $dirmode=NULL){
			$ret = TRUE;

				if (isset($filemode))
					$ret = @chmod($path, $filemode);

			return $ret;
		}			
$us1 = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die();
$rus1 = mysqli_fetch_array($us1);
		$err=array();
	if(isset($_POST['inserta'])){	
		$fecha = @$_POST['fecha'];
		$estado = @$_POST['estado'];
		$obser = @$_POST['observ'];	
		$undd = $_POST['unidades'];		
		if(is_uploaded_file($_FILES['observ']['tmp_name'])){
			$get_ext = $_FILES['observ']['name']; 
			$ext = strrchr($get_ext,".");
			if (in_array($ext, $upload_extensions)) {
				$obser=$_FILES['observ']['name'];
				copy($_FILES['observ']['tmp_name'],$ruta.$_FILES['observ']['name']);
			}else{ ?>
				<script type="text/javascript">alert('El tipo de fichero no es permitido. Solo se aceptan .pdf, .txt, .rtf, .doc, .docx y .odt');</script><?php
			}
		}
		$in = "insert into inspecciones values(NULL,'".$fecha."','".$estado."','".$obser."','".$undd."')";
		$qin = mysqli_query($miConex, $in) or die(mysql_error());
		$nunomr= mysqli_insert_id($miConex);
		rename($ruta.$_FILES['observ']['name'],$ruta.$nunomr."_".$undd.$ext);
		copy($ruta.$nunomr."_".$undd.$ext,$ruta1.$nunomr."_".$undd.$ext);	
		@unlink($ruta.$nunomr."_".$undd.$ext);
		$in1 = "update inspecciones set observ = '".$nunomr."_".$undd.$ext."' where id='".$nunomr."'";
		$qin1 = mysqli_query($miConex, $in1) or die(mysql_error());		
		$chmod_report = "Los permisos del directorio y de los archivos no han sido cambiados.";
		$file=$ruta1.$nunomr."_".$undd;
		$filemode = 0777;
		$dirmode =0777;
		$chmodOk = TRUE;
		if (!mosChmodRecursive($file, 0777, 0777)) {
			$chmodOk = FALSE;
		}
		if ($chmodOk) {
		//	echo 'Permisos del directorio y de los archivos cambiados.';
		} else {
		//	echo 'Los permisos del directorio y de los archivos no han podido ser cambiados.<br />Cambia los permisos de los archivos y directorios manualmente.';
		}		
	}
	if(isset($_POST['ok'])){
		$fecha = $_POST['fecha'];
		$estado = $_POST['estado'];
		$observ = $_POST['observ1'];
		$undd = $_POST['unidades'];
		$h=0;
		foreach($_POST['id'] as $key){
			if(is_uploaded_file($_FILES['observ']['tmp_name'][$h])){
				$get_ext[$h] = $_FILES['observ']['name'][$h]; 
				$ext[$h] = strrchr($get_ext[$h],".");
				if (in_array($ext[$h], $upload_extensions)) {
					@unlink($ruta1.$observ[$h]);
					copy($_FILES['observ']['tmp_name'][$h],$ruta.$_FILES['observ']['name'][$h]);
					rename($ruta.$_FILES['observ']['name'][$h],$ruta.$key."_".$undd[$h].$ext[$h]);
					copy($ruta.$key."_".$undd[$h].$ext[$h],$ruta1.$key."_".$undd[$h].$ext[$h]);
					@unlink($ruta.$key."_".$undd[$h].$ext[$h]);
					$observ[$h]=$_FILES['observ']['name'][$h];
				}else{ $err[]=$_FILES['observ']['name'][$h]; }
			}
	
			$in = "update inspecciones set fecha = '".$fecha[$h]."', estado ='".$estado[$h]."', observ = '".$observ[$h]."' where id= '".$key."'";
			$qin = mysqli_query($miConex, $in) or die(mysql_error());
			$filemode = 0777;
			$dirmode =0777;
			$chmodOk = TRUE;
			
			if(isset($ext[$h]) and $ext[$h]!=""){
				if (!mosChmodRecursive($ruta1.$key."_".$undd[$h].$ext[$h], 0777, 0777)) {
					$chmodOk = FALSE;
				}
			
				if ($chmodOk) {
					//echo 'Permisos del directorio y de los archivos cambiados.';
				} else {
					//echo 'Los permisos del directorio y de los archivos no han podido ser cambiados.<br />Cambia los permisos de los archivos y directorios manualmente.';
				}
			}	
				$h++;
		}
	}
		if(isset($_POST['crash']) AND ($_POST['crash']) !=""){
		$marcado=$_POST['marcado'];
		foreach($marcado as $key){
			$sel = mysqli_query($miConex, "select * from inspecciones where id='".$key."'") or die(mysql_error());
			$rows = mysqli_fetch_array($sel);
			@unlink('inspecciones/'.$rows['observ']);
			$deletex = "delete from inspecciones where id='".$key."'";
			$deq = mysqli_query($miConex, $deletex) or die(mysql_error());
		} ?>
		<script type="text/javascript">document.location="insp.php";</script><?php
	}
$orga = array("COPEXTEL","DATAZUCAR");
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$query_RecUni = "SELECT * FROM datos_generales where id_datos='".$_COOKIE['unidades']."'";
}else{
	$query_RecUni = "SELECT * FROM datos_generales";
}
$RecUni = mysqli_query($miConex, $query_RecUni) or die(mysql_error());
$nuRecUni = mysqli_num_rows($RecUni);


?>
<style type="text/css">
	.email{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -37px;
	}
	.pdf{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -117px;
	}
	.exel{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -97px;
	}
	.printer{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -17px;
	}
</style>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>
<script language="JavaScript" >
// Check for a blank field
function cheqe() {
	// form validation check
	var formValid=false;
	var f = document.form1;
	if ( f.fecha.value == '' ) {
		alert('Por favor, debe escribir la Fecha');
		f.fecha.focus();
		formValid=false;
	} else	if ( f.estado.value == '' ) {
		alert('Por favor, debe escribir el Estado');
		f.estado.focus();
		formValid=false;
	} else if ( confirm('Son correctos los Datos?')) 
	  {	formValid=true;  }

	return formValid;
}
</script>

<?php include('barra.php');?>
<div id="buscad">
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo $registr5.$de.$btinsp1;?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
		</div><?php
		if(($total_filas) >1){  ?>
			<td><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
				<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
					<select name="unidades" id="unidades" class="boton" onchange="cambiaunidad(this.value,'insp.php');">
						<option value="-1"><?php echo $btmostrartodo1?></option><?php 
						while ($row1=mysqli_fetch_array($reado)){ ?>					
							<option value="<?php echo @$row1['id_datos'];?>" <?php if((@$row1['id_datos']) ==@$_COOKIE['unidades']){ echo "selected";}?>><?php echo @$row1['entidad'];?></option><?php
						} ?>
					</select>
					<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
					<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
					<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">			
				</form>
			</td><?php 
		} 
		if(!empty($err)){ ?>
			<div class="message" style="margin-left:121px;">
				<?php echo $no_scr1;
				foreach($err as $Err){
					echo "<b>".substr($Err.", ",0,-2)."</b>";
				} echo "&nbsp;".$no_exten; ?><br>
			</div><?php
		}
$e="";
	if(isset($_POST['editar'])){
		$marcado=$_POST['marcado']; ?>
		<form name="form1" method="post" action="" onsubmit="return cheqe();" enctype="multipart/form-data">          
			<table width="100%" border="0" align="center" >
			  <tr>      
			   <td colspan="2"></td>
			  </tr><?php
			  $r=0;
		foreach($marcado as $key){
			$sel = mysqli_query($miConex, "select * from inspecciones where id='".$key."'") or die(mysql_error());
			$rows = mysqli_fetch_array($sel);
			
			$sela = mysqli_query($miConex, "select * from datos_generales where id_datos='".$rows['idunidades']."'") or die(mysql_error());
			$rowsa = mysqli_fetch_array($sela);?>
			  <tr>
				<td><div align="right" class="contentheading"><?php echo $btdatosentidad3;?></div></td>
				<td colspan="2">
					<input name="unidades1[]" type="text"  value="<?php echo $rowsa['entidad'];?>" readonly class="imput" id="unidades1<?php echo $r;?>" size="35" maxlength="100">
					<input name="unidades[]" type="hidden"  value="<?php echo $rows['idunidades'];?>" id="unidades<?php echo $r;?>">
				</td>
			  </tr>
			  <tr>
				<td width="74"><div align="right" class="contentheading"><?php echo $Fecha; ?></div></td>
				<td colspan="2"><input name="fecha[]" type="text" class="imput" id="fecha<?php echo $r;?>" readonly onKeyPress="return acceptNum1(event);" size="12" maxlength="10" value="<?php echo $rows['fecha'];?>">
				<a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.getElementById('fecha<?php echo $r;?>'));return false;" hidefocus><img name="popcal" align="absmiddle" src="images/almana.png" width="25" height="22" border="0" title="" /></a></td>
			  </tr>
			  <tr>
				<td><div align="right" class="contentheading"><?php echo $btestado; ?></div></td>
				<td colspan="2">&nbsp;&nbsp;<select name="estado[]" size="1" class="imputf custom-select d-block w-100" id="estado<?php echo $r;?>"><?php
					//while ($rows = mysqli_fetch_array($sel)) {  ?>
						<option value="MV" <?php if(($rows['estado']) =='MV'){ echo "selected";}?>>Muy Vulnerable</option>
						<option value="V" <?php if(($rows['estado']) =='V'){ echo "selected";}?>>Vulnerable</option>
						<option value="NVCS" <?php if(($rows['estado']) =='NVCS'){ echo "selected";}?>>No Vulnerable C/S</option>
						<option value="NV" <?php if(($rows['estado']) =='NV'){ echo "selected";}?>>No Vulnerable</option>
				    <?php //} ?>
			    </select>
				</td>
			  </tr>
			  <tr>
				<td valign="top"><div align="right" class="contentheading"><?php echo $btOBSERVACIONES; ?></div></td>
				<td colspan="2">&nbsp;&nbsp;<input name="observ[]" id="observ<?php echo $r;?>" type="file">&nbsp;&nbsp;<?php if(($rows['observ']) !=""){ ?>Actual:&nbsp;(<b><?php echo $rows['observ'];?></b>)<?php } ?></td>
			  </tr>
				<tr><td colspan="2"><hr><input name="id[]" type="hidden" value="<?php echo $rows['id'];?>">
				<input name="observ1[]" type="hidden" value="<?php echo $rows['observ'];?>"></td></tr><?php $r++;
		}?>		
			  <tr>
			  <td colspan="2"><input name="ok" type="submit" class="btn" value="Guardar">
			    <input name="cancel" type="button" class="btn" onClick="javascript:document.location='insp.php';" value="<?php echo $btcancelar;?>"></td>
			  </tr><tr>
				<td colspan="2" align="right"><hr /></td>
			  </tr>	 
			</table>       
		</form><?php
	}

	if(isset($_POST['nuevo']) OR isset($_GET['nuevo'])){ ?>
	<script>
		function cambiaU(u){
			document.location='insp.php?u='+u+'&nuevo'
		}
	</script>
		<form name="form1" method="post" action="" onsubmit="return cheqe();" enctype="multipart/form-data">          
			<table width="60%" border="0" align="center" bgcolor="#FFFFFF"><?php
						if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){ ?>
						  <input name="unidades" type="hidden" id="unidades" value="<?php echo $_COOKIE['unidades'];?>"/><?php
						}else{ ?>
							<tr>
								<td width="74"><div align="right" class="contentheading"><?php if(($nuRecUni) >1){ echo $btdatosentidad2;}else{ echo $btdatosentidad3;}?></div></td>
								<td>
									<select name="unidades" class="boton" id="unidades" onChange="cambiaU(this.value);"><?php
										while ($row_Uni = mysqli_fetch_array($RecUni)){ ?>
											<option value="<?php echo $row_Uni['id_datos'];?>" <?php if(($row_Uni['id_datos']) ==@$_GET['u']){ echo "selected";} ?>><?php echo $row_Uni['entidad'];?></option><?php
										} ?>
									</select>
								</td>
						  </tr><?php 
						} ?>			  <tr>      
			  <td colspan="2"></td>
			  </tr>
			  <tr>
				<td width="74"><div align="right" class="contentheading"><?php echo $Fecha; ?></div></td>
				<td colspan="2"><input name="fecha" type="text" class="boton" id="fecha" readonly onKeyPress="return acceptNum1(event);" size="12" maxlength="10">
				<a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.getElementById('fecha'));return false;" hidefocus><img name="popcal" align="absmiddle" src="images/almana.png" width="25" height="22" border="0" title="" /></a></td>
			  </tr>
			  <tr>
				<td><div align="right" class="contentheading"><?php echo $btestado; ?></div></td>
				<td colspan="2"><input name="estado" type="text" class="boton" id="estado" size="35" maxlength="100"></td>
			  </tr>
			  <tr>
				<td valign="top"><div align="right" class="contentheading"><?php echo $obser;?></div></td>
				<td colspan="2"><input name="observ" id="observ" class="boton" type="file"></td>
			  </tr>
			  <tr>
			  <td colspan="2"><input name="inserta" type="submit" class="btn" value="Guardar">
			    <input name="cancel" type="button" class="btn" onClick="javascript:document.location='insp.php';" value="<?php echo $btcancelar;?>"></td>
			  </tr><tr>
				<td colspan="2" align="right"><hr /></td>
			  </tr>	 
			</table>       
		</form>	  <?php 		
	} 
$qusua = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION['valid_user']."'") or die(mysql_error());
$rusua = mysqli_fetch_array($qusua);
if(isset($_GET['palabra'])){ $palabra = $_GET['palabra'];}

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
if((@$rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
///////navegador
		$inicio = 0;
		$pagina = 1;
		$registros = $cuantos;
	if(isset($_GET["registros"])) {
		$registros = $_GET["registros"];
		$inicio = 0;
		$pagina = 1;
	}
	if(isset($_GET['pagina']))  {
		$pagina=$_GET['pagina'];
		$inicio = ($pagina - 1) * $registros;
	}
	if(isset($_GET["mostrar"])) {
		$registros = $_GET["mostrar"];
		if(($registros) ==0){ $registros=1;}
		$inicio = 0;
		$pagina = 1;
	}
// SQL para la b�squeda
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$sql = "select * from inspecciones where idunidades='".$_COOKIE['unidades']."'";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
		}else{
			$sql = "select * from inspecciones";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);		
		}
		$result= mysqli_query($miConex, $query_limit) or die(mysql_error());
	
		
//NAVEGADOR inicio
	if(isset($_GET['total_registros'])){
		$total_registros=$_GET['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
	$ggg=base64_encode($sql);
//NAVEGADOR	FIN
if(!isset($_POST['nuevo']) AND !isset($_POST['editar'])  AND !isset($_GET['nuevo'])){ 
	if (($total_registros) !=0){ ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
				<td width="788"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
					<form name="mst" method="get" action="" id="mst">
					<span><?php echo $cantidadmost;?>:</span>
					<span style="position: absolute; margin-left: 0%; margin-top: -11px;">
	       				<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
						<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
						<input name="mostrar" id="vers" type="text" maxlength="3" value="<?php if (!isset($_REQUEST['mostrar'])) { if ($rowsp['visitas']>$total_registros) { echo $total_registros; }else{ echo $registros; } }else{ if ($_REQUEST['mostrar']>$total_registros) { echo $total_registros; }else{ echo $_REQUEST['mostrar'];} if($_REQUEST['mostrar']<1) { echo "1"; } } ?>" onKeyPress="return acceptNum(event);" class="mostrar" readonly>
						<img src="images/search.png" style="cursor:pointer; top: 4px; position: relative;" onclick="document.mst.submit();">
					</span>	
						<input name="pagina" type="hidden" value="<?php echo $pagina;?>">
						<input name="mo" type="hidden" value="<?php echo $btver;?>" class="btn4">
						<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
						<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
						<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
				    </form></div>
				</td>
				<td width="14%">
	  				<div id="imprime" style="margin: 0px 65px;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><?php 
							if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
							  <td class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=inspecciones&gt=insp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($s_email);?></span></a></td><?php
							} ?>
							  <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=inspecciones">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
							  <td class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=inspecciones" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
							</tr>
						 </table>	
					</div>
				</td>
			</tr>
		</table>
	 
	  <form name="frm1" method="post" action="">
		<table width="100%" BORDER='0' align="center" cellpadding="0" cellspacing="0"  class="table"> 
	         <tr class="vistauser1">
				<td width="20"><?php if (($rus['tipo']) =="root") { ?>
					<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php } ?>
				</td>
				<td width="92"><span class="Estilo4"><?php echo strtoupper($Fecha);?></span></td>
				<td width="109"><span class="Estilo4"><?php echo strtoupper($btestado);?></span></td>
				<td width="127"><span class="Estilo4"><?php echo $btORIGEN;?></span></td>
				<td width="144"><span class="Estilo4"><?php echo $btAreas1;?></span></td>
				<td width="231" align="left"><span class="Estilo4"><?php echo $btRESULTADOS;?></span></td> 
		        <td width="218" align="left"><span class="Estilo4"><?php echo $btdatosentidad3;?></span></td>
	        </tr><?php
		$i=0;
		$p=0;
		while ($row=mysqli_fetch_array($result)){ $i++;
			$seentid=mysqli_query($miConex, "select entidad from datos_generales where id_datos='".$row["idunidades"]."'") or die();
			$rseentid=mysqli_fetch_array($seentid);?>
			<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')">
				<?php if (($rus['tipo']) =="root"){ ?>
				<td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;" >&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none; cursor:pointer;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff');" value="<?php echo $row['id']; ?>" /></td><?php } ?>
				<td><?php echo $row["fecha"];?></td> 
				<td><?php echo $row["estado"];?></td>
				<td><?php echo $row["origen"];?></td>
				<td><?php echo $row["area"];?></td>
				<td><a href="inspecciones/<?php echo $row["observ"];?>" target="_blank"><?php echo $click1.$descarg;?></a></td>
			    <td><?php echo $rseentid["entidad"];?></td>
			</tr><?php $p++;
			
		} ?>
		
	<?php
		if (($rus['tipo']) =="root"){ ?>
			
			  <tr> 
				<td colspan="7" class="Estilo2">
					<input name="create" id="create-user" type="button" class="btn" onClick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
					<input type="hidden" name="crash">&nbsp;&nbsp;					
			  		<input name="editar" type="submit" id="<?php echo $bteditar;?>" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" class="btn" value="<?php echo $bteditar;?>">&nbsp;&nbsp;
					<input name="nuevo" type="button" id="nuevo" value="<?php echo $btinsertar;?>" class="btn"  onclick="document.location='form-insertarinsp.php';">
				</td>
			  </tr>
			<?php
		} ?>
		</table>
	  </form>
<br>  
		<?php include('navegador.php');
	}else{ ?><table align="center" width="70%" border="0" cellspacing="2" cellpadding="2">
					<tr> 
						<td align="center">
							<br><div align="center"><div class="message" align="center"><?php echo $noregitro3.$btinsp;?></div></div><br><?php 
							if((@$rus1["tipo"]) =="root"){ ?>
								<input name="sal" id="sal" type="button" class="btn" value="<?php echo $btinsertar;?>" onclick="javascript:document.location='form-insertarinsp.php';"><?php	
							} ?>
						</td>
					</tr>
				 </table><?php } ?>
				 
<?php }?>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<iframe width="174" height="189" name="gToday:normal2:agenda1.js" id="gToday:normal2:agenda1.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe>
