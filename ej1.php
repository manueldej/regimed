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
$validus = "";
if(isset($_SESSION["autentificado"])){
	$validus = " AND idunidades='".$_SESSION["autentificado"]."'";
}elseif (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$validus = " AND idunidades='".$_COOKIE['unidades']."'";
}else{
	$validus = "";
}
$us1 = mysqli_query($miConex, "SELECT * FROM usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);
if((@$rus1['tipo']) !="root"){ ?>
	<script type="text/javascript">document.location="v1.php?marcado[0]=<?php echo $rus1['id'];?>&editar";</script><?php exit;
}
$i=0;
$palabra="";

if(isset($_REQUEST['palabra'])){ $palabra = $_REQUEST['palabra'];}
$sel = "SELECT visitas FROM preferencias where usuario='".$_SESSION['valid_user']."'";
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
///////////
	if(($palabra) ==""){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
			$sql = "SELECT * FROM usuarios WHERE idunidades = '".$_COOKIE['unidades']."'";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
			$contx1 = "SELECT * FROM usuarios WHERE idunidades = '".$_COOKIE['unidades']."'  kk  limit ".$inicio.",".$registros;
		}else{
			$sql = "SELECT * FROM usuarios ORDER BY nombre";
			$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);	
			$contx1 = "SELECT * FROM usuarios  kk  limit ".$inicio.",".$registros;
		}
	}else{
		$sql = "SELECT * FROM usuarios WHERE  login LIKE '%".$palabra."%' or nombre LIKE '%".$palabra."%' or idunidades = '".$palabra."'";
		$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
		$contx1 = "SELECT * FROM usuarios WHERE  login LIKE '%".$palabra."%' or nombre LIKE '%".$palabra."%' or idunidades = '".$palabra."'  kk  limit ".$inicio.",".$registros;
	}
	$result= mysqli_query($miConex, $query_limit);
