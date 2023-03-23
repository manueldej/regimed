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
			$resultq=mysqli_query($miConex, $sqlx) or die(mysqli_error($miConex));
			$num_resultados = mysqli_num_rows($resultq);
	
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

				$result=mysqli_query($miConex, $query) or die (mysqli_error($miConex));
				$row = mysqli_fetch_array ($result);
				$id_area=$row["id_area"];
				$area_antes=$row["idarea"];
				$categoria=$row["categ"];
				$idunid=$row["idunidades"];
				$custodio= @$_POST["custodio"];
				$mot = $_POST["motivos"];
				$descrip = $row["descrip"];;

				$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$idunid."'") or die(mysqli_error($miConex));
				$qsedg = mysqli_fetch_array($sedg);
				
				$vapara=mysqli_query($miConex, "select idarea from areas where nombre ='".$no_area."'") or die(mysqli_error($miConex));
				$qvapara = mysqli_fetch_array($vapara);
				$idareava = $qvapara['idarea'];
				
				$sqls = "UPDATE aft SET idarea = '".$no_area."', id_area ='".$idareava."' WHERE id = '".$key."' AND idunidades='".$qsedg['id_datos']."'";
				$results = mysqli_query($miConex, $sqls) or die(mysqli_error($miConex));
				
				if ($no_area !="Reparaciones"){
					if (isset($_POST['cambio'])){
						$consulta = "UPDATE aft SET custodio = '".htmlentities($custodiod)."' WHERE id = '".$key."' AND idunidades='".$qsedg['id_datos']."'";
					}else{
						$consulta = "UPDATE aft SET custodio = '".htmlentities($custodio)."' WHERE id = '".$key."' AND idunidades='".$qsedg['id_datos']."'";
					}
					
					$resultado = mysqli_query($miConex, $consulta) or die(mysqli_error($miConex));
				}
				
				$esta=strtolower($categoria);
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){	 
					$sqlc="Select ".$esta." from areas where (nombre='".$no_area."') AND (idunidades='".$_COOKIE['unidades']."')";
				}else{
					$sqlc="Select ".$esta." from areas where nombre='".$no_area."' AND idunidades='".$qsedg['id_datos']."'";
				}
				$resultado = mysqli_query($miConex, $sqlc) or die(mysqli_error($miConex));
				$valor_col="";
				while ($linea = mysqli_fetch_array($resultado))		    {
					foreach ($linea as $valor_col) {
						$valor_col++;
					}
				}			
				// PARA RESTARLA DEL AREA EN DONDE ESTABA ANTES
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
					$sqlf="Select ".$esta." from areas where (nombre='".$area_antes."') AND (idunidades='".$_COOKIE['unidades']."')";
				}else{
					$sqlf="Select ".$esta." from areas where nombre='".$area_antes."' AND idunidades='".$qsedg['id_datos']."'";
				}
				$resultado = mysqli_query($miConex, $sqlf)  or die("La consulta fall&oacute;: " . mysqli_error($miConex));
				
				while ($linea = mysqli_fetch_array($resultado))		    {
					foreach ($linea as $valor_col) {
						$valor_col--;
					}
				}
				$sql2="UPDATE areas SET ".$esta."='".htmlentities($valor_col)."' where nombre='".$area_antes."' AND idunidades='".$qsedg['id_datos']."'";
				$result = mysqli_query($miConex, $sql2) or die(mysqli_error($miConex)); 

				$fecha=date("Y-m-d");
				$sql4="insert into traspasos (id_area, fecha, inv, descrip, motivo, origen, destino,idunidades) values ('".$id_area."', '".$fecha."', '".$invt[$ctaz]."', '".$descrip."', '".$mot."','".$area_antes."', '".$no_area."','".$idunid."')";
				$result3 = mysqli_query($miConex, $sql4) or die(mysqli_error($miConex)); 
				
				$sql="UPDATE aft SET estado = 'A' WHERE inv = '".$invt[$ctaz]."' AND id_area='".$id_area."' AND idunidades='".$idunid."'";
				$result1=mysqli_query($miConex, $sql) or die(mysqli_error($miConex)); 
				
				if ($categoria=='COMPUTADORAS') {
					$sqlexp="UPDATE exp SET custodio ='".htmlentities($custodiod)."', idarea='".$no_area."', id_area='".$idareava."' WHERE inv = '".$invt[$ctaz]."' AND id_area='".$id_area."' AND idunidades='".$idunid."'";
					$resultexp=mysqli_query($miConex, $sqlexp) or die(mysqli_error($miConex)); 
				}
		
				creasalva('traspasos');
				creasalva('plan_rep');
				$ctaz++;
			}		

			
?>
<script type="text/javascript">
 document.location='registrocustodio.php';
</script>
