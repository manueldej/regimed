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
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="template_css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {font-size: 14px}
-->
</style>
<?php 
   require_once("db_fns.php");
   $logi=$_SESSION["valid_user"];
   $us1 = mysqli_query("select * from usuarios where login='".$logi."'") or die(mysql_error());
   $rus1 = mysqli_fetch_array($us1);
   
   if ($_SESSION ["valid_user"] && (($rus1['tipo']) =="root"))
  {
	 if ($_POST['dia'])
	  {
        $_SESSION['fecha']=$_POST['dia']."/".$_POST['mes']."/".$_POST['ano'];
        include ('connections/miConex.php');
        mysql_select_db ($database_miConex,$miConex) OR die ("No se puede conectar");
        $sql="insert into mtto (id, inv, fecha) values (NULL, '".htmlentities($_POST[invent])."','".$_SESSION[fecha]."')"; 
        $result=mysqli_query($sql,$miConex);
      } 
	}
	 
    	    
?>
<fieldset class="fieldset"><legend class="vistauserx">Mantenimiento</legend>
<table width="681" border="0" align="center">
  <tr>
    <td width="671"><h2 align="center" class="vistauser1 Estilo2">  CRONOGRAMA </h2></td>
  </tr>
  <tr>
    <td> <div align="center">
      <?php 
$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$starttime = $mtime; 

?>
      <?php
include ('connections/miConex.php');
mysql_select_db ($database_miConex,$miConex) OR die ("No se puede conectar");

// SQL para la búsqueda
$sql="SELECT `mtto`.`id`, `mtto`.`inv`, `mtto`.`fecha`, `mtto`.`estado`, `aft`.`categ`, `aft`.`idarea` FROM mtto INNER JOIN aft ON (mtto.`inv` = `aft`.`inv`) order by id ASC"; 


$result=mysqli_query($sql,$miConex);
$num_resultados = mysqli_num_rows($result);

// Si hay resultados crea una tabla y los muestra
if ($row= mysqli_fetch_array($result)){
	echo "<TABLE BORDER='1' bordercolor=#AFCBCF > \n";
	echo "<tr> \n";
	echo "<td align=center><b><strong><font color=black>NO</b></td> \n";
	echo "<td align=center><b><strong><font color=black>INV</b></td> \n";
	echo "<td align=center><b><strong><font color=black>CATEGORIA</b></td> \n";
	echo "<td align=center><b><strong><font color=black>FECHA</b></td> \n";
	echo "<td align=center><b><strong><font color=black>AREA</b></td> \n";
	echo "<td align=center><b><strong><font color=black>ESTADO</b></td> \n";
	echo "</tr> \n";

	WHILE ($row=mysqli_fetch_array($result)){
		echo "<tr> \n";
		echo "<td align=center>".$row["id"];
		echo "<td align=center><a href=buscaaft.php?palabra=".$row["inv"]." target=c>".$row["inv"]."</a>";
		echo "<td align=center>".$row["categ"];
		echo "<td align=center>".$row["fecha"];
		echo "<td align=center>".$row["idarea"];
		echo "<td align=center>".$row["estado"];

		echo "</tr> \n";
	}
	echo "</TABLE>";
	echo "<p>Total encontrados:<strong>  ".$num_resultados."</p>";
}
mysql_close ($miConex);
echo "</p>";

$mtime = microtime(); 
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$endtime = $mtime; 
$totaltime = ($endtime - $starttime); 
echo "Esta búsqueda se creo en <strong><FONT COLOR=RED>".$totaltime."</strong><FONT COLOR=BLACK> segundos."; 
?>
    </div></td>
  </tr>
</table>
<br><hr width="70%" align="center">
<div class="Footer-inner" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>>
