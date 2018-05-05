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
include('mensaje.php');
$meses = array($enero =>1,$febrero=>2,$marzo=>3,$abril=>4,$mayo=>5,$junio=>6,$julio=>7,$agosto=>8,$septiembre=>9,$octubre=>10,$noviembre=>11,$diciembre=>12);
$Aini=array("2000");
$Afin=array("2030");
class cdate{
	function formatDate($adate, $currTab, $futTab){
		if (!is_null($adate)){
			$sep = array();
			$sep = explode($currTab, $adate);
			return @$sep[2].@$futTab.@$sep[1].@$futTab.@$sep[0];
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
if(($rsel['visitas']) !=""){
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
$fe_bu = "";
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

		if(isset($_REQUEST['bus_fecha'])){
			if(($_REQUEST['mes']) !="-1"){
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$fe_bu = "where (fecha like '%".$_REQUEST['ano']."-".$_REQUEST['mes']."%') AND (idunidades='".$_COOKIE['unidades']."')";
				}else{
					$fe_bu = "where fecha like '%".$_REQUEST['ano']."-".$_REQUEST['mes']."%'";
				}
			}else{
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$fe_bu = "where (idunidades='".$_COOKIE['unidades']."')";
				}else{ 
					$fe_bu = ""; 
				}				
			}			
		}else{
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$fe_bu = "where (idunidades='".$_COOKIE['unidades']."')";
			}else{
				$fe_bu = "";
			}
		}		
		
$sql = "SELECT * FROM traspasos ".@$fe_bu."  order by fecha ";
$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
$result= mysqli_query($miConex, $query_limit) or die(mysql_error());
$num_resultados = mysqli_num_rows($result);
$ggg = base64_encode($query_limit);	

$sqlq = "SELECT * FROM traspasos order by fecha ";
$resultq= mysqli_query($miConex, $sqlq);
$resultq=mysqli_query($miConex, $sqlq);
$num_resultadosq = mysqli_num_rows($resultq);
//NAVEGADOR inicio
	if(isset($_REQUEST['total_registros'])){
		$total_registros=$_REQUEST['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN
?>
<style type="text/css">
<!--
.Estilo1 {font-size: 9px}
-->

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
	include('jquery.php'); 
	include('barra.php');?>
<div id="buscad"> 
<?php
$msg="";
if(isset($_REQUEST["msg"])){ $msg = base64_decode($_REQUEST["msg"]);}
if(isset($_REQUEST["msg"])){ print'<meta http-equiv="refresh" content="4;URL=r_traspasos.php"><span align="center" class="vistauser1"><em><strong><font size="2" color="red">'.$msg.'</font></strong></em></span>';}
?>
<script type="text/javascript">
	function mues_ano(va){
		if((va) !="-1"){
		document.getElementById('divc').style.display="";
		document.getElementById('bus_fecha').style.display="";
		document.getElementById('ano').style.display="";
		}else{ document.location="r_traspasos.php";}
	}
</script>
<fieldset class="fieldset"><legend class="vistauserx"><?php echo strtoupper(substr($mostrar1,0,-1).$de.$bttrasp);?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>
	<div id="openModal" class="modalDialog">
		<div>
			<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
			<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
		</div>
	</div><?php
	if(isset($_REQUEST['crash']) AND ($_REQUEST['crash']) !=""){
		$marcado=@$_REQUEST['marcado'];
		include('salva_rep.php');
		if(($marcado) ==""){
			show_message($strerror,$plea8.$bttrasp.".","cancel","r_traspasos.php"); ?>
			  <br><hr width="70%" align="center">
			<div class="Footer">
				  <div class="Footer-inner">
					 <div class="Footer-text"><p><?php include ("version.php");?></p></div>
			  </div>
			</div><?php
			exit;
		}
		 creasalva('traspasos');
		foreach($marcado as $key){
			$de = "delete from traspasos where id='".$key."'";
			$deq = mysqli_query($miConex, $de) or die(mysql_error());
		} ?>
		<script type="text/javascript">document.location="r_traspasos.php";</script><?php
	} 
	if((@$num_resultados)!=0){ ?>
	<br>
		<table width="896" height="20" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td width="640">
					<form action="" method="post" name="buscav" id="busca">
						<label><?php echo $btmes;?>:</label>
						<select name="mes" size="1" id="mes" class='boton'>
							<option onclick="mues_ano(this.value);" value="-1"><?php echo $btmostrartodo;?></option><?php
							$a=0;
							foreach($meses as $ms => $numeoq){ ?>
								<option onclick="mues_ano(this.value);" value="<?php if((@$ac) < 9){ $mm ="0".(@$ac+1); echo $mm;}else{ $mm = @$ac+1; echo @$mm;}?>" <?php if((@$mm) ==@$_REQUEST['mes']){ echo "selected";}?>><?php echo @$ms;?></option>
								<?php
								$ac++;
							} ?>
						</select>
						&nbsp;&nbsp;<label id="divc"><?php echo $btano;?>:</label>
						  <select name="ano" size="1" id="ano" class='boton'><?php
							$kk=date('Y');
							for($i=$Aini[0];$i<=$Afin[0];$i++){ ?>
									<option value='<?php echo $i;?>' <?php if(($i) ==@$_REQUEST['ano']){ echo "selected";}elseif(($i) ==$kk){ echo "selected"; }?>><?php echo $i;?></option>
								  <?php 
							} ?>
						  </select>                  
						  <input name="bus_fecha" type="submit" id="bus_fecha" class="btn4" value="<?php echo $btver;?>" />
					</form>
				</td><?php 
				if((@$num_resultados)!=0){ ?> 
					<td width="79" align="center"><div id="imprime">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><?php 
							if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
							  <td class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=traspasos&gt=r_traspasos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($s_email);?></span></a></td><?php
							} ?>
							  <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=traspasos">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
							  <td class="exel"><a class="tooltip" href="w.php?query=<?php echo $ggg;?>&tb=traspasos" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_exel);?></span></a></td>
							  <td class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=traspasos" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
							</tr>
						  </table>	
						</div></td><?php 
				} ?>
			</tr>
</table><?php 
	} 
	$i= 0;
	$p=0;
	if(($num_resultados)!=0){ ?><br>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td width="788"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
					<form name="mst" method="post" action="" id="mst">
						<span><?php echo $cantidadmost;?>:</span>
						<span style="position: absolute; margin-left: 0%; margin-top: -11px;">
						    <span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
						    <span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
						    <input name="mostrar" id="vers" type="text"  size="1" readonly  value="<?php if (!isset($_REQUEST['mostrar'])) { if ($rowsp['visitas']>$total_registros) { echo $total_registros; }else{ echo $registros; } }else{ echo $registros; } ?>" onKeyPress="return acceptNum(event);" class="mostrar">
						    <img src="images/search.png" style="cursor:pointer; top: 4px; position: relative;" onclick="document.mst.submit();">
						</span>	
							<input name="pagina" type="hidden" value="<?php echo $pagina;?>">
							<input name="mo" type="hidden" value="<?php echo $btver;?>" class="btn4">
							<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
							<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
							<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
					</form></div>
				</td>
			</tr>	
		</table>
	
		<form name="frm1" id="frm1" method="post" action="">
			<TABLE width="90%" BORDER='0' align="center" cellpadding="0" class="table" cellspacing="0" >
				<tr class="vistauser1">
					 <td width="40"><?php if(($rus1["tipo"]) =="root"){ ?>
						<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
						<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php }else{ echo "&nbsp;"; }?>	
					</td>
					
					<td width="67" align="center" class="vistauser1"><b><span class="Estilo4">INV</span></b></td>
					<td width="140" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $DESCRIPCION;?></span></b></td>
					<td width="17" class="vistauser1"><div align="center"><b><span class="Estilo4"><?php echo strtoupper($Fecha);?></span></b></div></td>	  
					<td width="164" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo strtoupper($selectmot);?></span></b></td>
					<td width="132" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $btORIGEN;?></span></b></td>
					<td width="123" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $btDESTINO;?></span></b></td>
				    <td width="215" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo strtoupper($btdatosentidad3);?></span></b>&nbsp;</td>
				</tr><?php
					while ($row=mysqli_fetch_array($result))	{	$i++;
						$sqlDG1=mysqli_query($miConex, "SELECT * FROM datos_generales where (id_datos ='".$row["idunidades"]."')") or die(mysql_error()); 
						$sqlxDG1 = mysqli_fetch_array($sqlDG1); 

						$sqlaft=mysqli_query($miConex, "SELECT descrip FROM aft where idunidades ='".$row["idunidades"]."' AND id_area='".$row["id_area"]."' AND inv='".$row["inv"]."'") or die(mysql_error()); 
						$rowaft = mysqli_fetch_array($sqlaft); 
						
						?>
						<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row["id"]?>');"> 
				            <td width="5"><?php if(($rus1["tipo"]) =="root"){ ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['id']?>" style="cursor:pointer;" /> <?php } ?></td>	
							<td align="center"><a href="registromedios1.php?palabra=<?php echo $row["inv"];?>"><?php echo $row["inv"];?></a></td>
							<td align="center"><?php echo $rowaft["descrip"];?></td>
							<td width="17" align="center"><?php echo $myDate->formatDate($row["fecha"],"-","/");?></td>
							<td><?php if(($row["motivo"]) !="") { echo $row["motivo"];}else{ echo "-"; }?></td>
							<td><?php echo $row["origen"];?></td>
							<td><?php echo $row["destino"];?></td>
							<td><?php echo $sqlxDG1["entidad"];?></td>
						</tr><?php $p++;
						
					} ?>
		  </TABLE>
			<?php 
			if(($rus1["tipo"]) =="root"){ ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<table width="324" border="0" cellspacing="0" cellpadding="0">
					<tr> 
						<td>&nbsp;&nbsp;&nbsp; 
						<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
						<input type="hidden" name="crash">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="sal" id="sal" type="button" class="btn" value="<?php echo $btrestaurar;?>" onClick="javascript:document.location='sal_mtto.php?tb=traspasos&legen=Traspasos.';"></td>
					</tr>
				</table> <?php
			} ?>
		</form><?php 
			include('navegador.php');
	}else{ 
		for ($a=1; $a<=count($meses); $a++){
			foreach ($meses as $key => $numeo) {
				$mx = str_replace("0","",@$_REQUEST['mes']);
				if (($mx) ==$numeo){
					$num = $key;
					break;
				}	 
			}
		} ?>
		<table align="center" width="50%" border="0" cellspacing="2" cellpadding="2">
			<tr> 
				<td align="center"><br><div align="center"><div class="message" align="center">
						<?php echo $noregitro3;?><b><?php echo $bttrasp;?></b><?php echo strtolower($enlinea); if(isset($_REQUEST['bus_fecha'])){ echo "con fecha: <b><font color='red'>".$num."/".$_REQUEST['ano']."</font></b>"; } ?>.</div></div><?php 
						if(($rus1["tipo"]) =="root"){ ?>
							<br><br>
							<input name="sal" id="sal" type="button" class="btn" value="<?php echo $btrestaurar;?>" onclick="javascript:document.location='sal_mtto.php?tb=traspasos&legen=Traspasos.';"><?php	
						} ?>
				</td>
			</tr>
		</table><?php	
	}?>
</fieldset><br>
<?php include ("version.php");?>
</div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
	function veo1(){
		document.location="r_traspasos.php";
	}

	function veo(){
		document.getElementById('divc').style.display="none";
		document.getElementById('bus_fecha').style.display="none";
		document.getElementById('ano').style.display="none";
	}
	veo();
</script>
