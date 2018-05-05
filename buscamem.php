<!DOCTYPE html>
<html lang="es"><?php
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
$versphpvieja = str_ireplace('.','',phpversion());
$versphpnueva = 540;
if($versphpvieja < $versphpnueva ){?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php 
}else{ ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php 
}?>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<?php
		@session_start();
		include('chequeo.php');
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
		if (!check_auth_user()){
			?><script type="text/javascript">window.parent.location="index.php";</script><?php
			exit;
		}
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php
		return;
	}else{
	 require_once('connections/miConex.php');
	} 
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}

	   if ($i=="es") {
	    include('esp.php');
	   }else{
		include('eng.php');
	   }

include('script.php');

if(isset($_SESSION["autentificado"])){
	$dage="select * from datos_generales WHERE id_datos='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$dage="select * from datos_generales WHERE id_datos='".$_COOKIE['unidades']."'";
}else{
	$dage="select * from datos_generales";
}
$qdage=mysqli_query($miConex, $dage) or die(mysql_error());
$rdage=mysqli_fetch_array($qdage);
$us = mysqli_query($miConex, "select * from usuarios WHERE login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us);

$sel = "select visitas from preferencias WHERE usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
$us1 = mysqli_query($miConex, "select * from usuarios WHERE login='".$_SESSION["valid_user"]."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);

if ($_SESSION['valid_user']!="invitado") { 
	   $sql_pref="SELECT * FROM preferencias WHERE usuario='".$_SESSION['valid_user']."'";
	   $rsul = mysqli_query($miConex, $sql_pref) or die (mysql_error());
	   $rowsp = mysqli_fetch_array($rsul);
	   
	   $query = "SELECT * FROM usuarios WHERE login='".$_SESSION['valid_user']."'";
       $result = mysqli_query($miConex, $query) or die(mysql_error());
	   $rws = mysqli_fetch_array($result);
	   
    }else{
	   $sql_pref="SELECT * FROM preferencias WHERE usuario='webmaster'";
	   $rsul = mysqli_query($miConex, $sql_pref) or die (mysql_error());
	   $rowsp = mysqli_fetch_array($rsul);
    } 
	
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
	$custo=""; 	
///////////
   $sqluser = "SELECT tipo FROM usuarios WHERE login='".$_SESSION['valid_user']."'";
   $resultuser = mysqli_query($miConex, $sqluser) or die (mysql_error());
   $resultuser = mysqli_fetch_array($resultuser);
                        
// SQL para la busqueda
if (isset($_REQUEST['custo']) AND $_REQUEST['custo']!="" ) {
 $custo = $_REQUEST['custo'];	
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$sql = "SELECT * FROM aft WHERE ((categ='FLASH') OR (categ like '%MEMORIA%') OR (categ like '%HDD EXTERNOS%')) AND (custodio like '%".$custo."%') AND (idunidades='".$_COOKIE['unidades']."')";
}else{
	$sql = "SELECT * FROM aft WHERE ((categ='FLASH' OR categ like '%MEMORIA%' OR (categ like '%HDD EXTERNOS%')) AND (custodio like '%".$custo."%'))";
}
}else{
  $sql = "SELECT * FROM aft where ((categ='FLASH') OR (categ like '%MEMORIA%') OR (categ like '%HDD EXTERNOS%'))";	
}

$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, "inv", "ASC", $inicio, $registros);
$result= mysqli_query($miConex, $query_limit) or die (mysql_error());
$num_resultados = mysqli_num_rows($result);
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
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><?php
	include('jquery.php'); ?>
	<script type="text/javascript">
		function hace(valo){
			document.location="v2.php?marcado[]="+valo+"&editar";
		}
	</script>
<div id="modal4" class="modalmask">
<div class="modalbox resize" style="width: 543px; height: 460px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -16px; width: 105%; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2 class="pos"><?php echo strtoupper($new3.$btregmedio1);?></h2></div>
		<p><iframe src="form-insertaraft.php" name="b" scrolling="Auto" width="102%" height="400" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>	
	    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tablen"><?php 
			if ($num_resultados !=0){?>
				<tr> 
					<td width="288"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
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
								<input type="hidden" name="orderby" value="<?php echo @$orderby;?>">
								<input type="hidden" name="asc" value="<?php echo @$asc;?>">
								<input type="hidden" name="custo" value="<?php echo @$custo;?>">
								<input type="hidden" name="m" value="m">
						</form></div>
					</td>	
				</tr>
		</table>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr> 
					<td valign="top">
						<form action="v2.php" method="post" enctype="multipart/form-data" name="frm1">
								<table width="100%" border='0' cellpadding="0" cellspacing="0" class="table">
									<tr class="vistauser1">
										 <td width="40">
										    <div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
										    <div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
									     </td>
										 <td width="151" align="center"><span><b>INV</b></span></td>
										 <td width="230" align="center"><span><b><?php echo $DESCRIPCION;?></b></span></td>
										 <td width="165" align="center"><span><b><?php echo $btMARCA;?></b></span></td>
										 <td width="193" align="center"><span><b><?php echo strtoupper($btCustodios);?></b></span></td>
									</tr><?php
									$p=0;
									$i=0;
										while ($row=mysqli_fetch_array($result)){ $i++; ?>
										<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row["id"]?>');"> 
			                                  <td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['id']?>" style="cursor:pointer;" /></td>												  
											  <td width="151"><a href="registromedios1.php?palabra=<?php echo $row["inv"];?>"><?php echo $row["inv"];?></a> </td>
											  <td width="230" align="center"><?php echo $row["descrip"];?></td>
											  <td align="center"><?php echo $row["marca"];?></td>
											  <td><?php echo $row["custodio"];?></td>
										</tr><?php $p++;
										} ?>
									<tr>
										<td colspan="4"><?php 
												if (($rus['tipo']) =="root") {   
													if(($total_registros) !=0){ ?>
														<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
														<input type="hidden" name="crash">
														<input name="editar" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" type="submit" class="btn" value="<?php echo $bteditar;?>" /><?php 
													} ?>
													<input name="insertar" type="button" class="btn" onclick="document.location='#modal4';" value="<?php echo $btinsertar;?>" />
													<input name="iusb" type="hidden"/><input name="u" type="hidden"/> <?php 
												} ?>
										</td>
									</tr>
								</table>
						</form>
					</td>
				</tr>
				<tr>
					<td valign="top"><?php if(($total_registros) !=0){ include('navegador.php'); } ?></td>
				</tr><?php
			}else{ ?>
				<tr> 
					<td valign="top">
						<table width="100%" border="0" cellspacing="2" cellpadding="2">
							<tr> 
								<td align="center"><br><div align="center"><div class="message" align="center"><?php echo "No hay coincidencias para <b>".$custo."</b>"; ?></div></div></td>
							</tr>
						</table>				   
					</td>
				</tr><?php 
			}?>
		</table>