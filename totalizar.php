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
echo "<!DOCTYPE html>"; 
echo "<html lang='es'>";
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
@session_start();
include('chequeo.php');
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
		if (!check_auth_user()){
			?><script type="text/javascript">window.parent.location="index.php";</script><?php
			exit;
		}
	if (!file_exists('connections/miConex.php')){ ?>
		<script type="text/javascript">window.parent.location="installation/index.php";</script><?php
		return;

	}
	$i="es";
	if(isset($_COOKIE['seulang'])){
		if(($_COOKIE['seulang']) =="es"){$i="es"; }else{$i="en";}
	}
	if(($i) =="es"){include('esp.php');}else{ include('eng.php');}
	require_once('connections/miConex.php');
    $Uact = "";
	if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql_uactiva = "select * from datos_generales WHERE id_datos='".$_COOKIE['unidades']."'";
	}else{
		$sql_uactiva = "select * from datos_generales";
	}
	$result_uactiva= mysqli_query($miConex, $sql_uactiva);
	$ractiva = mysqli_fetch_array($result_uactiva);
	$Uact = $ractiva['id_datos'];
	$entidd = $ractiva['entidad'];
	
	if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
		$sql = "select * from areas where idunidades='".$_COOKIE['unidades']."'";
	}else{
		$sql = "select * from areas";
	}
	$result= mysqli_query($miConex, $sql) or die(mysql_error());
	$nucap=mysqli_num_fields($result);
	$nufil=mysqli_num_rows($result);
	$rows = mysqli_fetch_array($result);
	$TG=0;
	$TTG=0;
	$TGU = 0;
	$TGR = 0;
	$TGB = 0;
	$TG_R = 0;
	$TG_inter = 0;
	$TG_intra = 0;
	$count =0;
	$p=0;
	$ggg=base64_encode($sql);	?>
	<link href="css/template.css" rel="stylesheet">
	<style>
		.save{
			background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
			height: 16px;
			background-position: 0 -57px;
		}
		.pdf{
			background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
			height: 16px;
			background-position: 0 -116px;
		}
		.printer{
			background: url(images/gr_custom-inputs.png) 0 -1px no-repeat;
			height: 16px;
			background-position: 0 -16px;
		}	
	</style>
	<script type="text/javascript">
	function busca_tipo(tipo){
		if((tipo) != "-1"){
			window.parent.location="registromedios1.php?palabra="+tipo;
		}
		return false;
    }
    </script>
	<table class="table" width="56%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="8" style="border-top: 0px none;">
				<div id="imprime" >
					<table align="right" width="15%" border="0" cellspacing="0" cellpadding="0">
						<tr>
						  <td class="pdf" style="border-top: 0px none;"><a class="tooltip" href="pdf/tuto3.php?query=<?php echo $ggg;?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($cr_pdf);?></span></a><div style="display:none;"><div id="subpdf"><?php echo strtoupper($cr_pdf);?></div></div></td>
						  <td class="printer" style="border-top: 0px none;"><a class="tooltip" href="imprimir/index3.php" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onmouseover="this.style.cursor='pointer';" ><?php echo strtoupper($sav_print);?></span></a></td>
						</tr>
					</table>	
				</div>
			</td>
		</tr>
		<tr>
			<td width="28%" class="vistauser1"><strong><?php echo $btversion1;?></strong></td>
			<td align="center" class="vistauser1"><strong>Total</strong>			</td>
			<td align="center" class="vistauser1"><b><?php echo $btenuso;?></b></td>
		    <td align="center" class="vistauser1"><b><?php echo $btrotas;?></b></td>
		    <td align="center" class="vistauser1"><b><?php echo $btPBajas;?></b></td>
		    <td align="center" class="vistauser1"><b><?php echo $btenred;?></b></td>
		    <td align="center" class="vistauser1"><b>Internet</b></td>
		    <td width="10%" align="center" class="vistauser1"><b>Intranet</b></td>
		</tr>
  				<tr>
					<td colspan="8"><hr></td>
				</tr><?php
				for($n=1; $n<$nucap; $n++){ 
                    $field = mysqli_fetch_field_direct ($result, $n);
					$name1  = $field->name;
					$flags = $field->flags;
					
					if (($name1) !='idunidades' and ($name1) !='nombre')  { 
						//en uso
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consulta  = "SELECT COUNT(estado) as enuso FROM aft WHERE  estado = 'A' AND categ='".strtoupper($name1)."' AND idunidades='".$Uact."'";
						}else{
							$consulta  = "SELECT COUNT(estado) as enuso FROM aft WHERE  estado = 'A' AND categ='".strtoupper($name1)."'";
						}						
						$resultado1 = mysqli_query($miConex, $consulta) or die(mysql_error());
						$uso = mysqli_fetch_array($resultado1);
						//en red
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultared  = "SELECT COUNT(enred) as enred1 FROM aft WHERE enred = 's' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
						}else{
							$consultared  = "SELECT COUNT(enred) as enred1 FROM aft WHERE enred = 's' AND categ='COMPUTADORAS'";
						}
						$resultado1red = mysqli_query($miConex, $consultared) or die(mysql_error());
						$enlared = mysqli_fetch_array($resultado1red);
						
						//internet
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultainternet  = "SELECT COUNT(conect) as internet FROM aft WHERE conect = 'Internet' AND categ='".strtoupper($name1)."' AND idunidades='".$Uact."'";
						}else{
							$consultainternet  = "SELECT COUNT(conect) as internet FROM aft WHERE conect = 'Internet' AND categ='".strtoupper($name1)."'";
						}					
						$resultado1internet = mysqli_query($miConex, $consultainternet) or die(mysql_error());
						$internet = mysqli_fetch_array($resultado1internet);
						//intranet
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultaintranet  = "SELECT COUNT(conect) as intranet FROM aft WHERE conect = 'Intranet' AND categ='COMPUTADORAS' AND idunidades='".$Uact."'";
						}else{
							$consultaintranet  = "SELECT COUNT(conect) as intranet FROM aft WHERE conect = 'Intranet' AND categ='COMPUTADORAS'";
						}						
						$resultado1intranet = mysqli_query($miConex, $consultaintranet) or die(mysql_error());
						$intranet = mysqli_fetch_array($resultado1intranet);
						//Rotas
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultarotas  = "SELECT COUNT(estado) as irotas FROM aft WHERE estado = 'R' AND categ='".strtoupper($name1)."' AND idunidades='".$Uact."'";
						}else{
							$consultarotas  = "SELECT COUNT(estado) as irotas FROM aft WHERE estado = 'R' AND categ='".strtoupper($name1)."'";
						}						
						$resultado1rotas = mysqli_query($miConex, $consultarotas) or die(mysql_error());
						$irotas = mysqli_fetch_array($resultado1rotas);
						//BAJAS						
						if(isset($_COOKIE['unidades']) AND ($_COOKIE['unidades']) !=""){
							$consultapbajas  = "SELECT COUNT(estado) as ipbajas FROM bajas_aft WHERE estado = 'P' AND categ='".strtoupper($name1)."' AND idunidades='".$Uact."'";
						}else{
							$consultapbajas  = "SELECT COUNT(estado) as ipbajas FROM bajas_aft WHERE estado = 'P' AND categ='".strtoupper($name1)."'";
						}						
						$resultado1pbajas = mysqli_query($miConex, $consultapbajas) or die(mysql_error());
						$ipbajas = mysqli_fetch_array($resultado1pbajas);

						$TG  = (($uso['enuso'] + $irotas['irotas']) + $ipbajas['ipbajas']); 
						$TTG = $TTG + $TG;
												
						if ($irotas['irotas']!=0){
							$TGR = $TGR + $irotas['irotas'];
						}
						if ($ipbajas['ipbajas']!=0){
							$TGB = $TGB + $ipbajas['ipbajas'];
						}
						if ($uso['enuso']!=0){
							$TGU = $TGU + $uso['enuso'];
						}
						if ($enlared['enred1']!=0){
							$TG_R = $enlared['enred1'];
						}
						if ($internet['internet']!=0){
							$TG_inter = $internet['internet'];
						}
						if ($intranet['intranet']!=0){
							$TG_intra = $intranet['intranet'];
							
						}
							
						if(($TG ) >0){  ?>
							<tr bgcolor="<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>" onMouseOver="this.style.background='#CCFFCC'; this.style.cursor='pointer';" onMouseOut="this.style.background='<?php  echo $uCPanel->ColorFila($p,$color1,$color2);?>'; ">
							  <td><?php if (($name1) =='computadoras'){ echo "<span class=badge1 onclick='javascript:window.parent.comp.submit();'><b>"; }else{ ?> <span class="badge1" onclick="javascript:busca_tipo('<?php echo $name1;?>');"><b> <?php } echo ucfirst($name1); if (($name1) =='computadoras'){ ?></b></span><?php } ?></td>
							  <td align="center"><?php if (($name1) =='computadoras'){ echo "<span class=badge1><b>"; }  if(($TG) !=0){ echo $TG;}else{ echo "0";} if (($name1) =='computadoras'){ echo "</b></span>";} ?></td>
							  <td align="center"><?php if (($name1) =='computadoras'){ echo "<span class=badge1><b>"; } if(($uso['enuso']) !=0){  echo $uso['enuso'];}else{ echo "0";} if (($name1) =='computadoras'){ echo "</b></span>";} ?></td>
							  <td align="center"><?php if (($name1) =='computadoras'){ echo "<span class=badge1><b>"; } if(($irotas['irotas']) !=0){  echo $irotas['irotas'];}else{ echo "0";} if (($name1) =='computadoras'){ echo "</b></span>";} ?></td>
							  <td align="center"><?php if (($name1) =='computadoras'){ echo "<span class=badge1><b>"; } if(($ipbajas['ipbajas']) !=0){  echo $ipbajas['ipbajas'];}else{ echo "0";} if (($name1) =='computadoras'){ echo "</b></span>";} ?></td>
							  <td align="center"><?php if (($name1) =='computadoras'){ echo "<span class=badge1><b>"; } if (($name1) =='computadoras'){ if(($enlared['enred1']) !=0){  echo $enlared['enred1'];}else{ echo "0";} }else{ echo "0";}  if (($name1) =='computadoras'){ echo "</b></span>";} ?></td>
							  <td align="center"><?php if (($name1) =='computadoras'){ echo "<span class=badge1><b>"; } if (($name1) =='computadoras'){ if(($internet['internet']) !=0){  echo $internet['internet'];}else{ echo "0";} }else{ echo "0";}  if (($name1) =='computadoras'){ echo "</b></span>";} ?></td>
							  <td align="center"><?php if (($name1) =='computadoras'){ echo "<span class=badge1><b>"; } if (($name1) =='computadoras'){ if(($intranet['intranet']) !=0){  echo $intranet['intranet'];}else{ echo "0";} }else{ echo "0";}  if (($name1) =='computadoras'){ echo "</b></span>";} ?></td>
						    </tr><?php 
						}else{ $count ++;}
					} $p++;
				} ?>
				<tr>
					<td colspan="8"><hr></td>
				</tr>
				<tr class="navegador">
				    <td><b>TOTAL DE AFT:</b></td>
					<td><font color="red"><b><?php echo $TTG;?></b></font></td>
					<td><font color="red"><b><?php echo $TGU;?></b></font></td>
					<td><font color="red"><b><?php echo $TGR;?></b></font></td>
					<td><font color="red"><b><?php echo $TGB;?></b></font></td>
					<td><font color="red"><b><?php echo $TG_R;?></b></font></td>
					<td><font color="red"><b><?php echo $TG_inter;?></b></font></td>
					<td><font color="red"><b><?php echo $TG_intra;?></b></font></td>
			    </tr>
	</Table>

