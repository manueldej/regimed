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
include('script.php');
$qus = mysqli_query("select login,tipo from usuarios where login ='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus = mysqli_fetch_array($qus);
?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><?php
$categ="";
	if(isset($_POST['categ'])){$categ =$_POST['categ'];}
	if(isset($_POST['marcado'])){$marcado =$_POST['marcado'];}
	if(isset($_GET['categ'])){$categ =$_GET['categ'];}
	if(isset($_GET['marcado'])){$marcado =$_GET['marcado'];}
			$query = "WHERE ";
				if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){ 
				  $query = "  WHERE (idunidades ='".$_COOKIE['unidades']."') AND "; 
				}
				$arreg = array(0 => 'Custodio', 1 => '&Aacute;rea', 2 => 'CPU', 3 => 'Invent');

				if(isset($_GET["palabra"])) {
					$ret = htmlentities(substr(stristr($_GET["resto"], '('), 1, strlen(stristr ($_GET["resto"], '('))-5));
					if (in_array($ret, $arreg)) {
						$clave = array_search($ret, $arreg);
					}
					switch ($clave) {
						case 0: $query .= " custodio LIKE '%". htmlentities($_REQUEST["palabra"])."%'"; 
						break;
						case 1: $query .= " idarea LIKE '%". htmlentities($_REQUEST["palabra"])."%'";
						break;			
						case 2: $query .= " CPU LIKE '%". htmlentities($_REQUEST["palabra"])."%'"; 
						break;
						case 3: $query .= " inv LIKE '%". htmlentities($_REQUEST["palabra"])."%'";
						break;			
					}
				}
				// SQL para la búsqueda
				
				$sql1="SELECT * FROM `exp` ".$query; 
				$result1=mysqli_query($sql1) or die (mysql_error());
				$num_resultados = mysqli_num_rows($result1);
?>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 9;
	font-weight: bold;
}
.Estilo3 {font-size: 9; font-weight: bold;}
.Estilo4 {font-size: 14px}
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

