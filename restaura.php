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
$qus = mysqli_query($miConex, "select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die();
$rus = mysqli_fetch_array($qus);
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
$upload_extensions = array(".sql", ".SQL", ".zip", ".ZIP");
	if(isset($_POST['subir'])){
		if(isset($_POST['filea'])) {			
			$upload_ext = strrchr($_POST['filea'],".");
			if (in_array($upload_ext, $upload_extensions) AND ($upload_ext) !="") { ?>
				<script type="text/javascript">
				   document.getElementById("subir").style.visibility='visible';
			    </script>
			<?php 
				@copy($_POST['filea'],$roo.$pht1."salvas/".$_POST['filea']);
				if(($upload_ext) ==".zip" OR ($upload_ext) ==".ZIP"){
					$zip = new ZipArchive;
					if ($zip->open($roo.$pht1."salvas/".$_POST['filea']) === TRUE) {
						$zip->extractTo($roo.$pht1."salvas/");
						$zip->close();
						@rename($roo.$pht1."salvas/".$_FILES['filea']['name'],$roo.$pht1."salvas/script_sql.sql");
						unlink($roo.$pht1."salvas/".$_POST['filea']);
					} else { 
					   echo 'Intento fallido';
					}				
				}else{
					@rename($roo.$pht1."salvas/".$_POST['filea'],$roo.$pht1."salvas/script_sql.sql");
				}
			}else{ ?>
			<script type="text/javascript">
				alert("El fichero: <?php echo $_POST['file'];?>, tiene una extesion no valida");
			</script> <?php
			} 
		}
	}
?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<?php 
   include('jquery.php'); 
   include('barra.php');
?>
<script type="text/javascript">
	function cierrz(){
		document.getElementById('cir').innerHTML="";
	}
	function chequea(){
		var tt= document.frm1;
		var cuenta=0;
		for (i=0;i<frm1.elements.length;i++)   {
			if ((frm1.elements[i].type=="radio")&&(frm1.elements[i].checked==true))	 {
				cuenta++;
			}	
		}
		
		if((cuenta) ==0){
			showAlert(4000,'<div class="alert negro" style="display: none"><button class="closex" type="button" onclick="cierrz();">X</button><div align="center"><font color="#FFDCA8" size="3"><b><?php echo $strerror;?></b></font></div><div align="center"><b><?php echo $plea8.$ficher;?>.</b></div></div>');
			return false;		
		}
	}
</script>
<div id="buscad"> 
<div <?php if(isset($_POST['restau'])){ echo 'style="display:none"'; }else{ echo 'style="display:block"'; }?>>
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btsalvare;?></legend>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
		</div>	<br>
		<table width="82%" border="0" align="center" cellpadding="2" cellspacing="2" class="sgf1">
			<tr><td><?php
				include("js/droparea.php"); ?>
				<div id="areas"><br>
			<form name="form1a" method="post" action="" enctype="multipart/form-data">
				<div id="arras">&nbsp;&nbsp;&nbsp;<?php echo $arrastrar;?></div>
                    <input type="file" class="droparea spot" style="font-size:12px;" name="ficheroX" data-post="uploadsalvas.php" data-width="220" data-height="345" data-crop="true"/><input type="hidden" name="filea">&nbsp;&nbsp;<span id="nambr"></span>
				<hr><input name="subir" type="submit" id="subir" value="<?php echo $cargar2;?>" class="btn" style="visibility:hidden">
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
							//var r = confirm("Are you sure you want to delete this Image?")
						//	if(r == true){
								$.ajax({
								  url: 'quitaresolu.php',
								  data: {'file' : "<?php echo dirname(__FILE__) . '/salvas/'?>" + file_name },
								  success: function (response) {
									if((q) =="s"){
										checkFile("<?php echo dirname(__FILE__) . '/salvas/'?>" + file_name);
										document.getElementById('nambr').innerHTML='';		
										document.form1a.subir.style.visibility='hidden';										
									}
									// do something
								  },
								  error: function () {
									 // do something
								  }
								});
							//}
						}
						extArray = new Array(".sql", ".zip", ".SQL", ".ZIP");
						extArray1 = new Array(".sql", ".zip");
						
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
								document.getElementById('nambr').innerHTML= ' &nbsp;&nbsp;&nbsp;'+file+' &nbsp;<a title="Quitar '+file+'..." onmouseover="this.style.cursor=\'pointer\'" onclick="quit(\''+file+'\',\'s\');"><img src="images/quitar.png" width="20" height="20" border="0" align="absmiddle" ></a>'; 
								document.form1a.filea.value=file;
								document.form1a.subir.style.visibility='visible';
								//document.form1a.submit();
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
								}
							});
				</script>
			</form></div>
			</td></tr>
		</table>
		<form name="frm1" method="post" action="imprt.php" onsubmit="return chequea();">
			<table width="82%" border="0" align="center" cellpadding="2" cellspacing="2" class="sgf1">
				<tr>
					<td><?php 
						$handle=opendir('./salvas');
						$r=0;
						while ($file = readdir($handle)) { 
							if ($file != "." && $file != "..") {
								$upload_extx = strrchr($file,".");
								//if(($upload_extx) ==".zip"){ 
									$estadisticas = stat($roo.$pht1."salvas/".$file); ?>
									<label class='Estilo3'><input name='marcado' type='radio' class="boton" id='<?php echo $r;?>' value='<?php echo $file;?>' />
									&nbsp;<?php echo $file."&nbsp;&nbsp;(<font color='red' size='2'>".tamano($estadisticas['size'],2)."</font>)";?></label><br><?php
									$r++;									
								//}
							} 
						}
						closedir($handle); ?>
					</td>
				</tr>
	            <?php if(($r) ==0){ ?>
				<tr>
					<td align="center"><br><div class="message" align="center"><?php echo $noregitro3." ".strtolower($ficher."s".$de.$btsalvare);?>.</div>
  				  </td>
				</tr><?php 
			    }
			    if(($r) >0){ ?>
				<tr>
					<td><input type="submit" class="btn" name="restau" value="<?php echo $btrestaurar;?>"/>
						&nbsp;&nbsp;<input name="create" id="create-user" type="button" class="btn" onclick="checkLengthr('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
						<input type="hidden" name="crash">
					</td>
				</tr><?php
			    } ?>				
            </table>	
			<input name="tb" type="hidden" value="todo">
			<input name="origen" type="hidden" value="restaura.php">			  
		</form>
		  <br>
</fieldset><br>
<?php include ("version.php");?>
<div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
