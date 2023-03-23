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
?>
<html>	
<script type="text/javascript" src="js/main.js"></script>  
  <script type="text/javascript">
	function ir(va,cut){
		document.location="et.php?categ="+va+"&cut="+cut;
	}
	function esconde(val){
		document.getElementById("area").style.display = "none";
		
		 if((val) !=area) {
				 document.getElementById("area").style.display = "block";
			}else 
				document.getElementById("area").style.display = "none";	
		if((val) =area){
			document.getElementById(val).style.display = "block";
		}else if((val) ==""){
			document.getElementById("-1").style.display = "block";
		}
	}

	function llena(valor){
		document.getElementById('area').style.display="block";
		esconde(valor);
	}
	
	function cheqec(v){
			if((v) =="t"){
				document.getElementById('labelareas').style.display='block';  
				document.getElementById('comboareas').style.display='block';
				document.getElementById("cheq").style.visibility='';
			}
			if((v) =="f"){
				document.getElementById('labelareas').style.display='none';  
				document.getElementById('comboareas').style.display='none';
				document.getElementById('usuar').style.display='none';
				document.getElementById('labelus').style.display='none';
				document.getElementById("cheq").style.visibility='hidden';
			}
			for (i=0;i<frm1.elements.length;i++)   {
				if((v) =="t"){
					document.getElementById("che"+i).style.visibility='';
				}else if((v) =="f"){
					document.getElementById("che"+i).style.visibility='hidden';
				}
			}
	}
	
	</script> 
<?php

	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$idunid=$_COOKIE['unidades'];
	}else{
		$sql_uactivab = "select * from datos_generales";
		$result_uactivab= mysqli_query($miConex, $sql_uactivab) or die(mysqli_error());
		$ractivab = mysqli_fetch_array($result_uactivab);
		$idunid = $ractivab['id_datos'];		
	}
		
$us = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysqli_error());
$russ = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us);

if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$query_Reco = "SELECT * FROM areas where idunidades='".$_COOKIE['unidades']."' AND nombre !='Reparaciones'" ;
}else{
	$query_Reco = "SELECT * FROM areas where idunidades='1' AND nombre !='Reparaciones'" ;
}

$Record = mysqli_query($miConex, $query_Reco) or die(mysqli_error());
$totalRows_Records = mysqli_num_rows($Record);
		
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($miConex, $sel) or die(mysqli_error());
$rsel = mysqli_fetch_array($qsel);
$cuantos = 5;

if((@$rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
$i=0;
$palabra="";
$palab="";
if(isset($_POST['palabra'])){ $palabra = $_POST['palabra'];}
if(isset($_POST['palabra'])){ $palabra = $_POST['palabra'];}
$chequeado="";
if(isset($_GET['chequeado'])){ $chequeado = $_GET['chequeado'];}

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
	
	if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$query_Recordset4 = "SELECT * FROM usuarios WHERE idunidades='".$_COOKIE['unidades']."' order by nombre";
	}else{
		$query_Recordset4 = "SELECT * FROM usuarios order by nombre"; 
	}	
	$Recordset4 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error());


	if((@$_GET["adestino"]) !=""){
		if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$adestn = base64_decode($_GET["adestino"]);
		$nomcus=base64_decode(($_GET['nom_custo']));
		$counid = $_COOKIE['unidades'];
			$query_Recordset41 = "SELECT * FROM usuarios where id_area = '".$adestn."' AND idunidades='".$counid."' AND nombre !='".$nomcus."'";
		}else{
			$adestn = base64_decode($_GET["adestino"]);
			$nomcus=base64_decode($_GET['nom_custo']);
			$query_Recordset41 = "SELECT * FROM usuarios where id_area ='".$adestn."' AND nombre !='".$nomcus."'";
		}
	   $Recordset41 = mysqli_query($miConex, $query_Recordset41) or die(mysql_error());
    }

	if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql1 = "SELECT * FROM aft WHERE idunidades='".$_COOKIE['unidades']."' order by custodio";
	}else{
		$sql1 = "SELECT * FROM aft order by custodio";
	}	
	
	$resultado = mysqli_query($miConex, $sql1) or die("La consulta fall&oacute;: " . mysql_error());
	$row1 = mysqli_fetch_array($resultado);
	$nom_custo = "all"; 
    $quer =  " WHERE custodio = '".$nom_custo."'"; 
	$quer =  " "; 
	
	if(isset($_POST['nom_custo'])){
		$nom_custo = htmlentities($_POST['nom_custo']);
		if(($nom_custo) !="all"){
			if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$quer =  " WHERE custodio = '".$nom_custo."' AND idunidades='".$_COOKIE['unidades']."'";
			}else{
				$quer =  " WHERE custodio = '".$nom_custo."'";
			}
		}else{
			if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$quer =  " WHERE  idunidades='".$_COOKIE['unidades']."'";
			}else{
				$quer =  "";
			}
		}		
	}
	
	if(isset($_GET['nom_custo'])){
		$nom_custo = (base64_decode($_GET['nom_custo']));
		if(($nom_custo) !="all"){
			if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$quer =  " WHERE custodio = '".$nom_custo."' AND idunidades='".$_COOKIE['unidades']."'";
			}else{
				$quer =  " WHERE custodio = '".$nom_custo."'";
			}
		}else{
			if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$quer =  " WHERE  idunidades='".$_COOKIE['unidades']."'";
			}else{
				$quer =  "";
			}
		}		
	}

	$sql = "SELECT * FROM aft".$quer;
	$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
	$result= mysqli_query($miConex, $query_limit);


