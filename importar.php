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
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php	
		return;	
	} 
include('connections/miConex.php');
$qus = mysqli_query("select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
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

?>
<link href="css/template.css" rel="stylesheet" type="text/css" />
<fieldset class="fieldset">
<?php
$mesarre=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Aini=array("2000");
$Afin=array("2030");
?>
		<form id="form1" name="form1" method="post" action="">
					<fieldset class='fieldset'><legend class="vistauserx">Importar... <?php echo $_GET['legen'];?></legend>
						<table width="237" border="0" cellspacing="2" cellpadding="2">
							<tr>
								<td width="42" height="28" align="right">
									<select name="mes" id="mes" class="combo_box"><?php
									$a=0;
									while($a<count($mesarre)){ ?>
										<option value="<?php if(($a) < 9){ $mm ="0".($a+1); echo $mm;}else{ $mm = $a+1; echo $mm;}?>" <?php if(($mm) ==@$_POST['mes']){ echo "selected";}?>><?php echo $mesarre[$a];?></option><?php
										$a++;
									} ?>
							  </select>							  </td>
								<td width="42">
									<SELECT name='anno'  class="combo_box"><?php
										$kk=date('Y');
										for($i=$Aini[0];$i<=$Afin[0];$i++){ ?>
											<OPTION value='<?php echo $i;?>' <?php if(($i) ==@$_POST['ano']){ echo "selected";}elseif(($i) ==$kk){ echo "selected"; }?>><?php echo $i;?></OPTION><?php 
										} ?>
							  </SELECT></td>
								<td width="246" align="center"><input class="boton" type="submit" name="rstau" value="Seleccionar" />
						      <input name="tb" value="<?php echo $_GET['tb'];?>" type="hidden" /></td>
							</tr>
					</table>
					</fieldset>
				</form>		<div <?php if(!isset($_POST['rstau'])){ echo 'style="display:none"';}else{ echo 'style="display:block"'; }?>>
<script type="text/javascript">
	function doSubmit(){
		if((document.getElementById('marcado').checked) ==false){
		 alert('Por favor seleccione el Fichero');
		 return false;
		} else{
			document.submit();
		}
	}
</script>
	<fieldset class='fieldset'><legend class="vistauserx">Exportaciones Realizadas</legend>
		<form name="busca" method="post" action="imprt.php" onsubmit="return doSubmit();">
			<table width="100%" border="0" cellpadding="2" cellspacing="2" class="sgf1">
				<tr>
					<td><?php 
						$fichero = $_POST['tb']."_".$_POST['mes'].$_POST['anno'].".zip";
						$handle=opendir('./Exportar');
						$r="";
						while ($file = readdir($handle)) { 
							if ($file != "." && $file != "..") {
								$upload_ext = strrchr($file,".");
								if(($fichero) ==$file){
									if(($upload_ext) ==".zip"){ 
										$estadísticas = stat($roo.$pht1."Exportar/".$file); ?>
										<label class='Estilo3'><input name='marcado' type='radio' class="boton" id='marcado' value='<?php echo $file;?>' />
										&nbsp;<?php echo $file."&nbsp;&nbsp;(<font color='red' size='2'>".tamano($estadísticas['size'],2)."</font>)";?></label><br><?php
										$r="s";									
									}
								}
							}else{					
								  $r="n";
							} 
						}
						closedir($handle); ?>
					</td>
				</tr>
	<?php 	if(($r) =="n"){
				for ($a=1; $a<=count($mesarre); $a++){
					foreach ($mesarre as $key) {
						$mx = str_replace("0","",$_POST['mes']);
					   if (($mx) ==$_POST['mes']){
						 $num = $key;
						 break;
					   }	 
					}
				}?>
				<tr>
					<td class="sgf1"><span class="vistauser2">No existen Ficheros de Salvas con fecha: <b><font color="red"><?php echo $num."/".$_POST['anno']?></font></b></span><br>
					  <br>
						<input type="button" class="boton" name="retor" value="<?php echo $btcancelar;?>" onclick="javascript:document.location='configura.php?salva=s';" />				  </td>
				</tr><?php 
			}
			if(($r) =="s"){ ?>
				<tr>
					<td><input type="hidden" name="carpeta" value="Exportar"/>
					<input type="submit" class="boton" name="restau" value="<?php echo $btrestaurar;?>"/>
					&nbsp;&nbsp;<input type="submit" class="boton" name="del" value="<?php echo $bteliminar;?>" onclick="return confirm('Realmente desea Eliminar el Fichero?');" />
					&nbsp;&nbsp;<input type="button" class="boton" name="retor" value="<?php echo $btcancelar;?>" onclick="javascript:document.location='configura.php?salva=s';" /></td>
				</tr><?php
			} ?>				
		  </table>
			<input name="tb" type="hidden" value="<?php echo $_GET['tb'];?>">		  
		</form>
	</fieldset>
</div>
  <br>
</div>
	<div class="Footer">
	  <div class="Footer-inner">
		 <div class="Footer-text"><p><?php include ("version.php");?></p></div>
	   </div>
	</div>
</fieldset>