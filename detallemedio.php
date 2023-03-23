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
class cdate{
	function formatDate($adate, $currTab, $futTab){
		if (!is_null($adate)){
			$sep = array();
			$sep = explode($currTab, $adate);
			return @$sep[2].@$futTab.@$sep[1].@$futTab.@$sep[0];
		}else{
			return "";
		}
	}
}
$myDate = new cdate();
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
				$sql = "SELECT * FROM aft ORDER BY ".$_GET['orderby']." ".$_GET['asc']."  LIMIT ".$_GET['ini'].",".$_GET['reg'];
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
			$row=mysqli_fetch_array($result);?>
			<table width="100%" border="0" class="table" align="center">
				<tr>
					  <td width="207" class="vistauser1" align="center"><b><?php echo $DESCRIPCION;?></b></td>
					  <td width="100" class="vistauser1" align="center"><b><?php echo $btestado;?></b></td>
					  <td width="113" class="vistauser1" align="center"><b><?php echo $btSELLO;?></b></td>
					  <td width="90" class="vistauser1" align="center"><b><?php echo $btMARCA;?></b></td>
					  <td width="237" class="vistauser1" align="center"><b>SERIE</b></td>
					  <td width="198" class="vistauser1" align="center"><b><?php echo $btMODELO;?></b></td>
					  <td width="100" class="vistauser1" align="center"><b><?php echo strtoupper($bttipo)."-AFT";?></b></td>
					  <td width="300" class="vistauser1" align="center"><b><?php echo strtoupper($unidad);?></b></td>
				</tr><?php
						$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$row["idunidades"]."'") or die(mysql_error());
						$qsedg = mysqli_fetch_array($sedg);	?>
						<tr title="<?php echo $btregmedio1.$dela.$btdatosentidad3.": ".$qsedg['entidad'];?>" id="cur_tr_<?php echo $p;?>">
						  <td><?php  echo $row["descrip"];?></td>
							<td><div  align="center"><?php  echo $row["estado"];?></div></td>
							<td><?php  echo $row["sello"];?></td>
							<td><?php  echo $row["marca"];?></td>
							<td><?php  echo $row["no_serie"];?></td>
						    <td><?php  echo $row["modelo"];?></td>
						    <td align="center"><?php  echo $row["t_AFT"];?></td>
						    <td align="center"><?php  echo $qsedg["entidad"];?></td>
						</tr>
			</table><br>
		    <h4>&nbsp;<?php echo strtoupper($record); ?></h4><?php  
			    $sql_tras=mysqli_query($miConex, "select * from traspasos where inv ='".$row["inv"]."' AND idunidades='".$row['idunidades']."'") or die(mysql_error());
				$ca_tras = mysqli_num_rows($sql_tras);
				if($ca_tras!=0){ 
			 ?>
			<table width="100%" border="0" class="table" align="center">
				<tr>
					<td width="47" align="center" class="vistauser1"><b><span class="Estilo4">INV</span></b></td>
					<td width="194" class="vistauser1"><b><span class="Estilo4"><?php echo $DESCRIPCION;?></span></b></td>
					<td width="17" class="vistauser1"><div align="center"><b><span class="Estilo4"><?php echo strtoupper($Fecha);?></span></b></div></td>	  
					<td width="100" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo strtoupper($selectmot);?></span></b></td>
					<td width="132" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $btORIGEN;?></span></b></td>
					<td width="123" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $btDESTINO;?></span></b></td>
				    <td width="215" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo strtoupper($btdatosentidad3);?></span></b>&nbsp;</td>
				</tr><?php
					
					while ($row_trasp=mysqli_fetch_array($sql_tras))	{ $i++; 
					  $sqlaft=mysqli_query($miConex, "SELECT descrip FROM aft where idunidades ='".$row["idunidades"]."' AND inv='".$row["inv"]."'") or die(mysql_error()); 
					  $rowaft = mysqli_fetch_array($sqlaft); ?>
						<tr title="<?php echo $row['inv'];?>" id="cur_tr_<?php echo $p;?>" onclick="marca1(<?php echo $p;?>,'#ffffff');">
						  <td> <?php  echo $row["inv"];?></td>
							<td><div><?php echo $rowaft["descrip"];?></div></td>
							<td><?php echo $myDate->formatDate($row_trasp["fecha"],"-","/");?></td>
							<td><?php echo $row_trasp["motivo"];?></td>
							<td><?php echo $row_trasp["origen"];?></td>
						    <td><?php echo $row_trasp["destino"];?></td>
						    <td align="center"><?php echo $qsedg["entidad"];?></td>
						</tr><?php @$p++;
						
					} ?>
			</table><?php } else { echo "&nbsp;&nbsp;<< <b>".$no_traspasos.".</b> >>"; } ?>
			<br>
		    <h4>&nbsp;<?php echo strtoupper($hist_upgrade); ?></h4>
			<?php  
			    $sql_upgrade=mysqli_query($miConex, "select * from upgrade where exp ='".$row["inv"]."' AND idunidades='".$row['idunidades']."'") or die(mysql_error());
				$ca_up = mysqli_num_rows($sql_upgrade);
				if($ca_up !=0){ 
			 ?>
			<table width="100%" border="0" class="table" align="center">
				<tr>
					<td width="47" align="center" class="vistauser1"><b><span class="Estilo4">EXP</span></b></td>
					<td width="67" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $Fecha;?></span></b></td>
					<td width="120" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo $comp_m;?></span></b></td>
					<td width="215" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo strtoupper($bttipo);?></span></b></td>	  
					<td width="264" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo strtoupper($remplazado_por);?></span></b></td>
				</tr><?php
						while ($row_upgrade=mysqli_fetch_array($sql_upgrade)){ $i++; ?>
						<tr id="cur_tr_<?php echo $p;?>">
						    <td> <?php  echo $row_upgrade["exp"];?></td>
						    <td><?php echo $myDate->formatDate($row_upgrade["fecha"],"-","/");?></td>
							<td><div><?php  echo $row_upgrade["componente"];?></div></td>
							<td><?php  echo $row_upgrade["tipo"];?></td>
							<td><?php  echo $row_upgrade["remplazado_por"];?></td>
						</tr><?php @$p++;
						
					} ?>
			</table><?php } else { echo "&nbsp;&nbsp;<< <b>".$no_upgrade.".</b> >>"; } ?>
			<br>
			<h4>&nbsp;<?php echo strtoupper($hist_sellos); ?></h4>
			<?php  
			    $sql_sellos=mysqli_query($miConex, "select * FROM sellos INNER JOIN (aft) ON (sellos.inv = aft.inv) where sellos.inv ='".$row["inv"]."'") or die(mysqli_error($miConex));
				$ca_sello = mysqli_num_rows($sql_sellos);
				if($ca_sello !=0){ 
			 ?>
			<table width="100%" border="0" class="table" align="center">
				<tr>
				    <td width="215" align="center" class="vistauser1"><b><span class="Estilo4"><?php echo strtoupper($sellos_utilizados);?></span></b></td>	  
				</tr><?php
						while ($row_sellos=mysqli_fetch_array($sql_sellos)){ $i++; ?>
						<tr id="cur_tr_<?php echo $p;?>">
						    <td> <?php  echo $row_sellos["numero"];?></td>
						</tr><?php @$p++;
						
					} ?>
			</table><?php } else { echo "&nbsp;&nbsp;<< <b>".$no_sellos.".</b> >>"; } ?>