<?php include('barra.php');?>
<div id="buscad">
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $btEXPEDIENTE1;?></legend>
	<table width="798" border="0" align="center">
		<tr>
			<td width="587"></td>
			<td width="72"> 
				<form name="form1" method="post" action="meiler/mail.php">
					<input name="email" type="image" id="email" src="images/emailButton.png" width="14" height="14" border="0">
					<img src="images/pdf_button.png" width="14" height="14" /> <a href="imprimir/index1.php?categ=<?php echo $categ;?>" target="_blank"><img src="images/printButton.png" width="14" height="14" border="0" /></a> 
				</form>
			</td>
		</tr>
		<tr>
			<td colspan="2"><p align="center"><span><span class="tool-title Estilo6"><span class="Estilo8"><?php echo $btEXPEDIENTE1;?></span></span>: <?php echo "<font color='red' class='Estilo10'><strong>".$categ."</strong>"; ?></td>
		</tr>
		<tr>
			<td colspan="2"><?php
				if(($num_resultados) !=0){
					// Si hay resultados crea una tabla y los muestra
					if ($row=mysqli_fetch_array($result1)){
						$sqlse="SELECT * FROM aft WHERE inv='".$row['inv']."'"; 
						$resultsq=mysqli_query($sqlse,$miConex) or die(mysql_error());
						$resultsqlse = mysqli_fetch_array($resultsq);
						$sellod = $resultsqlse['sello'];
						$custo=$row["custodio"];
						$nomb_PC = $row["CPU"];
						$area_resp = $row["idarea"];
						echo "Responsable del Medio: <font color='red'><b>".$custo."</b><font color='black'>";	?>
						<TABLE BORDER='1' border="0" cellspacing="0" cellpadding="0" bordercolor=#6699CC class="sgf1" >
							<tr>
								<td class="bannerfooter_text"><span class="Estilo1"><strong><font color='black'>INV</span></td>
								<td width=200 class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'>CPU</b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'>MOTHERBOARD</b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'>CHIPSET</b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'><?php echo $Memorias1;?></b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'><?php echo $bttargeta;?></b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'>HDD1</b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'>HDD2</b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'><?php echo $btSONIDO;?></b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'><?php echo $btRED;?></b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'>SO</b></span></td>
								<td class="bannerfooter_text"><span class="Estilo3"><b><strong><font color='black'><?php echo strtoupper($btNombre);?> PC</b></span></td> 
							</tr>
							<tr>
								<td>&nbsp;<?php echo $row["inv"]; ?></td>
								<td>&nbsp;<?php echo $row["CPU"]; ?></td>
								<td>&nbsp;<?php echo $row["PLACA"]; ?></td>
								<td>&nbsp;<?php echo $row["CHIPSET"]; ?></td>
								<td>&nbsp;<?php echo $row["MEMORIA"]; ?></td>
								<td>&nbsp;<?php echo $row["GRAFICS"]; ?></td>
								<td>&nbsp;<?php echo $row["DRIVE1"]; ?></td>
								<td>&nbsp;<?php echo $row["DRIVE2"]; ?></td>
								<td>&nbsp;<?php echo $row["SONIDO"]; ?></td>
								<td>&nbsp;<?php echo $row["RED"]; ?></td>
								<td>&nbsp;<?php echo $row["OS"]; ?></td>
								<td>&nbsp;<?php echo $row["n_PC"]; ?></td>
							</tr>	
						</TABLE><?php 
					} ?>
					<span><?php echo $btNombre;?> PC:</span><span><?php echo "<font color='red'>".$nomb_PC ."<font color=black>";?></span><span> <?php echo ucwords($btSELLO);?> B T: </span><span><?php echo "<font color='red'>".$sellod."<font color=black>"; ?></span><span> <?php echo substr($btAreas,0,-1);?>: </span><span ><?php echo "<font color='red'>".$area_resp."<font color=black>";
				}else{
					echo "<div class='Estilo10'>Este medio no tiene Expepediente conformado.</div><a href='form-insertarexp.php?inv=".$categ."'>Click</a> para crearlo";
				}
				$sql="SELECT * FROM aft WHERE custodio='".$custo."' and custodio is Not Null"; 
				$result=mysqli_query($sql,$miConex) or die(mysql_error());
				$num_resultados = mysqli_num_rows($result);

				if ($row1= mysqli_fetch_array($result)){ ?>
					 <h1 class="contentheading" ><?php echo $btotros;?></h1>
					 <TABLE BORDER='0' align="center" class="sgf1" > 
						 <tr> 
							 <td><span class="Estilo23">INV</span></td>
							 <td><span class="Estilo23"><?php echo $DESCRIPCION; ?></span></td>
							 <td><span class="Estilo23"><?php echo $btSELLO; ?></span></td>
							 <td><span class="Estilo23"><?php echo $btMARCA; ?></span></td>
							 <td><span class="Estilo23">NO. SERIE</span></td>
							 <td><span class="Estilo23"><?php echo $btMODELO; ?></span></td>
							 <td><span class="Estilo23">CATEG.</span></td>
							 <td><span class="Estilo23"><?php echo strtoupper($bttipo); ?></span></td>
						 </tr><?php 
						WHILE ($row1=mysqli_fetch_array($result)){ ?>
						<tr>
							<td><?php echo $row1["inv"]; ?></td>
							<td><?php echo $row1["descrip"];?></td> 
							<td><?php echo $row1["sello"]; ?></td>
							<td><?php echo $row1["marca"]; ?></td>
							<td><?php echo $row1["no_serie"]; ?></td>
							<td><?php echo $row1["modelo"] ;?></td>
							<td><?php echo $row1["categ"]; ?></td>
							<td><?php echo $row1["tipo"]; ?></td>
						</tr><?php 
						}	?>
					</TABLE><?php 
					echo "Total medios: ".$num_resultados;
				} ?>
				
				<form name="va" method="post" action="q.php">
					<?php if (($rus['tipo']) =="root") { ?><hr><input name="edita" type="button" id="edita" value="<?php echo $bteditar;?>" class="boton" onclick="javascript:document.location='modificarexp.php?inv=<?php echo $row["inv"];?>*'"><?php } ?>
					<input name="marcado1" type="hidden" value="<?php echo $marcado;?>">
				</form>	
			</td>
		  </tr>
	</table>
<br><hr width="70%" align="center">
<div class="Footer-inner" align="center">
	<div class="Footer-text" align="center">
		<?php include ("version.php"); ?>
	</div>
</div>
</fieldset>
</div>
<?php
mysql_close ($miConex);
?>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>