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
?>
<?php
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	header ("Location: index.php");
	exit;
}
?><?php

$i=0;
if(is_numeric(@$_SESSION["registros"]))
    $registros = $_SESSION["registros"];
else
   $registros = 3;
 @session_destroy;

if(!isset($_GET['pagina'])) 
 { 
   $inicio = 0; 
   $pagina = 1; 
 } else 
    { 
	  $pagina=$_GET['pagina'];
	  $inicio = ($pagina - 1) * $registros; 
	}
include ('connections/miConex.php');

$resultados = mysqli_query("SELECT * FROM aft WHERE inv LIKE '%".$palabra."%' or estado LIKE '%".$palabra."%'
or descrip LIKE '%".$palabra."%' or idarea LIKE '%".$palabra."%' or categ LIKE '%".$palabra."%'or marca LIKE '%".$palabra."%'or modelo LIKE '%".$palabra."%' or tipo LIKE '%".$palabra."%' or custodio LIKE '%".$palabra."%'");
$total_registros = mysqli_num_rows($resultados);
$total_paginas = ceil($total_registros / $registros);

$sql="SELECT * FROM aft WHERE inv LIKE '%".$palabra."%' or estado LIKE '%".$palabra."%'
or descrip LIKE '%".$palabra."%' or idarea LIKE '%".$palabra."%' or categ LIKE '%".$palabra."%'or marca LIKE '%".$palabra."%'or modelo LIKE '%".$palabra."%' or tipo LIKE '%".$palabra."%' or custodio LIKE '%".$palabra."%'"; 

$result= mysqli_query($sql); 
?>
<link href="css/template.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
			function ir(va){
				document.location="et.php?categ="+va;
			}
		</script>
<fieldset class="fieldset">
		<table width="980" border="0" align="center" id="CABECERA">
		  <tr>
			<td><div align="center"><h3 class='bannerfooter_text'>AREA DE RESPONSABILIDAD NO. <font color='red'><?php echo @$marcado[@$m];?></h3><?php @$area=@$marcado[@$m]; ?></div></td>
		  </tr>
		</table>
	  
			<TABLE BORDER='0' bordercolor=#AFCBCF class='sgf1' aling='center'>
			<tr>
			<td><b></b></td>
			<td align="center"><b>INV</b></td>
			<td align="center"><b>DESCRIPCION</b></td>
			<td align="center"><b>ESTADO</b></td>
			<td align="center"><b>AREA</b></td>
			<td align="center"><b>SELLO</b></td>
			<td align="center"><b>MARCA</b></td>
			<td align="center"><b>SERIE</b></td>
			<td align="center"><b>MODELO</b></td>
			<td align="center"><b>CATEGORIA</b></td>
			<td align="center"><b>TIPO</b></td>
			<td align="center"><b>CUSTODIO</b></td>
			</tr>
	<?php  		$id = 0;   
		 
		 while($row=mysqli_fetch_array($result))
			{
				echo "<tr>\n";
				$i++;
				$nombre="n".$i;
				
		?>

			   <tr id="cur_tr_<?php echo $i;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='#ffffff';colorear('<?php echo $p;?>','#DBE2D0');"  onclick="marca1(<?php echo $i;?>,'#ffffff')">
		 <?php ?>
				<td>
				<?php if((strtoupper($row["categ"])) =="COMPUTADORA" OR (strtoupper($row["categ"])) =="COMPUTADORAS" OR (strtoupper($row["categ"])) =="PC"){ ?>
				<img title="Ver Expediente T&eacute;nico..." src="images/pc.png" width="24" height="24" align="absmiddle" onMouseOVer="this.style.cursor='pointer';" onClick="ir('<?php echo $row["inv"];?>');">&nbsp;&nbsp;
				
				<?php }?>				</td>
		
				<td class='Estilo2'><?php echo $row["inv"];?></td>
				<td class='Estilo2'><?php echo $row["descrip"];?></td>
				<td class='Estilo2'><?php echo $row["estado"];?></td>
				<td class='Estilo2'><?php echo $row["idarea"];?></td>
				<td class='Estilo2'><?php echo $row["sello"];?></td>
				<td class='Estilo2'><?php echo $row["marca"];?></td>
				<td class='Estilo2'><?php echo $row["no_serie"];?></td>
				<td class='Estilo2'><?php echo $row["modelo"];?></td>
				<td class='Estilo2'><?php echo $row["categ"];?></td>
				<td class='Estilo2'><?php echo $row["tipo"];?></td>
				<td class='Estilo2'><?php echo $row["custodio"];?></td>
</tr>

		<?php  	$id++;	
			}
		?>
		</table>
		 <table width="200" align="center">
		<tr>
			<td>
				<?php 
	if($registros >= $total_registros){
		echo $bttotalreg.": <font color='red'>".$total_registros."</font>&nbsp;&nbsp;&nbsp;";
	}else{
		if($pagina == 1) {
			if($i !=1){
				echo "Registros <font color='red'> 1</font> - <font color='red'>".$i."</font> / <font color='blue'>".$total_registros."</font><br>";
			}else{
				echo "Registro <font color='red'> 1</font> de <font color='blue'> ".$total_registros."</font><br>";
			}
		}else  {
			if($i !=1){
				echo "Registro del <font color='red'>".($inicio+1)."</font> al <font color='red'>".($inicio + $i)."</font> de <font color='blue'>".$total_registros."</font><br>";
			}else{
				echo "Registro <font color='red'>".($inicio + 1)."</font> de <font color='blue'>".$total_registros."</font><br>";
			}
		}
	}


 ?>
			</td>
		</tr>
	</table>
  <br><hr width="70%" align="center">
<div class="contentpaneopen" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>