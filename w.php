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
?>
<?php 
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php	
		return;	
	} 
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Expedientes.xls");
header("Pragma: no-cache");
header("Expires: 0"); 
include('connections/miConex.php');
include('script.php');
include('mensaje.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Exportador Excel</title>
<?php

class cdate{
	function formatDate($adate, $currTab, $futTab){
		if (!is_null($adate)){
			$sep = array();
			$sep = explode($currTab, $adate);
			return $sep[2].$futTab.$sep[1].$futTab.$sep[0];
		}else{
			return "";
		}
	}
}
$myDate = new cdate();
$i=0;
$ordena="";
$tb ="areas";
if(isset($_GET['ordena'])){$ordena=$_GET['ordena'];}
$cuantos=1;

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
///////////

$Uactb="";
$Uactb1="";
$idunidad="";

if(isset($_GET['area']) AND ($_GET['area']) !=""){
	$idunidad=" where idarea =".$_GET['area'];
	if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	  $Uactb = " AND idunidades='".$_COOKIE['unidades']."'";
	  $Uactb1 = " WHERE id_datos='".$_COOKIE['unidades']."'";
    }
}elseif(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	 $Uactb = " WHERE idunidades='".$_COOKIE['unidades']."'";
	 $Uactb1 = " WHERE id_datos='".$_COOKIE['unidades']."'";
}else{
	 $Uactb = "";
	 $Uactb1 = "";
	
}

$sql = "SELECT * FROM ".$tb.$idunidad.$Uactb." ORDER BY nombre";
$result= mysqli_query($miConex, $sql);

$total_registros = mysqli_num_rows($result);
$total_paginas = ceil($total_registros / $registros);

$gene = "SELECT * FROM datos_generales".$Uactb1;
$resultgene = mysqli_query($miConex, $gene) or die (mysql_error());
$filagene = mysqli_fetch_array ($resultgene);

$selvi = "select * from preferencias where usuario='".$_SESSION['valid_user']."'";
$qselvi = mysqli_query($miConex, $selvi) or die(mysql_error());
$rsel = mysqli_fetch_array($qselvi);

if(($rsel['columnas']) !=""){
	$columnas = $rsel['columnas'];
}else{
  $columnas = 14;	
}

function total($campo, $miConex) {
	if(isset($_GET['area']) AND ($_GET['area']) !=""){
		$consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas where idarea=".$_GET['area'];
	}else{
		$consulta  = "SELECT SUM(".$campo.") as valor_col FROM areas";
	}
	$resultado = mysqli_query($miConex, $consulta) or die(mysqli_error($miConex));
	$linea = mysqli_fetch_array($resultado);

	echo $linea['valor_col']."\n";
	/* Liberar conjunto de resultados */
	mysqli_free_result($resultado);
}
$ggg = base64_encode($sql);

?>
</head>
<body>
 <table width="803" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="4"><h3 align="center">REPORTE DE MEDIOS INFORMATICOS POR AREAS DE RESPONSABILIDAD</h3></td>
  </tr>
  <tr>
    <td width="63"><div align="right">Empresa:</div></td>
    <td width="495"><font><strong><?php print_r ($filagene['entidad']);?></strong></font></td>
    <td width="40">fecha:</td>
    <td width="179"><?php echo date('d/m/Y');?></td>
  </tr>
</table>
<table border="0" class="sgf1" align="center" >
    <tr>
		<td></td>
		<?php for($n=1; $n<=$columnas; $n++){
			$fields  = mysqli_fetch_field_direct ($result, $n); 
			$name1 = $fields->name;
			$flags = $fields->flags; ?>
		<td align="center" class="vistauser1"><b><?php if((strlen(strtoupper($name1))) >7){ echo substr(strtoupper($name1),0,5);}else { echo strtoupper($name1);} ?></b></td>
			<?php
		    }?>
	</tr>
		<?php
			 $id = 0;
			 $p=0;
			 while($row=mysqli_fetch_array($result))	{
			  $i++;
				//if(($row["nombre"]) !="Reparaciones"){ ?>
				 <tr id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='#ffffff';colorear('<?php echo $p;?>','#DBE2D0');"  onclick="marca1(<?php echo $p;?>,'#ffffff')">
				 <td></td>
				<?php for($n=1; $n<=$columnas; $n++){
					$fields  = mysqli_fetch_field_direct ($result, $n); 
					$name1 = $fields->name;
					$flags = $fields->flags; ?>
				<td><?php echo $row[$name1];?><input type="hidden" name="cant" size="4" value="<?php echo $p?>"></td>
				<?php
					}?>
				<?php $id++; $p++;
				//}
			 } ?>
				<tr>
					<td colspan="2" align="center"><font color="red">TOTALES</font><br></td>
					<?php for($n=2; $n<=$columnas; $n++){
				    $fields  = mysqli_fetch_field_direct ($result, $n); 
					$name1 = $fields->name;
					$flags = $fields->flags; ?>	
				<td><font color='red'><?php echo "<b>".total($name1, $miConex)."</b>";?></font></td>
				<?php
			}?>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
</table>
</form>
</body>
</html>