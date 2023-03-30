<?php
#############################################################################################################
# Software: Regimed                                                                                         #
#(Registro de Medios Informáticos)     					                                		            #
# Version:  3.1.1                                                     				                        #
# Fecha:    01/06/2016                                             					                        #
# @autor  Ing. Manuel de Jesús Núñez Guerra   								     			                #
#          	Msc. Carlos Pollan Estrada											         		            #
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
@session_start(); include('../chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="../index.php";</script><?php
	exit;
}
require_once('../connections/miConex.php');
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('../esp.php');}else{ include('../eng.php');}
    
	$categ =$_REQUEST['categ'];
	
	if ($_POST['tb']=="bajas_exp"){
		$donde = 'bajas_aft'; 
		$dondemas = 'bajas_exp';
	}elseif ($_POST['tb']=="exp"){
		$donde = 'aft';
		$dondemas = 'exp';
	}
	
	if (isset($_REQUEST['idunidades']) AND ($_REQUEST['idunidades']) !=""){ 
		$query="select * from ".$donde." where inv='".@$categ."' AND idunidades='".$idunidadesc."'";
	}else{
		$query="select * from ".$donde." where inv='".@$categ."'";
	}
    

	$result=mysqli_query($miConex, $query);
	$row = mysqli_fetch_array ($result);
	$idunddes= $row["idunidades"];

$palabra ="";
$dde="";
$varCPU = array('marca','cpuid','fabricante','socket','cpucores','cpulogicos');
$varMemorias = array('marca','modelo','no_serie','fabricante','capacidad','tasa','frecuencia');
$varDiscoDuro = array('marca','modelo','no_serie','fabricante','capacidad','tasa','cache','rpm');
$varTarjetaGrafica = array('marca','modelo','no_serie','fabricante','capacidad','frecuencia');
$varcomponente = array($varCPU,$varMemorias,$varDiscoDuro,$varTarjetaGrafica);
$Uactb1="";

if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$Uactb = " AND idunidades='".$_COOKIE['unidades']."'";
	$Uactb1 = " AND id_datos='".$_COOKIE['unidades']."'";
}

$sqltipo = "select * from usuarios Where tipo='rsi'";
$resultipD= mysqli_query($miConex, $sqltipo) or die(mysql_error());
$RespSI = mysqli_fetch_array($resultipD);

$sqlD = "select * from datos_generales".$Uactb1;
$resultD= mysqli_query($miConex, $sqlD) or die(mysql_error());
$DatosG = mysqli_fetch_array($resultD);


	if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql1="SELECT * FROM `".$dondemas."` where inv='".@$categ."' and idunidades='".$_COOKIE['unidades']."'"; 
	}elseif (isset($_REQUEST['idunidades']) AND ($_REQUEST['idunidades']) !=""){
		$sql1="SELECT * FROM `".$dondemas."` where inv='".@$categ."' and idunidades='".$_REQUEST['idunidades']."'"; 
	}else{
		$sql1="SELECT * FROM `".$dondemas."` where inv='".@$categ."'"; 
	}

$result1=mysqli_query($miConex, $sql1) or die (mysql_error());
$result2=mysqli_query($miConex, $sql1) or die (mysql_error());
$num_resultados1 = mysqli_num_rows($result1);
$num_resultados2 = mysqli_num_rows($result2);

$seledtgn = mysqli_query($miConex, "select * from datos_generales where id_datos = '".$row["idunidades"]."'")  or die (mysql_error());
$qseledtgn = mysqli_fetch_array($seledtgn);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Exp_Tecnico</title>
<link href="../template.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo6 {
	font-size: 17px;
	color: #000000;
}
.Estilo25 {font-size: 18px}
.Estilo27 {font-size: 16px}
.Estilo28 {font-size: 12px}
.Estilo29 {font-size: 11px}
-->
</style>
</head>
<body onLoad="javascript:print()"><?php 
echo "<div align='center'><img src='../images/logoaplicacion.png' width='102' height='62'></div>";
echo "<div align='center'>". $DatosG['entidad'].".<br></div>".
 "<div align='center'>".$DatosG['web']."</div><br>";
