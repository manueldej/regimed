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

@session_start(); include('chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=Exp_Técnico.xls");
 header("Pragma: no-cache");
 header("Expires: 0");

$i=0;
include ('connections/miConex.php');
$idunidad="";
$qio="es";
$dde="";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$qio="es"; }else{$qio="en";}
	}
	if ($qio=="es") {
	  include('esp.php');
	}else{
	  include('eng.php');
	}
	if(isset($_POST['categ'])){$categ =$_POST['categ'];}
	if(isset($_POST['marcado'])){$marcado =$_POST['marcado'];}
	if(isset($_GET['inv'])){$categ =$_GET['inv'];}
    if(isset($_GET['categ'])){$categ =$_GET['categ'];}
	if(isset($_GET['idunidades'])){$idunidadesc =$_GET['idunidades'];}
	if(isset($_GET['cut'])){$nom_custo =$_GET['cut'];}
	if(isset($_GET['marcado'])){$marcado =$_GET['marcado'];}
	if(isset($_GET['palabra'])){$palabra =$_GET['palabra'];}
	if(isset($_GET['dde'])){$dde =$_GET['dde'];}
	
	if(isset($_GET['area']) AND ($_GET['area']) !=""){
		$idunidad=" where id =".$_GET['area'];
	}
	if(isset($_GET['query'])){
		$kk= base64_decode($_GET['query']);
		if(stristr($kk,'kk') !=""){
			$se = str_ireplace('kk',$idunidad,$kk);
		}else{
			$se =$kk;
		}
	}else{
		$se = "select * from exp".$idunidad;
	}
 
 // SQL para la búsqueda
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$sql1="SELECT * FROM `exp` where inv='".@$categ."' and idunidades='".$_COOKIE['unidades']."'"; 
}elseif (isset($_GET['idunidades']) AND ($_GET['idunidades']) !=""){
	$sql1="SELECT * FROM `exp` where inv='".@$categ."' and idunidades='".$_GET['idunidades']."'"; 
}else{
	$sql1="SELECT * FROM `exp` where inv='".@$categ."'"; 
}
$result1 = mysqli_query($miConex, $se);
$result2=mysqli_query($miConex, $sql1) or die (mysql_error());
$row2=mysqli_fetch_array($result1);
$num_resultados1 = mysqli_num_rows($result1);

	$query_Recordset4 = "SELECT * FROM usuarios where login = '".$_SESSION['valid_user']."'";
	$Recordset4 = mysqli_query($miConex, $query_Recordset4) or die(mysql_error());
	$Rerow4 = mysqli_fetch_array($Recordset4);
	
	if (isset($_GET['idunidades']) AND ($_GET['idunidades']) !=""){ 
		$query="select * from aft where inv='".@$categ."' AND idunidades='".$idunidadesc."'";
	}else{
		$query="select * from aft where inv='".@$categ."'";
	}
	$result=mysqli_query($miConex, $query);
	$row12 = mysqli_fetch_array ($result);
	$idunddes= $row12["idunidades"];
	
