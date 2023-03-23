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
include('script.php');
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
 include('barra.php');
?>
<div id="buscad" style="margin-left:120px;"> 
<table width="100%" border="0" align="center" class="table">
	<tr>
		<td width="466"><?php
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$sqlx="SELECT * FROM areas where (nombre ='".htmlentities($_POST['area'])."') AND (idunidades='".$_COOKIE['unidades']."')"; 
			}else{
				$sqlx="SELECT * FROM areas where nombre ='".htmlentities($_POST['area'])."'"; 
			}
			$resultq=mysqli_query($miConex, $sqlx) or die(mysql_error($miConex));
			$num_resultados = mysqli_num_rows($resultq);

			// Si hay resultados crea una tabla y los muestra

			if (($num_resultados) !=0){
				$rowz=mysqli_fetch_array($resultq);
				$no_area=$rowz["nombre"];
					
				if ($_POST['area'] != "") {?>		 
					<div class='message'> 
					 <font color='black'><b>No. <?php echo $btInventario;?> AFT: </b></font><font color='red'><b><?php echo $_POST["invent1"]; ?></b></font>
					</div> <?php  
				}			 
			} 
	 
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$query="SELECT * FROM aft where (inv ='".$_POST['invent1']."') AND (idunidades='".$_COOKIE['unidades']."')";                   
			}else{
				$query="SELECT * FROM aft where inv ='".$_POST['invent1']."' AND idunidades='".$_POST['unidades']."'";
			}
			$result=mysqli_query($miConex, $query) or die (mysql_error($miConex));
			$row = mysqli_fetch_array($result);
			$id_area=$row["id_area"];
			$area_antes=$row["idarea"];
			$categoria=$row["categ"];
			$idunid=$row["idunidades"];
			$custodio= @$_POST["custodio"];
			$mot = $_POST["motivos"];

			$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$idunid."'") or die();
			$qsedg = mysqli_fetch_array($sedg);
			
			$sqls = "UPDATE aft SET idarea = '".$no_area."' WHERE inv = '".$_POST['invent1']."' AND idunidades='".$qsedg['id_datos']."'";
			$results = mysqli_query($miConex, $sqls) or die();
				
			//actualizo nuevo Custodio para este Medio 

			if ($no_area !="Reparaciones"){
				$consulta = "UPDATE aft SET custodio = '".htmlentities($custodio)."' WHERE inv = '".$_POST['invent1']."' AND idunidades='".$qsedg['id_datos']."'";
				$resultado = mysqli_query($miConex, $consulta) or die();
			}
			$p=0;
			?>
			<div class='message'>
				<table width='100%' class="table" border="0">
					<tr>
						<td>
							<?php echo $btdatosentidad3; ?>: <font color='red'><?php echo $qsedg['entidad'];?></font><br>
							<?php echo $bttipo.$de.$btregmedio1; ?>: <font color='red'><?php echo $categoria;?></font><br>
							<?php echo $btAanterior; ?>: <font color='red'><?php echo $area_antes;?></font><br><hr>
							<?php echo $btUdestino; ?>: <font color='red'><?php echo $qsedg['entidad'];?></font><br>
							<?php echo $btAdestino; ?>: <font color='red'><?php echo $no_area;?></font><br><?php
							if ($no_area !="Reparaciones"){	
								echo "Nuevo Custodio: <font color='red'>".$custodio."</font><br>";
							}	?>
							<hr>
							<br><input type="checkbox" id="continu" value="s" name="continu" style="cursor:pointer;"><label><?php echo $btotrotras;?>:</label><br><span onmouseoVer="this.style.cursor='pointer';" onClick="if((document.getElementById('continu').checked) ==false){ document.location='r_traspasos.php'; }else{ document.location='traspasos.php'; }" class="btn">Continuar...</span>
						</td>
					</tr>
			    </table>
	
			</div><?php	
			$p++;			
			$esta=strtolower($categoria);
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){	 
				$sqlc="Select ".$esta." from areas where (nombre='".$no_area."') AND (idunidades='".$_COOKIE['unidades']."')";
			}else{
				$sqlc="Select ".$esta." from areas where nombre='".$no_area."' AND idunidades='".$qsedg['id_datos']."'";
			}
			$resultado = mysqli_query($miConex, $sqlc) or die();
			$valor_col="";
			
			while ($linea = mysqli_fetch_array($resultado)){
				foreach ($linea as $valor_col) {
					$valor_col++;
				}
			}

			$sql2s="UPDATE areas SET ".$esta."='".$valor_col."' where nombre='".$no_area."' AND idunidades='".$qsedg['id_datos']."'";
			$resulta = mysqli_query($miConex, $sql2s) or die();

			$sqld="UPDATE aft SET estado = 'A' WHERE inv = '".$_POST['invent1']."' AND idarea='".$area_antes."'";	
			$resultd=mysqli_query($miConex, $sqld) or die();

			// PARA RESTARLA DEL AREA EN DONDE ESTRABA ANTES
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$sqlf="Select ".$esta." from areas where (nombre='".$area_antes."') AND (idunidades='".$_COOKIE['unidades']."')";
			}else{
				$sqlf="Select ".$esta." from areas where nombre='".$area_antes."' AND idunidades='".$qsedg['id_datos']."'";
			}
			$resultado = mysqli_query($miConex, $sqlf)  or die();
			while ($linea = mysqli_fetch_array($resultado))	{
				foreach ($linea as $valor_col) {
					$valor_col--;
				}
			}
			
			$sql2="UPDATE areas SET ".$esta."='".htmlentities($valor_col)."' where nombre='".$area_antes."' AND idunidades='".$qsedg['id_datos']."'";
			$result = mysqli_query($miConex, $sql2) or die(); 

			$fecha=date("Y-m-d");
			if (($_POST["area"])=="Reparaciones") {
				$sql="UPDATE aft SET estado = 'R' WHERE inv = '".$_POST['invent1']."' AND id_area='".$id_area."' AND idunidades='".$idunid."'";
				$result1=mysqli_query($miConex, $sql) or die(); 
				
				$sql3="insert into plan_rep (id_area, inv, fecha, observ, idarea, custodio, idunidades) values ('".$id_area."','".$_POST['invent1']."','".$fecha."', '".$mot."', '".$area_antes."', '".$custodio."','".$idunid."')";
				$result2=mysqli_query($miConex, $sql3) or die(); 
				
				$sql4="insert into traspasos (id_area, fecha, inv, descrip, motivo, origen, destino,idunidades) values ('".$id_area."', '".$fecha."', '".$_POST['invent1']."','".$categoria."','".$mot."','".$area_antes."', '".$no_area."','".$idunid."')";

				$result3 = mysqli_query($miConex, $sql4) or die(); 
				creasalva('plan_rep');
				creasalva('traspasos');
			}else{
				$sql4="insert into traspasos (id_area, fecha, inv, descrip, motivo, origen, destino,idunidades) values ('".$id_area."', '".$fecha."', '".$_POST['invent1']."','".$categoria."','".$mot."','".$area_antes."', '".$no_area."','".$idunid."')";
				$result3 = mysqli_query($miConex, $sql4) or die(); 
				$sql="UPDATE aft SET estado = 'A' WHERE inv = '".$_POST['invent1']."' AND id_area='".$id_area."' AND idunidades='".$idunid."'";
				$result1=mysqli_query($miConex, $sql) or die(); 
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