?>
	<table width="95%" border="1" align="center" cellspacing="0" cellpadding="0"><?php
	if(($num_resultados1) !=0){ ?>
	    <tr>
		   <td colspan="2"><img src="../images/cabeceraET.jpg" width="100%" height="75"><?php if ($dondemas=="bajas_exp") {?>
		     <span style="color:red;margin-top: 15px;position: absolute;margin-left: -813px;font-size: 25px;font-size-adjust: ic-height;"><?php echo strtoupper($para_baja); ?></span>
		   <?php } ?>
		   </td>
		</tr><?php 
			$result3=mysqli_query($miConex, $sql1) or die (mysql_error());
			$rowq=mysqli_fetch_array($result3);
			$custoq=$rowq["custodio"];
			$nomb_PCq = $rowq["n_PC"];
			$idunidasq = $rowq["idunidades"];
			$area_respq = $rowq["idarea"];
			$sello_s = $row["sello"];
			$serie_s = $row["no_serie"];
			$sqlcargo ="SELECT * FROM usuarios WHERE nombre='".$custoq."'";
			$resulcargo =mysqli_query($miConex, $sqlcargo) or die (mysql_error());
			$filacargo = mysqli_fetch_array($resulcargo); ?>
		<tr>
			<td colspan="2">
			<table width="100%" border="1" cellspacing="0" cellpadding="0">
			  <tr>
				<td><span><?php echo $btEXPEDIENTE1;?></span></td>
				<td><span>&nbsp;<b><?php echo @$categ; ?></b></span></td>
				<td><span><?php echo $btdatosentidad3; ?></span></td>
				<td><span><b>&nbsp;<?php echo $qseledtgn['entidad']; ?></b></span></td>
			  </tr>
			  <tr>
				<td width="181"><span><?php echo $apodo1.$dela3;?>PC:</span></td>
				<td width="392">&nbsp;<span><b><?php echo $nomb_PCq; ?></b></span></td>
				<td width="86"><span ><?php echo substr($btAreas,0,-1);?>:</span></td>
				<td width="300">&nbsp;<b><?php echo $rowq['idarea']; ?></b></td>
			  </tr>
			  <tr>
				<td><span><?php echo $btResponsable; ?>:</span></td>
				<td><span>&nbsp;<b><?php echo $custoq; ?></b></span></td>
				<td><span><?php echo $btnCargo; ?>:</span></td>
				<td>&nbsp;<b><?php echo $filacargo['cargo']; ?></b></td>
			  </tr>
			  <tr>
				<td><span><?php echo ucwords(strtolower($btSELLO));?>:</span></td>
				<td><span>&nbsp;<b><?php echo $sello_s; ?></b></span></td>
				<td><span class="vistauser1"><b><?php echo $serie1; ?>:</b></span></td>
				<td><?php echo $serie_s; ?></td>
			  </tr>
			</table>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="2"><?php
				if(($num_resultados1) !=0){
					$row2=mysqli_fetch_array($result2);
					$custo=$row2["custodio"];
					$nomb_PC = $row2["n_PC"];
					$idunidas = $row2["idunidades"];
					$area_resp = $row2["idarea"];?>
					<br>
						<font size="3"><b>&nbsp;<?php echo $Comp;?></b>
						<br>
						<table width="100%" border='1' cellpadding="0" cellspacing="0" >
							<tr>
								<td width="10%" align="center"><span ><b>CPU<b></span></td>
								<td width="15%" align="center"><span ><b>MOTHERBOARD<b></span></td>
								<td width="15%" align="center"><span ><b>CHIPSET<b></span></td>
								<td width="15%" align="center"><span ><b>HDD/CD/DVD<b></span></td>
								<td width="15%" align="center"><span ><b>HDD/CD/DVD<b></span></td>
							</tr><?php 
						while ($row=mysqli_fetch_array($result1)){ 
							$red3 = explode('*',$row["RED2"]);?>
							<tr>
								<td valign="top" >
								 <?php 
									  $sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$row["CPU"]."'";
									  $rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
									  $filacomp = mysqli_fetch_array($rescpt);
									  $numre = mysqli_num_rows($rescpt);
								
									foreach ($varcomponente[0] as $clave => $valor) { 
										   $nombcampo[] = $valor; 
									}?>
								<span>&nbsp;<?php echo strtoupper($row['CPU']); ?></span>
								<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" >
									<?php if ($numre!=0) { 
									 for ($a=0; $a<count($nombcampo); $a++) { ?>
									<tr>
									   <td width="46%" align="right"><?php echo strtoupper($nombcampo[$a]); ?>:</td>
									   <td width="54%">&nbsp;<?php echo $filacomp[$nombcampo[$a]]; ?></td>
									</tr><?php } } ?>
								</table>
								</td>
								<td valign="top">&nbsp;<?php echo $row["PLACA"] ?></td>
								<td valign="top" width="15%">&nbsp;<?php echo $row["CHIPSET"] ?></td>
								<td valign="top" width="27%">
								 <?php 
								  $sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$row["DRIVE1"]."'";						
								  $rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								  $filacomp = mysqli_fetch_array($rescpt);
								  $numre = mysqli_num_rows($rescpt);
										  
								 	foreach ($varcomponente[2] as $clave => $valor) { 
										$nombcampo1[] = $valor; 
									}
								?>
								<span>&nbsp;<?php echo @$row["DRIVE1"] ?></span>
								<table align="center" border="0" cellspacing="0" cellpadding="0" ><?php if ($numre!=0) { 
									 for ($a=0; $a<count($nombcampo1); $a++) { ?>
									<tr>
									  <td width="46%" align="right"><?php echo strtoupper($nombcampo1[$a]); ?>:</td>
									  <td width="54%">&nbsp;<?php echo $filacomp[$nombcampo1[$a]]; ?></td>
									</tr><?php } ?>
									<tr>
										<td width="46%" align="right">INTERFAZ: </td>
										<td width="54%"><?php echo $filacomp['interfaz'];?></td>
									</tr><?php } ?>
								</table><?php } ?>		
								</td>
								<td valign="top" width="27%">
								  <?php 
								  $sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".@$row["DRIVE2"]."'";
								  $rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								  $filacomp = mysqli_fetch_array($rescpt);
								  $numre = mysqli_num_rows($rescpt);
								    
									foreach ($varcomponente[2] as $clave => $valor) { 
										$nombcampo2[] = $valor; 
									}
								?>
								<span>&nbsp;<?php echo @$row["DRIVE2"] ?></span>
								<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" ><?php 
								if ($numre!=0) { 
									for ($a=0; $a<count($nombcampo2); $a++) { ?>
										<tr>
										  <td width="46%"><?php echo strtoupper($nombcampo2[$a]); ?></td>
										  <td width="54%"><b><?php echo $filacomp[$nombcampo2[$a]]; ?></b></td>
										</tr><?php 
									} ?>
									<tr>
										<td width="46%">INTERFAZ</td>
										<td width="54%"><b><?php echo $filacomp['interfaz'];?></b></td>
									</tr><?php
								} ?>	
								</table>
								</td>
							</tr>
						</table>
						<br><?php 
				        }
				$sql="SELECT * FROM ".$dondemas." WHERE custodio='".@$custo."' AND inv ='".@$categ."' and idunidades='".@$idunidas."'"; 
				$result=mysqli_query($miConex, $sql);
				$num_resultados = mysqli_num_rows($result);

                //Saber los AFT que se integran al Exp.
				$sqlact="SELECT * FROM ".$donde." WHERE custodio='".@$custo."' AND inv LIKE '".@$categ."%' and idunidades='".@$idunidas."' and categ!='COMPUTADORAS'"; 
				$resulaft=mysqli_query($miConex, $sqlact);
				$num_resultaft = mysqli_num_rows($resulaft);
				
				$sqla="SELECT * FROM ".$donde." WHERE custodio='".@$custo."' AND inv !='".@$categ."' and idunidades='".@$idunidas."' and categ!='COMPUTADORAS'"; 
				$resulta=mysqli_query($miConex, $sqla);
				$num_resultadosa = mysqli_num_rows($resulta);
				
				if ($num_resultados !=0){ ?>
				    <table width="100%" border='0'  cellpadding="0" cellspacing="0"> 
						<tr> 
							<td width="10%" align="center"><span ><b><?php echo $Memorias1;?></b></span></td>
							<td width="10%" align="center"><span ><b><?php echo $Memorias1;?></b></span></td>
							<td width="10%" align="center"><span ><b><?php echo $Memorias1;?></b></span></td>
							<td width="10%" align="center"><span ><b><?php echo $Memorias1;?></b></span></td>
						</tr><?php 
				
						while ($row = mysqli_fetch_array($result)) { 
							$memoriasf = explode('*',$row["MEMORIA2"]);
							$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$row["MEMORIA"]."'";
							$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
							$filacomp = mysqli_fetch_array($rescpt);
							$numre = mysqli_num_rows($rescpt);
								    foreach ($varcomponente[1] as $clave => $valor) { 
										$nombcampo3[] = $valor; 
									}?>
						<tr>
							<?php if ($row['MEMORIA']!="") { ?>
							<td valign="top"><span><?php echo $row["MEMORIA"] ?></span>
							    <table width="100%" border="0" cellspacing="0" cellpadding="0" ><?php if ($numre!=0) { 
								 for ($a=0; $a<count($nombcampo3); $a++) { ?>
								<tr>
							        <td width="46%" align="right"><?php echo strtoupper($nombcampo3[$a]); ?>:</td>
									<td width="54%"><?php echo $filacomp[$nombcampo3[$a]]; ?></td>
								</tr><?php } ?>
								<tr>
									<td width="46%" align="right">TIPO :</td>
									<td width="54%"><?php echo $filacomp['tipo'];?></td>
								</tr><?php } ?>	
								</table><?php } ?>	
							</td>
							<td valign="top"><?php 
								$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$memoriasf[0]."'";
								$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								$filacomp = mysqli_fetch_array($rescpt);
								$numre = mysqli_num_rows($rescpt);
										foreach ($varcomponente[1] as $clave => $valor) { 
											$nombcampo4[] = $valor; 
										} ?>
								<span><?php echo @$memoriasf[0];?></span>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" ><?php if ($numre!=0) {
									 for ($a=0; $a<count($nombcampo4); $a++) { ?>
									<tr>
									   <td width="46%"><?php echo strtoupper($nombcampo4[$a]); ?></td>
									   <td width="54%"><b><?php echo $filacomp[$nombcampo4[$a]]; ?></b></td>
									</tr><?php } ?>
									<tr>
									   <td width="46%">TIPO</td>
									   <td width="54%"><b><?php echo $filacomp['tipo'];?></b></td>
									</tr><?php } ?>	
								</table>
							</td> 
							<td valign="top"><?php 
								$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$memoriasf[1]."'";
								$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								$filacomp = mysqli_fetch_array($rescpt);
								$numre = mysqli_num_rows($rescpt);
										foreach ($varcomponente[1] as $clave => $valor) { 
											$nombcampo5[] = $valor; 
										}?>
								<span><?php echo @$memoriasf[1];?></span>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" ><?php if ($numre!=0) { 
									 for ($a=0; $a<count($nombcampo5); $a++) { ?>
									<tr>
									  <td width="46%"><?php echo strtoupper($nombcampo5[$a]); ?></td>
									  <td width="54%"><b><?php echo $filacomp[$nombcampo5[$a]]; ?></b></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%">TIPO</td>
									  <td width="54%"><b><?php echo $filacomp['tipo'];?></b></td>
									</tr><?php } ?>
								</table>	
							</td>
							<td valign="top"><?php 
								$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$memoriasf[2]."'";
								$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								$filacomp = mysqli_fetch_array($rescpt);
								$numre = mysqli_num_rows($rescpt);
										foreach ($varcomponente[1] as $clave => $valor) { 
											$nombcampo6[] = $valor; 
										}?>
								<span><?php echo @$memoriasf[2];?></span>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" ><?php if ($numre!=0) { 
									 for ($a=0; $a<count($nombcampo6); $a++) { ?>
									<tr>
									  <td width="46%"><?php echo strtoupper($nombcampo6[$a]); ?></td>
									  <td width="54%"><b><?php echo $filacomp[$nombcampo6[$a]]; ?></b></td>
									</tr><?php } ?>
									<tr>
									  <td width="46%">TIPO</td>
									  <td width="54%"><b><?php echo $filacomp['tipo'];?></b></td>
									</tr><?php } ?>
								</table>	
							</td>
						</tr>
			        </table><br>
					<table width="100%" border='1' cellpadding="0"  cellspacing="0"  >
							<tr>
								<td width="8%" align="center"><span ><b><?php echo $btRED;?>-1</b></span></td>
								<td width="8%" align="center"><span ><b><?php echo $btRED;?>-2</b></span></td>
								<td width="8%" align="center"><span ><b><?php echo $btRED;?>-3</b></span></td>
							</tr>
							<tr>
								<td valign="top">&nbsp;<?php echo $row["RED"] ?></td>
								<td valign="top">&nbsp;<?php echo @$red3[0]; ?></td>
								<td valign="top">&nbsp;<?php echo @$red3[1]; ?></td>
							</tr>
					</table><br>
					<table width="100%" border='1'  cellpadding="0" cellspacing="0" > 
						<tr> 
							<td width="20%" align="center"><span><b><?php echo $btSONIDO;?></b></span></td>
							<td width="8%" align="center"><span><b><?php echo $bttargeta;?></b></span></td>
							<td width="20%" align="center"><span><b><?php echo $btdevice;?>-3</b></span></td>
							<td width="20%" align="center"><span><b><?php echo $btdevice;?>-4</b></span></td>
							<td width="20%" align="center"><span><b><?php echo $btFUENTE;?></b></span></td>	
						</tr>
						<tr>
							<td valign="top">&nbsp;<?php echo $row["SONIDO"] ?></td>
							<td width="29%"><?php 
								$sqlcpt = "SELECT * FROM componentes WHERE componentes.idexp='".$categ."' AND componentes.nombre = '".$row["GRAFICS"]."'";
								$rescpt = mysqli_query($miConex, $sqlcpt) or die (mysql_error());
								$filacomp = mysqli_fetch_array($rescpt);
								$numre = mysqli_num_rows($rescpt);
										foreach ($varcomponente[3] as $clave => $valor) { 
											$nombcampo7[] = $valor; 
										}?>	
								<span><?php echo $row["GRAFICS"];?></span>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" ><?php if ($numre!=0) { 
									 for ($a=0; $a<count($nombcampo7); $a++) { ?>
									<tr>
									  <td width="15%" align="right"><?php echo strtoupper($nombcampo7[$a]);?>:</td>
									  <td width="60%">&nbsp;<?php echo $filacomp[$nombcampo7[$a]];?></td>
									</tr><?php } ?>
									<tr>
										<td width="46%" align="right">INTERFAZ :</td>
										<td width="54%"><?php echo $filacomp['interfaz'];?></td>
									</tr><?php } ?>	
								</table>
							</td> 
							<td valign="top" width="20%">&nbsp;<?php echo $row["DRIVE3"]; ?></td> 
							<td valign="top" width="20%">&nbsp;<?php echo $row["DRIVE4"]; ?></td>
							<td valign="top" width="10%">&nbsp;<?php echo $row["FUENTE"]; ?></td> 							
						</tr>
						<tr>
						    <td colspan="5">
						    <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="47%"><div align="center"><b>SISTEMA OPERATIVO</b></div></td>
							  </tr>
							  <tr>
								<td><div align="center"><?php echo $row["OS"] ?></div></td>
							  </tr>
							</table>
							</td> 
						</tr>
						
						<?php 
		} ?>
		<tr>
						    
			</td>
					</table><br>
				  <?php if ($num_resultaft >= 1) { ?>
					<font size="3">&nbsp;<b><?php echo $btotros;?></b>
					<table width="95%" border='0' cellpadding="0" cellspacing="0" align="center" > 
							 <tr> 
								 <td><span ><b>INV</b></span></td>
								 <td><span ><b><?php echo $DESCRIPCION;?></b></span></td>
								 <td><span ><b><?php echo $btSELLO;?></b></span></td>
								 <td><span ><b><?php echo $btMARCA;?></b></span></td>
								 <td><span ><b>NO. <?php echo $serie1;?></b></span></td>
								 <td><span ><b><?php echo $btMODELO;?></b></span></td>
								 <td><span ><b>CATEG.</b></span></td>
								 <td><span ><b><?php echo strtoupper($bttipo);?></b></span></td>
							 </tr><?php 
							while ($rowa = mysqli_fetch_array($resulaft)) { ?>
								<tr>
									<td>&nbsp;<?php echo $rowa["inv"]; ?></td>
									<td>&nbsp;<?php echo $rowa["descrip"];?></td> 
									<td>&nbsp;<?php echo $rowa["sello"]; ?></td>
									<td>&nbsp;<?php echo $rowa["marca"]; ?></td>
									<td>&nbsp;<?php echo $rowa["no_serie"]; ?></td>
									<td>&nbsp;<?php echo $rowa["modelo"] ;?></td>
									<td>&nbsp;<?php echo $rowa["categ"]; ?></td>
									<td>&nbsp;<?php echo $rowa["tipo"]; ?></td>
								</tr>&nbsp;<?php 
							} ?>
				  </table>
               		<div class="navegador" align="center" style="width:100%"><?php echo $bttmecateg2;?>: <font color=red><?php echo $num_resultadosa; ?></div></p><hr> <?php 
				        } 
			    } ?>
			</td>
		</tr>
		<tr>
		  <td colspan="2">
		    <table border="0" width="100%">
				<tr>
				    <td colspan="2"><div align="left">Responsable del Medio</div></td>
					<td colspan="3"><div align="left">Especialista en Seguridad Inform&aacute;tica</div></td>
				</tr>
				<tr>
				    <td width="20%" height="23"><div align="left">Nombre y Apellidos:</div></td>
					<td width="29%"><span style="text-decoration:underline;">
					<?php echo $custoq; ?></td>
				    <td width="20%"><div align="left">Nombre y Apellidos:</div></td>
				    <td width="22%"><span style="text-decoration:underline;"><?php echo $RespSI['nombre']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span></td>
					
				</tr>
				<tr>
				    <td><div align="left">Firma:</div></td>
				    <td><span style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
				    <td><div align="left">Firma:</div></td>
				    <td><span style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
				</tr>
			</table></td>
		</tr>
	</table>
</body>
</html>