//NAVEGADOR inicio
	 if(isset($_GET['total_registros']))  {  
	  $total_registros=$_GET['total_registros'];
	 } else { 
		 $all_rsDA = mysqli_query($miConex, $sql) or die(mysqli_error);
		 $total_registros = mysqli_num_rows($all_rsDA);	
	 }
	 $total_paginas = ceil($total_registros / $registros);

//NAVEGADOR	FIN
?>
<style type="text/css">
<!--
.Estilo2 {font-weight: bold}
.Estilo3 {font-size: 12px}
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
<script type="text/javascript">
	function camcust(){
		var emptyForm = true;
		with (document.form1c){      
			emptyForm = (nom_custo.value == "");		
			if (!emptyForm)	{
				submit();	
			}	
		}
	}
	
	function envia(key,ncust,most){
		document.location='?adestino='+key+'&nom_custo='+ncust+'&mostrar='+most;
		alert(key+mcust+most);
	}
</script>

<body>
<?php
 $aftt = base64_encode($sql);
 include('barra.php');?>
<div id="buscad"> 
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $registr5.$de.$btCustodios1;?><?php if(($unidadactiva) !=""){ echo "&nbsp;&nbsp;&nbsp;".$btdatosentidad3.": <font color='red'>".$unidadactiva."</font>"; }?></legend>
<?php

