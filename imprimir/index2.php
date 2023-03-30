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
		$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('../esp.php');}else{ include('../eng.php');}
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="../index.php";</script><?php
	exit;
}
require_once('../connections/miConex.php');
$Datosgene="select * from datos_generales";
$resultD= mysqli_query($miConex, $Datosgene) or die(mysql_error());
$DatosG = mysqli_fetch_array($resultD);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Exp_Tecnico</title>
<link href="../css/template.css" rel="stylesheet">
<style type="text/css">
<!--
.Estilo1 {
	font-size: 9;
	font-weight: bold;
}
.Estilo3 {font-size: 9}
.Estilo6 {
	font-size: 17px;
	color: #000000;
}
.Estilo23 {font-size: 9; color: #000000; font-weight: bold; }
-->
</style>
</head>
<body onLoad="javascript:print()">
<font size='2'><div align='center'class='tool-title Estilo6'>..:REGISTRO DE MEDIOS INFORM&Aacute;TICOS:..<br></div>
	      <div align='center'><?php echo $DatosG['entidad'];?><br></div>
	      <div align='center'><a href='<?php echo $DatosG['web'];?>'><?php echo $DatosG['web'];?></a></div></font><br><hr><br>

<table width="798" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="659" colspan="2"><p align="center"><span><span class="tool-title Estilo6"><span class="Estilo8">Expediente T&eacute;cnico</span></span>    </td></tr><tr><td colspan="2">
<?php
// SQL para la búsqueda
$categ = base64_decode($_GET['consulta']);
$result1=mysqli_query($miConex, $categ) or die (mysql_error());
$num_resultados = mysqli_num_rows($result1);
?>
	<TABLE BORDER='1' bordercolor=#6699CC class="sgf1" >
	<tr>
	<td class="bannerfooter_text"><span class="Estilo1"><strong><font color=black>INV</span></td>
	<td width=200 class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>CPU</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>MOTHERBOARD</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>CHIPSET</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>MEMORIA</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>TARJETA GRAFICA</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>HDD1</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>HDD2</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>SONIDO</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>RED</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>SO</b></span></td>
	<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color=black>NOMBRE PC</b></span></td> 
	</tr><?php 
		WHILE ($row=mysqli_fetch_array($result1)){	?>
			<tr>
			<td>&nbsp;<?php echo $row["inv"] ?></td>
			<td>&nbsp;<?php echo $row["CPU"] ?></td>
			<td>&nbsp;<?php echo $row["PLACA"] ?></td>
			<td>&nbsp;<?php echo $row["CHIPSET"] ?></td>
			<td>&nbsp;<?php echo $row["MEMORIA"] ?></td>
			<td>&nbsp;<?php echo $row["GRAFICS"] ?></td>
			<td>&nbsp;<?php echo $row["DRIVE1"] ?></td>
			<td>&nbsp;<?php echo $row["DRIVE2"] ?></td>
			<td>&nbsp;<?php echo $row["SONIDO"] ?></td>
			<td>&nbsp;<?php echo $row["RED"] ?></td>
			<td>&nbsp;<?php echo $row["OS"] ?></td>
			<td>&nbsp;<?php echo $row["n_PC"] ?></td>
			</tr>&nbsp;<?php
		}
	?>
	</TABLE>
</p>
</td>
  </tr>
</table>
</body>
</html>
