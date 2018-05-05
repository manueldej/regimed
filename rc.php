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
    header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=RegClaves.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

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
include('connections/miConex.php');
include('script.php');
include('mensaje.php');
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<body>
<?php 
///////navegador
		$inicio = 0; 
		$pagina = 1; 
		$registros = @$cuantos;
	
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

    $sql="SELECT * FROM reg_claves";
	$result=mysqli_query($sql) or die(mysql_error());
	$num_resultados = mysqli_num_rows($result);
 
?>

<table width="827" border='1' align="center" cellspacing="2" bordercolor="#F0F0F0" >
				<tr bgcolor="#F0F0F0">
					<?php if((@$row["tipo"]) !="root") { ?><td width="20" align="center">&nbsp;</td><?php }?>
					<td width="220" align="center"><b>CUSTODIO</b></td>
					<td width="99" align="center"><b>EQUIPO</b></td>
					<td width="220" align="center"><b>LOGIN</b></td>
					<td width="122" align="center"><b>SETUP</b></td>
					<td width="113" align="center"><b>SISTEMA</b></td>
				</tr><?php
				WHILE ($row=mysqli_fetch_array($result)){	@$i++;?>
				<tr>
					<?php if((@$row["tipo"]) !="root") { ?>
				  <td>&nbsp;</td>
			    <?php }?>
					<td><?php echo $row["usuario"];?></td>
					<td><?php echo $row["equipo"];?></td>
					<td><?php echo $row["login"];?></td>
					<td><?php echo base64_decode($row["setup"]);?></td>
					<td><?php echo base64_decode($row["sistema"]);?></td>
				</tr><?php
				} 
				if(($row["tipo"]) !="root") { ?>
				<?php
				}?>
		</table>
</body>
</html>
