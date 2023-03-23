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
include('header.php'); 
include('script.php');
require("mensaje.php");
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
$es="";
	if(isset($_GET['es'])){ $es=$_GET['es']; }
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
include('barra.php'); ?>

<div id="buscad"> <?php

$e="";
	if(isset($_POST['crash']) AND ($_POST['crash']) !=""){
		@$marcado = @$_POST['marcado'];
		$lin = $_POST['link'];
			if((@$marcado) ==""){ 
			  echo "<br><br>";
			  show_message($strerror,$plea1.$bteliminar.".","cancel","res.php");  			?>
			    <br><br><div id="footer" class="degradado" align="center">
				    <div class="container">
					    <p class="credit"><?php include ("version.php");?></p>
				    </div>
			    </div><?php
			  exit;
			} 
		for($k=0; $k<count($marcado); $k++){
			$seldo = "select * from resoluciones where id='".$marcado[$k]."'";
			$qseldo = mysqli_query($seldo) or die(mysql_error());
			$rseldo = mysqli_fetch_array($qseldo);
			@unlink("res/".$rseldo['link']);
			
			$delm = "delete from resoluciones where id='".$marcado[$k]."'";
			$qdelm = mysqli_query($delm) or die(mysql_error());
		} ?>
		<script type="text/javascript">document.location='res.php';</script>;<?php
	}
	if(isset($_POST['quitarf'])){
		$marcado = @$_POST['marcado'];
		$lin = $_POST['link'];
			if((@$marcado) ==""){ 
			  echo "<br><br>";
			  show_message($strerror,$plea1.$quit.".","cancel","res.php");  			?>
			    <br><br><div id="footer" class="degradado" align="center">
				    <div class="container">
					    <p class="credit"><?php include ("version.php");?></p>
				    </div>
			    </div><?php
			  exit;
			}
		for($k=0; $k<count($marcado); $k++){
			$seldo = "select * from resoluciones where id='".$marcado[$k]."'";
			$qseldo = mysqli_query($seldo) or die(mysql_error());
			$rseldo = mysqli_fetch_array($qseldo);
			@unlink("res/".$rseldo['link']);

			$delpv = "update resoluciones set tiene= 'n' where id='".$marcado[$k]."'";
			$qdelmv = mysqli_query($delpv) or die(mysql_error());
		}?>
		<script type="text/javascript">document.location='res.php';</script> <?php
	}
	if(isset($_POST['edit'])){
			$marcado = @$_POST['marcado'];
			$marca="";
			if((@$marcado) ==""){ 
			  echo "<br><br>";
			  show_message($strerror,$plea1.$bteditar.".","cancel","res.php");  			?>
			    <br><br><div id="footer" class="degradado" align="center">
				    <div class="container">
					    <p class="credit"><?php include ("version.php");?></p>
				    </div>
			    </div><?php
			  exit;
			}
			foreach($marcado AS $key){
				$marca .= "*".$key; 
			}
		$orga = array("MININT","MINAZ","MFP","MINBAS","SIME","CITMA","MITRANS","MINFAR","MINCULT","MIC","EMPRESA");

			$marcado = $marca;
			$marcado = explode('*',$marcado); ?>
		<fieldset class="fieldset"><legend class="vistauserx">Editar Resoluci&oacute;n</legend>
			<form action="" method="post" enctype="multipart/form-data" name="form1x">
				<table width="100%" border="0" cellspacing="2" cellpadding="2">	<?php 		
					$k=0;
					foreach($marcado AS $k1){
						if(($k1) !=""){
							$delm1 = "select * from resoluciones where id='".$k1."'";
							$qdelm1 = mysqli_query($delm1) or die(mysql_error());
							$rdelm1 = mysqli_fetch_array($qdelm1);
							?>
							<tr> 
								<td width="15%" align="right"><strong>Fichero Actual:</strong></td>
							  <td width="85%"><?php if(($rdelm1['tiene']) =="s"){ echo "<b><font color='red'>".$rdelm1['link']."</font></b>";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;
								<input class="imput" type="file" name="quy1[]" id="quy1<?php echo $k;?>"/>						  </td>
							</tr>
							<tr> 
								<td align="right"><strong>T&iacute;tulo:</strong></td>
								<td><input name="titulo[]" type="text" class="imput" id="titulo[]" value="<?php echo $rdelm1['titulo'];?>" size="40"></td>
							</tr>
							<tr> 
							<td height="39" align="right" valign="top"><strong>Descripci&oacute;n:</strong></td>
								<td><textarea name="descripcion[]" cols="50" rows="2" class="imput" id="descripcion[]"><?php echo $rdelm1['descripcion'];?></textarea></td>
							</tr>
							<tr>
							  <td align="right"><strong>Fecha:</strong></td>
							  <td><input name="fecha[]" class="imput" id="fecha<?php echo $k;?>"  value="<?php echo $rdelm1['fecha'];?>" size="23" maxlength="10" /> 
							  <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.getElementById('fecha<?php echo $k;?>'));return false;" hidefocus="hidefocus"><img src="images/almana.png" name="popcal" width="25" height="22" border="0" align="absmiddle" id="popcal" title="fecha<?php echo $k;?>" /></a></td>
							</tr>
							<tr>
								<td align="right"><strong>&Oacute;rgano Emisor:</strong></td>
								<td>
									<select name="organo[]" class="boton" id="organo[]"><?php 					
									$d=0;
									while($d< count($orga)){ ?>
										<option value="<?php echo $orga[$d];?>" <?php if(($rdelm1['organo']) ==$orga[$d]){ echo "selected";}?>><?php echo $orga[$d];?></option><?php 
										$d++;
									} ?>
								  </select>							</td>
							</tr>
							<tr> 
								<td colspan="2">
									<input name="id[]" type="hidden" value="<?php echo $rdelm1['id'];?>">
									<input name="link[]" type="hidden" value="<?php echo $rdelm1['link'];?>">
									<input name="tiene[]" type="hidden" value="<?php echo $rdelm1['tiene'];?>"><hr>							</td>
							</tr>	<?php 
							$k++;
						}
					} ?>
					<tr> 
						<td align="right"></td>
						<td><input type="button" name="cancel" value="<?php echo $btcancelar;?>" onclick="document.location='res.php';" class="btn">&nbsp;<input type="submit" name="editado" value="<?php echo $btaceptar;?>" class="btn"></td>
					</tr>
				</table>
			</form>
			<br>
			<div id="footer" class="degradado" align="center">
				<div class="container">
					<p class="credit"><?php include ("version.php");?></p>
				</div>
			</div>
		</fieldset>
		<iframe width="174" height="189" name="gToday:normal1:agenda1.js" id="gToday:normal1:agenda1.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe><?php 		
	}
		$upload_extensions = array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT");	
		if(isset($_POST['editado'])){
			$id = $_POST['id'];
			$titulo = $_POST['titulo'];
			$descripcion = $_POST['descripcion'];
			$fecha = $_POST['fecha'];
			$organo = $_POST['organo'];
			$link = $_POST['link'];
			$tiene = $_POST['tiene'];
				
			for($k=0;$k<count($id); $k++){
				if(is_uploaded_file($_FILES['quy1']['tmp_name'][$k])) {
					@copy($_FILES['quy1']['tmp_name'][$k],"res/".$_FILES['quy1']['name'][$k]);
					$li[$k] =  $_FILES['quy1']['name'][$k];
					$upload_ext[$k] = strrchr($li[$k],".");
					if (in_array($upload_ext[$k], $upload_extensions)) {		
						$li[$k] = $_FILES['quy1']['name'][$k];
						$tiene[$k] = "s";
						@unlink("res/".$link[$k]);
					}else{	  
						@unlink("res/".$li[$k]);
					}
					$link[$k] = $li[$k];
				}
				if(($link[$k]) ==""){
					$vsa = "select link from resoluciones where id='".$id[$k]."'";
					$vs = mysqli_query($vsa) or die(mysql_error());
					$rvs = mysqli_fetch_array($vs);
					@unlink("res/".$rvs['link']); 
					$tiene[$k] = "n";
					$link[$k] = "";
				}
				$delp = "update resoluciones set titulo = '".$titulo[$k]."', descripcion = '".$descripcion[$k]."', fecha= '".$fecha[$k]."',organo= '".$organo[$k]."', tiene= '".$tiene[$k]."', link= '".$link[$k]."' where id='".$id[$k]."'";
				$qdelm = mysqli_query($delp) or die(mysql_error());
				
				rename("res/".$link[$k],"res/".$id[$k].$upload_ext[$k]);
				$inreup = "update resoluciones set link='".$id[$k].$upload_ext[$k]."' where id='".$id[$k]."'";		
				$qinreup = mysqli_query ($inreup,$miConex) or die(mysql_error());
			} ?>
			<script type="text/javascript">document.location='res.php';</script><?php
		}

	$upload_extensions = array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT");	
	
