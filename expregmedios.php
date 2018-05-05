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
 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=Registro.xls");
 header("Pragma: no-cache");
 header("Expires: 0");
$i=0;
$palabra="";
include ('connections/miConex.php');
		$idunidad="";
		if(isset($_GET['area']) AND ($_GET['area']) !=""){
			$idunidad=" where id =".$_GET['area'];
		}
	if(isset($_GET['query'])){
		$kk= base64_decode($_GET['query']);
		if(stristr($kk,'kk') !=""){
			$se = str_ireplace('kk',$idunidad,$kk);
		}else{
			$se =$kk;
		}
	}else{
		$se = "select * from aft".$idunidad;
	}

$result1 = mysqli_query($miConex, $se);
$rows1   = mysqli_num_rows($result1);
$leg = "REGISTRO DE MEDIOS";
?><html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>expexcelregmedios</title><fieldset class='fieldset'><legend class="vistauserx"><?php echo $leg;?></legend>	
	<TABLE width="100%" BORDER='0' bordercolor=#AFCBCF class=sgf1 aling=center >
			<tr>
			  <td width="12" bgcolor="#EBEBEB"><b> </b></td>
			  <td width="96" bgcolor="#EBEBEB" align="center">INV</td>
			  <td width="260" bgcolor="#EBEBEB" align="center">DESCRIPCI&Oacute;N</td>
			  <td width="47" bgcolor="#EBEBEB" align="center">ESTADO</td>
			  <td width="31" bgcolor="#EBEBEB" align="center">AREA</td>
			  <td width="38" bgcolor="#EBEBEB" align="center">SELLO</td>
			  <td width="43" bgcolor="#EBEBEB" align="center">MARCA</td>
			  <td width="33" bgcolor="#EBEBEB" align="center">SERIE</td>
			  <td width="50" bgcolor="#EBEBEB" align="center">MODELO</td>
			  <td width="47" bgcolor="#EBEBEB" align="center">CATEG.</td>
			  <td width="45" bgcolor="#EBEBEB" align="center">TIPO</td>
			  <td width="67" bgcolor="#EBEBEB" align="center">CUSTODIO</td>
			  <td width="49" bgcolor="#EBEBEB" align="center">TIPO-AFT</td>
			</tr>
			<?php
			$id = 0;
			while($row=mysqli_fetch_array($result1)) {
				$i++;
				if(($rows1) !=0){	?>
					<tr>
					  <td class="Estilo2">&nbsp;&nbsp;</td>
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
					  <td width="49" class="Estilo2"><?php  echo $row["t_AFT"];?></td>
					</tr><?php }

			}?>
			<tr>
		</tr>
	  </table>
</fieldset>
</html>