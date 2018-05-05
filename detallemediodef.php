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
@session_start(); include('chequeo.php');
if (!check_auth_user()){
	?><script type="text/javascript">window.parent.location="index.php";</script><?php
	exit;
}
include ('connections/miConex.php');
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
$us = mysqli_query($miConex, "select * from usuarios where login='".$_SESSION ["valid_user"]."'") or die(mysql_error());
$rus = mysqli_fetch_array($us);
$kk=0;
if(isset($_GET['l1'])){$kk=1;}
	if(($kk) !=1){
		if(isset($_GET['det'])){
			$sql = "SELECT * FROM aft WHERE id = '".$_GET['det']."'";
		}elseif(isset($_GET['ini'])){
			if (isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
				$sql = "SELECT * FROM aft WHERE idunidades='".$_COOKIE['unidades']."' ORDER BY ".$_GET['orderby']." ".$_GET['asc']."  LIMIT ".$_GET['ini'].",".$_GET['reg'];
			}else{
				$sql = "SELECT * FROM aft  ORDER BY ".$_GET['orderby']." ".$_GET['asc']."  LIMIT ".$_GET['ini'].",".$_GET['reg'];
			}
		}elseif(isset($_GET['quer'])){
			$sql =base64_decode($_GET['quer']);
		}
		$result= mysqli_query($miConex, $sql) or die(mysql_error());
		$numro = mysqli_num_rows($result);
        
		$i="es";
		if(isset($_COOKIE['seulang'])){
			if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
		}
		if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
		?>
		<link href="css/template.css" rel="stylesheet" type="text/css" />
		<fieldset class='fieldset'><legend class="vistauserx"><?php echo strtoupper($otrosdet);?></legend>	
		<?php
		if(($numro) ==1){ 
			$row=mysqli_fetch_array($result);
			// para saber al área a la cuál pertenece el aft defectuoso
			$sqlpertenece ="SELECT * FROM usuarios where nombre='".$row['custodio']."'";
			$resultpertenece= mysqli_query($miConex, $sqlpertenece) or die(mysql_error());
			$rowresultpertenece=mysqli_fetch_array($resultpertenece);?>
			<TABLE width="100%" BORDER='0' class='sgf1' align='center' >
				<tr>
					  <td width="98" class="vistauser1" align="center"><b>INV</b></td>
					  <td width="189" class="vistauser1" align="center"><b><?php echo $btestado;?></b></td>
					  <td width="105" class="vistauser1" align="center"><b><?php echo $btSELLO;?></b></td>
					  <td width="102" class="vistauser1" align="center"><b>SERIE</b></td>
					  <td width="290" class="vistauser1" align="center"><b><?php echo $btPERTENECE.$btAreas1;?></b></td>
					  <td width="191" class="vistauser1" align="center"><b><?php echo strtoupper($btCustodios);?></b></td>
				</tr><?php
						$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$row["idunidades"]."'") or die(mysql_error());
						$qsedg = mysqli_fetch_array($sedg);	?>
						<tr title="<?php echo $btregmedio1.$dela.$btdatosentidad3.": ".$qsedg['entidad'];?>" <?php if (($rus['tipo']) =="root") {?> onDblClick="hacer('<?php echo $row["id"]?>');"<?php }?> id="cur_tr_<?php echo $p;?>" onclick="marca1(<?php echo $p;?>,'#ffffff');  det('<?php echo $row["id"];?>');">
						    <td align="center"><?php  echo $row["inv"];?></td>
							<td align="center"><?php  if (($row["estado"]) =="R") { echo "ROTO"; }elseif (($row["estado"]) =="P") { echo "P. BAJAS"; } ?></td>
							<td align="center"><?php  echo $row["sello"];?></td>
							<td align="center"><?php  echo $row["no_serie"];?></td>
						 	<td align="center"><?php  echo $rowresultpertenece["idarea"];?></td>
						    <td align="center"><?php  echo $row["custodio"];?></td>
						</tr>
			</table>
<?php
		}elseif(($numro) >1){ ?>
			<TABLE width="100%" BORDER='0' bordercolor='#AFCBCF' class='sgf1' align='center' cellpadding="0" cellspacing="0">
				<tr>
					  <td width="98"class="vistauser1" align="center"><b>INV</b></td>
					  <td width="189" class="vistauser1" align="center"><b><?php echo $btestado;?></b></td>
					  <td width="105" class="vistauser1" align="center"><b><?php echo $btSELLO;?></b></td>
					  <td width="102" class="vistauser1" align="center"><b>SERIE</b></td>
					  <td width="290" class="vistauser1" align="center"><b><?php echo $btPERTENECE.$btAreas1;?></b></td>
					  <td width="191" class="vistauser1" align="center"><b><?php echo strtoupper($btCustodios);?></b></td>
				</tr><?php
					$id = 0;
					$p=0;
					while($row=mysqli_fetch_array($result)) { $i++;
						$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$row["idunidades"]."'") or die(mysql_error());
						$qsedg = mysqli_fetch_array($sedg);	
						// para saber al área a la cuál pertenece el aft defectuoso
						$sqlpertenece ="SELECT * FROM usuarios where nombre='".$row['custodio']."'";
						$resultpertenece= mysqli_query($miConex, $sqlpertenece) or die(mysql_error());
						$rowresultpertenece=mysqli_fetch_array($resultpertenece);?>
						<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" title="<?php echo $btregmedio1.$dela.$btdatosentidad3.": ".$qsedg['entidad'];?>" <?php if (($rus['tipo']) =="root") {?> onDblClick="hacer('<?php echo $row["id"]?>');"<?php }?> id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#DBE2D0');"  onclick="marca1(<?php echo $p;?>,'#ffffff');  det('<?php echo $row["id"];?>');">
						    <td align="center"><?php  echo $row["inv"];?></td>
							<td align="center"><?php  echo $row["estado"];?></td>
							<td align="center"><?php  echo $row["sello"];?></td>
							<td align="center"><?php  echo $row["no_serie"];?></td>
							<td align="center"><?php  echo $rowresultpertenece["idarea"];?></td>
						    <td align="center"><?php  echo $row["custodio"];?></td>
						</tr><?php $p++;
					}?>
			</table>
<?php
		}
	}	?>
</fieldset>
