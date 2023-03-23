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
include('mensaje.php');
$con="";
$meses = array($enero =>1,$febrero=>2,$marzo=>3,$abril=>4,$mayo=>5,$junio=>6,$julio=>7,$agosto=>8,$septiembre=>9,$octubre=>10,$noviembre=>11,$diciembre=>12);
$Aini=array("2000");
$Afin=array("2030");
if(isset($_REQUEST['con']) !=""){ $con = $_REQUEST['con'];}
class cdate{
	function formatDate($adate, $currTab, $futTab){
		if (!is_null($adate)){
			$sep = array();
			$sep = explode($currTab, $adate);
			return $sep[2].$futTab.$sep[1].$futTab.$sep[0];
		}else{
			return "";
		}
	}
}
$myDate = new cdate();
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;

if((@$rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
$validus = "";
if(isset($_SESSION["autentificado"])){
	$validus = " AND idunidades='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
}else{
	$validus = "";
}
$us1 = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);
/////////
$palabra="";
$msg="";
$m="";
$i=0;
$rp="";
$palab="";
$logi=$_SESSION["valid_user"];
$us1 = mysqli_query($miConex, "select * from usuarios where login='".$logi."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);
if(isset($_REQUEST['palabra'])){ $palabra = $_REQUEST['palabra'];}
if(isset($_REQUEST['palabra'])){ $palabra = $_REQUEST['palabra'];}
if(isset($_REQUEST['rp'])){ $rp = $_REQUEST['rp'];}

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
	if(isset($_REQUEST["registros"])) {
		$registros = $_REQUEST["registros"];
		$inicio = 0;
		$pagina = 1;
	}
	if(isset($_REQUEST['pagina']))  {
		$pagina=$_REQUEST['pagina'];
		$inicio = ($pagina - 1) * $registros;
	}
	if(isset($_REQUEST["mostrar"])) {
		$registros = $_REQUEST["mostrar"];
		if(($registros) ==0){ $registros=1;}
		$inicio = 0;
		$pagina = 1;
	}
//////////
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql="SELECT * FROM aft WHERE (estado!='A') AND (idunidades='".$_COOKIE['unidades']."') order by inv"; 
	}else{
		$sql="SELECT * FROM aft WHERE estado!='A' order by inv"; 
	}
	$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
	$result= mysqli_query($miConex, $query_limit) or die(mysql_error());
	$ggg = base64_encode($query_limit);		
	$num_resultados = mysqli_num_rows($result);
	
	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sqlq = "SELECT * FROM aft where (idunidades='".$_COOKIE['unidades']."')";
	}else{
		$sqlq = "SELECT * FROM aft ";
	}
	$resultq= mysqli_query($miConex, $sqlq) or die(mysql_error());
	$num_resultadosq = mysqli_num_rows($result);
	

