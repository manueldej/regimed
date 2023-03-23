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
	function remmpl($texto){ 
		$a = str_ireplace("á","&aacute;",$texto);
		$e = str_ireplace("é","&eacute;",$a);
		$i = str_ireplace("í","&iacute;",$e);
		$o = str_ireplace("ó","&oacute;",$i);
		$u = str_ireplace("ú","&uacute;",$o);
		$n = str_ireplace("ñ","&ntilde;",$u);
		return $n; 
	} 
	$idiomx="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$idiomx="es"; }else{$idiomx="en";}
	}
	if(($idiomx) =="es"){include('esp.php');}else{ include('eng.php');}
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

	function COMP_exp($inv){
		include('connections/miConex.php');
		$existe = 0;

		$sql = "SELECT * FROM aft WHERE exp='".$inv."' AND categ='COMPUTADORAS'";
		$result= mysqli_query($miConex, $sql) or die(mysqli_error($miConex));	  
		$existe = mysqli_num_rows($result);
		if($existe!=0){
			return true;
		}
        return false;
	}
	
$usx = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$russx = mysqli_fetch_array($usx);
$nrusx=mysqli_num_rows($usx);

$m="";
$palab="";

if(isset($_REQUEST["m"])){ $m = "&m=m";}
$palabra="";
$logi=$_SESSION["valid_user"];
$rus = mysqli_query($miConex, "select * from usuarios where login='".$logi."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($rus);
$cuantos = 5;

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

	
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
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
///////////
///////////
		$resux = "SELECT * FROM aft";
		$result1 = mysqli_query($miConex, $resux);
		$fields1 = mysqli_num_fields($result1);
		$rows1   = mysqli_num_rows($result1);
		$fields  = mysqli_fetch_field_direct ($result1, 1); 
		$nam  = $fields->name;

	$orderby = $nam;
	$asc="ASC";
	if(isset($_REQUEST['asc'])){ $asc = $_REQUEST['asc']; }
	if(isset($_REQUEST['asc'])){ $asc = $_REQUEST['asc']; }
	if(isset($_REQUEST['orderby'])){ $orderby = $_REQUEST['orderby']; }
	if(isset($_REQUEST['orderby'])){ $orderby = $_REQUEST['orderby']; }
	
	if(isset($_REQUEST['ent'])){ $palabra = remmpl($_REQUEST['ent']); }
	if(isset($_REQUEST['ent'])){ $palabra = remmpl($_REQUEST['ent']); }


if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$sql = "SELECT * FROM aft WHERE  (descrip LIKE '%".$palabra."%' or tipo LIKE '%".$palabra."%' or inv LIKE '%".$palabra."%' or sello LIKE '%".$palabra."%' or custodio LIKE '%".$palabra."%' or marca LIKE '%".$palabra."%' or categ  LIKE '%".$palabra."%' or modelo  LIKE '%".$palabra."%') AND (idunidades='".$_COOKIE['unidades']."')";
}else{
	$sql = "SELECT * FROM aft WHERE  descrip LIKE '%".$palabra."%' or tipo LIKE '%".$palabra."%' or inv LIKE '%".$palabra."%' or custodio LIKE '%".$palabra."%' or sello LIKE '%".$palabra."%' or marca LIKE '%".$palabra."%' or categ  LIKE '%".$palabra."%' or modelo  LIKE '%".$palabra."%'";
}
$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, $orderby, $asc, $inicio, $registros);
$i=0;
	$result= mysqli_query($miConex, $query_limit);
	$ggg = base64_encode($query_limit);

	//NAVEGADOR inicio
	if(isset($_REQUEST['total_registros'])){
		$total_registros=$_REQUEST['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN ?>
<link href="css/template.css" rel="stylesheet">
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript">
	function ir(inv,idun,ini,donde){
	alert('algo');
		alert('algo');
		document.location="et.php?inv="+inv+"&idunidades="+idun+"&palabra="+ini+"&dde="+donde;
	}	
</script>
<div id="divMenu"></div>
<div id="modal6" class="modalmask">
<div class="modalbox resize" style="width: 54%; height: 343px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 563px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo strtoupper($bteditar);?> AFT</h2></div>
		<p><iframe src="modificarexp_modal.php?marcado=<?php echo $_POST['marcado'];?>&idunidades=<?php echo $_POST['idunidades'];?>&donde=v2" name="b" scrolling="Auto" width="102%" height="300" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="modal5" class="modalmask">
<div class="modalbox resize" style="width: 54%; height: 343px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 563px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo strtoupper($bteditar);?> AFT</h2></div>
		<p><iframe src="v2.php?marcado[]=<?php echo $_POST['marcado'];?>&idunidades=<?php echo $_POST['idunidades'];?>&editar" name="b" scrolling="Auto" width="102%" height="300" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="modal4" class="modalmask">
<div class="modalbox resize" style="width: 50%; height: 460px; border-radius: 5px 5px 5px 5px;">
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
<?php if(($total_registros) !=0){ ?>	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
					<input type="hidden" name="orderby" value="<?php echo $orderby;?>">
					<input type="hidden" name="asc" value="<?php echo $asc;?>">
					<input type="hidden" name="m" value="m">
			</form></div>
		</td>	
	  </tr>
	</table>
<?php
} ?>
<form action="v3.php" method="post" enctype="multipart/form-data" name="frm1">
	<table width="100%" border='0' class='table' align='center' cellpadding="0" cellspacing="0">
		<tr class="vistauser1"><?php 
			if(($total_registros) !=0){ ?>
			  <td width="20"><?php if ((@$rus1['tipo']) =="root") { ?>
				<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
				<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div><?php }else{ echo "&nbsp;"; } ?>
			  </td>
			  <td width="40">&nbsp;</td>
			  <td width="84" align="center"><a href="registromedios1.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&gral=<?php echo $gral;?>&orderby=inv<?php if(isset($_REQUEST['m'])){ ?>&m=m<?php } ?>">INV<?php if(($orderby) =="inv"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
			  <td width="197" align="center"><a href="registromedios1.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&gral=<?php echo $gral;?>&orderby=descrip<?php if(isset($_REQUEST['m'])){ ?>&m=m<?php } ?>">DESCRIPCI&Oacute;N<?php if(($orderby) =="descrip"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
			  <td width="176" align="center"><a href="registromedios1.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&gral=<?php echo $gral;?>&orderby=idarea<?php if(isset($_REQUEST['m'])){ ?>&m=m<?php } ?>">AREA<?php	if(($orderby) =="idarea"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
			  <td width="96"  align="center"><a href="registromedios1.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&gral=<?php echo $gral;?>&orderby=categ<?php if(isset($_REQUEST['m'])){ ?>&m=m<?php } ?>">CATEG.<?php	if(($orderby) =="categ"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
			  <td width="77" align="center"><a href="registromedios1.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&gral=<?php echo $gral;?>&orderby=tipo<?php if(isset($_REQUEST['m'])){ ?>&m=m<?php } ?>">TIPO<?php		if(($orderby) =="tipo"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
			  <td width="177" align="center"><a href="registromedios1.php?asc=<?php if(($asc) =="ASC"){ echo "DESC";}elseif(($asc) =="DESC"){ echo "ASC";} ?>&palabra=<?php echo $palabra;?>&gral=<?php echo $gral;?>&orderby=custodio<?php if(isset($_REQUEST['m'])){ ?>&m=m<?php } ?>">CUSTODIO<?php if(($orderby) =="custodio"){ if(($asc) =="ASC"){echo '&nbsp;&nbsp;<img src="images/as.png" border="0" width="24" height="9" align="absmiddle" title="Ascendente">';}else{ echo '&nbsp;&nbsp;<img src="images/des.png" border="0" width="24" height="9" align="absmiddle" title="Descendente">';}}?></a></td>
			  <?php 
			} else{ ?>
				<td width="134" colspan="13"><br><div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btversion1." ".$quecoin." -->".remmpl($palabra);?>.</div></div><br></td><?php 
			 } ?>
		</tr>
			<?php
			$p=0;
			while($row=mysqli_fetch_array($result)) { $i++;
				$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$row["idunidades"]."'") or die(mysql_error());
				$qsedg = mysqli_fetch_array($sedg); 
				
				// Saber nombre de la PC 
				$sqlexp = "select * from exp WHERE inv = '".$row['inv']."'";
				$result_exp= mysqli_query($miConex, $sqlexp) or die(mysql_error());
				$row_exp=mysqli_fetch_array($result_exp);
				?>
			<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="if ((document.getElementById('marcado<?php echo $p;?>').type =='checkbox') && (document.getElementById('marcado<?php echo $p;?>').checked ==false)) { document.getElementById('deta').style.display='block'; det('<?php echo $row['id']; ?>'); marca1(<?php echo $p;?>,'#ffffff'); }else{ marca1(<?php echo $p;?>,'#ffffff'); document.getElementById('deta').style.display='none'; } "onContextMenu="contextual(event,'<?php echo $row["id"]?>'); ">
				<td width="5"><?php if ((@$rus1['tipo']) =="root") { ?><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $row['id']?>" style="cursor:pointer;" /><?php }else{ echo "&nbsp;"; } ?></td>		
				<td class="Estilo2"><?php if((strtoupper($row["categ"])) =="COMPUTADORA" OR (strtoupper($row["categ"])) =="COMPUTADORAS" OR (strtoupper($row["categ"])) =="PC"){ ?>
					&nbsp;&nbsp;&nbsp;<a href="javascript:ir('<?php echo $row["inv"];?>','<?php echo $row["idunidades"];?>','<?php echo $palab;?>','rm');" class="tooltip" style="margin-left:12px;"><img src="images/pc.png" width="24" height="24" align="absmiddle"><?php if(COMP_exp($row["inv"])==true){ ?><span onmouseover="this.style.cursor='pointer';"><?php echo $verdetalles1.$row["inv"]." (".$row_exp["n_PC"].")"; ?></span><?php }else{ ?><span onmouseover="this.style.cursor='pointer';"><?php echo $row["inv"]." (Sin ".$btEXPEDIENTE1.")"; ?></span><?php } ?></a><?php 
				} ?></span></a></td>
				<td class="Estilo2"><?php  echo $row["inv"];?></td>
				<td class="Estilo2"> <?php  echo $row["descrip"];?></td>
				<td class="Estilo2"><?php  echo $row["idarea"];?></td>
				<td class="Estilo2"><?php  echo $row["categ"];?></td>
				<td class="Estilo2"> <?php  echo $row["tipo"];?></td>
				<td class="Estilo2"><?php  echo $row["custodio"];?></td>
			</tr><?php $p++;
			}?>
			<tr>
				<td colspan="7" class="Estilo2"><?php 
							if ((@$rus1['tipo']) =="root") {   
								if(($total_registros) !=0){ ?>
									<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
									<input type="hidden" name="eliminar"/>
									<input type="hidden" name="crash"/>
									<input name="editar" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" type="submit" class="btn" value="<?php echo $bteditar;?>" /><?php 
								} ?>
								<input name="insertar" type="button" onclick="document.location='form-insertaraft.php';" class="btn"  value="<?php echo $btinsertar;?>" /><?php 
							} ?>
				</td>
			</tr>
	</table>
</form>
<?php if(($total_registros) !=0){ include('navegador.php'); } ?>
<div id='deta1'><div id='deta' style="display:none;"></div></div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>