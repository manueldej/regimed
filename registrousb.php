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
include('script.php');

$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;
$us1 = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION["valid_user"]."'") or die(mysql_error());
$rus1 = mysqli_fetch_array($us1);
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
   $sqluser = "SELECT tipo FROM usuarios where login='".$_SESSION['valid_user']."'";
   $resultuser = mysqli_query($miConex, $sqluser) or die (mysql_error());
   $resultuser = mysqli_fetch_array($resultuser);
                        
// SQL para la busqueda
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$sql = "SELECT * FROM aft where ((categ='FLASH') OR (categ like '%HDDEXTERNOS%') OR (categ like '%MEMORIA%')) AND (idunidades='".$_COOKIE['unidades']."') order by inv limit ".$inicio.",".$registros;
}else{
	if (isset($_REQUEST['custo']) AND $_REQUEST['custo']!="" ) {
	 $custo = $_REQUEST['custo'];
	 $sql = "SELECT * FROM aft where ((categ='FLASH') OR (categ like '%MEMORIA%') OR (categ like '%HDDEXTERNOS%') AND (custodio like '%".$custo."%'))";
	}else{
		$sql = "SELECT * FROM aft where ((categ='FLASH') OR (categ like '%MEMORIA%') OR (categ like '%HDDEXTERNOS%'))";
	}
	 
}
$i=0;
$query_limit = sprintf("%s ORDER BY %s %s LIMIT %d, %d",$sql, "inv", "ASC", $inicio, $registros);
$result= mysqli_query($miConex, $query_limit) or die (mysql_error());
$num_resultados = mysqli_num_rows($result);
$ggg = base64_encode($sql);

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
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<?php include('jquery.php'); ?>
<script type="text/javascript">
	function hace(valo){
		document.location="v2.php?marcado[]="+valo+"&editar";
	}
</script>
<?php include('barra.php');?>
<div id="divMenu"></div>
<div id="modal4" class="modalmask">
<div class="modalbox resize" style="background-color:#ffffff; width: 543px; height: 460px; border-radius: 5px 5px 5px 5px;">
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
<div id="modal5" class="modalmask">
<div class="modalbox resize" style="background-color:#ffffff; width: 543px; height: 460px; border-radius: 5px 5px 5px 5px;">
<div style="height: 25px; border-color: rgb(0, 109, 138); border-radius: 4px 4px 0 0;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);	
	background-color: #DA4F49;
    background-image: linear-gradient(to bottom, #EE5F5B, #BD362F);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffe3e3; padding: 1px 0px 16px 9px; margin-left: -16px; width: 105%; border-radius: 5px; vertical-align:middle;"><a href="#close" original-title="<?php echo $btclose;?>" class="close tip-s medium  barramenu" style="text-decoration:none; color: #F8F3F3;">X</a>
<h2 class="pos"><?php echo strtoupper($new3.$btregmedio1);?></h2></div>
	<p><iframe src="v2.php" name="b" scrolling="Auto" width="102%" height="400" frameborder="0" class="notice" border="0"></iframe></p>
</div>
</div>
<div id="buscad"> 
	<fieldset class='fieldset'><legend class="vistauserx"><?php echo strtoupper($btrecords.$de.$Memorias);?></legend>
		<div id="openModal" class="modalDialog">
			<div>
				<button title="<?php echo $cerrar2;?>" class="closex" type="button" onclick="document.location='#closex';">X</button>
				<div align="justify"><div><?php echo $seguro;?><hr><input class="btn" onclick="document.location='#closex';" value="<?php echo $btcancelar;?>">&nbsp;<input id="ok" class="btn" onclick="bValid();" value="<?php echo $btaceptar;?>"></div></div>			
			</div>
		</div>
		<table width="100%" border="0" align="center">
		<tr><?php
	         if(($total_filas) >1){ ?>
				<td width="26%">
					<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
						<select name="unidades" id="unidades" class="form-control" onchange="cambiaunidad(this.value,'registromedios1.php');">
							<option value="-1"><?php echo $btmostrartodo1?></option><?php 
							while ($row1=mysqli_fetch_array($reado)){ ?>					
								<option value="<?php echo @$row1['id_datos'];?>" <?php if((@$row1['id_datos']) ==@$_COOKIE['unidades']){ echo "selected";}?>><?php echo @$row1['entidad'];?></option><?php
							} ?>
						</select>
						<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
						<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
						<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">				
					</form>
		  </td><?php } 
			if(($total_registros) !=0){  ?>
				<td width="450" align="right"><b>Filtrar Custodio:</b></td>
				<td width="450"><form name="formulario" method="post" action=""><i style="background: transparent url(&quot;images/glyphicons-halflings.png&quot;) repeat scroll -408px -140px; height: 20px; width: 16px; float: left; margin-left: 6px; position: absolute; margin-top: 3px;"></i><input type="text" style="width: 75%; padding-left: 21px;" class="form-control" name="custo" id="custo" onKeyup="memorias(this.value);" onClick="document.getElementById('custo').value=''; memorias(this.value);" ></form></td>
		       	<td width="22%" align="right">
					<div id="imprime" style="margin-left:45px; margin: 0px 65px;">
					  <table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr><?php 
						if(($_SESSION['valid_user']) !="invitado" AND ($total_registros) !=0){ ?>
						  <td width="17%" class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo @$ggg;?>&tb=aft&gt=registromedios1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($s_email);?></span></a></td>
						  <?php
						} ?>
						  <td width="19%" class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $ggg;?>&tb=aft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_pdf);?></span></a></td>
						  <td width="21%" class="exel"><a class="tooltip" href="expregmedios.php?query=<?php echo $ggg;?>&tb=aft" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_exel);?></span></a></td>
						  <td width="43%" class="printer"><a class="tooltip" href="imprimir/index.php?query=<?php echo $ggg;?>&tb=aft" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($sav_print);?></span></a></td>
						</tr>
					  </table>	
					</div>
		        </td><?php 
			} ?>
		</tr>
	</table>
		<div id="buscamem">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tablen"><?php 
			if ($num_resultados !=0){?>
				<tr> 
					<td width="288"><div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
						<form name="mst" method="get" action="" id="mst">
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
										<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="exped('<?php echo $row['id'];?>', false); marca1(<?php echo $p;?>,'#ffffff')" onContextMenu="contextual(event,'<?php echo $row["id"]?>');"> 
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
								<td align="center"><br><div align="center"><div class="message" align="center"><?php echo $btnoregistro.$de.$Memorias;?></div></div></td>
							</tr>
						</table>				   
					</td>
				</tr><?php 
			}?>
		</table>
		</div> 
</fieldset><br>
   <?php include ("version.php");?></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>