$semean = mysqli_query($miConex, "select id from aft") or die(mysqli_error());
$nsemean = mysqli_num_rows($semean);
   
    if(($total_filas) >1){ ?> <!-- Seleccionar Unidades si existiera mas de una --> 
		<form action="" method="post" name="formU"><?php echo $btdatosentidad2;?>:
			<select name="unidades" id="unidades" class="boton" onchange="cambiaunidad(this.value,'registrocustodio.php');">
				<option value="-1"><?php echo $btmostrartodo1?></option><?php 
			while ($row1=mysqli_fetch_array($reado)){ ?>					
				<option value="<?php echo $row1['id_datos'];?>" <?php if((@$row1['id_datos']) ==@$_COOKIE['unidades']){ echo "selected";}?>><?php echo @$row1['entidad'];?></option><?php
			} ?>
			</select>
				<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
				<input name="palabra" type="hidden"  value="<?php echo $palabra;?>">
				<input name="total_registros" type="hidden" value="<?php echo $total_registros;?>">			
		</form><?php 
	}
	
	if(($nsemean) ==0){ ?>
		<div align="center"><div class="message" align="center"><?php echo $noregitro3." ".$btversion1;?>.</div></div><?php
	} else { ?> <!-- Tabla central que agrupa todo -->
	<table width="100%" height="122" border="0" align="center">
		<tr>
			<td height="42" colspan="6" align="right"><?php 
				if(($total_registros) !=0){ ?>
				<div id="imprime">
				  <table width="15%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="email"><a class="tooltip" href="pdf/mail.php?query=<?php echo $aftt;?>&tb=aft&gt=registrocustodio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($s_email);?></span></a></td>
                      <td class="pdf"><a class="tooltip" href="pdf/tuto1.php?query=<?php echo $aftt;?>&tb=aft">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_pdf);?></span></a></td>
                      <td class="exel"><a class="tooltip" href="expregmedios.php" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($cr_exel);?></span></a></td>
                      <td class="printer"><a class="tooltip" href="imprimir/index.php?tb=aftt&qr=<?php echo $aftt;?>" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';"><?php echo strtoupper($sav_print);?></span></a></td>
                    </tr>
                  </table>	
				</div><?php
				} ?>
			</td>
		</tr>
		<tr>
			<td colspan="6"><b><?php echo $btlistacust;?></b></td>
		</tr>
		<tr>
			<td width="11%"><!-- selecciona custodio -->
				<form action="registrocustodio.php" method="post" name="form1c" onchange="camcust();">
					<select name="nom_custo" size="1" class="combo_box" id="nom_custo">
						<option value="all"><?php echo $btmostrartodo;?></option><?php
							while ($row_Recordset4 = mysqli_fetch_array($Recordset4)) {  ?>
						<option onclick="camcust();" value="<?php echo $row_Recordset4['nombre'];?>"<?php if((($nom_custo)) ==$row_Recordset4['nombre']){ echo "selected";}?>><?php echo $row_Recordset4['nombre']." (".$row_Recordset4['login'].")"?></option><?php
						} ?>
					</select>
				</form>
			</td><!-- marcar check traspaso -->
			<td width="12%"><?php
				if(($total_registros) !=0){ ?>
					<form id="form2" name="form2" method="post" action="">
			  			<label id="checkbx" <?php if((isset($_POST['nom_custo']) AND ($_POST['nom_custo']) !="all" ) OR (isset($_GET['adestino'])) OR ($chequeado) =="s"){ ?>style="display:block;" <?php }else{ ?>style="display:none;"<?php } ?>>
			  			<input name="traspa" style="cursor:pointer;" type="checkbox" id="traspa"  value="traspa"  <?php if(isset($_GET['adestino'])){ echo "checked"; }?> onClick="if((this.checked) ==false){ cheqec('f'); }else{ cheqec('t'); document.getElementById('labelareas').style.display='block'; document.getElementById('comboareas').style.display='block'; document.getElementById('cheque1').style.display='block'; }"  />
			  			<?php echo $bttrasp; ?></label>
			  		</form><?php
				} ?>
			</td><!-- Seleccione el area destino -->
			<td width="17%"><span id="labelareas" <?php if(isset($_GET['adestino'])){ ?>style="display:block; text-align:right;" <?php }else{ ?>style="display:none; text-align:right;"<?php } ?>><b><?php echo $btAreas1." ".$btDESTINO; ?></b></span></td>
			<td width="14%">
				<div id="comboareas" <?php if(isset($_GET['adestino'])){ ?>style="display:block;" <?php }else{ ?>style="display:none;"<?php } ?>>
					<select class="combo_box" name="area" size="1" id="area" onchange=" if((this.value) =='-1'){ document.getElementById('usuar').style.display='none'; document.getElementById('labelus').style.display='none';}">
                  			<option value="-1"><?php echo $seleccione.$El.substr($btAreas,0,-1)." ".ucfirst($btDESTINO);?></option> <?php
							  while ($row_R = mysqli_fetch_array($Record)) {  
								if((@$rse['idarea']) !=$row_R['nombre']){	?>
                  					<option onclick=" envia('<?php echo base64_encode($row_R['idarea'])?>','<?php echo @base64_encode($nom_custo);?>','<?php echo $total_registros;?>');" value="<?php echo $row_R['idarea'];?>"<?php if(($row_R['idarea']) ==@$adestn){echo "selected";}?>><?php echo $row_R['nombre'];?></option><?php
								}
							} ?>
           			</select>
				</div>
			</td><!-- Seleccione el custodio destino -->
	        <td width="25%"><span id="labelus" <?php if(isset($_GET['adestino'])){ ?>style="display:block; text-align:right;" <?php }else{ ?>style="display:none; text-align:right;"<?php } ?>><b><?php echo strtoupper($btusuario); ?></b></span></td>
		   
		   <td width="21%"><?php if (@$Recordset41!="") { ?><div id="usuar" <?php if(isset($_GET['adestino'])){ ?> style="display:block;" <?php }else{ ?>style="display:none;"<?php } ?>>
                  <select class="combo_box" name="custodio" size="1" id="custodio" onchange="if((this.value) !='-1'){ muestraboton('s','<?php echo base64_decode($_GET['adestino']);?>'); document.getElementById('custodiod').value=this.value;}else{ muestraboton('n',''); }">
				  	<option value="-1">Seleccione el Usuario</option><?php									
				 	  while ($row_Recordset4 = mysqli_fetch_array($Recordset41)) {  ?>
                    <option value="<?php echo $row_Recordset4['nombre']?>" <?php if(isset($_REQUEST['custo'])){ if((base64_decode($_REQUEST['custo'])) ==$row_Recordset4['nombre']){ echo "selected"; }	}?>><?php echo $row_Recordset4['nombre']?></option>
                    <?php } ?>
                  </select>
		   </div><?php } ?>
			</td>
		<tr></tr>
		<tr>
			<td colspan="6"><?php
			if(($total_registros) !=0){ ?>	
				<div style="position: relative; margin-top: 7px; padding-bottom: 8px;">
					<form name="mst" method="get" action="" id="mst">
						<span><?php echo $cantidadmost;?>:</span>
						<span style="position: absolute; margin-left: 0%; margin-top: -11px;">
						<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'ascendente');" style="cursor:pointer; position: absolute; margin-left: 30px; margin-top: 5px; z-index: 999;"><img src="gfx/asc.png"></span>
						<span onClick="mueve('vers',getElementById('vers').value,<?php echo $total_registros; ?>,'descendente');" style="cursor:pointer; position: absolute; margin-top: 17px; margin-left:30px; z-index: 999;"><img src="gfx/desc.png"></span>
							<input name="mostrar" id="vers" type="text"  size="1" readonly  value="<?php if (!isset($_REQUEST['mostrar'])) { if ($rowsp['visitas']>$total_registros) { echo $total_registros; }else{ echo $registros; } }else{ echo $registros; } ?>" onKeyPress="return acceptNum(event);" class="mostrar">
							<img src="images/search.png" style="cursor:pointer; top: 4px; position: relative;" onclick="document.mst.submit(); if((document.getElementById('traspa').checked) ==true){ document.formx.chequeado.value='s';} ">
						</span>	
							<input name="chequeado" id="chequeado" type="hidden">
							<input name="pagina" type="hidden" value="<?php echo $pagina;?>">
							<input name="mo" type="hidden" value="<?php echo $btver;?>">
							<input name="total_paginas" type="hidden" value="<?php echo $total_paginas;?>">
							<input name="palabra" type="hidden"  value="<?php echo @$palabra;?>">
							<input name="total_registros" type="hidden"  value="<?php echo $total_registros;?>">
							<input type="hidden" name="orderby" value="<?php echo $orderby;?>">
							<input type="hidden" name="asc" value="<?php echo $asc;?>">
							<input type="hidden" name="m" value="m">
							<input type="hidden" name="nom_custo" value="<?php echo base64_encode($nom_custo);?>" />
					</form>
				</div>
			<?php
			} ?>
			<form action="trasp1.php" method="post" enctype="multipart/form-data" name="frm1">
				<table width="100%" border="0" class="table" align="center" cellpadding="0" cellspacing="0">
					<tr class="vistauser1" >
					   <?php if(($total_registros) !=0){ ?>
                      <td id="cheq">
						<div id="cheque1" onClick="marcar_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
						<div id="cheque2" onClick="desmarca_todo();" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent; display:none; cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
					  </td>
                      <td><div align="left">&nbsp;</div></td>
					  <td><div align="left"><b><font color="black">INV.</font></b></div></td>
					  <td><div align="left"><b><font color="black"><?php echo $DESCRIPCION;?></font></b></div></td>
					  <td><div align="center"><b><font color="black"><?php echo strtoupper($btestado);?></font></b></div></td>
					  <td><div align="center"><b><font color="black"><?php echo $btAreas1;?></font></b></div></td>
					  <td><div align="center"><b><font color="black">CATEG.</font></b></div></td>
					  <td><div align="center"><b><font color="black"><?php echo strtoupper($btCustodios);?></font></b></div></td>
					  <?php }else{ ?>
					  <td colspan="7"><b><font color="black"><?php echo $btnoregistro; ?></font></b></td>
					  <?php } ?>
					</tr><?php 	
					$id = 0; 
					$p=0;			
					while($row= mysqli_fetch_array($result)) { $i++; 
					  // Saber nombre de la PC 
						$sqlexp = "select * from exp WHERE inv = '".$row['inv']."'";
						$result_exp= mysqli_query($miConex, $sqlexp) or die(mysql_error());
						$row_exp=mysqli_fetch_array($result_exp);?>
						
						 <tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff');"> 
							<td><?php if (($russ['tipo']) =="root") { ?><span id="che<?php echo $p;?>" style="visibility:hidden;"><div id="chequeadera<?php echo $p;?>" style="background:url(gfx/checkbox.gif) no-repeat scroll 0 -15px transparent;">&nbsp;&nbsp;&nbsp;&nbsp;</div><input name="marcado[]" type="checkbox" style="display:none; cursor:pointer;" id="marcado<?php echo $p;?>" onClick="marca1('<?php echo $p;?>','#ffffff')" value="<?php echo $row["id"]; ?>" /></span><?php	}?></td>
                            <td><?php if((strtoupper($row["categ"])) =="COMPUTADORA" OR (strtoupper($row["categ"])) =="COMPUTADORAS" OR (strtoupper($row["categ"])) =="PC"){ ?>
						  &nbsp;&nbsp;&nbsp;<a href="javascript:ir('<?php echo $row["inv"];?>','<?php echo $row["idunidades"];?>','<?php echo $palab; ?>','rm');" class="tooltip"><img src="images/pc.png" width="24" height="24" align="absmiddle"><span onmouseover="this.style.cursor='pointer';"><?php echo $verdetalles1.$row["inv"]." (".$row_exp["n_PC"].")";?></span></a><?php
						} ?></td>
						<td><div align="justify"><?php echo $row["inv"];?></div><input name="invent1[]" type="hidden" value="<?php echo $row["inv"];?>">                                                </td>
						<td><?php  echo $row["descrip"];?></td>
						<td><div align="center"><?php  echo $row["estado"];?></div></td>
						<td><?php  echo $row["idarea"];?></td>
						<td><?php  echo $row["categ"];?></td>
						<td><?php  echo $row["custodio"];?></td>
					    </tr><?php $p++;  
					}?>
						<tr><td colspan="9"><input name="unidades" type="hidden" value="<?php echo $idunid;?>"><input name="area" id="area" type="hidden" value="<?php echo @base64_decode($_GET['adestino']);?>"><input name="custodiod" id="custodiod" type="hidden"><input name="motivos" id="motivos" type="hidden" value="Cambio de Custodio"><input name="cambio" id="cambio" type="hidden"></td></tr>
					<tr>
						<td class="Estilo2" colspan="9"><?php
							if ((@$russ['tipo']) =="root") {
								if ((@$total_registros) >1){ ?>
									<br>&nbsp;<?php 
								}
							}?>
						<span id="subm" style="height: 27px; position: relative; left: 30px; top: 2px; display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="btn" name="traspz" id="traspz" value="<?php echo $btotrotras1;?>" style="height: 27px;" onclick="return alerta('<?php echo $strerror;?>','<?php echo $plea1." ".$bttrasp2;?>','');" /></span>
						</td>
				    </tr>
			  </table>
			</form>
			<?php include('navcustodio.php');?></td>
		</tr>
		</tr>	
		</table>
		<?php
    } ?>