//NAVEGADOR inicio
	if(isset($_REQUEST['total_registros'])){
		$total_registros=$_REQUEST['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN ?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
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
	.printer{
		background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
		height: 16px;
		background-position: 0 -17px;
	}
</style><?php
	include('jquery.php'); ?>
<?php include('barra.php');
$msg="";
$ac="";
if(isset($_REQUEST["msg"])){ $msg = base64_decode($_REQUEST["msg"]);}
if(isset($_REQUEST["msg"])){ print'<meta http-equiv="refresh" content="4;URL=rep.php"><span align="center" class="vistauser1"><em><strong><font size="2" color="red">'.$msg.'</font></strong></em></span>';}
?>
<div id="buscad"> 
<fieldset class='fieldset'><legend class="vistauserx"><?php echo strtoupper($btListado1);?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>
	<div id="openModal" class="modalDialog">
		<div>
			<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
			<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
		</div>
	</div><?php
	if(($total_filas) >1){  ?>
			<td>
				<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
					<select name="unidades" id="unidades" class="form-control" style="width:19%; margin-left:73px; margin-top: -20px;" onchange="cambiaunidad(this.value,'insp.php');">
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
	$semean = mysqli_query($miConex, "select id from aft") or die(mysqli_error());
	$nsemean = mysqli_num_rows($semean);
	if(($num_resultados) ==0){ ?>
			<br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btListado1;?>.</div></div><?php
	}else{ 
		?>
			<table width="100%" border='0' align='center' cellpadding="0" cellspacing="0" >
				<tr>
					<td width="504" align="right">
						<table width="76" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center">
									<div id="imprime">
									  <table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr><?php 
										if(($_SESSION['valid_user']) !="invitado" AND ($num_resultados) !=0){ ?>
										  <td class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=aft&gt=defectuosos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onMouseOver="this.style.cursor='pointer';" ><?php echo strtoupper($s_email);?></span></a></td><?php
										} ?>
										 <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=aft" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onMouseOver="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
										 <td class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=defec" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onMouseOver="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
										</tr>
									  </table>	
									</div>								
								</td>
							</tr>
						</table>
				  </td>
				</tr>
				<tr>
					<td colspan="2">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="788"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
									<form name="mst" method="post" action="" id="mst">
										<span><?php echo $cantidadmost;?>:</span>
										<span style="position: absolute; margin-left: 0%; margin-top: -11px;">
										<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
										<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
										<input name="mostrar" id="vers" type="text" maxlength="3" value="<?php if (!isset($_REQUEST['mostrar'])) { if ($rowsp['visitas']>$total_registros) { echo $total_registros; }else{ echo $registros; } }else{ if ($_REQUEST['mostrar']>$total_registros) { echo $total_registros; }else{ echo $_REQUEST['mostrar'];} if($_REQUEST['mostrar']<1) { echo "1"; } } ?>" onKeyPress="return acceptNum(event);" class="mostrar">
										<img src="images/search.png" style="cursor:pointer; top: 4px; position: relative;" onclick="document.mst.submit();">
										</span>	
										<input name="pagina" type="hidden" value="<?php echo $pagina;?>">
										<input name="mo" type="hidden" value="<?php echo $btver;?>" class="btn4">
										<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
										<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
										<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
										<input type="hidden" name="orderby" value="<?php echo $orderby;?>">
										<input type="hidden" name="asc" value="<?php echo $asc;?>">
										<input type="hidden" name="m" value="m">
									</form></div>
								</td>
							  </tr>
							</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<form action="v2.php" method="post" name="frm1">
							<table width="100%" border="0" class="table" cellspacing="0" cellpadding="0">						
								<tr class="vistauser1">	
									<td width="20"><?php if(($rus1["tipo"]) =="root"){ ?>
										<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php }else{ echo "&nbsp;"; }?>
									</td>	
									<td width="45"><span><b>&nbsp;&nbsp;INV</b></span></td> 
									<td width="270"><span><b><?php echo $DESCRIPCION;?></b></span></td> 
									<td width="116"><span><b><?php echo $btAreas1;?></b></span></td> 
									<td width="105"><span><b><?php echo $btMARCA;?></b></span></td> 
									<td width="122"><span><b><?php echo $btMODELO;?></b></span></td> 
									<td width="163"><span><b><?php echo strtoupper($btdatosentidad3);?></b></span></td>
								    <?php if(($rus1["tipo"]) =="root"){?><td width="70"><span><b><div align="center"><?php if(($rus1["tipo"]) =="root"){ echo $Reincorporar;}?><div></b></span></td><?php } ?>
								</tr><?php
								$i=0;
								$p=0;
								while($row=mysqli_fetch_array($result)){ $i++;
									// para saber al área a la cuál pertenece el aft defectuoso
									$sqlpertenece ="SELECT * FROM usuarios where nombre='".$row['custodio']."'";
									$resultpertenece= mysqli_query($miConex, $sqlpertenece) or die(mysql_error());
									$rowresultpertenece=mysqli_fetch_array($resultpertenece);

									$sqlDG1=mysqli_query($miConex, "SELECT * FROM datos_generales where (id_datos ='".$row["idunidades"]."')") or die(mysql_error()); 
									$sqlxDG1 = mysqli_fetch_array($sqlDG1);?>
									<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row["inv"]?>');"> 
				                        <td width="5"><?php if(($rus1["tipo"]) =="root"){ ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['inv']?>" style="cursor:pointer;" /></td><?php }else { echo "&nbsp;"; }?>	
										<td width="75"><a href='registromedios1.php?palabra=<?php echo $row["inv"];?>&rp=rp'><?php echo $row["inv"];?></a></td>
										<td><?php echo $row["descrip"];?></td>
										<td><?php echo $row["idarea"];?></td>
										<td><?php echo $row["marca"];?></td>
										<td><?php echo $row["modelo"];?></td>
										<td><?php echo $sqlxDG1["entidad"];?></td>
									    <?php if(($rus1["tipo"]) =="root"){ ?><td><div align="center"><a href="traspasos.php?inv=<?php echo $row["inv"];?>&af=<?php echo $row["inv"];?>&cod=<?php echo $row["idunidades"];?>&adestino=<?php echo base64_encode($rowresultpertenece['idarea']);?>&custo=<?php echo base64_encode($row['custodio']);?>" class="tooltip"><img src="images/retorna.png" width="17" height="17" align="absmiddle"><span onMouseOver="this.style.cursor='pointer';" ><?php echo $Reincorporar1;?></span><?php } ?></div></td>
									</tr>   <?php $p++;									
								}  ?>	
								<tr valign="bottom"> 
									<td height="33" colspan="8"><?php 
										if(($rus1["tipo"]) =="root"){ ?>&nbsp;&nbsp;&nbsp; 
											<input name="create" id="create-user" type="button" class="btn" onClick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
											<input type="hidden" name="crash"><?php
										} ?>
									</td>
								</tr>
								<tr>
									<td colspan="8">&nbsp;</td>
								</tr>								
							</table>
						</form>
					</td>
				</tr>
			</table><?php include('navegador.php');
		}	?>
<div id='detade'><div id='detadef'></div></div>
</fieldset><br><?php include ("version.php");?>

<div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
