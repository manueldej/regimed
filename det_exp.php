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

	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
@session_start();
include ('connections/miConex.php');
include('script.php');
class colores {
	public function ColorFila($i,$color1,$color2){
		if (($i % 2)== 0) {
			$this->ColorFondo = $color1;
		}else {
			$this->ColorFondo = $color2;
		}
		return $this->ColorFondo;
	}
}
$color1="#F1F2F3";
$color2="#E9EAEB";
$uCPanel = new colores();
$IDET=$_GET['det'];
$sel = "select visitas from preferencias where usuario='".$_SESSION['valid_user']."'";
$qsel = mysqli_query($sel,$miConex) or die(mysql_error());
$rsel = mysqli_fetch_array($qsel);
$us = mysqli_query("select * from usuarios where login='".$_SESSION ["valid_user"]."'",$miConex) or die(mysql_error());
$russ = mysqli_fetch_array($us);
$nrus=mysqli_num_rows($us);
$cuantos = 5;
if(($rsel['visitas']) !=""){
	$cuantos = $rsel['visitas'];
}
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
// SQL para la b�squeda
if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
	$sql = "SELECT * FROM exp WHERE id = '".$IDET."' and idunidades='".$_COOKIE['unidades']."'"; 
}else{
	$sql = "SELECT * FROM exp WHERE id = '".$IDET."'";
}
$i = 0;
	$query_limit = sprintf("%s LIMIT %d, %d",$sql, $inicio, $registros);
	if(isset($_GET['query_limit'])){ $query_limit = base64_decode($_GET['query_limit']);}
	$result= mysqli_query($query_limit,$miConex) or die(mysql_error());
	$total_mm = mysqli_num_rows($result);
	$ggg = base64_encode($query_limit);
//NAVEGADOR inicio
	if(isset($_GET['total_registros'])){
		$total_registros=$_GET['total_registros'];
	} else {
		$all_rsDA = mysqli_query($sql,$miConex) or die(mysql_error());
		$total_registros = mysqli_num_rows($all_rsDA);
	}
	$total_paginas = ceil($total_registros / $registros);
//NAVEGADOR	FIN 
?>
<link href="css/template.css" rel="stylesheet">
<style type="text/css">
<!--
.Estilo4 {color: #000000; font-weight: bold; }
-->
</style>
<div id="buscad">
<fieldset class="fieldset"><legend class="vistauserx"><?php echo $otrosdet;?></legend>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table" >
							<tr>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">INV</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">CHIPSET</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black"><?php echo $Memorias1;?>2</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">HDD2</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">HDD3</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">HDD4</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black"><?php echo $btSONIDO;?></font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black"><?php echo $btRED;?>2</font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black"><?php echo $sist_op;?></font><strong></span></td>
								<td class="vistauser1"><span class="Estilo4"><strong><font color="black">PC</font><strong></span></td>
							</tr><?php 
							$p=0;
						WHILE ($row=mysqli_fetch_array($result)){ $i++;?>
							<tr id="cur_tr_<?php echo $p;?>" bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');"> <?php 
								 ?>
								<td>&nbsp;<?php echo $row['inv'] ?></td>
								<td>&nbsp;<?php echo $row["CHIPSET"] ?></td>
								<td>&nbsp;<?php echo $row["MEMORIA2"] ?></td>
								<td>&nbsp;<?php echo $row["DRIVE2"] ?></td>
								<td>&nbsp;<?php echo $row["DRIVE3"] ?></td>
								<td>&nbsp;<?php echo $row["DRIVE4"] ?></td>
								<td>&nbsp;<?php echo $row["SONIDO"] ?></td>
								<td>&nbsp;<?php echo $row["RED2"] ?></td>
								<td>&nbsp;<?php echo $row["OS"] ?></td>
								<td>&nbsp;<?php echo $row["n_PC"] ?></td>
							</tr><?php
							$p++;
						} ?>
						</TABLE>
				</fieldset>
</div>
<div class="dialogoInfo"></div>
<div class="ContenedorAlert" id="cir"> </div>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="js/main.js"></script>