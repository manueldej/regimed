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
<?php 
include ('header.php');
include('barra.php');

?>
<div id="buscad"> 
<table width="472" border="0" align="center">
	<tr>
		<td width="466" class="Estilo1"><?php
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$sqlx="SELECT * FROM areas where (nombre ='".htmlentities($_POST['area'])."') AND (idunidades='".$_COOKIE['unidades']."')"; 
			}else{
				$sqlx="SELECT * FROM areas where nombre ='".htmlentities($_POST['area'])."'"; 
			}
			$resultq=mysqli_query($miConex, $sqlx) or die(mysql_error());
			$num_resultados = mysqli_num_rows($resultq);

			// Si hay resultados crea una tabla y los muestra

			if (($num_resultados) !=0){
				$rowz=mysqli_fetch_array($resultq);
				$no_area=$rowz["nombre"];
					
				if ($_POST['area'] != "") {?>		 
					<div class='message'> 
						<table border='0' bordercolor='#AFCBCF' align='center' width='100%' class="table">
							<tr width='300'><?php echo "\n"; ?><td>No. <?php echo $btInventario;?> AFT: <font color='red'><?php echo $_POST["invent1"]; ?></font></td>
							</tr>
						</table>
					</div> <?php  
				}			 
			} 
	
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$query="SELECT * FROM aft where (inv ='".$_POST['invent1']."') AND (idunidades='".$_COOKIE['unidades']."')";                   
			}else{
				$query="SELECT * FROM aft where inv ='".$_POST['invent1']."' AND idunidades='".$_POST['unidades']."'";
			}
			$result=mysqli_query($miConex, $query) or die (mysql_error());
			$row = mysqli_fetch_array($result);
			$id_area=$row["id_area"];
			$area_antes=$row["idarea"];
			$categoria=$row["categ"];
			$idunid=$row["idunidades"];
			$custodio= @$_POST["custodio"];
			$mot = $_POST["motivos"];

			$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$idunid."'") or die(mysql_error());
			$qsedg = mysqli_fetch_array($sedg);
			
			$sqls = "UPDATE aft SET idarea = '".$no_area."' WHERE inv = '".$_POST['invent1']."' AND idunidades='".$qsedg['id_datos']."'";
			$results = mysqli_query($miConex, $sqls) or die(mysql_error());
			//echo $sqls."<br>";
			//actualizo nuevo Custodio para este Medio 

			if ($no_area !="Reparaciones"){
				$consulta = "UPDATE aft SET custodio = '".htmlentities($custodio)."' WHERE inv = '".$_POST['invent1']."' AND idunidades='".$qsedg['id_datos']."'";
				$resultado = mysqli_query($miConex, $consulta) or die(mysql_error());
				//echo $consulta;
			}
			?>
			<div class='message'>
			<div align="left">
				<TABLE width='100%' class="table">
					<tr>
						<td>
							<b><?php echo $btdatosentidad3?>: </b><font color='red'><?php echo $qsedg['entidad'];?></font><br>
							<b><?php echo $bttipo.$de.$btregmedio1?>: </b><font color='red'><?php echo $categoria;?></font><br>
							<b><?php echo $btAanterior;?>: </b><font color='red'><?php echo $area_antes;?></font><br>
							<b><?php echo $btAdestino;?>: </b><font color='red'><?php echo $no_area;?></font><br><?php
							if ($no_area !="Reparaciones"){	
								echo "<b>Nuevo Custodio: </b><font color='red'>".$custodio."</font><br>";
							}	?>
							<b><label><?php echo $btotrotras;?>: <input type="checkbox" id="continu" value="s" name="continu"></label><br><span onmouseoVer="this.style.cursor='pointer';" onClick="if((document.getElementById('continu').checked) ==false){ document.location='r_traspasos.php'; }else{ document.location='traspasos.php'; }" class="btn">Continuar...</span><b>
						</td>
					</tr>
			    </table>
			</div>
			</div><?php			
			$esta=strtolower($categoria);
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){	 
				$sqlc="Select ".$esta." from areas where (nombre='".$no_area."') AND (idunidades='".$_COOKIE['unidades']."')";
			}else{
				$sqlc="Select ".$esta." from areas where nombre='".$no_area."' AND idunidades='".$qsedg['id_datos']."'";
			}
			$resultado = mysqli_query($miConex, $sqlc) or die(mysql_error());
			$valor_col="";
			while ($linea = mysqli_fetch_array($resultado)){
				foreach ($linea as $valor_col) {
					$valor_col++;
				}
			}

			$sql2s="UPDATE areas SET ".$esta."='".$valor_col."' where nombre='".$no_area."' AND idunidades='".$qsedg['id_datos']."'";
			$resulta = mysqli_query($miConex, $sql2s) or die(mysql_error());

			$sqld="UPDATE aft SET estado = 'A' WHERE inv  = '".$_POST['invent1']."' AND id_area='".$area_antes."'";
			$resultd=mysqli_query($miConex, $sqld) or die(mysql_error());

			// PARA RESTARLA DEL AREA EN DONDE ESTRABA ANTES
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$sqlf="Select ".$esta." from areas where (nombre='".$area_antes."') AND (idunidades='".$_COOKIE['unidades']."')";
			}else{
				$sqlf="Select ".$esta." from areas where nombre='".$area_antes."' AND idunidades='".$qsedg['id_datos']."'";
			}
			$resultado = mysqli_query($miConex, $sqlf)  or die("La consulta fall&oacute;: " . mysql_error());
			while ($linea = mysqli_fetch_array($resultado))	{
				foreach ($linea as $valor_col) {
					$valor_col--;
				}
			}
			$sql2="UPDATE areas SET ".$esta."='".htmlentities($valor_col)."' where nombre='".$area_antes."' AND idunidades='".$qsedg['id_datos']."'";
			$result = mysqli_query($miConex, $sql2) or die(mysql_error()); 

			$fecha=date("Y-m-d");
			if (($_POST["area"])=="Reparaciones")   {
				$sql="UPDATE aft SET estado = 'R' WHERE inv = '".$_POST['invent1']."' AND id_area='".$id_area."' AND idunidades='".$idunid."'";
				$result1=mysqli_query($miConex, $sql) or die(mysql_error()); 
				$sql3="insert into plan_rep (id_area, inv, fecha, observ, idarea, custodio, idunidades) values ('".$id_area."','".$_POST['invent1']."','".$fecha."', '".$mot."', '".$area_antes."', '".$custodio."','".$idunid."')";
				$result2=mysqli_query($miConex, $sql3) or die(mysql_error()); 
				$sql4="insert into traspasos (id_area, fecha, inv, motivo, origen, destino,idunidades) values ('".$id_area."', '".$fecha."', '".$_POST['invent1']."', '".$mot."','".$area_antes."', '".$no_area."','".$idunid."')";
				$result3 = mysqli_query($miConex, $sql4) or die(mysql_error()); 
				creasalva('plan_rep');
				creasalva('traspasos');
			}else{
				$sql4="insert into traspasos (id_area, fecha, inv, motivo, origen, destino,idunidades) values ('".$id_area."', '".$fecha."', '".$_POST['invent1']."', '".$mot."','".$area_antes."', '".$no_area."','".$idunid."')";
				$result3 = mysqli_query($miConex, $sql4) or die(mysql_error()); 
				$sql="UPDATE aft SET estado = 'A' WHERE inv = '".$_POST['invent1']."' AND id_area='".$id_area."' AND idunidades='".$idunid."'";
				$result1=mysqli_query($miConex, $sql) or die(mysql_error()); 
				creasalva('traspasos');
				creasalva('plan_rep');
		    }?>
	  </td>
	</tr>
</table>
</fieldset><br><?php include ("version.php");?>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>