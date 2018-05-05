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
include('header.php');
include ('script.php');
include('salva_rep.php');
?>
<style type="text/css">
<!--
.message {
	BORDER-RIGHT: #aabf76 1px dotted; PADDING-RIGHT: 7px; BORDER-TOP: #aabf76 1px dotted; MARGIN-TOP: 10px; PADDING-LEFT: 7px; FONT-WEIGHT: bold; FONT-SIZE: 12px; BACKGROUND: #f9fdf0; PADDING-BOTTOM: 7px; BORDER-LEFT: #aabf76 1px dotted; WIDTH: 400px; COLOR: #777971; PADDING-TOP: 7px; BORDER-BOTTOM: #aabf76 1px dotted
}
.Estilo3 {
	font-size: 12px;
	color: #846131;
	font-weight: bold;
	font-style: italic;
}
.Estilo1 {
	color: #000000;
	font-weight: bold;
	font-family: Tahoma, Helvetica, Arial, sans-serif;
	font-size: 18px;
}
-->
</style>
<script type="text/javascript">
	document.cookie='adestino=';
</script>
<fieldset class="fieldset">
<?php include('barra.php');?>
<div id="buscad"> 
<table width="472" border="0" align="center">
	<tr>
		<td width="466" class="Estilo1"><?php
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$sqlx="SELECT * FROM areas where (idarea ='".htmlentities($_POST['area'])."') AND (idunidades='".$_COOKIE['unidades']."')"; 
			}else{
				$sqlx="SELECT * FROM areas where idarea ='".htmlentities($_POST['area'])."'"; 
			}
			$resultq=mysqli_query($miConex, $sqlx) or die(mysql_error());
			$num_resultados = mysqli_num_rows($resultq);

			// Si hay resultados crea una tabla y los muestra

			if (($num_resultados) !=0){
				$rowz=mysqli_fetch_array($resultq);
				$no_area=$rowz["nombre"];			 
			} 
			
	
			$ctaz = 0;
			$invt = $_POST['invent1'];
			if (isset($_POST['cambio'])){
				$custodiod= @$_POST["custodiod"];
			}

			foreach($_POST['marcado'] as $key){
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$query="SELECT * FROM aft where (id ='".$key."') AND (idunidades='".$_COOKIE['unidades']."')";                   
				}else{
					$query="SELECT * FROM aft where id ='".$key."' AND idunidades='".$_POST['unidades']."'";
				}

				$result=mysqli_query($miConex, $query) or die (mysql_error());
				$row = mysqli_fetch_array ($result);
				$id_area=$row["id_area"];
				$area_antes=$row["idarea"];
				$categoria=$row["categ"];
				$idunid=$row["idunidades"];
				$custodio= @$_POST["custodio"];
				$mot = $_POST["motivos"];

				$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$idunid."'") or die(mysql_error());
				$qsedg = mysqli_fetch_array($sedg);
				
				$vapara=mysqli_query($miConex, "select idarea from areas where nombre ='".$no_area."'") or die(mysql_error());
				$qvapara = mysqli_fetch_array($vapara);
				$idareava = $qvapara['idarea'];
				
				$sqls = "UPDATE aft SET idarea = '".$no_area."', id_area ='".$idareava."' WHERE id = '".$key."' AND idunidades='".$qsedg['id_datos']."'";
				$results = mysqli_query($miConex, $sqls) or die(mysql_error());
				
				if ($no_area !="Reparaciones"){
					if (isset($_POST['cambio'])){
						$consulta = "UPDATE aft SET custodio = '".htmlentities($custodiod)."' WHERE id = '".$key."' AND idunidades='".$qsedg['id_datos']."'";
					}else{
						$consulta = "UPDATE aft SET custodio = '".htmlentities($custodio)."' WHERE id = '".$key."' AND idunidades='".$qsedg['id_datos']."'";
					}
					
					$resultado = mysqli_query($miConex, $consulta) or die(mysql_error());
				}
				
				//echo $consulta."<br>".$sqls;
				//exit;

				$esta=strtolower($categoria);
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){	 
					$sqlc="Select ".$esta." from areas where (nombre='".$no_area."') AND (idunidades='".$_COOKIE['unidades']."')";
				}else{
					$sqlc="Select ".$esta." from areas where nombre='".$no_area."' AND idunidades='".$qsedg['id_datos']."'";
				}
				$resultado = mysqli_query($miConex, $sqlc) or die(mysql_error());
				$valor_col="";
				while ($linea = mysqli_fetch_array($resultado))		    {
					foreach ($linea as $valor_col) {
						$valor_col++;
					}
				}

				$sql2s="UPDATE areas SET ".$esta."='".$valor_col."' where nombre='".$no_area."' AND idunidades='".$qsedg['id_datos']."'";
				$resulta = mysqli_query($miConex, $sql2s) or die(mysql_error());

				$sqld="UPDATE aft SET estado = 'A' WHERE inv  = '".$invt[$ctaz]."' AND id_area='".$area_antes."'";
				$resultd=mysqli_query($miConex, $sqld) or die(mysql_error());

				// PARA RESTARLA DEL AREA EN DONDE ESTRABA ANTES
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$sqlf="Select ".$esta." from areas where (nombre='".$area_antes."') AND (idunidades='".$_COOKIE['unidades']."')";
				}else{
					$sqlf="Select ".$esta." from areas where nombre='".$area_antes."' AND idunidades='".$qsedg['id_datos']."'";
				}
				$resultado = mysqli_query($miConex, $sqlf)  or die("La consulta fall&oacute;: " . mysql_error());
				while ($linea = mysqli_fetch_array($resultado))		    {
					foreach ($linea as $valor_col) {
						$valor_col--;
					}
				}
				$sql2="UPDATE areas SET ".$esta."='".htmlentities($valor_col)."' where nombre='".$area_antes."' AND idunidades='".$qsedg['id_datos']."'";
				$result = mysqli_query($miConex, $sql2) or die(mysql_error()); 

				$fecha=date("Y-m-d");
				$sql4="insert into traspasos (id_area, fecha, inv, motivo, origen, destino,idunidades) values ('".$id_area."', '".$fecha."', '".$invt[$ctaz]."', '".$mot."','".$area_antes."', '".$no_area."','".$idunid."')";
				$result3 = mysqli_query($miConex, $sql4) or die(mysql_error()); 
				
				$sql="UPDATE aft SET estado = 'A' WHERE inv = '".$invt[$ctaz]."' AND id_area='".$id_area."' AND idunidades='".$idunid."'";
				$result1=mysqli_query($miConex, $sql) or die(mysql_error()); 
				
				if ($categoria=='COMPUTADORAS') {
					$sqlexp="UPDATE exp SET custodio ='".htmlentities($custodiod)."', idarea='".htmlentities($area_antes)."' WHERE inv = '".$invt[$ctaz]."' AND id_area='".$id_area."' AND idunidades='".$idunid."'";
					$resultexp=mysqli_query($miConex, $sqlexp) or die(mysql_error()); 
				}
				
				
				creasalva('traspasos');
				creasalva('plan_rep');
				
				$ctaz++;
			}		

			
?>
<script type="text/javascript">
 document.location='registrocustodio.php';
</script>
