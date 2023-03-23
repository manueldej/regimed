<?php 
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Informáticos)     					                                		           #
# Version:  3.1.1                                                    				                       #
# Fecha:    01/06/2016 - 01/01/2023                                             					       #
# Autores:  Ing. Manuel de Jesús Núñez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################
include('header.php');
include ('script.php');
$qus = mysqli_query($miConex, "select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
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
		if(is_uploaded_file($_FILES['fichero']['tmp_name']))    {
			$tamao = $_FILES['fichero']['size'];
//			if((file_exists( $ruta.$_FILES['fichero']['name']))){@unlink($ruta.$_FILES['fichero']['name']);}
			$fichero = $_FILES['fichero']['name'];
			$acamb = substr($fichero,0,-4);
			$upload_ext = strrchr($fichero,".");
			if(($upload_ext) ==".zip"){
				copy($_FILES['fichero']['tmp_name'],$ruta.$_FILES['fichero']['name']);
				$zip = new ZipArchive;
				if ($zip->open($ruta.$fichero) === TRUE) {
					$nomre_act = $zip->getNameIndex(0);
					$zip->close();
				} else {
					echo 'failed';
				}
				$zip = new ZipArchive;
				if ($zip->open($ruta.$fichero) === TRUE) {
					$zip->renameName($nomre_act,$acamb.'.sql');
					$zip->close();
				} else {
					echo 'failed';
				}
				$zip = new ZipArchive;
				if ($zip->open($ruta.$fichero) === TRUE) {
					$zip->extractTo($ruta);
					$zip->close();
				} else {
					echo 'failed';
				}
				unlink($ruta.$fichero);
			}elseif(($upload_ext) ==".sql"){
				copy($_FILES['fichero']['tmp_name'],$ruta.$fichero);
			}else{	  
				$Mensaje = $no_ext;
		//CAMBIAR ESTO
				show_message2($strerror,$impo_exp3,$Mensaje,"cancel",$strOK,"configura.php","#026CAE",$DBname);
				@unlink($ruta.$_FILES['fichero']['name']);
				exit;
			}
		}
		$handle=opendir(substr($ruta,0,-1));
		while ($file = readdir($handle)) { 
			if($file != "." && $file != ".."){
				$filemode = 0777;
				$dirmode =0777;
				$chmodOk = TRUE;			
				$ret = @chmod($ruta.$file, 0777);
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
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>
<?php include('barra.php');?>
<div id="buscad"> 
<div <?php if(isset($_POST['restau'])){ echo 'style="display:none"';}else{ echo 'style="display:block"'; }  //import_bd.php ?>>
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btsalvare; ?></legend>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
		</div>
		 <div id="areas"><br><div id="arras">&nbsp;&nbsp;&nbsp;<?php echo $arrastrar;?></div>
		 <?php echo "<font color='red'><b>".$MENs."</b></font>";
							include("js/droparea.php"); ?>
			
			<table width="82%" border="0" align="center" cellpadding="2" cellspacing="2" class="sgf1">
				<tr>
					<td>
					<form name="busca" method="post" action="" enctype="multipart/form-data">		
					<input title="<?php echo $arrastrar;?>" class="droparea spot" style="font-size:12px;" type="file" name="fichero" id="fichero" onblur="return LimitAttach(this.value);"/>&nbsp;&nbsp;<input type="submit" class="btn" onclick="if(document.busca.fichero.value ==''){ return false;}" name="ok" id="ok" value="<?php echo $cargar2;?>">
					<script type="text/javascript">
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
									document.getElementById('nambr').innerHTML="";
									return true;
								}else{
									document.getElementById('nambr').innerHTML= "<font color='red'><b>ERROR.</b></font> Solo Se permiten archivos con la extenci&oacute;n: " + (extArray1.join("  ")) + "\nPor favor, seleccione otro archivo.";
									document.busca.fichero.value="";
									return false;
								}
							}
					</script>				
					</td> <span id="nambr"></span>
				</tr>		
			</table>
			     </form></div>

		  
		<form name="frm1" method="post" action="import_bd.php" enctype="multipart/form-data">
			<table width="82%" border="1" cellpadding="0" cellspacing="0" class="sgf1"><?php
				$handle=@opendir(substr($ruta,0,-1));
				$cuts=0;
				while ($file = readdir($handle)) { 
					if($file != "." && $file != ".."){ ?>
						<tr>
						  <td width="1%" valign="middle"><input name="marcado" type="radio" id="marcado" value="<?php echo $file;?>"></td>
							<td width="99%"><label for="marcado"><?php echo $file;?></label>	</td>
						</tr><?php
						$cuts++;
					}
				}
				closedir($handle);?>
				<tr>
				    <td colspan="2"><hr></td>
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
</div>
</fieldset><br>
<?php include ("version.php");?>
<div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
