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
@session_start();
$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('../esp.php');}else{ include('../eng.php');}
	require_once('../connections/miConex.php');
$sqlD = "select * from datos_generales";
$resultD= mysqli_query($miConex, $sqlD) or die(mysql_error());
$DatosG = mysqli_fetch_array($resultD);
$Uact = "";
if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$Uact = $_COOKIE['unidades'];
}else{
	$sql_uactiva = "select * from datos_generales";
	$result_uactiva= mysqli_query($miConex, $sql_uactiva);
	$ractiva = mysqli_fetch_array($result_uactiva);
	$Uact = $ractiva['id_datos'];
} ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>RegiMed -<?php echo $btversion;?>-</title>
<link rel="shortcut icon" href="../images/logo_10814142.png" />
<link href="../css/template.css" rel="stylesheet">
	<body onLoad="javascript:print()"><?php
		echo "<div align='center'><img src='../images/logoaplicacion.png' width='62' height='62'></div>";
		echo "<font size='2'><div align='center'class='article_column Estilo1'>..:REGISTRO DE MEDIOS INFORM&Aacute;TICOS:..<br></div>".
				 "<div align='center'>". $DatosG['entidad'].".<br></div>".
				  "<div align='center'><a href='". $DatosG['web']."'>". $DatosG['web']."</a></div></font><br>"; ?>
	<table class="" width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td colspan="8" align="left" valign="top"></td>
		</tr>
		<tr>
			<td width="16%"><strong><?php echo $btversion1;?></strong></td>
			<td width="16%" align="center"><strong>Total</strong>			</td>
			<td width="14%" align="center"><b><?php echo $btenuso;?></b></td>
			<td width="14%" align="center"><b><?php echo $btrotas;?></b></td>
			<td width="14%" align="center"><b><?php echo $btPBajas;?></b></td>
		    <td width="14%" align="center"><b><?php echo $btenred;?></b></td>
		    <td width="14%" align="center"><b>Internet</b></td>
		    <td width="14%" align="center"><b>Intranet</b></td>
		</tr>
  		<tr>
			<td colspan="8"><hr></td>
		</tr><?php
			    $sql = "select * from areas where idunidades='".$Uact."'";
				$result= mysqli_query($miConex, $sql) or die(mysql_error());
				$nucap=mysqli_num_fields($result);
				$nufil=mysqli_num_rows($result);
				$rows = mysqli_fetch_array($result);
				$TG=0;
				$tuso=0;
				$trotas=0;
				$tbajas=0;
				$TG_R = 0;
				$TG_inter = 0;
				$TG_intra = 0;
				$count =0;
				$p=0;
		
				for($n=1; $n<$nucap; $n++){ 					
					$field = mysqli_fetch_field_direct($result, $n);
					$name1  = $field->name;
					$flags = $field->flags;
					
					if (($name1 !='idunidades') and ($name1 !='nombre'))  { 
						//total generall
						
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$sql1="SELECT SUM(".$name1.") as total FROM areas WHERE idunidades='".$Uact."'";
						}else{
							$sql1="SELECT SUM(".$name1.") as total FROM areas";
						}	
												
						$quesql1 = mysqli_query($miConex, $sql1) or die(mysql_error());
						$totU = mysqli_fetch_array($quesql1);
						$TG  = $TG + $totU['total']; 
						
						//en uso
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consulta  = "SELECT COUNT(estado) as enuso FROM aft WHERE  estado = 'A' AND categ='".strtoupper($name1)."' AND idunidades='".$Uact."'";
						}else{
							$consulta  = "SELECT COUNT(estado) as enuso FROM aft WHERE  estado = 'A' AND categ='".strtoupper($name1)."'";
						}	
												
						$resultado1 = mysqli_query($miConex, $consulta) or die(mysql_error());
						$uso = mysqli_fetch_array($resultado1);
						$tuso = $tuso + $uso['enuso'];
						
						//en rotas
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultarotas  = "SELECT COUNT(estado) as rotas FROM aft WHERE estado = 'R' AND categ='".strtoupper($name1)."' AND idunidades='".$Uact."'";
						}else{
							$consultarotas  = "SELECT COUNT(estado) as rotas FROM aft WHERE estado = 'R' AND categ='".strtoupper($name1)."'";
						}	
						$resultado3 = mysqli_query($miConex, $consultarotas) or die(mysql_error());
						$rotas = mysqli_fetch_array($resultado3);
						$trotas = $trotas + $rotas['rotas'];
						//BAJAS						
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultapbajas  = "SELECT COUNT(estado) as ipbajas FROM bajas_aft WHERE estado = 'P' AND categ='".strtoupper($name1)."' AND idunidades='".$Uact."'";
						}else{
							$consultapbajas  = "SELECT COUNT(estado) as ipbajas FROM bajas_aft WHERE estado = 'P' AND categ='".strtoupper($name1)."'";
						}						
						$resultado1pbajas = mysqli_query($miConex, $consultapbajas) or die(mysql_error());
						$ipbajas = mysqli_fetch_array($resultado1pbajas);
						$tbajas = $tbajas + $ipbajas['ipbajas'];
						//en red
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultared  = "SELECT COUNT(enred) as enred1 FROM aft WHERE enred = 's' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
						}else{
							$consultared  = "SELECT COUNT(enred) as enred1 FROM aft WHERE enred = 's' AND categ='COMPUTADORAS'";
						}
						$resultado1red = mysqli_query($miConex, $consultared) or die(mysql_error());
						$enlared = mysqli_fetch_array($resultado1red);
						$TG_R = $enlared['enred1'];
						//internet
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultainternet  = "SELECT COUNT(conect) as internet FROM aft WHERE conect = 'Internet' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
						}else{
							$consultainternet  = "SELECT COUNT(conect) as internet FROM aft WHERE conect = 'Internet' AND categ='COMPUTADORAS'";
						}	
						$resultado1internet = mysqli_query($miConex, $consultainternet) or die(mysql_error());
						$internet = mysqli_fetch_array($resultado1internet);
						$TG_inter = $internet['internet'];
						//intranet
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultaintranet  = "SELECT COUNT(conect) as intranet FROM aft WHERE conect = 'Intranet' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
						}else{
							$consultaintranet  = "SELECT COUNT(conect) as intranet FROM aft WHERE conect = 'Intranet' AND categ='COMPUTADORAS'";
						}
						$resultado1intranet = mysqli_query($miConex, $consultaintranet) or die(mysql_error());
						$intranet = mysqli_fetch_array($resultado1intranet);
						$TG_intra = $intranet['intranet'];
						if($TG >0){ ?>
							<tr>
								<td><?php if (($totU['total']!=0) OR ($uso['enuso']!=0) OR ($rotas['rotas']!=0)) { echo ucfirst($name1); } ?></td>
								<td align="center"><?php if (($totU['total']!=0) OR ($uso['enuso']!=0) OR ($rotas['rotas']!=0)) { echo $totU['total']; } ?></td>
								<td align="center"><?php if (($totU['total']!=0) OR ($uso['enuso']!=0) OR ($rotas['rotas']!=0)) { echo $uso['enuso']; }?></td>
								<td align="center"><?php if (($totU['total']!=0) OR ($uso['enuso']!=0) OR ($rotas['rotas']!=0)) { echo $rotas['rotas']; }?></td>
							    <td align="center"><?php if (($totU['total']!=0) OR ($uso['enuso']!=0) OR ($rotas['rotas']!=0)) { echo $ipbajas['ipbajas']; }?></td>
								<td align="center"><?php if (($totU['total']!=0) OR ($uso['enuso']!=0) OR ($rotas['rotas']!=0)) { if (($name1) =='computadoras'){ echo $enlared['enred1']; }else{ echo "0";}} ?></td>
							    <td align="center"><?php if (($totU['total']!=0) OR ($uso['enuso']!=0) OR ($rotas['rotas']!=0)) {if (($name1) =='computadoras'){ echo $internet['internet']; }else{ echo "0";}}?></td>
							    <td align="center"><?php if (($totU['total']!=0) OR ($uso['enuso']!=0) OR ($rotas['rotas']!=0)) {if (($name1) =='computadoras'){ echo $intranet['intranet']; }else{ echo "0";}} ?></td>
						    </tr><?php 
						}else{ $count ++;}
					} $p++; 
				} ?>
				<tr>
					<td><hr><b>TOTALES</b></td>
					<td align="center"><hr><b><?php echo $TG;?></b></td>
					<td align="center"><hr><b><?php echo $tuso;?></b></td>
					<td align="center"><hr><b><?php echo $trotas;?></b></td>
					<td align="center"><hr><b><?php echo $tbajas;?></b></td>
					<td align="center"><hr><b><?php echo $TG_R;?></b></td>
					<td align="center"><hr><b><?php echo $TG_inter;?></b></td>
					<td align="center"><hr><b><?php echo $TG_intra;?></b></td>
				</tr>
	</Table>
</body>