if(isset($_POST['mete'])){
		$titulo = @$_POST['titulo'];
		$descrip = @$_POST['descripcion'];
		$organo = @$_POST['organo'];
		$fecha = @$_POST['fecha'];
		$tiene = "n";
		//$quy = "";
		$msg = "";

		if(isset($_FILES['quy']['tmp_name'])) {
			copy($_FILES['quy']['tmp_name'],"res/".$_FILES['quy']['name']);
			$quy1 =  $_FILES['quy']['name'];
			$upload_ext = strrchr($quy1,".");
			if (in_array($upload_ext, $upload_extensions)) {	
				$quy = $_FILES['quy']['name'];
				$tiene = "s";				
			}else{	  
				$msg = "<br>La extensi&oacute;n del fichero seleccionado no es&aacute; autorizada, s&oacute;lo se admiten <stron>.zip</stron>, <stron>.rar</stron>, <stron>.doc</stron>, <stron>.rtf</stron>, <stron>.txt</stron> y <stron>.pdf</stron>. Por favor seleccione otro fichero";
				unlink("res/".$quy1);
				$e = "s";
			}
		}
		if(isset($_POST['quy']) AND ($_POST['quy']) !=""){
					$quy1=$_POST['quy'];					
					$upload_ext = strrchr($quy1,".");
					if (in_array($upload_ext, $upload_extensions)) {	
						$quy = $quy1;
						$tiene = "s";				
					}else{	  
						$msg = "<br>La extensi&oacute;n del fichero seleccionado no es&aacute; autorizada, s&oacute;lo se admiten <stron>.zip</stron>, <stron>.rar</stron>, <stron>.doc</stron>, <stron>.rtf</stron>, <stron>.txt</stron> y <stron>.pdf</stron>. Por favor seleccione otro fichero";
						unlink("res/".$quy1);
						$e = "s";
					}			
				}		
		if(($msg) ==""){ 
			$inre = "insert into resoluciones (titulo, descripcion, tiene, link, organo, fecha) values ('".htmlentities($titulo)."', '".htmlentities($descrip)."', '".$tiene."', '".$quy."', '".$organo."', '".$fecha."')";		
			$qinre = mysqli_query ($inre,$miConex) or die(mysql_error());
			$nuvoname = mysqli_insert_id($miConex);
			@chmod('sql/'.$quy,0777);
			rename("res/".$quy,"res/".$nuvoname.$upload_ext);
			$inreup = "update resoluciones set link='".$nuvoname.$upload_ext."' where id='".$nuvoname."'";		
			$qinreup = mysqli_query ($inreup,$miConex) or die(mysql_error());
		}else{ ?>
		<script type="text/javascript">alert('Extension no soportada. no se insertara la resolucion.');document.location='res.php';</script>;<?php } ?>
		<script type="text/javascript">document.location='res.php';</script>;<?php
	}
	if(isset($_POST['new'])){
		$orga = array("MININT","MINAZ","MFP","MINBAS","SIME","CITMA","MITRANS","MINFAR","MINCULT","MIC","EMPRESA");?>
		<script language="JavaScript" >
		// Check for a blank field
		function check1() {
			// form validation check
			var formValid=false;
			var f = document.form1;
			if ( f.quy.value == '' ) {
				alert('Por favor, seleccione la Resolucion');
				f.quy.focus();
				formValid=false;
			} else	if ( f.titulo.value == '' ) {
				alert('Por favor, debe escribir el Titulo de la Resolucion');
				f.titulo.focus();
				formValid=false;
			} else	if ( f.descripcion.value == '' ) {
				alert('Por favor, debe escribir una vrebe descripcion de la Resolucion');
				f.descripcion.focus();
				formValid=false;
			} else	if ( f.fecha.value == '' ) {
				alert('Por favor, debe seleccionar la Fecha');
				f.fecha.focus();
				formValid=false;
			} else if ( confirm('Son correctos los Datos?')) 
			  {	formValid=true;  }

			return formValid;
		}
		</script>
		<fieldset class="fieldset"><legend class="vistauserx">Insertar Resoluci&oacute;n</legend><?php
				include("js/droparea.php"); ?>
					<div id="areas">
						<br>
			<form action="inserta_res.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return check1();">				
				<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2">
					<tr> 
						<td align="right"></td>
						<td colspan="2"><div id="arras">&nbsp;&nbsp;&nbsp;<?php echo $arrastrar;?></div></td>
					</tr>
					<tr> 
						<td valign="top" width="20%" align="right"><strong>Cargar Resoluci&oacute;n:</strong></td>
						<td valign="top" width="40%"><input type="file" class="droparea spot" name="ficheroX" data-post="upload.php" data-width="220" data-height="345" data-crop="true"/></td>
					    <td valign="top" width="40%"><span id="nambr"></span></td>
					</tr>
					<tr> 
						<td align="right"><strong>T&iacute;tulo:</strong></td>
						<td colspan="2"><input name="titulo" type="text" class="imput" id="titulo" size="40"></td>
				    </tr>
					<tr> 
						<td height="39" align="right" valign="top"><strong>Descripci&oacute;n:</strong></td>
						<td colspan="2"><textarea name="descripcion" cols="50" rows="2" class="imput" id="descripcion"></textarea></td>
				    </tr>
					<tr>
						<td align="right"><strong>Fecha:</strong></td>
						<td colspan="2">
							<input name="fecha" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.fecha);return false;" class="imput" id="fecha" readonly value="" size="23" maxlength="10" />
							<a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.fecha);return false;" hidefocus="hidefocus"><img src="images/almana.png" name="popcal" width="25" height="22" border="0" align="absmiddle" id="popcal" title="" /></a>						</td>
				    </tr>
					<tr>
						<td align="right"><strong>&Oacute;rgano Emisor:</strong></td>
						<td colspan="2">
							<select name="organo" class="boton" id="organo"><?php
								$d=0;
								while($d< count($orga)){ ?>
									<option value="<?php echo $orga[$d];?>"><?php echo $orga[$d];?></option><?php 
									$d++;
								} ?>
							</select>						</td>
				    </tr>
					<tr> 
						<td align="right"></td>
						<td colspan="2"><input name="quy" type="hidden">
							<input type="button" name="cancel" value="<?php echo $btcancelar;?>" onClick="document.location='res.php';" class="btn">&nbsp;
							<input type="submit" name="mete" value="Cargar" class="btn"></td>
				    </tr>
  </table>
				<script type="text/javascript">
						function checkFile(fileUrl) {
							var xmlHttpReq = false;
							var self = this;
							// Mozilla/Safari
							if (window.XMLHttpRequest) {
								self.xmlHttpReq = new XMLHttpRequest();
							}
							// IE
							else if (window.ActiveXObject) {
								self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
							}

							self.xmlHttpReq.open('HEAD', fileUrl, true);
							self.xmlHttpReq.onreadystatechange = function() {
								if (self.xmlHttpReq.readyState == 4) {
									if (self.xmlHttpReq.status == 200) {
										//alert('the file exists');
									} else if (self.xmlHttpReq.status == 404) {
										document.getElementById('nambr').innerHTML='';
										document.form1.quy.value='';
										//alert('the file does not exist');
									}
								}
							}
							self.xmlHttpReq.send();
						}

							function quit(file_name,q){
								//var r = confirm("Are you sure you want to delete this Image?")
							//	if(r == true){
									$.ajax({
									  url: 'quitaresolu.php',
									  data: {'file' : "<?php echo dirname(__FILE__) . '/res/'?>" + file_name },
									  success: function (response) {
										if((q) =="s"){
											checkFile("<?php echo dirname(__FILE__) . '/res/'?>" + file_name); 
										}
										// do something
									  },
									  error: function () {
										 // do something
									  }
									});
								//}
							}
							extArray = new Array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt", ".pps", ".ppt", ".TXT", ".ZIP", ".RAR", ".PDF", ".DOC", ".ODT", ".PPS", ".PPT");
							extArray1 = new Array(".txt", ".zip", ".rar", ".pdf", ".doc", ".odt", ".pps", ".ppt");
							function LimitAttach(file) {
								allowSubmit = false;
								if (!file) return;
								while (file.indexOf("\\") != -1)
								file = file.slice(file.indexOf("\\") + 1);
								ext = file.slice(file.indexOf(".")).toLowerCase();
								for (var i = 0; i < extArray.length; i++) {
									if (extArray[i] == ext) { allowSubmit = true; break; }
								}
								if (allowSubmit) {
									document.getElementById('nambr').innerHTML= ' &nbsp;&nbsp;&nbsp;'+file+' &nbsp;<a title="Quitar Resoluci&oacute;n..." onmouseover="this.style.cursor=\'pointer\'" onclick="quit(\''+file+'\',\'s\');"><img src="images/quitar.png" width="20" height="20" border="0" align="absmiddle" ></a>'; 
									document.form1.quy.value=file;
								}else{
									document.getElementById('nambr').innerHTML= "<font color='red'><b>ERROR.</b></font> Solo Se permiten archivos con la extenci&oacute;n: " + (extArray1.join("  ")) + "\nPor favor, seleccione otro archivo.";
									quit(file,'n');
								}
							}
								// Calling jQuery "droparea" plugin
								$('.droparea').droparea({
									'instructions': '',
									'init' : function(result){
										//console.log('custom init',result);
									},
									'start' : function(area){
										area.find('.error').remove(); 
									},
									'error' : function(result, input, area){
										$('<div class="error">').html(result.error).prependTo(area); 
										return 0;
										//console.log('custom error',result.error);
									},
									'complete' : function(result, file, input, area){
										var tld = file.name.toLowerCase().split(/\./);
										tld = tld[tld.length -1];
LimitAttach(file.name);
									//	if (tld =='sql'  || tld =='cpe'  ||tld =='zip'  ) {
											
											
											//document.form1.submit();
									//	}else{ 
										//	document.getElementById('arras').innerHTML= ' &nbsp;&nbsp;&nbsp;<?php echo '<font color="red">ERROR.</font> Extensi&oacute;n no soportada, solo se aceptan .zip y .sql. Por favor trate de nuevo!';?><br><?php echo $arrastrar;?>'; 
										//}
									}
								});
						</script>
			</form>

			</div>
			<br>
			<div id="footer" class="degradado" align="center">
				<div class="container">
					<p class="credit"><?php include ("version.php");?></p>
				</div>
			</div>			
		</fieldset>
		<iframe width="174" height="189" name="gToday:normal1:agenda1.js" id="gToday:normal1:agenda1.js" src="js/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-501px; top:0px;"></iframe><?php
	} ?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
