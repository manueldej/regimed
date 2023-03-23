<!DOCTYPE html>
<html lang="es">
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

	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
@session_start();
include ('connections/miConex.php');
include('script.php');
class colores {
	public function ColorFila($i,$color1,$color2){
		if (($i % 2)== 0) {
			$this->ColorFondo = $color1;
		}else {
			$this->ColorFondo = $color2;
		}
		return $this->ColorFondo;
	}
}
$color1="#F1F2F3";
$color2="#E9EAEB";
$uCPanel = new colores();
$idd=0;
$m="";
if(isset($_GET["m"])){ $m = "&m=m";}
$palabra="";
$logi=$_SESSION["valid_user"];
$rus = mysqli_query("select * from usuarios where login='".$logi."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($rus);
$cuantos = 5;
$qusua = mysqli_query("select * from usuarios where login='".$_SESSION['valid_user']."'") or die(mysql_error());
$rusua = mysqli_fetch_array($qusua);
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
if(($rsel['visitas']) !=""){
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
///////////
$resultados = mysqli_query("SELECT * FROM resoluciones") or die(mysql_error());
$total_registros = mysqli_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);
$palabra=$_GET['ent'];
$sql = "select * from resoluciones where (titulo like '%".$palabra."%') OR (descripcion like '%".$palabra."%') OR (organo like '%".$palabra."%') limit ".$inicio.",".$registros;
$result= mysqli_query($sql) or die(mysql_error());
$total_registrosx = mysqli_num_rows($result);
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>	
		<table width="100%" border="0" align="center" class='table' cellpadding="0" cellspacing="0"><?php 
			if(($total_registrosx) !=0){ ?>			
				<form name="frm1" action="inserta_res.php" method="post">
					<tr class="vistauser1"> 
							<td colspan="2"></td>
							<td><strong><span class="Estilo4"><?php echo $title3;?></span></strong></td>
							<td><strong><span class="Estilo4"><?php echo $DESCRIPCION;?></span></strong></td>
							<td><strong><span class="Estilo4"><?php echo $btorganoemi2;?></span></strong></td>
							<td><strong><span class="Estilo4"><?php echo strtoupper($Fecha);?></span></strong></td>
						</tr><?php
						$p=0;
						$i=0;
						while($rows=mysqli_fetch_array($result)){ $i++;?>
						<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');" <?php if(($rusua['tipo']) =="root" ){ ?> onclick="marca1(<?php echo $p;?>,'#ffffff')"<?php } ?>> 
							<td width="20"><?php if(($rusua['tipo']) =="root" ){ ?><input name="marcado[]" type="checkbox" class="boton" id="marcado[<?php echo $p?>]" onClick="marca1(<?php echo $p;?>,'#ffffff')" value="<?php echo $rows["id"]?>" />
							<?php } ?></td>
							<td width="20"> 
							  <?php if(($rows['tiene']) =="s") { ?>
							  <a href="res/<?php echo $rows['link'];?>" target="_blank"><img src="images/file_f2.png" width="20" height="20" border="0" title="Descargar Resoluci&oacute;n..."/></a> 
							  <?php }else{ ?>
							  <img src="images/file.png" width="20" height="20" /> 
							  <?php }?>			</td>
							<td width="275"><?php echo $rows['titulo'];?></td>
							<td width="402"><?php echo $rows['descripcion'];?><input name="link[]" type="hidden" value="<?php echo $rows['link'];?>"></td>
							<td width="128"><?php echo $rows['organo'];?></td>
							<td width="87"><?php echo $rows['fecha'];?></td>
						</tr>  <?php $p++;
						} ?>
						<tr>
							<td colspan="5"><?php if (($rus['tipo']) =="root") { ?>
								<img src="images/check_all.png" name="marcart" id="marcart" width="17" height="17" border="0" usemap="#marcart" title="<?php echo $sel_all;?>" onClick='marcar_todo();' onMouseOver="this.style.cursor='pointer';">&nbsp;<img src="images/uncheck_all.png" name="desmarcart" width="17" height="17" id="desmarcart" title="<?php echo $des_all;?>" onClick='desmarcar_todo();' onMouseOver="this.style.cursor='pointer';"><?php } ?>
							</td>
						</tr><?php
						if(($rusua['tipo']) =="root"){ ?>
							<tr> 
								<td colspan="6">
									<input name="edit" type="submit" value="<?php echo $bteditar;?>" class="btn" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');">&nbsp;&nbsp;&nbsp;
									<input name="del" type="submit" value="<?php echo $bteliminar;?>" class="btn" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');">&nbsp;&nbsp;&nbsp;
									<input name="new" type="submit" class="btn" id="new" value="<?php echo $btinsertar;?>" />&nbsp;&nbsp;&nbsp;
									<input name="quitarf" type="submit" class="btn" id="quitarf" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$quit;?>','');" value="<?php echo $quit;?>" /></td>
							</tr><?php
						} ?><tr> 
								<td colspan="6">&nbsp;</td>
							</tr>		
				</form><?php
				include('navegador.php');
			}else{ ?>
				<tr> 
					<td colspan="6">
						<form name="news" action="inserta_res.php" method="post">
							<br><div align="center"><div class="message" align="center"><?php echo $noart." ".$quecoin." -->".$palabra;?>.</div></div><br><br><?php 
							if(($rusua['tipo']) =="root" AND !isset($_POST['new'])){ ?>
						<div align="center"><input name="new" type="submit" class="btn" id="new" value="<?php echo $btinsertar;?>" /></div><?php 
							} ?>
						</form>
					</td>
				</tr><?php
			}  ?>
		</table>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>