</fieldset><br>
<?php include ("version.php");?>
<div class="ContenedorAlert" id="cir"></div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
 function marcacust(rw,co1)  {   
	if ((document.getElementById("marcado"+rw).type=="checkbox")&&(document.getElementById("marcado"+rw).checked==false))	 { 
		document.getElementById("cur_tr_"+rw).style.backgroundColor='#DBE2D0';
		document.getElementById("marcado"+rw).checked=true;
	}    else     { 
	    //document.getElementById("cur_tr_"+rw).style.backgroundColor=co1;
		document.getElementById("marcado"+rw).checked=false;
	}
 } 
 function muestraboton(s,v){
 	if((s) =='s'){
	 	document.getElementById("subm").style.display='block';
		document.frm1.area.value=v;
	}else{
		document.getElementById("subm").style.display='none';
		document.frm1.area.value='';
	}
 }
 	function cheqec(v){
		if((v) =="t"){
			document.getElementById('labelareas').style.display='block';  
			document.getElementById('comboareas').style.display='block';
			document.getElementById("cheq").style.visibility='';
		}
		if((v) =="f"){
			document.getElementById('labelareas').style.display='none';  
			document.getElementById('comboareas').style.display='none';
			document.getElementById('usuar').style.display='none';
			document.getElementById('labelus').style.display='none';
			document.getElementById("cheq").style.visibility='hidden';
		}
		for (i=0;i<frm1.elements.length;i++)   {
			if((v) =="t"){
				document.getElementById("che"+i).style.visibility='';
			}else if((v) =="f"){
				document.getElementById("che"+i).style.visibility='hidden';
			}
		}
			
	}
	<?php if(isset($_GET['adestino'])){  ?>
		for (i=0;i<frm1.elements.length;i++)   {
				document.getElementById("che"+i).style.visibility='';
		}<?php	
	 } ?>
 </script>
 </body>
 </html>