$seledtgn = mysqli_query($miConex, "select * from datos_generales where id_datos = '".$row2["idunidades"]."'")  or die (mysql_error());
$qseledtgn = mysqli_fetch_array($seledtgn);
$leg = "";
?><html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>expexcelusuarios</title>
<?php
			$result3=mysqli_query($miConex, $se) or die (mysql_error());
			$rowq=mysqli_fetch_array($result3);
			$custoq=$rowq["custodio"];
			$nomb_PCq = $rowq["n_PC"];
			$idunidasq = $rowq["idunidades"];
			$area_respq = $rowq["idarea"];
			$sello_s = $row12["sello"];

			$sqlcargo ="SELECT * FROM usuarios WHERE nombre='".$custoq."'";
			$resulcargo =mysqli_query($miConex, $sqlcargo) or die (mysql_error());
			$filacargo = mysqli_fetch_array($resulcargo);?>
			<table width="630" border="1" cellspacing="0" cellpadding="0" style="border-color: rgb(204, 221, 240); border-style: solid;" class="table">
			  <tr>
				<td colspan="2"><span class="vistauser1"><b><?php echo $btEXPEDIENTE1;?></b></span><span class="vistauser1">:<?php echo "<font color=red class=Estilo8><strong>".@$categ."</strong></font>"; ?></span></td>
				<td><span class="vistauser1"><b><?php echo $btdatosentidad3; ?>:</b></span></td>
				<td><?php echo $qseledtgn['entidad']; ?></td>
			  </tr>
			  <tr>
				<td width="160"><span class="vistauser1"><b><?php echo $apodo1.$dela3;?>PC</b>:</span></td>
				<td width="156"><?php echo $nomb_PCq; ?></td>
				<td width="44"><span class="vistauser1"><b><?php echo substr($btAreas,0,-1);?>:</b></span></td>
				<td width="307"><?php echo $row2['idarea']; ?></td>
			  </tr>
			  <tr>
				<td width="200"><span class="vistauser1"><b><?php echo $btResponsable; ?>:</b></span></td>
				<td><?php echo $custoq; ?></td>
				<td><span class="vistauser1"><b><?php echo $btnCargo; ?>:</b></span></td>
				<td><?php echo $filacargo['cargo']; ?></td>
			  </tr>
			  <tr>
				<td><span class="vistauser1"><b><?php echo ucwords(strtolower($btSELLO));?>:</b></span></td>
				<td><?php echo $sello_s; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			</table><?php
		if($num_resultados1!=0){
					// Si hay resultados crea una tabla y los muestra		
					   // $row3=mysqli_fetch_array($result2);
						$custo=$row2["custodio"];
						$nomb_PC = $row2["n_PC"];
						$idunidas = $row2["idunidades"];
						$area_resp = $row2["idarea"]; ?>
			<table width="100%" border='1' cellpadding="0" style="border-color: rgb(204, 221, 240); border-style: solid;" cellspacing="0" class="table" >
				<tr>
				 <td width="300" colspan="8"><font size="3"><b><?php echo $Comp;?></b></font></td>
				</tr>
				<tr>
					<td width="13%"><span class="vistauser1"><strong><font color="black">CPU</font><strong></span></td>
					<td width="21%"><span class="vistauser1"><strong><font color="black">MOTHERBOARD</font><strong></span></td>
					<td width="15%"><span class="vistauser1"><strong><font color="black">CHIPSET</font><strong></span></td>
					<td width="11%"><span class="vistauser1"><strong><font color="black">HDD/CD/DVD</font><strong></span></td>
					<td width="11%"><span class="vistauser1"><strong><font color="black">HDD/CD/DVD</font><strong></span></td>
					<td width="6%"><span class="vistauser1"><strong><strong><font color="black"><?php echo $btRED;?>-1</font></strong></span></td>
					<td width="8%"><span class="vistauser1"><strong><font color="black"><?php echo $btRED;?>-2</font></strong></span></td>
					<td width="8%"><span class="vistauser1"><strong><font color="black"><?php echo $btRED;?>-3</font></strong></span></td>
				</tr><?php 
				//while ($row32=mysqli_fetch_array($result1)){
					$red3 = explode('*',$row2["RED2"]); ?>
				<tr>
					<td valign="top">&nbsp;<?php echo $row2['CPU']; ?></td>
					<td valign="top">&nbsp;<?php echo $row2["PLACA"]; ?></td>
					<td valign="top">&nbsp;<?php echo $row2["CHIPSET"]; ?></td>
					<td valign="top">&nbsp;<?php echo $row2["DRIVE1"]; ?></td>
					<td valign="top">&nbsp;<?php echo $row2["DRIVE2"]; ?></td>
					<td valign="top">&nbsp;<?php echo $row2["RED"]; ?></td>
					<td valign="top">&nbsp;<?php echo @$red3[0]; ?></td>
					<td valign="top">&nbsp;<?php echo @$red3[1]; ?></td>
				</tr><?php
				//} ?>
			<?php if((@$sello) !=""){ echo $btSELLO;?>: <?php echo "<font color=red>".@$sello."</font>"; } 
		} 
				$sql="SELECT * FROM exp WHERE custodio='".@$custo."' AND inv ='".@$categ."' and idunidades='".@$idunidas."'"; 
				$result=mysqli_query($miConex, $sql);
				$num_resultados = mysqli_num_rows($result);

				$sqla="SELECT * FROM aft WHERE custodio='".@$custo."' AND inv !='".@$categ."' and idunidades='".@$idunidas."' and categ!='COMPUTADORAS'"; 
				$resulta=mysqli_query($miConex, $sqla);
				$num_resultadosa = mysqli_num_rows($resulta);
				if ($num_resultados !=0){ ?>
				<table width="100%" BORDER='1' style="border-color: rgb(204, 221, 240); border-style: solid;" cellpadding="0" cellspacing="0" class="table" > 
						 <tr> 
							 <td width="116"><span class="vistauser1"><b><?php echo $Memorias1;?></b></span></td>
							 <td width="151"><span class="vistauser1"><b><?php echo $Memorias1;?></b></span></td>
							 <td width="165"><span class="vistauser1"><b><?php echo $Memorias1;?></b></span></td>
							 <td width="175"><span class="vistauser1"><b><?php echo $Memorias1;?></b></span></td>
							 <td width="101"><span class="vistauser1"><b><?php echo $btSONIDO;?></b></span></td>
						 </tr><?php 
						WHILE ($row = mysqli_fetch_array($result)) { 
							$memoriasf = explode('*',$row["MEMORIA2"]);?>
							<tr>
								<td><?php echo $row["MEMORIA"] ?></td> 
								<td><?php echo @$memoriasf[0];?></td> 
								<td><?php echo @$memoriasf[1];?></td>
								<td><?php echo @$memoriasf[2]; ?></td>
								<td>&nbsp;<?php echo $row["SONIDO"] ?></td>
							</tr>&nbsp;
			    </table>
			    <table width="100%" BORDER='1' style="border-color: rgb(204, 221, 240); border-style: solid;" cellpadding="0" cellspacing="0" class="table" > 
						 <tr> 
							 <td width="116"><span class="vistauser1"><b><?php echo $bttargeta;?></b></span></td>
							 <td width="151"><span class="vistauser1"><b><?php echo $btdevice;?>-3</b></span></td>
							 <td width="165"><span class="vistauser1"><b><?php echo $btdevice;?>-4</b></span></td>
							 <td width="175"><span class="vistauser1"><b><?php echo $btFUENTE;?></b></span></td>
							 <td width="101"><span class="vistauser1"><b>SO</b></span></td>
						 </tr>
							<tr>
								<td>&nbsp;<?php echo $row["GRAFICS"];?></td> 
								<td>&nbsp;<?php echo $row["DRIVE3"]; ?></td> 
								<td>&nbsp;<?php echo $row["DRIVE4"]; ?></td>
								<td>&nbsp;<?php echo $row["FUENTE"]; ?></td>
								<td>&nbsp;<?php echo $row["OS"] ?></td>
							</tr>&nbsp;<?php 
						} ?>
			    </table>
						<div class="navegador" align="center" style="width:100%"><?php echo $bttmecateg2;?>: <font color=red><?php echo $num_resultadosa; ?></font></div></p><hr> <?php 
				} ?>				
</html>