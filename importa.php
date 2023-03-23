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
include ('script.php');
$qus = mysqli_query($miConex, "select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die(mysqli_error());
$rus = mysqli_fetch_array($qus);
$MENs="";
	function tamano($size,$digits) {
		$kb=1024; $mb=1024*$kb; $gb=1024*$mb; $tb=1024*$gb;
		if (($size==0)) { 
			return "0 Byte"; 
		}elseif ($size<$kb) { 
			return $size." Byte"; 
		}elseif ($size<$mb) { 
			return round($size/$kb,$digits)." Kb"; 
		}elseif ($size<$gb) { 
			return round($size/$mb,$digits)." Mb"; 
		}elseif ($size<$tb) { 
			return round($size/$gb,$digits)." Gb"; 
		}else { 
			return round($size/$tb,$digits)." Tb"; 
		}
	}
$roo = $_SERVER['DOCUMENT_ROOT'];
$fin =str_replace($_SERVER['SERVER_NAME'],"",$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
$pht1 = substr($fin, 0, strlen($fin)- strlen(basename($_SERVER['PHP_SELF'])));
$ruta = $roo .$pht1."importar/";
    // Aqui comienzo a sibir si existe el fichero cargado 
	if(isset($_POST['ok'])){
		function mosChmodRecursive($path, $filemode=NULL, $dirmode=NULL){
			$ret = TRUE;
			if (is_dir($path)) {
				if (isset($dirmode))
					$ret = @chmod($path, $dirmode);
			}else{
				if (isset($filemode))
					$ret = @chmod($path, $filemode);					
			}
			return $ret;
		}
		
		// si el fichero a importar ha sido cargado
		if(is_uploaded_file($_FILES['fichero']['tmp_name'])) {
			$tamao = $_FILES['fichero']['size'];
			//if((file_exists( $ruta.$_FILES['fichero']['name']))){@unlink($ruta.$_FILES['fichero']['name']);}
			$fichero = $_FILES['fichero']['name'];
			$acamb = substr($fichero,0,-4);
			$upload_ext = strrchr($fichero,".");
			
			if(($upload_ext) ==".zip"){
				@copy($_FILES['fichero']['tmp_name'],$ruta.$_FILES['fichero']['name']);
				$zip = new ZipArchive;
				if ($zip->open($ruta.$fichero) === TRUE) {
					$nomre_act = $zip->getNameIndex(0);
					$zip->close();
				} else {
					echo 'fallido';
				}
				$zip = new ZipArchive;
				if ($zip->open($ruta.$fichero) === TRUE) {
					$zip->renameName($nomre_act,$acamb.'.sql');
					$zip->close();
				} else {
					echo 'fallido';
				}
				$zip = new ZipArchive;
				if ($zip->open($ruta.$fichero) === TRUE) {
					$zip->extractTo($ruta);
					$zip->close();
				} else {
					echo 'fallido';
				}
				@unlink($ruta.$fichero);
			}elseif(($upload_ext) ==".sql"){
				@copy($_FILES['fichero']['tmp_name'],$ruta.$fichero);
			}else{	  
				$Mensaje = $no_ext;
		//cambiar esto 
				show_message2($strerror,$impo_exp3,$Mensaje,"cancel",$strOK,"configura.php","#026CAE",$DBname);
				@unlink($ruta.$_FILES['fichero']['name']);
				exit;
			}
		}
		
		$handle=opendir(substr($ruta,0,-1));

		while ($file = readdir($handle)) { 
			if($file != "." && $file != ".." && $file != "import_exp.txt"){
				$filemode = 0777;
				$dirmode =0777;
				$chmodOk = TRUE;			
				$ret = mosChmodRecursive($ruta, $file, $filemode);
				$chmodOk = TRUE;
			}
		}
		closedir($handle);
		if ($chmodOk) {
			//echo '<span class="bodyText">El fichero '.$fichero.', fue copiado.</span>';
		} else {
			$MENs= '<span class="bodyText">El fichero '.$fichero.', fue copiado, pero los permisos de este no han podido ser cambiados.<br />Por favor c&aacute;mbielos manualmente.</span>';
		}		
	}
?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<?php
include('jquery.php'); 
include('barra.php');?>
<div <?php if(isset($_POST['restau'])){ echo 'style="display:none"';}else{ echo 'style="display:block"'; }  //import_bd.php ?>>
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btsalvare; ?></legend>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
		</div>
		<table width="82%" border="0" align="center" cellpadding="2" cellspacing="2" class="sgf1">
			<tr>
			    <td><div id="arras">&nbsp;&nbsp;&nbsp;<?php echo $arrastrar;?></div>
				    <?php
				   include("js/droparea.php"); ?>
			       <div id="areas"><br>
				    <?php echo "<font color='red'><b>".$MENs."</b></font>";	?>
				<form name="busca" method="post" action="" enctype="multipart/form-data">						
                    <input type="file" class="droparea spot" style="font-size:12px;" data-post="uploadimport.php" name="fichero" id="fichero" title="<?php echo $arrastrar;?>" onchange="return LimitAttach(this.value);" data-width="220" data-height="345" data-crop="true"/>&nbsp;&nbsp;<input type="hidden" name="filea">&nbsp;&nbsp;<span id="nambr"></span>					
					<hr><input name="ok" type="submit" id="ok" value="<?php echo $cargar2;?>" class="btn" onclick="if(document.busca.fichero.value ==''){ return false;}" style="visibility:hidden">
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
										alert('El fichero no existe');
									} else if (self.xmlHttpReq.status == 404) {
										document.getElementById('nambr').innerHTML='';
										document.form1a.filea.value='';
										alert('El fichero no existe');
									}
								}
							}
							self.xmlHttpReq.send();
						}

						function quit(file_name,q){
						//var r = confirm("Seguro que desea eliminar este archivo?")
							//if(r == true){
								$.ajax({
								  url: 'quitaresolu.php',
								  data: {'file' : "<?php echo dirname(__FILE__) . '/importa/'?>" + file_name },
								  success: function (response) {
									if((q) =="s"){										
										checkFile("<?php echo dirname(__FILE__) . '/importa/'?>" + file_name);
										document.getElementById('nambr').innerHTML='';
										document.busca.ok.style.visibility='hidden';
									}
									
								  },
								  error: function () {
									// alert("No se ha podido eliminar");
								  }
								});
							//}
						}
						extArray = new Array(".sql", ".zip", ".SQL", ".ZIP");
												
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
								document.getElementById('nambr').innerHTML= ' &nbsp;&nbsp;&nbsp;Por subir: <b>'+file+'</b> &nbsp;<a title="Quitar '+file+'..." onmouseover="this.style.cursor=\'pointer\'" onclick="quit(\''+file+'\',\'s\');"><img src="images/quitar.png" width="20" height="20" border="0" align="absmiddle" ></a>'; 
								document.busca.filea.value=file;
								document.busca.ok.style.visibility='visible';																
								//document.busca.submit();
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
											console.log(tld);
											LimitAttach(file.name);
										}
									});
					</script>
				</form></div>
				</td></tr>
		</table>		  
		
   
		<form name="frm1" method="post" action="import_bd.php" enctype="multipart/form-data">
			<table width="82%" border="0" align="center" cellpadding="2" cellspacing="2" class="sgf1">
				<tr>
				    <td><?php
						$handle=@opendir(substr($ruta,0,-1));
						$cuts=0;
						while ($file = readdir($handle)) { 
							if($file != "." && $file != ".." && $file != "import_exp.txt"){ ?>
								<tr>
								  <td width="1%" valign="middle"><input name="marcado" type="radio" id="marcado" value="<?php echo $file;?>"></td>
									<td width="99%"><label for="marcado"><?php echo $file;?></label></td>
								</tr><?php
								$cuts++;
							}
						}
						closedir($handle);?>
					</td>
				</tr><?php
				if(($cuts) !=0){ ?>
					<tr>
						<td colspan="2">
							<input type="submit" class="btn" name="impo" value="<?php echo $btImportar;?>" onClick="return alertaradio('<?php echo $strerror;?>','<?php echo $plea1.$impo_exp8;?>','');">&nbsp;&nbsp;
							<input name="create" id="create-user" type="button" class="btn" onclick="checkLengthr('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
							<input type="hidden" name="crash">
						</td>
					</tr><?php
				} ?>				
		  </table>
		</form>
</fieldset><br>
<?php include ("version.php");?>
<div class="dialogoInfo"></div>	
<div class="ContenedorAlert" id="cir"></div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>