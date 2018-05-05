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
include('header.php');
include ('script.php');
include('barra.php');
$qus = mysqli_query($miConex, "select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
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
$mesarre=array($enero,$febrero,$marzo,$abril,$mayo,$junio,$julio,$agosto,$septiembre,$octubre,$noviembre,$diciembre);
$Aini=array("2000");
$Afin=array("2030"); //Este valor tendrá que irlo cambiando a medida de sus necesidades, no espero estar aquí para entonces.
$num ="Enero";
?>
<link href="css/template.css" rel="stylesheet" type="text/css" />
<div id="buscad"> 
<fieldset class="fieldset">
	<form id="form1" name="form1" method="post" action="">
					<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btrestaurar." "; if($_GET['legen'] =="Traspasos."){echo $bttrasp;};?></legend>
					    <table width="237" border="0" cellspacing="2" cellpadding="2">
							<tr>
								<td width="42" height="28" align="right">
									<select name="mes" id="mes" class="combo_box"><?php
									$a=0;
									while($a<count($mesarre)){ ?>
										<option value="<?php if(($a) < 9){ $mm ="0".($a+1); echo $mm;}else{ $mm = $a+1; echo $mm;}?>" <?php if(($mm) ==@$_POST['mes']){ echo "selected";}?>><?php echo $mesarre[$a];?></option><?php
										$a++;
									} ?>
							       </select>							  
								</td>
								<td width="42">
									<select name='anno' class="combo_box"><?php
										$kk=date('Y');
										for($i=$Aini[0];$i<=$Afin[0];$i++){ ?>
											<option value='<?php echo $i;?>' <?php if(($i) ==@$_POST['ano']){ echo "selected";}elseif(($i) ==$kk){ echo "selected"; }?>><?php echo $i;?></option><?php 
										} ?>
							        </select></td>
								<td width="246" align="center"><input class="btn" type="submit" name="rstau" value="<?php echo $combo1;?>" />
						      <input name="tb" value="<?php echo $_GET['tb'];?>" type="hidden" /></td>
							</tr>
					    </table>
					</fieldset>
	</form><div <?php if(!isset($_POST['rstau'])){ echo 'style="display:none"';}else{ echo 'style="display:block"'; }?>>
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
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo $btsalvare;?></legend>
		<form name="busca" method="post" action="imprt.php" onsubmit="return doSubmit();">
			<table width="100%" border="0" cellpadding="2" cellspacing="2" class="sgf1">
				<tr>
					<td><?php 
						$fichero = $_POST['tb']."_".$_POST['mes'].$_POST['anno'].".zip";
						$handle=opendir('./reparaciones');
						$r="";
						while ($file = readdir($handle)) { 
							if ($file != "." && $file != "..") {
								$upload_ext = strrchr($file,".");
								if(($fichero) ==$file){
									if(($upload_ext) ==".zip"){ 
										$estadísticas = stat($roo.$pht1."reparaciones/".$file); ?>
										<label class='Estilo3'><input name='marcado' type='radio' class="boton" id='marcado' value='<?php echo $file;?>' />
										&nbsp;<?php echo $file."&nbsp;&nbsp;(<font color='red' size='2'>".tamano($estadísticas['size'],2)."</font>)";?></label><br><?php
										$r="s";									
									}
								}
							}
						}
						closedir($handle); ?>
					</td>
				</tr>
	<?php 	$mess=$_POST['mes']-1; 
			if(($r) =="s"){ ?>
				<tr>
					<td><input type="hidden" name="carpeta" value="reparaciones"/>
					<input type="submit" class="btn" name="restau" value="<?php echo $btrestaurar;?>"/>
					&nbsp;&nbsp;<input type="submit" class="btn" name="del" value="<?php echo $bteliminar;?>" onclick="return confirm('<?php echo $cuidado1;?>');" />
					&nbsp;&nbsp;</td>
				</tr><?php
			}else{ ?>
				<tr>
					<td><br><div align="center"><div class="message" align="center"><?php echo $noregitro3.$btsalvare.$btEN.$Fecha;?>: <b><font color="red"><?php echo $mesarre[$mess]."/".$_POST['anno']?></div></div></td>
				</tr><?php 
			} ?>				
		  </table>
			<input name="tb" type="hidden" value="<?php echo $_GET['tb'];?>">		  
		</form>
	</fieldset>
</div>
</div>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>