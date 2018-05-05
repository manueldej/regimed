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
<script type="text/javascript" src="ajax.js"></script>
<link href="css/template.css" rel="stylesheet" type="text/css" /> 
	<style type="text/css">
<!--
.Estilo4 {color: #000000; font-weight: bold; }
-->
</style><?php
		$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}
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
$kk=0;
if(isset($_GET['l1'])){$kk=1;}
include('script.php');
include ('connections/miConex.php');
	if(($kk) !=1){
		if(isset($_GET['id'])){ 
			$id=$_GET['id'];
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$sql = "SELECT * FROM bajas_aft WHERE id = '".$id."' AND idunidades='".$_COOKIE['unidades']."'";
			}else{
				$sql = "SELECT * FROM bajas_aft WHERE id = '".$id."'";
			}
		}
		if(isset($_GET['ini'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$sql = "SELECT * FROM bajas_aft WHERE idunidades='".$_COOKIE['unidades']."' LIMIT ".$_GET['ini'].",".$_GET['reg'];
			}else{
				$sql = "SELECT * FROM bajas_aft LIMIT ".$_GET['ini'].",".$_GET['reg'];
			}
		}
			
			$result= mysqli_query($miConex, $sql) or die(mysql_error());
			$numro = mysqli_num_rows($result);?>
		<br>
			<fieldset class='fieldset'>
					<table width="100%" BORDER='0' class='table' align='center' cellpadding="0" cellspacing="0">
						<tr>
							  <td width="84"class="vistauser1" align="center"><span class="Estilo4"><b>INV.</b></span></td>
							  <td width="203" class="vistauser1" align="center"><span class="Estilo4"><b><?php echo $DESCRIPCION;?></b></span></td>
							  <td width="43" class="vistauser1" align="center"><span class="Estilo4"><b><?php echo $btestado;?></b></span></td>
							  <td width="32" class="vistauser1" align="center"><span class="Estilo4"><b><?php echo $btAreas1;?></b></span></td>
							  <td width="35" class="vistauser1" align="center"><span class="Estilo4"><b><?php echo $btSELLO;?></b></span></td>
							  <td width="44" class="vistauser1" align="center"><span class="Estilo4"><b><?php echo $btMARCA;?></b></span></td>
							  <td width="33" class="vistauser1" align="center"><span class="Estilo4"><b>SERIE</b></span></td>
							  <td width="46" class="vistauser1" align="center"><span class="Estilo4"><b><?php echo $btMODELO;?></b></span></td>
							  <td width="48" class="vistauser1" align="center"><span class="Estilo4"><b>CATEG.</b></span></td>
							  <td width="46" class="vistauser1" align="center"><span class="Estilo4"><b><?php echo strtoupper($bttipo);?></b></span></td>
							  <td width="68" class="vistauser1" align="center"><span class="Estilo4"><b><?php echo strtoupper($btCustodios);?></b></span></td>
							  <td width="50" class="vistauser1" align="center"><span class="Estilo4"><b><?php echo strtoupper($bttipo);?>-AFT</b></span></td>
						</tr><?php
						if(($numro) ==1){
							$row=mysqli_fetch_array($result); ?>
							<tr>
								<td class="Estilo2"><?php  echo $row["inv"];?></td>
								<td class="Estilo2"> <?php  echo $row["descrip"];?></td>
								<td class="Estilo2"> <?php  echo $row["estado"];?></td>
								<td class="Estilo2"><?php  echo $row["idarea"];?></td>
								<td class="Estilo2"><?php  echo $row["sello"];?></td>
								<td class="Estilo2"><?php  echo $row["marca"];?></td>
								<td class="Estilo2"><?php  echo $row["no_serie"];?></td>
								<td class="Estilo2"><?php  echo $row["modelo"];?></td>
								<td class="Estilo2"><?php  echo $row["categ"];?></td>
								<td class="Estilo2"> <?php  echo $row["tipo"];?></td>
								<td class="Estilo2"><?php  echo $row["custodio"];?></td>
								<td width="50" align="center"><?php  echo $row["t_AFT"];?></td>
							</tr><?php
						}elseif(($numro) >1){ $p=0;
							while($row=mysqli_fetch_array($result)){ ?>
								<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>"  onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');">
									<td class="Estilo2"><?php  echo $row["inv"];?></td>
									<td class="Estilo2"> <?php  echo $row["descrip"];?></td>
									<td class="Estilo2"> <?php  echo $row["estado"];?></td>
									<td class="Estilo2"><?php  echo $row["idarea"];?></td>
									<td class="Estilo2"><?php  echo $row["sello"];?></td>
									<td class="Estilo2"><?php  echo $row["marca"];?></td>
									<td class="Estilo2"><?php  echo $row["no_serie"];?></td>
									<td class="Estilo2"><?php  echo $row["modelo"];?></td>
									<td class="Estilo2"><?php  echo $row["categ"];?></td>
									<td class="Estilo2"> <?php  echo $row["tipo"];?></td>
									<td class="Estilo2"><?php  echo $row["custodio"];?></td>
									<td width="50" align="center"><?php  echo $row["t_AFT"];?></td>
								</tr><?php
								$p++;
							}							
						} ?>
					</table>
		</fieldset><?php
	}?>