<?php
############################################################################################################
# Software: Regimed                                                                                        #
#(Registro de Medios Inform�ticos)     					                                		           #
# Version:  3.0.1                                                     				                       #
# Fecha:    01/06/2016 - 03/04/2018                                             					                       #
# Autores:  Ing. Manuel de Jes�s N��ez Guerra   								     			           #
#          	Msc. Carlos Pollan Estrada											         		           #
# Licencia: Freeware                                                				                       #
#                                                                       			                       #
# Usted puede usar y modificar este software si asi lo desea, pero debe mencionar la fuente                #
############################################################################################################

    header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Expediente_Tecnico.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
@session_start(); include('chequeo.php');

if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
include('connections/miConex.php');
	if(isset($_POST['categ'])){$categ =$_POST['categ'];}
	if(isset($_POST['marcado'])){$marcado =$_POST['marcado'];}
	if(isset($_GET['categ'])){$categ =$_GET['categ'];}
	if(isset($_GET['cut'])){$nom_custo =$_GET['cut'];}
	if(isset($_GET['marcado'])){$marcado =$_GET['marcado'];}
	
	$query_Recordset4 = "SELECT * FROM usuarios where login = '".$_SESSION['valid_user']."'";
	$Recordset4 = mysqli_query($query_Recordset4) or die(mysql_error());
	$Rerow4 = mysqli_fetch_array($Recordset4);
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
.Estilo6 {
	font-size: 36px;
	color: #000000;
}
.Estilo8 {
	font-size: 24px;
	margin: 0;
	margin-top: -15px;
	padding-top: 15px;
	padding-bottom: 5px;
	background: url(../../system/images/selector-arrow.png) no-repeat;
	padding: 0;
}
.Estilo23 {font-size: 9; color: #000000; font-weight: bold; }
-->
</style>
<table width="798" border="0">
   <tr>
    <td colspan="2"><p align="left"><span><span class="tool-title Estilo6"><span class="Estilo8">Expediente T&eacute;cnico</span></span>: <?php echo "<font color=red class=Estilo10><strong>".$categ."</strong>"; ?>
    </td></tr><tr><td colspan="2">
<?php

	 
	$query="select * from aft where inv='".$categ."'";
	$result=mysqli_query($query);
	$row = mysqli_fetch_array ($result);
	if (($row["categ"])!="COMPUTADORAS")	  {
//		header("location:expedientes.php");
	}
// SQL para la b�squeda
$sql1="SELECT * FROM `exp` where inv='".$categ."'"; 
$result1=mysqli_query($sql1) or die (mysql_error());
$num_resultados = mysqli_num_rows($result1);
	if(($num_resultados) !=0){
		// Si hay resultados crea una tabla y los muestra
		if ($row=mysqli_fetch_array($result1)){
		$custo=$row["custodio"];
		$nomb_PC = $row["n_PC"];
		$area_resp = $row["idarea"];

		echo "Responsable del Medio: <font color=red><b>".$custo."</b><font color='black'>";
		?>
		<TABLE BORDER='1' cellpadding="1" cellspacing="1" bordercolor=#333333 class="sgf1" >
		<tr>
		<td ><span class="Estilo23"><strong><font color="black">INV</span></td>
		<td width=200 ><span class="Estilo23"><strong><font color="black">CPU</span></td>
		<td ><span class="Estilo23"><strong><font color="black">MOTHERBOARD</span></td>
		<td ><span class="Estilo23"><strong><font color="black">CHIPSET</span></td>
		<td ><span class="Estilo23"><strong><font color="black">MEMORIA</span></td>
		<td ><span class="Estilo23"><strong><font color="black">TARJETA GRAFICA</span></td>
		<td ><span class="Estilo23"><strong><font color="black">HDD1</span></td>
		<td ><span class="Estilo23"><strong><font color="black">HDD2</span></td>
		<td ><span class="Estilo23"><strong><font color="black">SONIDO</span></td>
		<td ><span class="Estilo23"><strong><font color="black">RED</span></td>
		<td ><span class="Estilo23"><strong><font color="black">SO</span></td>
		<td ><span class="Estilo23"><strong><font color="black">NOMBRE PC</span></td> 
		</tr>

		<?php 
		DO
		{
		?>

		<tr>
		<td><?php echo $row["inv"] ?></td>
		<td><?php echo $row["CPU"] ?></td>
		<td><?php echo $row["PLACA"] ?></td>
		<td><?php echo $row["CHIPSET"] ?></td>

		<td><?php echo $row["MEMORIA"] ?></td>
		<td><?php echo $row["GRAFICS"] ?></td>
		<td><?php echo $row["DRIVE1"] ?></td>
		<td><?php echo $row["DRIVE2"] ?></td>
		<td><?php echo $row["SONIDO"] ?></td>
		<td><?php echo $row["RED"] ?></td>
		<td><?php echo $row["OS"] ?></td>
		<td><?php echo $row["n_PC"] ?></td>
		</tr>

		<?php
		}
		WHILE ($row=mysqli_fetch_array($result1));
		?>
		</TABLE>

		<?php 
		}
		mysql_close ($miConex);
		echo "</p>";
?>

<span>Nombre de la PC:</span><span><?php echo "<font color=red>".@$nomb_PC ."<font color='black'>";?></span><span> Sello B T: </span><span><?php echo "<font color=red>".@$sello."<font color='black'>"; ?></span><span> Area: </span><span ><?php echo "<font color=red>".@$area_resp."<font color='black'>";?>
<?php
	}else{ echo "<div class='Estilo10'>Este medio no tiene Expepediente conformado.</div><a href='form-insertarexp.php?inv=".$categ."&marcado=".$marcado."'>Click</a> para crearlo";}
require('connections/miConex.php');

$sql="SELECT * FROM aft WHERE custodio='".@$custo."' and custodio is Not Null"; 
$result=mysqli_query($sql);
$num_resultados = mysqli_num_rows($result);

if ($row= mysqli_fetch_array($result)){ ?>
	<table width="283" border="0" align=''>
		<tr>
			<td><br><div align="center"><div class="message" align="center"><?php echo "Total de Medios: <font color='red'><b>".$num_resultados."</b></font>"; ?></div></div></td>
		</tr>
	</table><?php 
}
mysql_close ($miConex);

?>
		
</td>
  </tr>
</table>