//NAVEGADOR inicio
	if(isset($_REQUEST['total_registros'])){
		$total_registros=$_REQUEST['total_registros'];
	} else {
		$all_rsDA = mysqli_query($miConex, $sql);
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN
$ggg=base64_encode($sql);
$contx = base64_encode($contx1);
?>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<?php	include('jquery.php'); ?>
	<script type="text/javascript" src="ajax.js"></script>
	<script type="text/javascript">
		function hacer(valo){
			document.location="v1.php?marcado[]="+valo+"&modificar=Modificar";

		}
		function limpia(){
			document.getElementById('palabra1').value ="";
		}
	</script>
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
</style><?php 
	include('barra.php');?>
<form action="#modal5" method="post" name="contel" id="contel">
	<input name="editar" value="1" type="hidden">
	<input name="marcado" id="marcado" type="hidden">
</form>
<form action="v0.php" method="post" name="conted" id="conted">
	<input name="crash" value="1" type="hidden">
	<input name="marcado[]" id="marcado" type="hidden">
</form>
<script type="text/javascript">
function accion(id,q){
	if((q) =="ed"){
		document.contel.marcado.value=id;
		document.contel.submit();
	}else{
		if(confirm('<?php echo $cuidado;?>')){
			document.conted.marcado.value=id;
			document.conted.submit();
		}
	}
}

function contextual(event,id){
		var iX = event.clientX;
		var iY = event.clientY;
		event.preventDefault();
		$('#divMenu').css({
			display:	'block',
			left:		iX,
			top:		iY
		});

		$('#divMenu').html('<ul><li><a style="cursor:pointer; text-decoration:none;" onclick="accion(\''+id+'\',\'ed\');"><img title="Editar..." align="asbmiddle" src="images/editar.png" width="16" height="16">&nbsp;&nbsp;Editar</a></li><li><a style="cursor:pointer; text-decoration:none;" onclick="accion(\''+id+'\',\'el\');"><img align="asbmiddle" src="images/delete.png" width="16" height="16" title="Eliminar...">&nbsp;&nbsp;Eliminar</a></li></ul>');
}
</script>
<div id="modal4" class="modalmask">
<div class="modalbox resize" style="width: 548px; height: 370px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 570px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo $mostrar1.$de.$new6; ?>: <?php echo $new1;?></h2></div>
		<p><iframe src="registro2.php" name="b" scrolling="Auto" width="102%" height="350" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="modal5" class="modalmask">
<div class="modalbox resize" style="width: 541px; height: 340px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -13px; width: 563px; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2  class="pos"><?php echo $musuario1;?></h2></div><hr>
		<p><iframe src="v0.php?editar&marcado[]=<?php echo $_REQUEST['marcado'];?>" name="b" scrolling="Auto" width="102%" height="400" frameborder="0" class="notice" border="0"></iframe></p>
	</div>
</div>
<div id="divMenu"></div>
<div id="buscad">
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $mostrar1.$de.$new6; ?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
		</div>
		<table width="100%" border="0" align="center">
			<tr><?php
			if(($total_filas) >1){  ?>
				<td>
					<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
						<SELECT name="unidades" id="unidades" class="form-control" style="margin-top: -20px; margin-left:73px; width:57%;" onchange="cambiaunidad(this.value,'ej1.php');">
							<option value="-1"><?php echo $btmostrartodo1?></option><?php 
								while ($row1=mysqli_fetch_array($reado)){ ?>					
									<option value="<?php echo @$row1['id_datos'];?>" <?php if((@$row1['id_datos']) ==@$_COOKIE['unidades']){ echo "SELECTed";}?>><?php echo @$row1['entidad'];?></option><?php
								} ?>
						</SELECT>
							<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
							<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
							<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">				
					</form>
				</td><?php 
			} ?>
				<td ><?php if(($total_filas) ==1){ echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; } ?><strong class="componentheading"><?php echo $filtr.substr($Por1,0,-1);?>:</strong>&nbsp;
				  <input name="palabra2" type="text" id="palabra1" size="20" autocomplete="off" class="imput" align="middle" value="<?php echo $bttextobuscar;?>..." onKeyUp="mand(this.value);" onClick="limpia();"/>
				</td>
			   <td width="22%" align="right">
					<div id="imprime" style="margin-left:45px; margin: 0px 65px;">
						<table width="76" border="0" cellspacing="0" cellpadding="0">
							<tr><?php 
								if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
								  <td width="19%" class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $ggg;?>&tb=usuarios&gt=ej1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($s_email);?></span></a></td>
								  <?php
								} ?>
								  <td width="19%" class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=usuarios">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a></td>
								  <td width="20%" class="exel"><a class="tooltip" href="expusuarios.php?query=<?php echo $ggg;?>&tb=usuarios" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_exel);?></span></a></td>
								  <td width="42%" class="printer"><a class="tooltip" href="imprimir/index.php?inicio=<?php echo $inicio;?>&registros=<?php echo $registros;?>&tb=usuarios" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
							</tr>
						</table>				  
					</div>
				</td>
			</tr>
		</table>
		<div id="vistausua">
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
						</form></div>
					</td>
				</tr>
		</table>
		<form name="frm1" method="post" action="v1.php">
		<table width="100%" border='0' class='table' cellpadding="0" cellspacing="0">
				<tr class="vistauser1">
					 <td width="20">
						<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:block; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
						<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					</td>
					<td width="90" align='center'><div align="left"><b>LOGIN</b></div></td>
					<td width="200" align='center'><div align="left"><b><?php echo strtoupper($btNombre);?></b></div></td>
					<td width="150" align='center'><div align="left"><b><?php echo strtoupper($btnCargo);?></b></div></td>
					<td width="198" align='center'><div align="left" ><b><?php echo strtoupper('E-mail');?></b></div></td>
					<td width="205" align='center'><div align="left"><b><?php  echo strtoupper($unidad); ?></b></div></td>
					<td width="205" align='center'><div align="left"><b><?php  echo strtoupper('area'); ?></b></div></td>
					<td width="100" align='center'><div align="left"><b><?php  echo strtoupper($bttipo); ?></b></div></td>
				    <td width="87" align='center'><div align="left"><b><?php echo strtoupper($Sexo);?></b></div></td>
				</tr>  
				<?php   	
				$i=0;
				$p=0;
					//$arreg = array();
				while($row=mysqli_fetch_array($result))    {  $i++;
					$selent=mysqli_query($miConex, "SELECT * FROM datos_generales where id_datos='".$row['idunidades']."'") or die(mysql_error()); 
					$rselun=mysqli_fetch_array($selent);
					$idf = $row["id"];  
			
					?>
					<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#CCFFCC');" onclick="marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $idf; ?>');"> 
				       <td width="5"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none;" id="marcado<?php echo $p;?>" onClick="marca1(<?php echo $p;?>,'#ffffff'); " value="<?php echo $idf; ?>" style="cursor:pointer;" /></td>	
						<td width="46"><?php echo $row["login"];?></td>
						<td><?php echo $row["nombre"];?></td>
						<td><?php echo $row["cargo"]; ?></td>
						<td><?php echo $row["email"];?></td>
						<td><?php echo $rselun['entidad'];?></td>
						<td><?php echo $row["idarea"];?></td>
						<td><?php echo $row["tipo"]; if ($row["tipo"]=='rsi') { echo "&nbsp;<a class='tooltip' href='#'><span>".$rsi."</span><img title='".$rsi."' src='images/rsi.png' width='20' height='20'></a>"; } ?></td>
						<td align="center">&nbsp;&nbsp;<?php if(($row["sexo"]) =="m"){ echo "<img src='images/female.png' width='16' height='18'>";} elseif(($row["sexo"]) =="h"){ echo "<img src='images/admin.png' width='16' height='18'>";}else{ echo "-";}?> </td>						
					</tr>
			          <?php  	$p++;	 
				} ?>
					<tr>
					  <td colspan="9"></td>
					</tr>
			<tr>
				<td colspan="9">
					<input name="create" id="create-user" type="button" class="btn" onclick="checkLength('<?php echo $strerror;?>','<?php echo $plea1.$bteliminar;?>','d');" value="<?php echo $bteliminar;?>"/>
					<input type="hidden" name="crash">&nbsp;&nbsp;
					<input name="editar" type="submit" class="btn" onClick="return alerta('<?php echo $strerror;?>','<?php echo $plea1.$bteditar;?>','');" value="<?php echo $bteditar;?>" />
					&nbsp;&nbsp;
					<input name="insertar"  type="button" onclick="document.location='#modal4';" class="btn"  value="<?php echo $btinsertar;?>" />
				</td>
			</tr>
		</table></form>
			<?php include('navegador.php');?>
		</div>
</div>
</fieldset><br>
	<?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>