<?php
		}elseif(($numro) >1){ ?>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
				<tr>
					  <td width="208" class="vistauser1" align="center"><b><?php echo $DESCRIPCION;?></b></td>
					  <td width="100" class="vistauser1" align="center"><b><?php echo $btestado;?></b></td>
					  <td width="114" class="vistauser1" align="center"><b><?php echo $btSELLO;?></b></td>
					  <td width="90" class="vistauser1" align="center"><b><?php echo $btMARCA;?></b></td>
					  <td width="240" class="vistauser1" align="center"><b>SERIE</b></td>
					  <td width="200" class="vistauser1" align="center"><b><?php echo $btMODELO;?></b></td>
					  <td width="100" class="vistauser1" align="center"><b><?php echo strtoupper($bttipo)."-AFT";?></b></td>
					  <td width="300" class="vistauser1" align="center"><b><?php echo strtoupper($unidad);?></b></td>
				</tr><?php
					$id = 0;
					$p=0;
					while($row=mysqli_fetch_array($result)) { $i++;
						$sedg=mysqli_query($miConex, "select * from datos_generales where id_datos ='".$row["idunidades"]."'") or die(mysql_error());
						$qsedg = mysqli_fetch_array($sedg);	?>
						<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" title="<?php echo $btregmedio1.$dela.$btdatosentidad3.": ".$qsedg['entidad'];?>" id="cur_tr_<?php echo $p;?>" onMouseOver="this.style.background='#CCFFCC';colorear('<?php echo $p;?>','#CCFFCC'); this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>';colorear('<?php echo $p;?>','#FCF8E2');" onclick="marca1(<?php echo $p;?>,'#ffffff');" >
						    <td> <?php  echo $row["descrip"];?></td>
							<td><div  align="center"><?php  echo $row["estado"];?></div></td>
							<td><?php  echo $row["sello"];?></td>
							<td><?php  echo $row["marca"];?></td>
							<td><?php  echo $row["no_serie"];?></td>
						    <td><?php  echo $row["modelo"];?></td>
						    <td align="center"><?php  echo $row["t_AFT"];?></td>
						    <td align="center"><?php  echo $qsedg["entidad"];?></td>
						</tr><?php $p++;
					}?>
			</table>
<?php
		}
	}	?>
</fieldset>
